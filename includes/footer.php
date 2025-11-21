<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="footer-info">
                    <h4 class="footer-logo">FASTFEED</h4>
                    <p><i class="fas fa-phone footer-icon"></i> 0856.596.xxx</p>
                    <p><i class="fas fa-envelope footer-icon"></i> fastfeed.contact@gmail.com</p>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="copyright">&copy; <?php echo date('Y'); ?> FastFeed. Tất cả quyền được bảo lưu.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="<?php echo ROOT_URL; ?>assets/js/main.js"></script>

<!-- Initialize any plugins -->
<script>
    $(document).ready(function() {
        // Hiệu ứng làm mờ và hiện dần các phần tử khi cuộn
        $(window).scroll(function() {
            $('.fade-in').each(function() {
                var position = $(this).offset().top;
                var scroll = $(window).scrollTop();
                var windowHeight = $(window).height();
                
                if (scroll + windowHeight > position) {
                    $(this).addClass('visible');
                }
            });
        });
        
        // Hiệu ứng hover cho các card bài viết
        $('.post-card').hover(
            function() {
                $(this).addClass('post-card-hover');
            },
            function() {
                $(this).removeClass('post-card-hover');
            }
        );
        
        // Xử lý Ajax cho form bình luận
        $('#comment-form').on('submit', function(e) {
            // Chỉ thực hiện khi đã đăng nhập
            <?php if(isLoggedIn()): ?>
            e.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();
            
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.success) {
                        // Thêm bình luận mới vào danh sách
                        $('#comments-container').prepend(data.html);
                        // Reset form
                        form[0].reset();
                    } else {
                        alert(data.message);
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                }
            });
            <?php endif; ?>
        });
    });
</script>

</body>
</html> 