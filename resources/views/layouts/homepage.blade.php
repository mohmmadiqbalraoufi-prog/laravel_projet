@extends('layouts.header')
    <!DOCTYPE html>
    <html lang="fa" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
        <title>Azure IaaS | زیرساخت ابری قدرتمند</title>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
        <link rel="stylesheet" href="homepage.css">

        <link rel="stylesshet" href="dashboard.html"
        @vite('resources/css/homePage.style.css');
   
         
    </head>
    <body>
     
    @section('home')
   

            <div class="auth-buttons">
                <button class="btn-register" id="registerBtn">ثبت نام</button>
                <button class="btn-login" id="loginBtn">ورود</button>
            </div>
        </div>
    </nav>

    <main>
        <div class="hero" id="heroSection">
            <h1><i class="fas fa-cloud-upload-alt"></i> <span id="heroTitle"></span></h1>
            <p id="heroSubtitle"></p>
            <div class="hero-stats" id="heroStats"></div>
        </div>

        <div class="container">
            <h2 class="section-title" id="servicesTitle"></h2>
            <div class="features-grid" id="featuresGrid"></div>
        </div>

        <div class="stats-section" id="statsSection">
            <div class="container">
                <div class="stats-grid" id="statsGrid"></div>
            </div>
        </div>

        <div class="container">
            <h2 class="section-title" id="pricingTitle"></h2>
            <div class="pricing-grid" id="pricingGrid"></div>
        </div>

        <!-- start demo -->

<div class="video-section">
    <div class="video-container">
        <div class="video-header">
            <h3><i class="fas fa-play-circle"></i> دموی سیستم Azure IaaS</h3>
            <div class="video-controls">
                <button id="playPauseBtn"><i class="fas fa-play"></i> پخش</button>
                <button id="volumeBtn"><i class="fas fa-volume-up"></i> صدا</button>
                <button id="fullscreenBtn"><i class="fas fa-expand"></i> تمام صفحه</button>
            </div>
        </div>
        <div class="video-wrapper" id="videoWrapper">
            <video id="demoVideo" poster="https://via.placeholder.com/1280x720/0b2b3f/0078d4?text=Azure+IaaS+Demo">
                <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="video/mp4">
                مرورگر شما از ویدیو پشتیبانی نمی‌کند.
            </video>
            <div class="play-overlay" id="playOverlay">
                <i class="fas fa-play-circle"></i>
            </div>
        </div>
        <div class="upload-area">
            <label class="upload-label">
                <!-- <i class="fas fa-upload"></i> آپلود ویدیوی خود -->
                <input type="file" id="videoUpload" accept="video/*">
            </label>
            <div class="video-info">
                <i class="fas fa-info-circle"></i>
                <span>ویدیوی نمونه: معرفی Azure IaaS</span>
                <span class="reset-video" id="resetVideoBtn"><i class="fas fa-sync-alt"></i> ویدیوی پیش‌فرض</span>
            </div>
        </div>
    </div>
</div>

<div id="videoSuccessModal" class="video-modal">
    <div class="video-modal-content">
        <i class="fas fa-check-circle"></i>
        <h3>ویدیو با موفقیت آپلود شد!</h3>
        <p>ویدیوی شما آماده پخش است.</p>
        <button onclick="closeVideoModal()">باشه</button>
    </div>
</div>

<div id="videoToastMessage" class="video-toast"></div>

            <!-- end demo -->
<section class="testimonials">
    <div class="container">
        <h2 class="section-title">نظرات کاربران</h2>
        <div class="testimonials-grid" id="testimonialsGrid"></div>
    </div>
</section>

<section class="faq">
    <div class="container">
        <h2 class="section-title">سوالات متداول</h2>
        <div class="faq-grid" id="faqGrid"></div>
    </div>
</section>
        <div class="cta-section" id="ctaSection">
            <h2 id="ctaTitle"></h2>
            <p id="ctaText"></p>
            <button class="cta-btn" id="ctaBtn"></button>
        </div>
    </main>

    <footer class="footer">
        <p><i class="fas fa-envelope"></i> ایمیل: MicrosoftAzureiass.com</p>
        <p><i class="fas fa-copyright"></i> © 2026 Azure IaaS - تمامی حقوق محفوظ است</p>
        <p>
            <i class="fab fa-linkedin"></i> 
            <i class="fab fa-twitter"></i> 
            <i class="fab fa-github"></i> 
            <i class="fab fa-telegram"></i>
        </p>
    </footer>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-sign-in-alt"></i> ورود به حساب کاربری</h2>
                <span class="close-modal" data-modal="loginModal">&times;</span>
            </div>
            <form id="loginForm">
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> ایمیل</label>
                    <input type="email" id="loginEmail" placeholder="example@email.com">
                    <small class="error-message" id="loginEmailError"></small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> رمز عبور</label>
                    <input type="password" id="loginPassword" placeholder="********">
                    <small class="error-message" id="loginPasswordError"></small>
                </div>
                <button type="submit" class="modal-submit-btn">ورود</button>
                <p class="modal-footer-text">حساب کاربری ندارید؟ <a href="#" id="switchToRegister">ثبت نام کنید</a></p>
            </form>
        </div>
    </div>

    <div id="registerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-user-plus"></i> ثبت نام در Azure IaaS</h2>
                <span class="close-modal" data-modal="registerModal">&times;</span>
            </div>
            <form id="registerForm">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> نام کامل</label>
                    <input type="text" id="regFullName" placeholder="محمد قبال روفی">
                    <small class="error-message" id="regNameError"></small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> ایمیل</label>
                    <input type="email" id="regEmail" placeholder="example@email.com">
                    <small class="error-message" id="regEmailError"></small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> شماره موبایل</label>
                    <input type="tel" id="regPhone" placeholder="0799301200">
                    <small class="error-message" id="regPhoneError"></small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> رمز عبور</label>
                    <input type="password" id="regPassword" placeholder="حداقل ۸ کاراکتر">
                    <small class="error-message" id="regPasswordError"></small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-check-circle"></i> تکرار رمز عبور</label>
                    <input type="password" id="regConfirmPassword" placeholder="رمز عبور را دوباره وارد کنید">
                    <small class="error-message" id="regConfirmError"></small>
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="regTerms">
                    <label for="regTerms"> <a href="#">قوانین و مقررات</a> را می‌پذیرم</label>
                    <small class="error-message" id="regTermsError"></small>
                </div>
                <button type="submit" class="modal-submit-btn">ثبت نام</button>
                <p class="modal-footer-text">قبلاً ثبت نام کرده‌اید؟ <a href="#" id="switchToLogin">ورود</a></p>
                    <!-- something new -->
                <div class="checkbox-group">
                    <input type="checkbox" id="rememberMe">
                    <label for="rememberMe">مرا به خاطر بسپار</label>
                </div>
            </form>
        </div>
    </div>

    <div id="toastMessage" class="toast"></div>

    <script>

        // document.write(history.go(-0))   
        const websiteData = {
            hero: {
                title: "ابر قدرتمند Azure IaaS",
                subtitle: "زیرساخت ابری مقیاس‌پذیر، امن و سریع برای کسب‌وکار شما",
                stats: [
                    { number: "99.9%", label: "در دسترس بودن" },
                    { number: "24/7", label: "پشتیبانی" },
                    { number: "+5000", label: "مشتری فعال" },
                    // {number:"+700$",label:'قیمت است'}
                ]
            },
            services: {
                title: "خدمات ابری ما",
                items: [
                    { icon: "fa-server", title: "ماشین مجازی", desc: "ایجاد سرورهای مجازی در کمترین زمان با قدرت پردازشی بالا" },
                    { icon: "fa-database", title: "ذخیره‌سازی امن", desc: "فضای ابری با رمزنگاری پیشرفته و پشتیبان خودکار" },
                    { icon: "fa-network-wired", title: "شبکه ابری", desc: "شبکه اختصاصی با پهنای باند نامحدود و امنیت بالا" },
                    { icon: "fa-robot", title: "هوش مصنوعی", desc: "سرویس‌های AI پیشرفته" },
                    { icon: "fa-chart-line", title: "تحلیل داده", desc: "Big Data Analytics" },
                     { icon: "fa-cubes", title: "کشتیرانی کانتینر", desc: "مدیریت کانتینرها با Kubernetes" }
                
                ]
            },
            stats: {
                items: [
                    { icon: "fa-microchip", number: "10,000+", label: "سرور فعال" },
                    { icon: "fa-database", number: "5PB+", label: "داده ذخیره شده" },
                    { icon: "fa-globe", number: "15+", label: "منطقه جغرافیایی" },
                    { icon: "fa-shield-alt", number: "ISO 27001", label: "گواهینامه امنیت" }
                ]
            },
            pricing: {
                title: "پلن‌های قیمتی",
                plans: [
                    { name: "شروع", price: "$19", features: ["۱ vCPU", "۱GB RAM", "۳۰GB SSD", "پشتیبانی معمولی"], popular: false },
                    { name: "حرفه‌ای", price: "$79", features: ["۴ vCPU", "۸GB RAM", "۲۵۰GB SSD", "پشتیبانی اولویت"], popular: false },
                    { name: "سازمانی", price: "$299", features: ["۱۶ vCPU", "۳۲GB RAM", "۱TB SSD", "پشتیبانی ۲۴/۷"], popular: true }
                ]
            },
            cta: {
                title: "آماده شروع هستید؟",
                text: "همین امروز حساب کاربری خود را بسازید و از اعتبار ۲۰۰ دلاری رایگان استفاده کنید",
                buttonText: "شروع رایگان"
            }
        };

        // ========== نمایش پیام (Toast) ==========
        function showToast(message, isSuccess = true) {
            const toast = document.getElementById('toastMessage');
            toast.textContent = message;
            toast.className = `toast show ${isSuccess ? 'success' : 'error'}`;
            setTimeout(() => {
                toast.className = 'toast';
            }, 3000);
        }

        function validateLoginForm(email, password) {
            let isValid = true;
            
            const emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
            if (!email) {
                document.getElementById('loginEmailError').textContent = 'ایمیل الزامی است';
                isValid = false;
            } else if (!emailRegex.test(email)) {
                document.getElementById('loginEmailError').textContent = 'فرمت ایمیل صحیح نیست';
                isValid = false;
            } else {
                document.getElementById('loginEmailError').textContent = '';
            }
            
            
            if (!password) {
                document.getElementById('loginPasswordError').textContent = 'رمز عبور الزامی است';
                isValid = false;
            } else if (password.length < 6) {
                document.getElementById('loginPasswordError').textContent = 'رمز عبور باید حداقل ۶ کاراکتر باشد';
                isValid = false;
            } else {
                document.getElementById('loginPasswordError').textContent = '';
            }
            
            return isValid;
        }

        
        function validateRegisterForm(fullName, email, phone, password, confirmPassword, terms) {
            let isValid = true;
            
            const nameRegex = /^[آ-یa-zA-Z\s]+$/;
            if (!fullName) {
                document.getElementById('regNameError').textContent = 'نام کامل الزامی است';
                isValid = false;
            } else if (fullName.length < 3) {
                document.getElementById('regNameError').textContent = 'نام کامل باید حداقل ۳ کاراکتر باشد';
                isValid = false;
            } 
                    else if (!nameRegex.test(fullName)) {
                document.getElementById('regNameError').textContent = 'نام فقط می‌تواند شامل حروف باشد (اعداد مجاز نیستند)';
                isValid = false;
            }
                    
            else {
                document.getElementById('regNameError').textContent = '';
            }
            
          
            const emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
            if (!email) {
                document.getElementById('regEmailError').textContent = 'ایمیل الزامی است';
                isValid = false;
            } else if (!emailRegex.test(email)) {
                document.getElementById('regEmailError').textContent = 'فرمت ایمیل صحیح نیست';
                isValid = false;
            } else {
                document.getElementById('regEmailError').textContent = '';
            }
            
         
            const phoneRegex = /^(07[0-9]{8}|7[0-9]{8})$/;
            if (!phone) {
                document.getElementById('regPhoneError').textContent = 'شماره موبایل الزامی است';
                isValid = false;
            } else if (!phoneRegex.test(phone)) {
                document.getElementById('regPhoneError').textContent = 'شماره موبایل باید با 07 شروع شود و 10 رقم باشد';
                isValid = false;
            } else {
                document.getElementById('regPhoneError').textContent = '';
            }
            
           
            if (!password) {
                document.getElementById('regPasswordError').textContent = 'رمز عبور الزامی است';
                isValid = false;
            } else if (password.length < 8) {
                document.getElementById('regPasswordError').textContent = 'رمز عبور باید حداقل ۸ کاراکتر باشد';
                isValid = false;
            } else {
                document.getElementById('regPasswordError').textContent = '';
            }
            
            
            if (!confirmPassword) {
                document.getElementById('regConfirmError').textContent = 'تکرار رمز عبور الزامی است';
                isValid = false;
            } else if (password !== confirmPassword) {
                document.getElementById('regConfirmError').textContent = 'رمز عبور و تکرار آن یکسان نیستند';
                isValid = false;
            } else {
                document.getElementById('regConfirmError').textContent = '';
            }
            
            
            if (!terms) {
                document.getElementById('regTermsError').textContent = 'پذیرش قوانین الزامی است';
                isValid = false;
            } else {
                document.getElementById('regTermsError').textContent = '';
            }
            
            return isValid;
        }

       
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
            document.body.style.overflow = 'hidden'; // orevent background scrolling 
             // / when model is opne user can not scroll the main page behined 
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = '';    // back to defual value
            /// user can agin scroll the page 
           
        }
        
        
        
        // فرم ورود
        document.getElementById('loginForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const rememberMe = document.getElementById('rememberMe').checked;
            //اګر فرم معتبر نبود متوقف شو
            if (!validateLoginForm(email, password)) return;

            const savedPassword = localStorage.getItem(email);
            if (savedPassword && savedPassword === password) {
                if (rememberMe) {
                    localStorage.setItem('azure_remember', 'true');
                    localStorage.setItem('azure_remember_username', email);
                }
                showToast('ورود موفقیت‌آمیز! خوش آمدید 👋', true);
                closeModal('loginModal');
                document.getElementById('loginForm').reset();
                document.querySelectorAll('#loginForm .error-message').forEach(el => el.textContent = ''); /// clean the error mesage
            } else {
                document.getElementById('loginPasswordError').textContent = 'ایمیل یا رمز عبور اشتباه است!';
                showToast('ایمیل یا رمز عبور اشتباه است', false);
            }
        });



        //// Registration 
        document.getElementById('registerForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const fullName = document.getElementById('regFullName').value;
            const email = document.getElementById('regEmail').value;
            const phone = document.getElementById('regPhone').value;
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;
            const terms = document.getElementById('regTerms').checked;

            if (validateRegisterForm(fullName, email, phone, password, confirmPassword, terms)) {   /// if the  form is valided then 
                // ذخیره در localStorage
                localStorage.setItem(email, password);
                showToast(`ثبت نام موفق! خوش آمدید ${fullName} 🎉`, true);
                closeModal('registerModal');
                document.getElementById('registerForm').reset();
                document.querySelectorAll('#registerForm .error-message').forEach(el => el.textContent = '');
            }
        });

        /// butten to open the model 
        document.getElementById('loginBtn').addEventListener('click', () => openModal('loginModal'));
        document.getElementById('registerBtn').addEventListener('click', () => openModal('registerModal'));
        
            // butten to close the model
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                closeModal(btn.getAttribute('data-modal'));
            });
        });
        /// closing model by clinking outside the page

        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
        
        document.getElementById('switchToRegister').addEventListener('click', (e) => {
            e.preventDefault();
            closeModal('loginModal');   // close the login page
            openModal('registerModal'); /// open the  regeartaion model 
        });
        
        document.getElementById('switchToLogin').addEventListener('click', (e) => {
            e.preventDefault();
            closeModal('registerModal');   // close the regsretin 
            openModal('loginModal');      /// open login 
        });
        
        // clean the error when typeing
        function clearErrorOnInput(inputId, errorId) {
            document.getElementById(inputId).addEventListener('input', () => {
                document.getElementById(errorId).textContent = '';
            });
        }
        
        clearErrorOnInput('loginEmail', 'loginEmailError');
        clearErrorOnInput('loginPassword', 'loginPasswordError');
        clearErrorOnInput('regFullName', 'regNameError');
        clearErrorOnInput('regEmail', 'regEmailError');
        clearErrorOnInput('regPhone', 'regPhoneError');
        clearErrorOnInput('regPassword', 'regPasswordError');
        clearErrorOnInput('regConfirmPassword', 'regConfirmError');
        document.getElementById('regTerms').addEventListener('change', () => {
            document.getElementById('regTermsError').textContent = '';
        });
        
            /// dinamic 
        function dyHero() {
            document.getElementById('heroTitle').textContent = websiteData.hero.title;
            document.getElementById('heroSubtitle').textContent = websiteData.hero.subtitle;
            const statsContainer = document.getElementById('heroStats');
            statsContainer.innerHTML = '';
            websiteData.hero.stats.forEach(stat => {
                const statDiv = document.createElement('div');
                statDiv.innerHTML = `<div class="number">${stat.number}</div><div>${stat.label}</div>`;
                statsContainer.append(statDiv);
            });
        }
        
        function dyServices() {
            document.getElementById('servicesTitle').textContent = websiteData.services.title;
            const gridContainer = document.getElementById('featuresGrid');
            gridContainer.innerHTML = '';
            websiteData.services.items.forEach((service, index) => {
                const card = document.createElement('div');
                card.className = 'feature-card';
                card.innerHTML = `<i class="fas ${service.icon}"></i><h3>${service.title}</h3><p>${service.desc}</p>`;
                gridContainer.appendChild(card);
            });
        }
        
        function dyStats() {
            const statsContainer = document.getElementById('statsGrid');
            statsContainer.innerHTML = '';
            websiteData.stats.items.forEach(stat => {
                const statDiv = document.createElement('div');
                statDiv.className = 'stat-item';
                statDiv.innerHTML = `<i class="fas ${stat.icon}"></i><div class="stat-number">${stat.number}</div><div>${stat.label}</div>`;
                statsContainer.append(statDiv);
            });
        }
        
        function dyPricing() {
            document.getElementById('pricingTitle').textContent = websiteData.pricing.title;
            const pricingContainer = document.getElementById('pricingGrid');
            pricingContainer.innerHTML = '';
            websiteData.pricing.plans.forEach((plan, index) => {
                const card = document.createElement('div');
                card.className = 'pricing-card';
                if (plan.popular) card.classList.add('popular');
                let featuresHtml = '';
                plan.features.forEach(feature => { featuresHtml += `<p>${feature}</p>`; });
                card.innerHTML = `${plan.popular ? '<div class="popular-badge">محبوب‌ترین</div>' : ''}<h3>${plan.name}</h3><div class="price">${plan.price}</div>${featuresHtml}`;
                pricingContainer.append(card);
            });
        }
        
        function dyCTA() {
            document.getElementById('ctaTitle').textContent = websiteData.cta.title;
            document.getElementById('ctaText').textContent = websiteData.cta.text;
            document.getElementById('ctaBtn').textContent = websiteData.cta.buttonText;
        }
        
        document.getElementById('ctaBtn').addEventListener('click', () => {
            openModal('registerModal');
        });
        
        function initHamburgerMenu() {
            const hamburger = document.getElementById('hamburgerBtn');
            const navMenu = document.getElementById('navMenu');
            hamburger.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                const icon = hamburger.querySelector('i');
                if (navMenu.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    navMenu.classList.remove('active');
                    const icon = hamburger.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                });
            });
        }


const userTestimonials = [
    {
        id: 1,
        name: "محمد شاه",
        position: "مدیر فنی شرکت هوشمند",
        comment: "بیش از ۲ سال است از Azure IaaS استفاده می‌کنم، واقعاً عالی و پایدار است! پشتیبانی عالی و سرعت بالا.",
        rating: 5,
        avatar: "MR",
        date: "۱۴۰۳/۱۲/۱۵"
    },
    {
        id: 2,
        name: "حلیم صابری",
        position: "توسعه‌دهنده ارشد",
        comment: "مهاجرت به Azure بهترین تصمیم بود. مقیاس‌پذیری فوق‌العاده و امنیت بالا از ویژگی‌های برجسته این سرویس است.",
        rating: 4,
        avatar: "SH",
        date: "۱۴۰۳/۱۲/۱۰"
    },
    {
        id: 3,
        name: "شکیبا حقیار",
        position: "مدیر پروژه استارتاپ",
        comment: "قیمت‌های منصفانه و امکانات عالی. تیم پشتیبانی همیشه پاسخگوی سوالات ما هستند. پیشنهاد می‌کنم.",
        rating: 4,
        avatar: "AK",
        date: "۱۴۰۳/۱۲/۰۵"
    },
    {
        id: 2,
        name: "حبیب الرحمن ",
        position: "مدیر دیتاسنتر",
        comment: "زیرساخت بسیار پایدار و مستحکم. آپتایم ۹۹.۹٪ واقعاً قابل اعتماد است. برای کسب‌وکارهای حیاتی عالی است.",
        rating: 3,
        avatar: "FN",
        date: "۱۴۰۳/۱۱/۲۸"
    },
    {
        id: 5,
        name: "حکمت نوری",
        position: "فریلنسر",
        comment: "محیط کاربری ساده و مستندات کامل. راه‌اندازی ماشین‌های مجازی فقط چند دقیقه طول می‌کشد.",
        rating: 1,
        avatar: "RA",
        date: "۱۴۰۳/۱۱/۲۰"
    },
    {
    id: 5
    ,
        name: "کریم سیاه",
        position: "مدیر شبکه",
        comment: "محیط کاربری ساده و مستندات کامل. راه‌اندازی ماشین‌های مجازی فقط چند دقیقه طول می‌کشد.",
        rating: 2,  
        avatar: "RA",
        date: "۱۴۰۳/۱۱/۲۰"
    }
];

const faqData = [
    {
        id: 1,
        question: "آیا نسخه رایگان دارد؟",
        answer: "بله، نسخه آزمایشی ۳۰ روزه رایگان با اعتبار اولیه ۲۰۰ دلاری برای تست سرویس‌ها ارائه می‌شود."
    },
    {
        id: 2,
        question: "آیا داده‌ها امن است؟",
        answer: "بله، کاملاً امن با گواهینامه‌های بین‌المللی ISO 27001، SOC 2 و رمزنگاری AES-256 برای داده‌های در حال استراحت و در حال انتقال."
    },
    {
        id: 3,
        question: "آیا می‌توان لغو کرد؟",
        answer: "در هر زمان می‌توانید سرویس خود را لغو کنید، بدون هزینه اضافی و فقط هزینه مصرف شده محاسبه می‌شود."
    },
    {
        id: 4,
        question: "پشتیبانی چگونه است؟",
        answer: "پشتیبانی ۲۴ ساعته، ۷ روز هفته از طریق تلفن، ایمیل و چت آنلاین. پلن‌های حرفه‌ای دارای پشتیبانی اولویت هستند."
    },
    {
        id: 5,
        question: "آیا می‌توانم منابع خود را مقیاس کنم؟",
        answer: "بله، می‌توانید در هر زمان منابع ماشین‌های مجازی خود را افزایش یا کاهش دهید بدون نیاز به راه‌اندازی مجدد."
    },
    {
        id: 6,
        question: "روش‌های پرداخت چیست؟",
        answer: "پرداخت آنلاین از طریق کارت‌های اعتباری، درگاه بانکی، یا صورتحساب ماهانه برای سازمان‌ها."
    }
];


        /// dunamic customer idea
function renderTestimonials() {
    const container = document.getElementById('testimonialsGrid');
    if (!container) return;
    
    container.innerHTML = '';
    
    userTestimonials.forEach(testimonial => {
        // ساخت ستاره‌ها بر اساس امتیاز
        let starsHtml = '';
        for (let i = 0; i < 5; i++) {
            if (i < testimonial.rating) {
                starsHtml += '<i class="fas fa-star"></i>';
            } else {
                starsHtml += '<i class="far fa-star"></i>';
            }
        }
        
        const card = document.createElement('div');
        card.className = 'testimonial-card';
        card.innerHTML = `
            <div class="quote-icon">
                <i class="fas fa-quote-right"></i>
            </div>
            <div class="testimonial-content">
                <p>${escapeHtml(testimonial.comment)}</p>
            </div>
            <div class="testimonial-footer">
                <div class="avatar" style="background: linear-gradient(135deg, #0078d4, #00a8e8);">
                    ${testimonial.avatar}
                </div>
                <div class="info">
                    <h4>${escapeHtml(testimonial.name)}</h4>
                    <p>${escapeHtml(testimonial.position)}</p>
                    <div class="stars">${starsHtml}</div>
                </div>
            </div>
            <div class="testimonial-date">
                <i class="far fa-calendar-alt"></i> ${testimonial.date}
            </div>
        `;
        container.appendChild(card);
    });
}

// ========== رندر سوالات متداول ==========
function renderFaq() {
    const container = document.getElementById('faqGrid');
    if (!container) return;
    
    container.innerHTML = '';
    
    faqData.forEach((faq, index) => {
        const faqItem = document.createElement('div');
        faqItem.className = 'faq-item';
        faqItem.innerHTML = `
            <div class="faq-question" data-idx="${index}">
                <h4><i class="fas fa-question-circle"></i> ${escapeHtml(faq.question)}</h4>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer" id="faqAnswer${index}">
                <p>${escapeHtml(faq.answer)}</p>
            </div>
        `;
        container.appendChild(faqItem);
    });
    
    // اضافه کردن رویداد کلیک برای باز و بسته شدن
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const idx = btn.getAttribute('data-idx');
            const answer = document.getElementById(`faqAnswer${idx}`);
            const icon = btn.querySelector('.fa-chevron-down, .fa-chevron-up');
            answer.classList.toggle('open');
            if (answer.classList.contains('open')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
    });
}

// تابع escapeHtml برای امنیت
function escapeHtml(str) {
    if (!str) return '';
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}


renderTestimonials();
renderFaq();
        
        dyHero();
        dyServices();
        dyStats();
        dyPricing();
        dyCTA();
        initHamburgerMenu();
    </script>
<script>
    const video = document.getElementById('demoVideo');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const volumeBtn = document.getElementById('volumeBtn');
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const playOverlay = document.getElementById('playOverlay');
    const videoUpload = document.getElementById('videoUpload');
    const resetVideoBtn = document.getElementById('resetVideoBtn');
    const videoWrapper = document.getElementById('videoWrapper');

    let isPlaying = false;
    let isMuted = false;

    function showVideoToast(message, isSuccess = true) {
        const toast = document.getElementById('videoToastMessage');
        if (!toast) return;
        toast.textContent = message;
        toast.className = `video-toast show ${isSuccess ? 'success' : 'error'}`;
        setTimeout(() => { 
            toast.className = 'video-toast'; 
        }, 3000);
    }

    function openVideoModal() {
        const modal = document.getElementById('videoSuccessModal');
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeVideoModal() {
        const modal = document.getElementById('videoSuccessModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    window.closeVideoModal = closeVideoModal;

    function togglePlay() {
        if (video.paused) {
            video.play();
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i> توقف';
            if (playOverlay) playOverlay.classList.add('hidden');
            isPlaying = true;
        } else {
            video.pause();
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i> پخش';
            if (playOverlay) playOverlay.classList.remove('hidden');
            isPlaying = false;
        }
    }

    if (playPauseBtn) playPauseBtn.addEventListener('click', togglePlay);
    if (playOverlay) playOverlay.addEventListener('click', togglePlay);

    if (volumeBtn) {
        volumeBtn.addEventListener('click', () => {
            if (isMuted) {
                video.muted = false;
                volumeBtn.innerHTML = '<i class="fas fa-volume-up"></i> صدا';
                isMuted = false;
            } else {
                video.muted = true;
                volumeBtn.innerHTML = '<i class="fas fa-volume-mute"></i> بی صدا';
                isMuted = true;
            }
        });
    }

    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', () => {
            if (videoWrapper.requestFullscreen) {
                videoWrapper.requestFullscreen();
            } else if (videoWrapper.webkitRequestFullscreen) {
                videoWrapper.webkitRequestFullscreen();
            }
        });
    }

    if (videoUpload) {
        videoUpload.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                if (file.type.startsWith('video/')) {
                    const fileURL = URL.createObjectURL(file);
                    video.src = fileURL;
                    video.load();
                    video.play();
                    playPauseBtn.innerHTML = '<i class="fas fa-pause"></i> توقف';
                    if (playOverlay) playOverlay.classList.add('hidden');
                    openVideoModal();  // استفاده از تابع مودال ویدیو
                    showVideoToast(`ویدیو "${file.name}" با موفقیت آپلود شد 🎬`, true);
                } else {
                    showVideoToast('لطفاً یک فایل ویدیویی معتبر انتخاب کنید', false);
                }
            }
            videoUpload.value = '';
        });
    }

    if (resetVideoBtn) {
        resetVideoBtn.addEventListener('click', () => {
            video.src = "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4";
            video.load();
            video.play();
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i> توقف';
            if (playOverlay) playOverlay.classList.add('hidden');
            showVideoToast('ویدیوی پیش‌فرض بارگذاری شد 🔄', true);
        });
    }

    video.addEventListener('ended', () => {
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i> پخش';
        if (playOverlay) playOverlay.classList.remove('hidden');
        isPlaying = false;
    });

    video.addEventListener('click', togglePlay);

    window.addEventListener('click', (e) => {
        const modal = document.getElementById('videoSuccessModal');
        if (e.target === modal) closeVideoModal();
    });
</script>
    </body>
    </html>

@endsection('home')