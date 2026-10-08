
// ========== داده‌های قیمت ==========
let billingType = "monthly";

const plans = [
    { id: 1, name: "شروع", priceMonthly: 19, priceYearly: 190, cpu: "1 vCPU", ram: "1 GB", storage: "30 GB SSD", support: "پشتیبانی معمولی", popular: false, features: ["وب سایت ساده", "تست و توسعه", "پهنای باند 5GB"] },
    { id: 2, name: "حرفه‌ای", priceMonthly: 79, priceYearly: 790, cpu: "4 vCPU", ram: "8 GB", storage: "250 GB SSD", support: "پشتیبانی اولویت", popular: true, features: ["برنامه‌های سازمانی", "دیتابیس‌های سنگین", "پهنای باند 100GB", "مانیتورینگ پایه"] },
    { id: 3, name: "سازمانی", priceMonthly: 299, priceYearly: 2990, cpu: "16 vCPU", ram: "32 GB", storage: "1 TB SSD", support: "پشتیبانی 24/7", popular: false, features: ["زیرساخت‌های حیاتی", "هوش مصنوعی", "پهنای باند نامحدود", "SLA 99.99%"] }
];

const vmPrices = [
    { series: "B1ls", vcpu: 1, ram: "0.5 GB", hourly: 0.005, monthly: 3.65, yearly: 36.50 },
    { series: "B1s", vcpu: 1, ram: "1 GB", hourly: 0.010, monthly: 7.30, yearly: 73.00 },
    { series: "B2s", vcpu: 2, ram: "4 GB", hourly: 0.020, monthly: 14.60, yearly: 146.00 },
    { series: "D2s v4", vcpu: 2, ram: "8 GB", hourly: 0.096, monthly: 70.08, yearly: 700.80 },
    { series: "D4s v4", vcpu: 4, ram: "16 GB", hourly: 0.192, monthly: 140.16, yearly: 1401.60 },
    { series: "E4s v4", vcpu: 4, ram: "32 GB", hourly: 0.252, monthly: 183.96, yearly: 1839.60 }
];

const storagePrices = [
    { type: "Standard HDD", performance: "متوسط", pricePerGB: 0.002, suitable: "دسترسی کم, بکاپ" },
    { type: "Standard SSD", performance: "خوب", pricePerGB: 0.005, suitable: "وب سرور, توسعه" },
    { type: "Premium SSD", performance: "عالی", pricePerGB: 0.012, suitable: "دیتابیس, تولید" }
];

const networkPrices = [
    { type: "ترافیک داخلی (همان منطقه)", intraRegion: "رایگان", interRegion: "$0.005/GB", internetOut: "-" },
    { type: "ترافیک بین مناطق (اروپا-آمریکا)", intraRegion: "-", interRegion: "$0.008/GB", internetOut: "-" },
    { type: "ترافیک خروجی به اینترنت (5GB اول)", intraRegion: "-", interRegion: "-", internetOut: "رایگان" },
    { type: "ترافیک خروجی به اینترنت (بیشتر)", intraRegion: "-", interRegion: "-", internetOut: "$0.087/GB" }
];

const pricingFaq = [
    { q: "آیا نسخه رایگان دارد؟", a: "بله، 12 ماه رایگان شامل 750 ساعت B1s و 100GB فضای ذخیره‌سازی" },
    { q: "پرداخت به چه صورت است؟", a: "پرداخت به صورت ماهانه یا سالانه، با کارت اعتباری یا صورتحساب سازمانی" },
    { q: "آیا می‌توانم هر زمان لغو کنم؟", a: "بله، بدون هزینه لغو و فقط هزینه مصرف شده محاسبه می‌شود" },
    { q: "آیا پشتیبانی 24/7 شامل قیمت می‌شود؟", a: "پشتیبانی پایه رایگان است. پلن‌های حرفه‌ای هزینه جدا دارند" }
];

// ========== توابع کمکی ==========
function showToast(message, isSuccess = true) {
    const toast = document.getElementById('toastMessage');
    toast.textContent = message;
    toast.className = `toast show ${isSuccess ? 'success' : 'error'}`;
    setTimeout(() => { toast.classList.remove('show'); }, 3000);
}

// ========== رندر پلن‌ها ==========
function renderPlans() {
    const container = document.getElementById('plansGrid');
    container.innerHTML = '';
    plans.forEach(plan => {
        const price = billingType === 'monthly' ? plan.priceMonthly : plan.priceYearly;
        const priceLabel = billingType === 'monthly' ? '/ماه' : '/سال';
        const card = document.createElement('div');
        card.className = `plan-card ${plan.popular ? 'popular' : ''}`;
        card.innerHTML = `
            ${plan.popular ? '<div class="popular-badge"><i class="fas fa-star"></i> محبوب‌ترین</div>' : ''}
            <h3>${plan.name}</h3>
            <div class="plan-price">$${price}<span>${priceLabel}</span></div>
            <div class="plan-specs">
                <div><i class="fas fa-microchip"></i> ${plan.cpu}</div>
                <div><i class="fas fa-memory"></i> ${plan.ram}</div>
                <div><i class="fas fa-hdd"></i> ${plan.storage}</div>
                <div><i class="fas fa-headset"></i> ${plan.support}</div>
            </div>
            <ul class="plan-features">${plan.features.map(f => `<li><i class="fas fa-check-circle"></i> ${f}</li>`).join('')}</ul>
            <button class="select-plan-btn" data-plan="${plan.name}">انتخاب پلن <i class="fas fa-arrow-left"></i></button>
        `;
        container.appendChild(card);
    });
    document.querySelectorAll('.select-plan-btn').forEach(btn => {
        btn.addEventListener('click', () => showToast(`پلن ${btn.getAttribute('data-plan')} برای شما رزرو شد!`, true));
    });
}

// ========== رندر جداول قیمت ==========
function renderVMPrices() {
    const tbody = document.getElementById('vmPriceTable');
    tbody.innerHTML = vmPrices.map(vm => `
        <tr>
            <td>${vm.series}</td>
            <td>${vm.vcpu}</td>
            <td>${vm.ram}</td>
            <td>$${vm.hourly.toFixed(3)}/ساعت</td>
            <td>$${vm.monthly.toFixed(2)}/ماه</td>
            <td>$${vm.yearly.toFixed(2)}/سال</td>
        </tr>
    `).join('');
}

function renderStoragePrices() {
    const tbody = document.getElementById('storagePriceTable');
    tbody.innerHTML = storagePrices.map(s => `
        <tr>
            <td>${s.type}</td>
            <td>${s.performance}</td>
            <td>$${s.pricePerGB.toFixed(4)}/GB</td>
            <td>${s.suitable}</td>
        </tr>
    `).join('');
}

function renderNetworkPrices() {
    const tbody = document.getElementById('networkPriceTable');
    tbody.innerHTML = networkPrices.map(n => `
        <tr>
            <td>${n.type}</td>
            <td>${n.intraRegion}</td>
            <td>${n.interRegion}</td>
            <td>${n.internetOut}</td>
        </tr>
    `).join('');
}

// ========== سوالات متداول ==========
function renderFaq() {
    const container = document.getElementById('pricingFaq');
    container.innerHTML = pricingFaq.map((faq, idx) => `
        <div class="faq-item">
            <div class="faq-question" data-idx="${idx}">
                <h4><i class="fas fa-question-circle"></i> ${faq.q}</h4>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer" id="faqAnswer${idx}"><p>${faq.a}</p></div>
        </div>
    `).join('');
    
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const idx = btn.getAttribute('data-idx');
            const answer = document.getElementById(`faqAnswer${idx}`);
            const icon = btn.querySelector('.fa-chevron-down, .fa-chevron-up');
            answer.classList.toggle('open');
            icon.className = answer.classList.contains('open') ? 'fas fa-chevron-up' : 'fas fa-chevron-down';
        });
    });
}

// ========== ماشین حساب ==========
const vmRates = { 'B1s': 0.010, 'B2s': 0.020, 'D2s': 0.096, 'D4s': 0.192, 'E4s': 0.252 };

function updateCalculator() {
    const vmType = document.getElementById('vmTypeSelect').value;
    const storageGB = parseInt(document.getElementById('storageSlider').value);
    const bandwidthGB = parseInt(document.getElementById('bandwidthSlider').value);
    const vmCount = parseInt(document.getElementById('vmCount').innerText);
    
    const vmMonthly = vmRates[vmType] * 730 * vmCount;
    const storageCost = storageGB * 0.005;
    const bandwidthCost = bandwidthGB > 5 ? (bandwidthGB - 5) * 0.087 : 0;
    const total = vmMonthly + storageCost + bandwidthCost;
    
    document.getElementById('vmCost').innerHTML = `$${vmMonthly.toFixed(2)}`;
    document.getElementById('storageCost').innerHTML = `$${storageCost.toFixed(2)}`;
    document.getElementById('bandwidthCost').innerHTML = `$${bandwidthCost.toFixed(2)}`;
    document.getElementById('totalPrice').innerHTML = `$${total.toFixed(2)}`;
}

function initCalculator() {
    document.getElementById('vmTypeSelect').addEventListener('change', updateCalculator);
    document.getElementById('storageSlider').addEventListener('input', (e) => {
        document.getElementById('storageValue').innerHTML = `${e.target.value} GB`;
        updateCalculator();
    });
    document.getElementById('bandwidthSlider').addEventListener('input', (e) => {
        document.getElementById('bandwidthValue').innerHTML = `${parseInt(e.target.value).toLocaleString()} GB`;
        updateCalculator();
    });
    document.getElementById('vmCountMinus').addEventListener('click', () => {
        let count = parseInt(document.getElementById('vmCount').innerText);
        if (count > 1) { document.getElementById('vmCount').innerText = count - 1; updateCalculator(); }
    });
    document.getElementById('vmCountPlus').addEventListener('click', () => {
        let count = parseInt(document.getElementById('vmCount').innerText);
        document.getElementById('vmCount').innerText = count + 1; updateCalculator();
    });
    updateCalculator();
}

// ========== مودال نقل قول ==========
const quoteModal = document.getElementById('quoteModal');

function openModal(modal) { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closeModal(modal) { modal.style.display = 'none'; document.body.style.overflow = ''; }

document.getElementById('applyCalcBtn').addEventListener('click', () => {
    const total = document.getElementById('totalPrice').innerText;
    document.getElementById('quoteBody').innerHTML = `
        <div class="quote-detail"><strong>نوع ماشین مجازی:</strong> ${document.getElementById('vmTypeSelect').value}</div>
        <div class="quote-detail"><strong>تعداد ماشین‌ها:</strong> ${document.getElementById('vmCount').innerText} عدد</div>
        <div class="quote-detail"><strong>فضای ذخیره‌سازی:</strong> ${document.getElementById('storageSlider').value} GB</div>
        <div class="quote-detail"><strong>پهنای باند خروجی:</strong> ${parseInt(document.getElementById('bandwidthSlider').value).toLocaleString()} GB</div>
        <div class="quote-total"><strong>مبلغ کل ماهانه:</strong> ${total}</div>
        <p style="margin-top:1rem;font-size:0.8rem;color:#718096;">این نقل قول به مدت 30 روز معتبر است.</p>
    `;
    openModal(quoteModal);
});

document.getElementById('closeModalBtn').addEventListener('click', () => closeModal(quoteModal));
document.getElementById('closeQuoteBtn').addEventListener('click', () => closeModal(quoteModal));
document.getElementById('downloadQuoteBtn').addEventListener('click', () => { 
    showToast('فایل نقل قول دانلود شد 📄', true); 
    closeModal(quoteModal); 
});
document.getElementById('contactSalesBtn').addEventListener('click', () => showToast('درخواست شما ثبت شد. کارشناسان تماس می‌گیرند 📞', true));

// ========== تغییر بین ماهانه/سالانه ==========
document.getElementById('toggleBillingBtn').addEventListener('click', () => {
    if (billingType === 'monthly') {
        billingType = 'yearly';
        document.getElementById('toggleBillingBtn').innerHTML = '<i class="fas fa-calendar-alt"></i> تغییر به پرداخت ماهانه';
        document.getElementById('billingPeriod').innerHTML = 'سالانه';
    } else {
        billingType = 'monthly';
        document.getElementById('toggleBillingBtn').innerHTML = '<i class="fas fa-calendar-alt"></i> تغییر به پرداخت سالانه';
        document.getElementById('billingPeriod').innerHTML = 'ماهانه';
    }
    renderPlans();
});

// ========== تب‌های جدول ==========
document.querySelectorAll('.table-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.table-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        document.querySelectorAll('.price-table').forEach(t => t.classList.remove('active'));
        const tabName = tab.getAttribute('data-tab');
        if (tabName === 'vm') document.getElementById('vmTable').classList.add('active');
        else if (tabName === 'storage') document.getElementById('storageTable').classList.add('active');
        else if (tabName === 'network') document.getElementById('networkTable').classList.add('active');
    });
});

// ========== منوی همبرگری ==========
function initHamburgerMenu() {
    const hamburger = document.getElementById('hamburgerBtn');
    const sidebar = document.querySelector('.sidebar');
    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        const icon = hamburger.querySelector('i');
        icon.className = sidebar.classList.contains('active') ? 'fas fa-times' : 'fas fa-bars';
    });
}

// ========== بستن مودال با کلیک بیرون ==========
window.addEventListener('click', (e) => { 
    if (e.target === quoteModal) closeModal(quoteModal); 
});

// ========== اجرای اولیه ==========
renderPlans();
renderVMPrices();
renderStoragePrices();
renderNetworkPrices();
renderFaq();
initCalculator();
initHamburgerMenu();