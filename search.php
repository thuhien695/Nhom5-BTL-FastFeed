<?php
// Kết nối đến cơ sở dữ liệu và bắt đầu phiên làm việc
require_once 'config/init.php';

// Lấy từ khóa tìm kiếm
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';

// Lấy kết quả tìm kiếm
$posts = [];
if(!empty($keyword)) {
    $posts = $postModel->searchPosts($keyword);
}

// Tiêu đề trang
$pageTitle = "Tìm kiếm: " . $keyword . " - FastFeed";

// Bao gồm header
include 'includes/header.php';
?>

<!-- Kết quả tìm kiếm -->
<div class="container main-container">
    <div class="section-title">
        <h2>Kết quả tìm kiếm: "<?php echo htmlspecialchars($keyword); ?>"</h2>
    </div>
    
    <?php if(empty($keyword)): ?>
        <div class="alert alert-info">
            Vui lòng nhập từ khóa để tìm kiếm.
        </div>
    <?php elseif(empty($posts)): ?>
        <div class="alert alert-warning">
            Không tìm thấy bài viết nào phù hợp với từ khóa "<?php echo htmlspecialchars($keyword); ?>".
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
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Nút quay về trang chủ -->
    <div class="text-center mb-5">
        <a href="<?php echo ROOT_URL; ?>" class="btn btn-view-more">
            <i class="fas fa-arrow-left"></i> Quay về trang chủ
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 