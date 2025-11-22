<?php
// Kết nối đến cơ sở dữ liệu và bắt đầu phiên làm việc
require_once 'config/init.php';

// Tiêu đề trang
$pageTitle = "Giới thiệu - FastFeed";

// Bao gồm header
include 'includes/header.php';
?>

<!-- Trang giới thiệu -->
<div class="container main-container">
    <div class="section-title">
        <h2>GIỚI THIỆU</h2>
    </div>

    <div class="about-container bg-light p-4 rounded shadow-sm mb-4">
        <div class="about-section mb-5 fade-in">
            <h2 class="text-center text-primary mb-4">GIỚI THIỆU</h2>
            <p><strong>FastFeed</strong> là một blog cá nhân được tạo ra với mục tiêu mang đến những 
                <strong>chia sẻ chân thực, gần gũi và không thiên vị</strong> về các 
                <strong>trải nghiệm du lịch</strong> - từ những điểm đến nổi tiếng cho đến những nơi bình yên, ít người biết tới.
                <br>
                Tại FastFeed, mình ghi lại cảm nhận của bản thân sau mỗi chuyến đi: cảnh đẹp, con người, chi phí, dịch vụ và cả những trải nghiệm thực tế.
                Tất cả nội dung đều được viết từ góc nhìn cá nhân, 
                <strong>không nhận tài trợ, không quảng cáo trá hình</strong> và không bị chi phối bởi bất kỳ thương hiệu nào. 
                Với mình, điều quan trọng nhất khi chia sẻ trải nghiệm là <strong>trung thực và rõ ràng</strong>, 
                để người đọc có thể tự tin tham khảo và lựa chọn hành trình phù hợp.
            </p>
        </div>

        <div class="about-section mb-5 fade-in">
            <h2 class="text-center text-primary mb-4">Lý do mình tạo nên FastFeed</h2>
            <p>Là một người yêu thích du lịch và khám phá, mình luôn hào hứng mỗi khi đặt chân đến một vùng đất mới. 
               Tuy nhiên, khi tìm kiếm thông tin, mình nhận ra rằng nhiều bài review hiện nay mang tính quảng bá nhiều hơn là chia sẻ thật lòng. 
               Điều đó khiến mình khó tìm được nguồn tham khảo đáng tin cậy – và từ đó nảy ra ý tưởng:</p>

            <blockquote class="blockquote text-center my-4">
                <p class="mb-0">"Tại sao không tự kể lại những chuyến đi của chính mình – một cách chân thật, mộc mạc và không màu mè?"</p>
            </blockquote>

            <p>FastFeed ra đời từ niềm <strong>đam mê du lịch và mong muốn tạo ra một không gian nhỏ để lan tỏa những trải nghiệm thật</strong> – 
               nơi người đọc có thể tìm thấy thông tin khách quan, hữu ích và thực tế trước mỗi chuyến đi.</p>
        </div>

        <div class="about-section mb-5 fade-in">
            <h2 class="text-center text-primary mb-4">Không gian cởi mở cho tất cả mọi người</h2>
            <p>Dù đây là một blog cá nhân, nhưng mình luôn trân trọng và lắng nghe mọi ý kiến đóng góp từ người đọc. 
               FastFeed không hướng đến sự hào nhoáng, mà chú trọng vào 
               <strong>chất lượng nội dung và sự kết nối chân thật với những người yêu du lịch</strong>.
            </p>
        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>