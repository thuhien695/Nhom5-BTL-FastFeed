<?php
// Kết nối đến cơ sở dữ liệu và bắt đầu phiên làm việc
require_once 'config/init.php';

// Kiểm tra xem có ID bài viết được truyền vào không
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    setFlash('danger', 'Không tìm thấy bài viết!');
    redirect('');
}

$id = (int)$_GET['id']; // ép kiểu về số nguyên an toàn
$post = $postModel->getPostById($id);

// Nếu không tìm thấy bài viết, chuyển hướng về trang chủ
if(!$post) {
    setFlash('danger', 'Không tìm thấy bài viết!');
    redirect('');
}

// Lấy danh sách bình luận
$comments = $commentModel->getCommentsByPostId($id);

// Lấy bài viết liên quan
$relatedPosts = $postModel->getRelatedPosts($id, 3);

// Xử lý form bình luận
$commentSuccess = false;
$commentError = '';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment']) && isLoggedIn()) { //Kiểm tra xem có phải là form được gửi đi bằng phương thức POST không
    $content = mysqli_real_escape_string($conn, $_POST['comment']);  //Kiểm tra xem người dùng có nhập bình luận không
    $user_id = $_SESSION['user_id']; // Kiểm tra người dùng đã đăng nhập hay chư
    
    if(empty($content)) {
        $commentError = 'Vui lòng nhập nội dung bình luận!';
    } else {
        $result = $commentModel->addComment($id, $user_id, $content);
        
        if($result) {
            $commentSuccess = true;
            
            // Nếu là một yêu cầu Ajax, trả về phản hồi JSON
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                // Lấy thông tin người dùng vừa bình luận
                $user = $userModel->getUserById($user_id);
                
                // Chuẩn bị HTML cho bình luận mới
                ob_start();
                ?>
                <div class="comment">
                    <div class="comment-header">
                        <span class="comment-author"><?php echo $user['fullname']; ?></span>
                        <span class="comment-date">Vừa xong</span>
                    </div>
                    <div class="comment-content">
                        <?php echo $content; ?>
                    </div>
                </div>
                <?php
                $commentHtml = ob_get_clean();
                
                echo json_encode(['success' => true, 'html' => $commentHtml]);
                exit;
            }
            
            // Tải lại trang để hiển thị bình luận mới
            redirect("post.php?id={$id}");
        } else {
            $commentError = 'Không thể thêm bình luận, vui lòng thử lại!';
        }
    }
    
    // Nếu là yêu cầu Ajax và có lỗi
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
        echo json_encode(['success' => false, 'message' => $commentError]);
        exit;
    }
}

// Tiêu đề trang
$pageTitle = $post['name'] . " - FastFeed";

// Bao gồm header
include 'includes/header.php';
?>

<!-- Chi tiết bài viết -->
<div class="container main-container">
    <div class="row">
        <div class="col-lg-8">
            <!-- Bài viết chính -->
            <div class="post-detail">
                <h1 class="post-title"><?php echo $post['name']; ?></h1>
                
                <div class="post-meta">
                    <span><i class="fas fa-user"></i> <?php echo $post['author_name']; ?></span>
                    <span><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                    <span><i class="fas fa-comments"></i> <?php echo count($comments); ?> bình luận</span>
                </div>
                
                <?php if(!empty($post['image'])): ?>
                    <div class="post-image">
                        <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['name']; ?>" class="img-fluid">
                    </div>
                <?php endif; ?>
                
                <div class="post-content">
                    <?php echo $post['content']; ?>
                </div>
            </div>
            
            <!-- Phần bình luận -->
            <div class="comments-section">
                <h3>Bình luận (<?php echo count($comments); ?>)</h3>
                
                <?php if(isLoggedIn()): ?>
                    <!-- Form bình luận -->
                    <div class="mb-4">
                        <?php if($commentError): ?>
                            <div class="alert alert-danger"><?php echo $commentError; ?></div>
                        <?php elseif($commentSuccess): ?>
                            <div class="alert alert-success">Bình luận của bạn đã được đăng!</div>
                        <?php endif; ?>
                        
                        <form id="comment-form" action="post.php?id=<?php echo $id; ?>" method="POST">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Viết bình luận</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-comment">Gửi bình luận</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info mb-4">
                        Vui lòng <a href="login.php">đăng nhập</a> để bình luận.
                    </div>
                <?php endif; ?>
                
                <!-- Danh sách bình luận -->
                <div id="comments-container">
                    <?php if(empty($comments)): ?>
                        <div class="text-center my-4">
                            <p>Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($comments as $comment): ?>
                            <div class="comment">
                                <div class="comment-header">
                                    <span class="comment-author"><?php echo $comment['fullname']; ?></span>
                                    <span class="comment-date"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></span>
                                </div>
                                <div class="comment-content">
                                    <?php echo $comment['content']; ?>
                                </div>
                                
                                <?php 
                                // Hiển thị nút xóa nếu là admin hoặc chủ bình luận
                                if(isLoggedIn() && (isAdmin() || $_SESSION['user_id'] == $comment['user_id'])): 
                                ?>
                                    <div class="comment-actions mt-2">
                                        <a href="delete_comment.php?id=<?php echo $comment['id']; ?>&post_id=<?php echo $id; ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Bạn có chắc muốn xóa bình luận này?');">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Bài viết liên quan -->
            <div class="sidebar">
                <div class="section-title">
                    <h2>Bài viết liên quan</h2>
                </div>
                
                <?php if(empty($relatedPosts)): ?>
                    <div class="text-center my-4">
                        <p>Không có bài viết liên quan.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($relatedPosts as $related): ?>
                        <div class="card post-card mb-3">
                            <a href="post.php?id=<?php echo $related['id']; ?>">
                                <?php if(!empty($related['image'])): ?>
                                    <img src="<?php echo $related['image']; ?>" class="card-img-top" alt="<?php echo $related['name']; ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $related['name']; ?></h5>
                                    <p class="card-text small"><?php echo substr(strip_tags($related['content']), 0, 100); ?>...</p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 