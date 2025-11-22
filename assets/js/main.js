/**
 * FastFeed - JavaScript chính
 */

// Đợi tài liệu DOM được tải hoàn tất
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo tooltips nếu có Bootstrap
    if(typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Hiệu ứng cho nút trở về đầu trang
    const backToTopBtn = document.querySelector('.back-to-top');
    if(backToTopBtn) {
        window.addEventListener('scroll', function() {
            if(window.scrollY > 300) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
        });
        
        backToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Kiểm tra và hiển thị các phần tử fade-in
    const checkFadeElements = function() {
        const fadeElements = document.querySelectorAll('.fade-in');
        fadeElements.forEach(element => {
            const position = element.getBoundingClientRect();
            // Hiển thị phần tử khi người dùng cuộn đến
            if(position.top < window.innerHeight) {
                element.classList.add('visible');
            }
        });
    };
    
    // Gọi hàm kiểm tra ngay khi trang tải xong
    checkFadeElements();
    
    // Đăng ký sự kiện cuộn để kích hoạt hiệu ứng
    window.addEventListener('scroll', checkFadeElements);
    
    // Xử lý hiệu ứng hover cho các card bài viết nếu không dùng jQuery
    const postCards = document.querySelectorAll('.post-card');
    postCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('post-card-hover');
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('post-card-hover');
        });
    });
    
    // Xác thực form đăng nhập/đăng ký
    const validateForm = function(form, event) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if(!field.value.trim()) {
                isValid = false;
                // Thêm lớp CSS cho trường không hợp lệ
                field.classList.add('is-invalid');
                
                // Tạo thông báo lỗi nếu chưa có
                let nextEl = field.nextElementSibling;
                if(!nextEl || !nextEl.classList.contains('invalid-feedback')) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'invalid-feedback';
                    errorMsg.textContent = 'Vui lòng điền thông tin này.';
                    field.parentNode.insertBefore(errorMsg, field.nextSibling);
                }
            } else {
                // Xóa lớp không hợp lệ
                field.classList.remove('is-invalid');
                
                // Xóa thông báo lỗi nếu có
                let nextEl = field.nextElementSibling;
                if(nextEl && nextEl.classList.contains('invalid-feedback')) {
                    nextEl.remove();
                }
            }
            
            // Thêm kiểm tra email nếu là trường email
            if(field.type === 'email' && field.value.trim()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if(!emailRegex.test(field.value)) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    let nextEl = field.nextElementSibling;
                    if(!nextEl || !nextEl.classList.contains('invalid-feedback')) {
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'invalid-feedback';
                        errorMsg.textContent = 'Email không hợp lệ.';
                        field.parentNode.insertBefore(errorMsg, field.nextSibling);
                    }
                }
            }
            
            // Thêm kiểm tra mật khẩu nếu là trường mật khẩu
            if(field.type === 'password' && field.value.trim()) {
                // Kiểm tra độ dài mật khẩu
                if(field.value.length < 6) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    let nextEl = field.nextElementSibling;
                    if(!nextEl || !nextEl.classList.contains('invalid-feedback')) {
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'invalid-feedback';
                        errorMsg.textContent = 'Mật khẩu phải có ít nhất 6 ký tự.';
                        field.parentNode.insertBefore(errorMsg, field.nextSibling);
                    }
                }
            }
        });
        
        // Kiểm tra xác nhận mật khẩu nếu có
        const password = form.querySelector('input[type="password"][name="password"]');
        const confirmPassword = form.querySelector('input[type="password"][name="confirm_password"]');
        
        if(password && confirmPassword && password.value && confirmPassword.value) {
            if(password.value !== confirmPassword.value) {
                isValid = false;
                confirmPassword.classList.add('is-invalid');
                
                let nextEl = confirmPassword.nextElementSibling;
                if(!nextEl || !nextEl.classList.contains('invalid-feedback')) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'invalid-feedback';
                    errorMsg.textContent = 'Mật khẩu không khớp.';
                    confirmPassword.parentNode.insertBefore(errorMsg, confirmPassword.nextSibling);
                }
            }
        }
        
        if(!isValid) {
            event.preventDefault();
        }
        
        return isValid;
    };
    
    // Đăng ký sự kiện xác thực form
    const authForms = document.querySelectorAll('.auth-form');
    authForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            validateForm(this, event);
        });
    });
    
    // Thêm nút trở về đầu trang vào body nếu chưa có
    if(!document.querySelector('.back-to-top')) {
        const backToTopBtn = document.createElement('a');
        backToTopBtn.href = '#';
        backToTopBtn.className = 'back-to-top';
        backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
        document.body.appendChild(backToTopBtn);
        
        // Thêm CSS cho nút
        const style = document.createElement('style');
        style.textContent = `
            .back-to-top {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 50px;
                height: 50px;
                background-color: var(--primary-color);
                color: var(--text-light);
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            }
            
            .back-to-top.visible {
                opacity: 1;
                visibility: visible;
            }
            
            .back-to-top:hover {
                background-color: var(--secondary-color);
                transform: translateY(-5px);
            }
        `;
        document.head.appendChild(style);
    }
}); 