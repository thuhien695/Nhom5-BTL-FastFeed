<?php
// Kết nối đến cơ sở dữ liệu và bắt đầu phiên làm việc
require_once 'config/init.php';

// Lấy tất cả bài viết
$posts = $postModel->getAllPosts();

// Tiêu đề trang
$pageTitle = "Bài viết - FastFeed";

// Bao gồm header
include 'includes/header.php';
?>

<!-- Danh sách các bài viết -->
<div class="container main-container">
    <div class="section-title">
        <h2>Tất cả bài viết</h2>
    </div>
    
    <?php if(empty($posts)): ?>
        <div class="alert alert-info">
            Chưa có bài viết nào.
        </div>
    <?php else: ?>
        <div class="row featured-posts">
            <?php foreach($posts as $post): ?>
                <div class="col-md-4 mb-4 fade-in">
                    <div class="card post-card">
                        <a href="post.php?id=<?php echo $post['id']; ?>">
                            <?php if(!empty($post['image'])): ?>
                                <img src="<?php echo $post['image']; ?>" class="card-img-top" alt="<?php echo $post['name']; ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $post['name']; ?></h5>
                                <p class="card-text"><?php echo substr(strip_tags($post['content']), 0, 100); ?>...</p>
                                <div class="post-meta small">
                                    <span><i class="fas fa-user"></i> <?php echo $post['author_name']; ?></span>
                                    <span><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                                    <span><i class="fas fa-comments"></i> <?php echo $postModel->getCommentCount($post['id']); ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> 