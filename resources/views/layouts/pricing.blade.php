@extends('layouts.sidebar')

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>قیمت | Azure IaaS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="Pricing.css">
    <link rel="stylesheet" href="HomePage.css">
    @vite('resources/css/pricing.style.css'); 
    @vite('resources/js/pricing.js'); 
    @vite('resources/css/homePage.style.css'); 
    
    

</head>
<body>

<div class="layout">
    <!-- سایدبار -->
    <!-- <aside class="sidebar">
        <h2><i class="fab fa-microsoft"></i> Azure</h2>
        <nav class="sidebar-nav">
            <a href="HomePage.html" class="active"><i class="fas fa-tachometer-alt"></i>صفحه اصلی</a>

            <a href="/dashboard"><i class="fas fa-tachometer-alt"></i> داشبورد</a>
            <a href="/VirtualMachines"><i class="fas fa-server"></i> ماشین مجازی</a>
            <a href="/Storage"><i class="fas fa-database"></i> ذخیره‌سازی</a>
            <a href="/Networking"><i class="fas fa-network-wired"></i> شبکه</a>
            <a href="/Security"><i class="fas fa-shield-alt"></i> امنیت</a>
            <a href="/Pricing" class="active"><i class="fas fa-tag"></i> قیمت</a>
        </nav>
    </aside> -->
@section('main')
    <!-- محتوای اصلی -->
    <main class="main">
        <div class="topbar">
            <div class="topbar-left">
                <div class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></div>
                <h3><i class="fas fa-tag"></i> قیمت‌گذاری و تعرفه‌ها</h3>
            </div>
            <div class="topbar-right">
                <button class="toggle-btn" id="toggleBillingBtn"><i class="fas fa-calendar-alt"></i> تغییر به پرداخت سالانه</button>
            </div>
        </div>

        <!-- پلن‌های قیمتی -->
        <div class="plans-section">
            <h2 class="section-title">پلن‌های قیمتی <span id="billingPeriod">ماهانه</span></h2>
            <div class="plans-grid" id="plansGrid"></div>
        </div>

        <!-- ماشین حساب -->
        <div class="calculator-section">
            <div class="section-header">
                <h3><i class="fas fa-calculator"></i> ماشین حساب هزینه</h3>
                <span class="calculator-badge">برآورد دقیق</span>
            </div>
            <div class="calculator-container">
                <div class="calculator-inputs">
                    <div class="input-group">
                        <label><i class="fas fa-microchip"></i> نوع ماشین مجازی</label>
                        <select id="vmTypeSelect">
                            <option value="B1s">B1s (1 vCPU, 1GB) - $0.010/ساعت</option>
                            <option value="B2s">B2s (2 vCPU, 4GB) - $0.020/ساعت</option>
                            <option value="D2s">D2s (2 vCPU, 8GB) - $0.096/ساعت</option>
                            <option value="D4s">D4s (4 vCPU, 16GB) - $0.192/ساعت</option>
                            <option value="E4s">E4s (4 vCPU, 32GB) - $0.252/ساعت</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-hdd"></i> فضای ذخیره‌سازی (GB)</label>
                        <input type="range" id="storageSlider" min="0" max="5000" step="100" value="500">
                        <span id="storageValue" class="range-value">500 GB</span>
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-cloud-upload-alt"></i> پهنای باند خروجی (GB)</label>
                        <input type="range" id="bandwidthSlider" min="0" max="10000" step="100" value="1000">
                        <span id="bandwidthValue" class="range-value">1,000 GB</span>
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-server"></i> تعداد ماشین‌ها</label>
                        <div class="number-input">
                            <button class="num-btn" id="vmCountMinus">-</button>
                            <span id="vmCount">1</span>
                            <button class="num-btn" id="vmCountPlus">+</button>
                        </div>
                    </div>
                </div>
                <div class="calculator-result">
                    <div class="result-card">
                        <h4>برآورد هزینه ماهانه</h4>
                        <div class="result-price" id="totalPrice">$0.00</div>
                        <div class="result-details">
                            <div class="detail-item"><span>VM:</span><span id="vmCost">$0.00</span></div>
                            <div class="detail-item"><span>ذخیره‌سازی:</span><span id="storageCost">$0.00</span></div>
                            <div class="detail-item"><span>پهنای باند:</span><span id="bandwidthCost">$0.00</span></div>
                        </div>
                        <button class="apply-calc-btn" id="applyCalcBtn">دریافت نقل قول</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول جزئیات قیمت -->
        <div class="details-section">
            <div class="section-header">
                <h3><i class="fas fa-table"></i> جزئیات قیمت</h3>
                <div class="table-tabs">
                    <button class="table-tab active" data-tab="vm">ماشین مجازی</button>
                    <button class="table-tab" data-tab="storage">ذخیره‌سازی</button>
                    <button class="table-tab" data-tab="network">شبکه</button>
                </div>
            </div>
            <div class="table-wrapper">
                <div id="vmTable" class="price-table active">
                    <table>
                        <thead><tr><th>سری</th><th>vCPU</th><th>RAM</th><th>قیمت ساعتی</th><th>قیمت ماهانه</th><th>قیمت سالانه</th></tr></thead>
                        <tbody id="vmPriceTable"></tbody>
                    </table>
                </div>
                <div id="storageTable" class="price-table">
                    <table>
                        <thead><tr><th>نوع</th><th>عملکرد</th><th>قیمت هر GB/ماه</th><th>مناسب برای</th></tr></thead>
                        <tbody id="storagePriceTable"></tbody>
                    </table>
                </div>
                <div id="networkTable" class="price-table">
                    <table>
                        <thead><tr><th>نوع ترافیک</th><th>داخل منطقه</th><th>بین مناطق</th><th>خروجی به اینترنت</th></tr></thead>
                        <tbody id="networkPriceTable"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- سوالات متداول -->
        <div class="faq-section">
            <div class="section-header">
                <h3><i class="fas fa-question-circle"></i> سوالات متداول درباره قیمت</h3>
            </div>
            <div class="faq-grid" id="pricingFaq"></div>
        </div>

        <!-- تماس با فروش -->
        <div class="contact-sales">
            <i class="fas fa-headset"></i>
            <h3>نیاز به قیمت سفارشی دارید؟</h3>
            <p>برای پروژه‌های بزرگ، تیم فروش ما آماده ارائه تخفیف ویژه است</p>
            <button class="contact-btn" id="contactSalesBtn">تماس با فروش <i class="fas fa-arrow-left"></i></button>
        </div>
    </main>
    
</div>
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
<!-- مودال نقل قول -->
<div id="quoteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-file-invoice-dollar"></i> نقل قول قیمت</h2>
            <span class="close-modal" id="closeModalBtn">&times;</span>
        </div>
        <div class="quote-body" id="quoteBody"></div>
        <div class="modal-buttons">
            <button id="closeQuoteBtn" class="btn-secondary">بستن</button>
            <button id="downloadQuoteBtn" class="btn-primary">دانلود نقل قول</button>
        </div>
    </div>
</div>

<div id="toastMessage" class="toast"></div>

<script src="pricing.js"></script>
</body>
</html>
@endsection('main')