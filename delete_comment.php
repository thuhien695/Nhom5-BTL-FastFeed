<?php
// Kết nối đến cơ sở dữ liệu và bắt đầu phiên làm việc
require_once 'config/init.php';

// Kiểm tra người dùng đã đăng nhập chưa
if(!isLoggedIn()) {
    setFlash('danger', 'Bạn phải đăng nhập để thực hiện chức năng này!');
    redirect('login.php');
}

// Lấy ID bình luận và ID bài viết
$comment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

// Kiểm tra ID bình luận và ID bài viết có hợp lệ không
if($comment_id <= 0 || $post_id <= 0) {
    setFlash('danger', 'ID bình luận hoặc ID bài viết không hợp lệ!');
    redirect('');
}

// Lấy thông tin người dùng
$user_id = $_SESSION['user_id'];
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : '';

// Kiểm tra xem người dùng có quyền xóa bình luận này không
if($commentModel->isOwnerOrAdmin($comment_id, $user_id, $user_role)) {
    // Thực hiện xóa bình luận
    if($commentModel->deleteComment($comment_id)) {
        setFlash('success', 'Xóa bình luận thành công!');
    } else {
        setFlash('danger', 'Không thể xóa bình luận, vui lòng thử lại!');
    }
} else {
    setFlash('danger', 'Bạn không có quyền xóa bình luận này!');
}

// Chuyển hướng về trang chi tiết bài viết
redirect("post.php?id={$post_id}");
?> 