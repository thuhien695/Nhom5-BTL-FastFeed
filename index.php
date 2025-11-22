<?php
// Kết nối đến cơ sở dữ liệu và bắt đầu phiên làm việc
require_once 'config/init.php';

// Lấy các bài viết mới nhất
$latestPosts = $postModel->getLatestPosts();

// Tiêu đề trang
$pageTitle = "Trang chủ - FastFeed";

// Bao gồm header
include 'includes/header.php';
?>

<!-- Banner chính -->
<div class="container-fluid main-container">
    <div class="hero-section text-center">
        <h1 class="main-title">FastFeed - Đi thật, cảm thật!</h1>
        <p class="sub-title">Tớ đi và kể lại, cậu đọc và góp ý! Cùng khám phá những hành trình du lịch qua trải nghiệm chân thật và góc nhìn gần gũi.</p>
    </div>


    <!-- Phần hiển thị bài viết nổi bật -->
    <div class="container">
        <div class="section-title">
            <h2>Bài viết nổi bật</h2>
        </div>
        
        <div class="row featured-posts">
            <?php foreach($latestPosts as $post): ?>
            <div class="col-md-4 mb-4">
                <div class="card post-card">
                    <a href="post.php?id=<?php echo $post['id']; ?>">
                        <?php if(!empty($post['image'])): ?>
                        <img src="<?php echo $post['image']; ?>" class="card-img-top" alt="<?php echo $post['name']; ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $post['name']; ?></h5>
                            <p class="card-text"><?php echo substr(strip_tags($post['content']), 0, 100); ?>...</p>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mb-5">
            <a href="posts.php" class="btn btn-view-more">Xem thêm...</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 