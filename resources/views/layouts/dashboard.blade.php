@extends('layouts.sidebar')
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>داشبورد | Azure IaaS</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <!-- فایل CSS جداگانه -->
    <!-- <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="HomePage.css"> -->
    @vite('resources/css/dashboard.style.css'); 
    @vite('resources/css/homePage.style.css'); 
    
    


</head>
<body>
<div class="layout">
<!-- سایدبار
       <aside class="sidebar">
        <h2><i class="fab fa-microsoft"></i> Azure</h2>
        <nav class="sidebar-nav">
            <a href="HomePage.html" class="active"><i class="fas fa-tachometer-alt"></i>صفحه اصلی</a>

            <a href="/Dashboard"><i class="fas fa-tachometer-alt"></i> داشبورد</a>
            <a href="/layouts/VirtualMachines"><i class="fas fa-server"></i> ماشین مجازی</a>
            <a href="/layouts/Storage"><i class="fas fa-database"></i> ذخیره‌سازی</a>
            <a href="/layouts/Networking" class="active"><i class="fas fa-network-wired"></i> شبکه</a>
            <a href="/layouts/Security"><i class="fas fa-shield-alt"></i> امنیت</a>
            <a href="/layouts/Pricing"><i class="fas fa-tag"></i> قیمت</a>
        </nav>
    </aside> -->
@section('main')

    <!-- محتوای اصلی -->
    <main class="main">
        <div class="topbar">
            <div class="topbar-left">
                <div class="hamburger" id="hamburgerBtn">
                    <i class="fas fa-bars"></i>
                </div>
                <h3><i class="fas fa-chart-line"></i> داشبورد مدیریت</h3>
            </div>
            <div class="topbar-right">
                <div class="user-info" id="userInfo">
                    <i class="fas fa-user-circle"></i>
                    <span id="userName">کاربر مهمان</span>
                </div>
                <button class="create-btn" id="createResourceBtn"><i class="fas fa-plus-circle"></i> ایجاد منبع</button>
            </div>
        </div>

        <!-- کارت‌های آمار - داینامیک -->
        <div class="cards" id="cardsContainer"></div>

        <!-- بخش اصلی: جدول + نمودار -->
        <div class="dashboard-grid">
            <div class="table-section">
                <div class="section-header">
                    <h3><i class="fas fa-server"></i> ماشین‌های مجازی</h3>
                    <button class="refresh-btn" id="refreshTableBtn"><i class="fas fa-sync-alt"></i></button>
                </div>
                <div class="table-wrapper">
                    <table id="vmsTable">
                        <thead>
                            <tr><th>نام</th><th>وضعیت</th><th>CPU</th><th>RAM</th><th>نوع</th><th>عملیات</th></tr>
                        </thead>
                        <tbody id="vmsTableBody"></tbody>
                    </table>
                </div>
                <div class="table-footer">
                    <span id="tableInfo"></span>
                </div>
            </div>

            <div class="chart-card">
                <h3><i class="fas fa-chart-pie"></i> مصرف منابع CPU</h3>
                <canvas id="cpuChart" width="400" height="220"></canvas>
                <div class="chart-footer" id="chartFooter"></div>
            </div>
        </div>

        <!-- بخش هشدارها و رویدادها -->
        <div class="alerts-section">
            <div class="section-header">
                <h3><i class="fas fa-bell"></i> هشدارها و رویدادها</h3>
                <button class="clear-btn" id="clearAlertsBtn"><i class="fas fa-trash-alt"></i> پاک کردن همه</button>
            </div>
            <div id="alertsContainer"></div>
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
<!-- مودال ایجاد منبع -->
<div id="resourceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-plus-circle"></i> ایجاد منبع جدید</h2>
            <span class="close-modal" id="closeModalBtn">&times;</span>
        </div>
        <form id="resourceForm">
            <div class="form-group">
                <label><i class="fas fa-tag"></i> نوع منبع</label>
                <select id="resourceType">
                    <option value="vm">ماشین مجازی</option>
                    <option value="storage">ذخیره‌سازی</option>
                    <option value="network">شبکه</option>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fas fa-font"></i> نام منبع</label>
                <input type="text" id="resourceName" placeholder="مثال: VM-Production">
                <small class="error-message" id="resourceNameError"></small>
            </div>
            <button type="submit" class="modal-submit-btn">ایجاد منبع</button>
        </form>
    </div>
</div>

<!-- مودال خروج -->
<div id="logoutModal" class="modal">
    <div class="modal-content logout-modal">
        <div class="modal-header">
            <h2><i class="fas fa-sign-out-alt"></i> خروج از حساب</h2>
            <span class="close-modal" id="closeLogoutModalBtn">&times;</span>
        </div>
        <div class="modal-body">
            <p>آیا مطمئن هستید که می‌خواهید خارج شوید؟</p>
        </div>
        <div class="modal-buttons">
            <button id="confirmLogoutBtn" class="btn-danger">بله، خروج</button>
            <button id="cancelLogoutBtn" class="btn-secondary">انصراف</button>
        </div>
    </div>
</div>

<!-- پیام Toast -->
<div id="toastMessage" class="toast"></div>

<script>
    // ========== داده‌های داینامیک ==========
    let dashboardData = {
        cards: [
            { id: 1, icon: "fa-microchip", title: "ماشین‌های فعال", value: "12", unit: "", change: "+2", color: "blue" },
            { id: 2, icon: "fa-hdd", title: "ذخیره‌سازی مصرفی", value: "1.24", unit: "TB", change: "+0.12", color: "green" },
            { id: 3, icon: "fa-network-wired", title: "شبکه‌های مجازی", value: "5", unit: "", change: "", color: "purple" },
            { id: 4, icon: "fa-exclamation-triangle", title: "هشدارهای فعال", value: "2", unit: "", change: "-1", color: "red" }
        ],
        vms: [
            { id: 1, name: "VM-WebServer", status: "active", cpu: 42, ram: "8GB", type: "B2s" },
            { id: 2, name: "VM-Database", status: "active", cpu: 68, ram: "16GB", type: "D4s" },
            { id: 3, name: "VM-Backup", status: "stopped", cpu: 0, ram: "4GB", type: "B1s" },
            { id: 4, name: "VM-K8s-Master", status: "active", cpu: 23, ram: "8GB", type: "D2s" },
            { id: 5, name: "VM-Logging", status: "warning", cpu: 89, ram: "4GB", type: "B2s" }
        ],
        alerts: [
            { id: 1, icon: "fa-shield-virus", text: "هشدار: ترافیک غیرمعمول در VM-WebServer", time: "۲ دقیقه پیش", type: "danger" },
            { id: 2, icon: "fa-database", text: "فضای ذخیره‌سازی دیسک مدیریت‌شده به 85% رسید", time: "۱ ساعت پیش", type: "warning" },
            { id: 3, icon: "fa-check-circle", text: "پشتیبان‌گیری خودکار از VM-Backup انجام شد", time: "۳ ساعت پیش", type: "success" },
            { id: 4, icon: "fa-network-wired", text: "آدرس IP عمومی برای LoadBalancer تخصیص یافت", time: "روز گذشته", type: "info" }
        ]
    };

    let chartInstance = null;

    // ========== توابع کمکی ==========
    function showToast(message, isSuccess = true) {
        const toast = document.getElementById('toastMessage');
        toast.textContent = message;
        toast.className = `toast show ${isSuccess ? 'success' : 'error'}`;
        setTimeout(() => {
            toast.className = 'toast';
        }, 3000);
    }

    function getStatusBadge(status) {
        const statusMap = {
            active: '<span class="status-badge status-active"><i class="fas fa-play-circle"></i> فعال</span>',
            stopped: '<span class="status-badge status-stopped"><i class="fas fa-stop-circle"></i> متوقف</span>',
            warning: '<span class="status-badge status-warning"><i class="fas fa-exclamation-triangle"></i> هشدار</span>'
        };
        return statusMap[status] || statusMap.stopped;
    }

    function getAlertIcon(type) {
        const iconMap = {
            danger: 'fa-shield-virus',
            warning: 'fa-exclamation-triangle',
            success: 'fa-check-circle',
            info: 'fa-info-circle'
        };
        return iconMap[type] || 'fa-bell';
    }

    function getAlertColor(type) {
        const colorMap = {
            danger: '#e74c3c',
            warning: '#f39c12',
            success: '#2ecc71',
            info: '#3498db'
        };
        return colorMap[type] || '#3498db';
    }

    // ========== رندر کارت‌ها ==========
    function renderCards() {
        const container = document.getElementById('cardsContainer');
        container.innerHTML = '';
        dashboardData.cards.forEach(card => {
            const cardDiv = document.createElement('div');
            cardDiv.className = 'card';
            cardDiv.innerHTML = `
                <div class="card-icon ${card.color}"><i class="fas ${card.icon}"></i></div>
                <div class="card-info">
                    <h4>${card.title}</h4>
                    <p>${card.value} <span class="card-unit">${card.unit}</span></p>
                    ${card.change ? `<small class="card-change ${card.change.startsWith('+') ? 'positive' : 'negative'}">${card.change}</small>` : ''}
                </div>
            `;
            container.appendChild(cardDiv);
        });
    }

    // ========== رندر جدول ماشین‌های مجازی ==========
    function renderVMsTable() {
        const tbody = document.getElementById('vmsTableBody');
        const infoSpan = document.getElementById('tableInfo');
        
        tbody.innerHTML = '';
        const activeCount = dashboardData.vms.filter(vm => vm.status === 'active').length;
        infoSpan.textContent = `${activeCount} ماشین از ${dashboardData.vms.length} عدد فعال هستند`;
        
        dashboardData.vms.forEach(vm => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><i class="fas fa-server"></i> ${vm.name}</td>
                <td>${getStatusBadge(vm.status)}</td>
                <td><div class="cpu-progress"><div class="cpu-fill" style="width: ${vm.cpu}%"></div><span>${vm.cpu}%</span></div></td>
                <td>${vm.ram}</td>
                <td>${vm.type}</td>
                <td class="vm-actions">
                    <i class="fas fa-play-circle" data-id="${vm.id}" data-action="start" title="شروع"></i>
                    <i class="fas fa-stop-circle" data-id="${vm.id}" data-action="stop" title="توقف"></i>
                    <i class="fas fa-sync-alt" data-id="${vm.id}" data-action="restart" title="راه‌اندازی مجدد"></i>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        // افزودن رویدادهای عملیات
        document.querySelectorAll('.vm-actions i').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const vmId = parseInt(btn.getAttribute('data-id'));
                const action = btn.getAttribute('data-action');
                handleVMAction(vmId, action);
            });
        });
    }
    
    function handleVMAction(vmId, action) {
        const vm = dashboardData.vms.find(v => v.id === vmId);
        if (!vm) return;
        
        const actionText = {
            start: 'شروع',
            stop: 'توقف',
            restart: 'راه‌اندازی مجدد'
        };
        
        if (action === 'start' && vm.status === 'active') {
            showToast(`${vm.name} قبلاً فعال است!`, false);
            return;
        }
        if (action === 'stop' && vm.status === 'stopped') {
            showToast(`${vm.name} قبلاً متوقف است!`, false);
            return;
        }
        
        if (action === 'start') {
            vm.status = 'active';
            showToast(`${vm.name} با موفقیت شروع به کار کرد ✅`, true);
        } else if (action === 'stop') {
            vm.status = 'stopped';
            showToast(`${vm.name} متوقف شد ⏹️`, true);
        } else if (action === 'restart') {
            showToast(`${vm.name} در حال راه‌اندازی مجدد... 🔄`, true);
            setTimeout(() => {
                vm.cpu = Math.floor(Math.random() * 80) + 10;
                renderVMsTable();
                renderChart();
                showToast(`${vm.name} راه‌اندازی مجدد شد ✅`, true);
            }, 1500);
            return;
        }
        
        renderVMsTable();
        updateCardsFromVMs();
        renderChart();
        addAlert(`عملیات ${actionText[action]} روی ${vm.name} انجام شد`, 'success');
    }
    
    function updateCardsFromVMs() {
        const activeCount = dashboardData.vms.filter(vm => vm.status === 'active').length;
        dashboardData.cards[0].value = activeCount.toString();
        renderCards();
    }
    
    // ========== رندر نمودار ==========
    function renderChart() {
        const ctx = document.getElementById('cpuChart').getContext('2d');
        const labels = dashboardData.vms.map(vm => vm.name);
        const cpuData = dashboardData.vms.map(vm => vm.cpu);
        const avgCpu = (cpuData.reduce((a, b) => a + b, 0) / cpuData.length).toFixed(1);
        
        document.getElementById('chartFooter').innerHTML = `<i class="fas fa-charging-station"></i> میانگین مصرف CPU: ${avgCpu}% | ${dashboardData.vms.filter(v => v.cpu > 70).length} سرور با مصرف بالا`;
        
        if (chartInstance) {
            chartInstance.destroy();
        }
        
        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'مصرف CPU (%)',
                    data: cpuData,
                    backgroundColor: cpuData.map(c => c > 70 ? '#e74c3c' : c > 40 ? '#f39c12' : '#2ecc71'),
                    borderRadius: 8,
                    barPercentage: 0.65
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top', rtl: true },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.raw}% مصرف CPU` } }
                },
                scales: { y: { beginAtZero: true, max: 100, title: { display: true, text: 'درصد (%)' } } }
            }
        });
    }
    
    // ========== رندر هشدارها ==========
    function renderAlerts() {
        const container = document.getElementById('alertsContainer');
        container.innerHTML = '';
        if (dashboardData.alerts.length === 0) {
            container.innerHTML = '<div class="empty-alerts"><i class="fas fa-check-circle"></i> همه هشدارها پاک شد! سیستم پایدار است.</div>';
            return;
        }
        dashboardData.alerts.forEach(alert => {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert-item';
            alertDiv.style.borderRightColor = getAlertColor(alert.type);
            alertDiv.innerHTML = `
                <span><i class="fas ${getAlertIcon(alert.type)}" style="color: ${getAlertColor(alert.type)};"></i> ${alert.text}</span>
                <span class="alert-time"><i class="far fa-clock"></i> ${alert.time}</span>
            `;
            container.appendChild(alertDiv);
        });
    }
    
    function addAlert(text, type = 'info') {
        const newAlert = {
            id: Date.now(),
            icon: getAlertIcon(type),
            text: text,
            time: 'همین الان',
            type: type
        };
        dashboardData.alerts.unshift(newAlert);
        if (dashboardData.alerts.length > 8) dashboardData.alerts.pop();
        renderAlerts();
        
        const warningCount = dashboardData.alerts.filter(a => a.type === 'danger' || a.type === 'warning').length;
        dashboardData.cards[3].value = warningCount.toString();
        renderCards();
        
        showToast(`هشدار جدید: ${text}`, true);
    }
    
    function clearAlerts() {
        if (dashboardData.alerts.length === 0) {
            showToast('هیچ هشدار جدیدی وجود ندارد!', false);
            return;
        }
        dashboardData.alerts = [];
        dashboardData.cards[3].value = '0';
        renderAlerts();
        renderCards();
        showToast('تمامی هشدارها پاک شدند ✅', true);
    }
    
    // ========== مودال ایجاد منبع ==========
    const resourceModal = document.getElementById('resourceModal');
    const logoutModal = document.getElementById('logoutModal');
    
    function openModal(modal) { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    function closeModal(modal) { modal.style.display = 'none'; document.body.style.overflow = ''; }
    
    document.getElementById('createResourceBtn').addEventListener('click', () => openModal(resourceModal));
    document.getElementById('closeModalBtn').addEventListener('click', () => closeModal(resourceModal));
    
    document.getElementById('resourceForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const resourceName = document.getElementById('resourceName').value.trim();
        const resourceType = document.getElementById('resourceType').value;
        
        if (!resourceName) {
            document.getElementById('resourceNameError').textContent = 'نام منبع الزامی است';
            return;
        }
        if (resourceName.length < 3) {
            document.getElementById('resourceNameError').textContent = 'نام منبع باید حداقل ۳ کاراکتر باشد';
            return;
        }
        
        document.getElementById('resourceNameError').textContent = '';
        
        const typeNames = { vm: 'ماشین مجازی', storage: 'ذخیره‌سازی', network: 'شبکه' };
        
        if (resourceType === 'vm') {
            const newVM = {
                id: dashboardData.vms.length + 1,
                name: resourceName,
                status: 'stopped',
                cpu: 0,
                ram: '4GB',
                type: 'B1s'
            };
            dashboardData.vms.push(newVM);
            renderVMsTable();
            renderChart();
            addAlert(`${typeNames[resourceType]} جدید "${resourceName}" ایجاد شد`, 'success');
            showToast(`${resourceName} با موفقیت ایجاد شد! 🎉`, true);
        } else {
            addAlert(`${typeNames[resourceType]} جدید "${resourceName}" ایجاد شد`, 'success');
            showToast(`${resourceName} با موفقیت ایجاد شد! 🎉`, true);
        }
        
        document.getElementById('resourceName').value = '';
        closeModal(resourceModal);
    });
    
    // ========== خروج ==========
    function initLogout() {
        const logoutBtn = document.getElementById('logoutBtn');
        const confirmLogout = document.getElementById('confirmLogoutBtn');
        const cancelLogout = document.getElementById('cancelLogoutBtn');
        const closeLogoutModal = document.getElementById('closeLogoutModalBtn');
        
        logoutBtn.addEventListener('click', () => openModal(logoutModal));
        
        function doLogout() {
            closeModal(logoutModal);
            showToast('خروج موفقیت‌آمیز! به زودی برمی‌گردید 👋', true);
            setTimeout(() => {
                window.location.href = 'HomePage.html';
            }, 1000);
        }
        
        confirmLogout.addEventListener('click', doLogout);
        cancelLogout.addEventListener('click', () => closeModal(logoutModal));
        closeLogoutModal.addEventListener('click', () => closeModal(logoutModal));
    }
    
    // ========== منوی همبرگری ==========
    function initHamburgerMenu() {
        const hamburger = document.getElementById('hamburgerBtn');
        const sidebar = document.querySelector('.sidebar');
        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            const icon = hamburger.querySelector('i');
            if (sidebar.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && sidebar.classList.contains('active')) {
                if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
                    sidebar.classList.remove('active');
                    hamburger.querySelector('i').classList.remove('fa-times');
                    hamburger.querySelector('i').classList.add('fa-bars');
                }
            }
        });
    }
    
    // ========== بستن مودال با کلیک بیرون ==========
    window.addEventListener('click', (e) => {
        if (e.target === resourceModal) closeModal(resourceModal);
        if (e.target === logoutModal) closeModal(logoutModal);
    });
    
    document.getElementById('clearAlertsBtn').addEventListener('click', clearAlerts);
    document.getElementById('refreshTableBtn').addEventListener('click', () => {
        renderVMsTable();
        renderChart();
        showToast('داده‌ها به‌روزرسانی شدند 🔄', true);
    });
    
    // ========== مقداردهی اولیه کاربر ==========
    function initUser() {
        const savedUser = localStorage.getItem('azureUser');
        if (savedUser) {
            document.getElementById('userName').textContent = savedUser;
        } else {
            document.getElementById('userName').textContent = 'کاربر مهمان';
        }
    }
    
    // ========== مقداردهی اولیه ==========
    function init() {
        renderCards();
        renderVMsTable();
        renderChart();
        renderAlerts();
        initHamburgerMenu();
        initLogout();
        initUser();
    }
    
    init();
</script>
<!--  local storage -->
<script src="auth.js"></script>
<script>
    // بررسی لاگین - اگر وارد نشده بود به صفحه لاگین برود
    if (!AuthStorage.isLoggedIn()) {
        window.location.href = 'login.html';
    }
    
    // نمایش نام کاربر (اختیاری)
    const user = AuthStorage.getCurrentUser();
    if (user) {
        console.log('کاربر وارد شده:', user.name);
        // می‌توانید نام کاربر را در جایی از صفحه نمایش دهید
        // مثال: یک المان با id="userName" در HTML بسازید
        const userNameElement = document.getElementById('userName');
        if (userNameElement) {
            userNameElement.textContent = user.name;
        }
    }
</script>



</body>
</html>

@endsection('main')