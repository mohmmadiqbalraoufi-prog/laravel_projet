@extends('layouts.sidebar')

<!DOCTYPE html>

<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>امنیت | Azure IaaS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="Security.css">
    <link rel="stylesheet" href="HomePage.css">
     @vite('resources/css/Security.style.css'); 
  
    @vite('resources/css/homePage.style.css'); 
    
</head>
<body>

<div class="layout">
    <!-- سایدبار -->
    <!-- <aside class="sidebar">
        <h2><i class="fab fa-microsoft"></i> Azure</h2>
        <nav class="sidebar-nav">
            <a href="HomePage" class="active"><i class="fas fa-tachometer-alt"></i>صفحه اصلی</a>

            <a href="/Dashboard"><i class="fas fa-tachometer-alt"></i> داشبورد</a>
            <a href="/VirtualMachines"><i class="fas fa-server"></i> ماشین مجازی</a>
            <a href="/Storage"><i class="fas fa-database"></i> ذخیره‌سازی</a>
            <a href="/Networking"><i class="fas fa-network-wired"></i> شبکه</a>
            <a href="/Security" class="active"><i class="fas fa-shield-alt"></i> امنیت</a>
            <a href="/Pricing"><i class="fas fa-tag"></i> قیمت</a>
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
                <h3><i class="fas fa-shield-alt"></i> مرکز امنیت</h3>
            </div>
            <div class="topbar-right">
                <div class="security-score" id="securityScore">
                    <span>امتیاز امنیتی</span>
                    <strong>92<span>%</span></strong>
                </div>
                <button class="create-btn" id="addRuleBtn"><i class="fas fa-plus-circle"></i> افزودن قانون فایروال</button>
            </div>
        </div>

        <!-- کارت‌های آمار امنیتی -->
        <div class="stats-cards" id="statsCards"></div>

        <!-- بخش اصلی: هشدارها و قوانین -->
        <div class="security-grid">
            <!-- هشدارهای امنیتی -->
            <div class="alerts-card">
                <div class="section-header">
                    <h3><i class="fas fa-exclamation-triangle"></i> هشدارهای امنیتی</h3>
                    <div class="alert-filters">
                        <button class="alert-filter-btn active" data-alert-filter="all">همه</button>
                        <button class="alert-filter-btn" data-alert-filter="high">بحرانی</button>
                        <button class="alert-filter-btn" data-alert-filter="medium">متوسط</button>
                        <button class="alert-filter-btn" data-alert-filter="low">کم</button>
                    </div>
                </div>
                <div class="alerts-list" id="alertsList"></div>
            </div>

            <!-- قوانین فایروال -->
            <div class="firewall-card">
                <div class="section-header">
                    <h3><i class="fas fa-firewall"></i> قوانین فایروال (NSG)</h3>
                    <button class="refresh-rules" id="refreshRulesBtn"><i class="fas fa-sync-alt"></i></button>
                </div>
                <div class="table-wrapper">
                    <table id="firewallTable">
                        <thead>
                            <tr><th>نام قانون</th><th>اولویت</th><th>منبع</th><th>مقصد</th><th>پورت</th><th>پروتکل</th><th>عمل</th><th>عملیات</th></tr>
                        </thead>
                        <tbody id="firewallTableBody"></tbody>
                    </table>
                </div>
                <button class="view-all-rules" id="viewAllRulesBtn">مشاهده همه قوانین</button>
            </div>
        </div>

        <!-- بخش گزارش‌های امنیتی -->
        <div class="reports-section">
            <div class="section-header">
                <h3><i class="fas fa-chart-line"></i> گزارش‌های امنیتی اخیر</h3>
                <button class="download-report" id="downloadReportBtn"><i class="fas fa-download"></i> دانلود گزارش</button>
            </div>
            <div class="reports-grid" id="reportsGrid"></div>
        </div>

        <!-- بخش توصیه‌های امنیتی -->
        <div class="recommendations-section">
            <div class="section-header">
                <h3><i class="fas fa-lightbulb"></i> توصیه‌های امنیتی</h3>
            </div>
            <div class="recommendations-list" id="recommendationsList"></div>
        </div>
    </main>
</div>

<!-- مودال افزودن قانون فایروال -->
<div id="firewallModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-plus-circle"></i> افزودن قانون فایروال</h2>
            <span class="close-modal" id="closeModalBtn">&times;</span>
        </div>
        <form id="firewallForm">
            <div class="form-group">
                <label><i class="fas fa-tag"></i> نام قانون</label>
                <input type="text" id="ruleName" placeholder="مثال: Allow-SSH">
                <small class="error-message" id="ruleNameError"></small>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-sort-numeric-down"></i> اولویت (100-4096)</label>
                    <input type="number" id="rulePriority" placeholder="مثال: 100" min="100" max="4096">
                    <small class="error-message" id="rulePriorityError"></small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-globe"></i> پروتکل</label>
                    <select id="ruleProtocol">
                        <option value="TCP">TCP</option>
                        <option value="UDP">UDP</option>
                        <option value="ICMP">ICMP</option>
                        <option value="Any">Any</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-network-wired"></i> پورت مقصد</label>
                    <input type="text" id="rulePort" placeholder="مثال: 22, 80, 443, 3389">
                    <small class="error-message" id="rulePortError"></small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-ip"></i> محدوده IP منبع</label>
                    <select id="ruleSource">
                        <option value="*">همه (0.0.0.0/0)</option>
                        <option value="10.0.0.0/8">شبکه داخلی (10.0.0.0/8)</option>
                        <option value="172.16.0.0/12">شبکه داخلی (172.16.0.0/12)</option>
                        <option value="192.168.0.0/16">شبکه محلی (192.168.0.0/16)</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-arrow-right"></i> عمل</label>
                    <select id="ruleAction">
                        <option value="Allow">Allow (مجاز)</option>
                        <option value="Deny">Deny (مسدود)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-align-right"></i> جهت</label>
                    <select id="ruleDirection">
                        <option value="Inbound">Inbound (ورودی)</option>
                        <option value="Outbound">Outbound (خروجی)</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="modal-submit-btn">افزودن قانون</button>
        </form>
    </div>
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
<!-- مودال جزئیات هشدار -->
<div id="alertDetailModal" class="modal">
    <div class="modal-content alert-detail">
        <div class="modal-header">
            <h2 id="alertDetailTitle"><i class="fas fa-shield-virus"></i> جزئیات هشدار</h2>
            <span class="close-modal" id="closeAlertModalBtn">&times;</span>
        </div>
        <div class="alert-detail-body" id="alertDetailBody"></div>
        <div class="modal-buttons">
            <button id="resolveAlertBtn" class="btn-success">علامت‌گذاری به عنوان حل شده</button>
            <button id="closeAlertDetailBtn" class="btn-secondary">بستن</button>
        </div>
    </div>
</div>

<!-- پیام Toast -->
<div id="toastMessage" class="toast"></div>

<script>
    // ========== داده‌های داینامیک ==========
    let securityAlerts = [
        { id: 1, severity: "high", title: "تلاش ورود غیرمجاز به VM-WebServer", description: "تعداد 15 تلاش ناموفق ورود در 5 دقیقه گذشته از IP 45.67.89.10", source: "VM-WebServer", time: "۲ دقیقه پیش", status: "active", recommended: "رمز عبور را تغییر داده و IP متخلف را مسدود کنید" },
        { id: 2, severity: "high", title: "اسکن پورت تشخیص داده شد", description: "اسکن پورت از IP 185.142.53.15 به سمت سابنت شبکه اصلی", source: "vnet-prod", time: "۱۵ دقیقه پیش", status: "active", recommended: "قانون فایروال برای مسدودسازی IP اضافه کنید" },
        { id: 3, severity: "medium", title: "خط مشی رمز عبور ضعیف", description: "کاربر test@azure دارای رمز عبور ساده است", source: "مدیریت هویت", time: "۱ ساعت پیش", status: "active", recommended: "کاربر را ملزم به تغییر رمز عبور کنید" },
        { id: 4, severity: "medium", title: "به‌روزرسانی امنیتی موجود", description: "۳ به‌روزرسانی امنیتی مهم برای VM-Database موجود است", source: "VM-Database", time: "۳ ساعت پیش", status: "active", recommended: "به‌روزرسانی‌ها را نصب کنید" },
        { id: 5, severity: "low", title: "دسترسی غیرعادی به فایل", description: "دسترسی به فایل حساس از آدرس IP جدید", source: "Storage-Account", time: "۵ ساعت پیش", status: "investigating", recommended: "دسترسی را بررسی کنید" }
    ];

    let firewallRules = [
        { id: 1, name: "Allow-SSH", priority: 100, source: "*", destination: "*", port: "22", protocol: "TCP", action: "Allow", direction: "Inbound" },
        { id: 2, name: "Allow-HTTP", priority: 110, source: "*", destination: "*", port: "80", protocol: "TCP", action: "Allow", direction: "Inbound" },
        { id: 3, name: "Allow-HTTPS", priority: 120, source: "*", destination: "*", port: "443", protocol: "TCP", action: "Allow", direction: "Inbound" },
        { id: 4, name: "Deny-Malicious", priority: 1000, source: "45.67.89.10/32", destination: "*", port: "*", protocol: "Any", action: "Deny", direction: "Inbound" },
        { id: 5, name: "Allow-RDP-From-Internal", priority: 200, source: "192.168.0.0/16", destination: "*", port: "3389", protocol: "TCP", action: "Allow", direction: "Inbound" },
        { id: 6, name: "Allow-Internal", priority: 150, source: "10.0.0.0/8", destination: "*", port: "*", protocol: "Any", action: "Allow", direction: "Inbound" }
    ];

    let securityReports = [
        { id: 1, title: "گزارش امنیتی ماهانه -حمل ۱۴۰۴", date: "۱۴۰۴/۰۱/۲۵", type: "monthly", size: "2.4 MB" },
        { id: 2, title: "گزارش تهدیدات سایبری - هفته اول", date: "۱۴۰۴/۰۱/۱۰", type: "weekly", size: "856 KB" },
        { id: 3, title: "گزارش انطباق با استاندارد ISO 27001", date: "۱۴۰۳/۱۲/۲۸", type: "compliance", size: "3.1 MB" },
        { id: 4, title: "تحلیل آسیب‌پذیری‌های شبکه", date: "۱۴۰۳/۱۲/۱۵", type: "vulnerability", size: "1.7 MB" }
    ];

    let securityRecommendations = [
        { id: 1, text: "فعال‌سازی احراز هویت دو مرحله‌ای (MFA) برای همه کاربران", priority: "high", category: "هویت" },
        { id: 2, text: "به‌روزرسانی سیستمی ماشین‌های مجازی", priority: "high", category: "پچ‌ها" },
        { id: 3, text: "محدود کردن دسترسی SSH فقط به IP‌های مجاز", priority: "medium", category: "شبکه" },
        { id: 4, text: "فعال‌سازی لاگ‌های تشخیص تهدید (Threat Detection)", priority: "medium", category: "مانیتورینگ" },
        { id: 5, text: "انجام تست نفوذ سالانه", priority: "low", category: "ارزیابی" }
    ];

    let currentAlertFilter = "all";
    let selectedAlertId = null;

    // ========== توابع کمکی ==========
    function showToast(message, isSuccess = true) {
        const toast = document.getElementById('toastMessage');
        toast.textContent = message;
        toast.className = `toast show ${isSuccess ? 'success' : 'error'}`;
        setTimeout(() => { toast.className = 'toast'; }, 3000);
    }

    function getSeverityBadge(severity) {
        const badges = {
            high: '<span class="severity-badge high"><i class="fas fa-skull-crosswalk"></i> بحرانی</span>',
            medium: '<span class="severity-badge medium"><i class="fas fa-exclamation-triangle"></i> متوسط</span>',
            low: '<span class="severity-badge low"><i class="fas fa-info-circle"></i> کم</span>'
        };
        return badges[severity] || badges.low;
    }

    function getActionBadge(action) {
        if (action === 'Allow') return '<span class="action-badge allow"><i class="fas fa-check-circle"></i> مجاز</span>';
        return '<span class="action-badge deny"><i class="fas fa-ban"></i> مسدود</span>';
    }

    // ========== رندر کارت‌های آمار ==========
    function renderStatsCards() {
        const highAlerts = securityAlerts.filter(a => a.severity === 'high' && a.status === 'active').length;
        const mediumAlerts = securityAlerts.filter(a => a.severity === 'medium' && a.status === 'active').length;
        const lowAlerts = securityAlerts.filter(a => a.severity === 'low' && a.status === 'active').length;
        const totalRules = firewallRules.length;
        const allowRules = firewallRules.filter(r => r.action === 'Allow').length;
        const denyRules = firewallRules.filter(r => r.action === 'Deny').length;

        const container = document.getElementById('statsCards');
        container.innerHTML = `
            <div class="stat-card"><div class="stat-icon red"><i class="fas fa-skull-crosswalk"></i></div><div class="stat-info"><h4>هشدار بحرانی</h4><p>${highAlerts}</p></div></div>
            <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-exclamation-triangle"></i></div><div class="stat-info"><h4>هشدار متوسط</h4><p>${mediumAlerts}</p></div></div>
            <div class="stat-card"><div class="stat-icon yellow"><i class="fas fa-info-circle"></i></div><div class="stat-info"><h4>هشدار کم</h4><p>${lowAlerts}</p></div></div>
            <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-firewall"></i></div><div class="stat-info"><h4>قوانین فایروال</h4><p>${totalRules}</p></div></div>
            <div class="stat-card"><div class="stat-icon green"><i class="fas fa-check-circle"></i></div><div class="stat-info"><h4>قوانین مجاز</h4><p>${allowRules}</p></div></div>
            <div class="stat-card"><div class="stat-icon purple"><i class="fas fa-ban"></i></div><div class="stat-info"><h4>قوانین مسدود</h4><p>${denyRules}</p></div></div>
        `;
    }

    // ========== رندر هشدارها ==========
    function renderAlerts() {
        const container = document.getElementById('alertsList');
        let filteredAlerts = securityAlerts.filter(a => a.status === 'active');
        
        if (currentAlertFilter !== 'all') {
            filteredAlerts = filteredAlerts.filter(a => a.severity === currentAlertFilter);
        }
        
        if (filteredAlerts.length === 0) {
            container.innerHTML = '<div class="empty-alerts"><i class="fas fa-check-circle"></i> هیچ هشدار فعالی وجود ندارد! سیستم امن است.</div>';
            return;
        }
        
        container.innerHTML = '';
        filteredAlerts.forEach(alert => {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert-item ${alert.severity}`;
            alertDiv.innerHTML = `
                <div class="alert-icon"><i class="fas ${alert.severity === 'high' ? 'fa-skull-crosswalk' : alert.severity === 'medium' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i></div>
                <div class="alert-content">
                    <div class="alert-title">${alert.title}</div>
                    <div class="alert-meta"><i class="far fa-clock"></i> ${alert.time} • <i class="fas fa-server"></i> ${alert.source}</div>
                </div>
                <div class="alert-actions">
                    ${getSeverityBadge(alert.severity)}
                    <button class="view-alert-btn" data-id="${alert.id}"><i class="fas fa-eye"></i></button>
                </div>
            `;
            container.appendChild(alertDiv);
        });
        
        document.querySelectorAll('.view-alert-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = parseInt(btn.getAttribute('data-id'));
                openAlertDetail(id);
            });
        });
    }
    
    function openAlertDetail(alertId) {
        const alert = securityAlerts.find(a => a.id === alertId);
        if (!alert) return;
        
        selectedAlertId = alertId;
        document.getElementById('alertDetailTitle').innerHTML = `<i class="fas ${alert.severity === 'high' ? 'fa-skull-crosswalk' : 'fa-shield-virus'}"></i> ${alert.title}`;
        document.getElementById('alertDetailBody').innerHTML = `
            <div class="detail-row"><strong>توضیحات:</strong> ${alert.description}</div>
            <div class="detail-row"><strong>منبع:</strong> ${alert.source}</div>
            <div class="detail-row"><strong>زمان وقوع:</strong> ${alert.time}</div>
            <div class="detail-row"><strong>توصیه:</strong> <span class="recommendation-text">${alert.recommended}</span></div>
        `;
        openModal(document.getElementById('alertDetailModal'));
    }
    
    function resolveAlert() {
        if (selectedAlertId) {
            const alert = securityAlerts.find(a => a.id === selectedAlertId);
            if (alert) {
                alert.status = 'resolved';
                showToast(`هشدار "${alert.title}" به عنوان حل شده علامت‌گذاری شد ✅`, true);
                renderAlerts();
                renderStatsCards();
                closeModal(document.getElementById('alertDetailModal'));
                selectedAlertId = null;
            }
        }
    }

    // ========== رندر قوانین فایروال ==========
    function renderFirewallRules() {
        const tbody = document.getElementById('firewallTableBody');
        tbody.innerHTML = '';
        
        firewallRules.slice(0, 5).forEach(rule => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><i class="fas fa-gavel"></i> ${rule.name}</td>
                <td>${rule.priority}</td>
                <td>${rule.source}</td>
                <td>${rule.destination}</td>
                <td>${rule.port}</td>
                <td>${rule.protocol}</td>
                <td>${getActionBadge(rule.action)}</td>
                <td class="actions">
                    <i class="fas fa-edit" data-id="${rule.id}" data-action="edit" title="ویرایش"></i>
                    <i class="fas fa-trash-alt" data-id="${rule.id}" data-action="delete" title="حذف"></i>
                 </td>
            `;
            tbody.appendChild(row);
        });
        
        document.querySelectorAll('#firewallTable .actions i').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(btn.getAttribute('data-id'));
                const action = btn.getAttribute('data-action');
                handleRuleAction(id, action);
            });
        });
    }
    
    function handleRuleAction(id, action) {
        const rule = firewallRules.find(r => r.id === id);
        if (action === 'edit') {
            showToast('ویرایش قانون در حال توسعه است...', false);
        } else if (action === 'delete') {
            if (confirm(`آیا از حذف قانون "${rule?.name}" مطمئن هستید؟`)) {
                firewallRules = firewallRules.filter(r => r.id !== id);
                renderFirewallRules();
                renderStatsCards();
                showToast(`قانون ${rule.name} حذف شد 🗑️`, true);
            }
        }
    }
    
    // ========== افزودن قانون فایروال ==========
    function addFirewallRule() {
        const name = document.getElementById('ruleName').value.trim();
        const priority = parseInt(document.getElementById('rulePriority').value);
        const protocol = document.getElementById('ruleProtocol').value;
        const port = document.getElementById('rulePort').value.trim();
        const source = document.getElementById('ruleSource').value;
        const action = document.getElementById('ruleAction').value;
        const direction = document.getElementById('ruleDirection').value;
        
        let isValid = true;
        if (!name) { document.getElementById('ruleNameError').textContent = 'نام قانون الزامی است'; isValid = false; }
        else if (name.length < 3) { document.getElementById('ruleNameError').textContent = 'نام باید حداقل ۳ کاراکتر باشد'; isValid = false; }
        else { document.getElementById('ruleNameError').textContent = ''; }
        
        if (!priority || priority < 100 || priority > 4096) {
            document.getElementById('rulePriorityError').textContent = 'اولویت باید بین 100 تا 4096 باشد';
            isValid = false;
        } else { document.getElementById('rulePriorityError').textContent = ''; }
        
        if (!port) {
            document.getElementById('rulePortError').textContent = 'پورت الزامی است';
            isValid = false;
        } else { document.getElementById('rulePortError').textContent = ''; }
        
        if (isValid) {
            const newId = Math.max(...firewallRules.map(r => r.id), 0) + 1;
            firewallRules.push({
                id: newId, name, priority, source, destination: "*", port, protocol, action, direction
            });
            renderFirewallRules();
            renderStatsCards();
            showToast(`قانون ${name} با موفقیت اضافه شد 🎉`, true);
            closeModal(document.getElementById('firewallModal'));
            document.getElementById('firewallForm').reset();
        }
    }
    
    // ========== رندر گزارش‌ها ==========
    function renderReports() {
        const container = document.getElementById('reportsGrid');
        container.innerHTML = '';
        securityReports.forEach(report => {
            const reportDiv = document.createElement('div');
            reportDiv.className = 'report-card';
            reportDiv.innerHTML = `
                <i class="fas fa-file-alt"></i>
                <h4>${report.title}</h4>
                <p><i class="far fa-calendar-alt"></i> ${report.date}</p>
                <span class="report-size"><i class="fas fa-database"></i> ${report.size}</span>
                <button class="download-report-btn" data-id="${report.id}"><i class="fas fa-download"></i> دانلود</button>
            `;
            container.appendChild(reportDiv);
        });
        
        document.querySelectorAll('.download-report-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = parseInt(btn.getAttribute('data-id'));
                const report = securityReports.find(r => r.id === id);
                showToast(`دانلود گزارش ${report?.title} شروع شد... 📄`, true);
            });
        });
    }
    
    // ========== رندر توصیه‌ها ==========
    function renderRecommendations() {
        const container = document.getElementById('recommendationsList');
        container.innerHTML = '';
        securityRecommendations.forEach(rec => {
            const recDiv = document.createElement('div');
            recDiv.className = `recommendation-item ${rec.priority}`;
            recDiv.innerHTML = `
                <div class="rec-icon"><i class="fas ${rec.priority === 'high' ? 'fa-exclamation-circle' : rec.priority === 'medium' ? 'fa-lightbulb' : 'fa-info-circle'}"></i></div>
                <div class="rec-content">
                    <div class="rec-text">${rec.text}</div>
                    <div class="rec-meta"><span class="rec-category">${rec.category}</span> • اولویت: ${rec.priority === 'high' ? 'بحرانی' : rec.priority === 'medium' ? 'متوسط' : 'کم'}</div>
                </div>
                <button class="rec-action-btn" data-id="${rec.id}">اعمال</button>
            `;
            container.appendChild(recDiv);
        });
        
        document.querySelectorAll('.rec-action-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = parseInt(btn.getAttribute('data-id'));
                const rec = securityRecommendations.find(r => r.id === id);
                showToast(`توصیه "${rec?.text}" در حال اعمال است... 🔧`, true);
            });
        });
    }
    
    // ========== فیلتر هشدارها ==========
    function initAlertFilters() {
        document.querySelectorAll('.alert-filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.alert-filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentAlertFilter = btn.getAttribute('data-alert-filter');
                renderAlerts();
            });
        });
    }
    
    // ========== امتیاز امنیتی ==========
    function updateSecurityScore() {
        const activeAlerts = securityAlerts.filter(a => a.status === 'active').length;
        const highAlerts = securityAlerts.filter(a => a.severity === 'high' && a.status === 'active').length;
        let score = 100 - (activeAlerts * 3) - (highAlerts * 5);
        score = Math.max(0, Math.min(100, score));
        document.getElementById('securityScore').innerHTML = `<span>امتیاز امنیتی</span><strong>${score}<span>%</span></strong>`;
    }
    
    // ========== مودال‌ها ==========
    const firewallModal = document.getElementById('firewallModal');
    const alertDetailModal = document.getElementById('alertDetailModal');
    
    function openModal(modal) { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    function closeModal(modal) { modal.style.display = 'none'; document.body.style.overflow = ''; }
    
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
    }
    
    // ========== مقداردهی اولیه ==========
    document.getElementById('addRuleBtn').addEventListener('click', () => openModal(firewallModal));
    document.getElementById('closeModalBtn').addEventListener('click', () => closeModal(firewallModal));
    document.getElementById('closeAlertModalBtn').addEventListener('click', () => closeModal(alertDetailModal));
    document.getElementById('closeAlertDetailBtn').addEventListener('click', () => closeModal(alertDetailModal));
    document.getElementById('resolveAlertBtn').addEventListener('click', resolveAlert);
    document.getElementById('refreshRulesBtn').addEventListener('click', () => { renderFirewallRules(); showToast('قوانین به‌روزرسانی شدند 🔄', true); });
    document.getElementById('downloadReportBtn').addEventListener('click', () => showToast('دانلود گزارش جامع امنیتی شروع شد... 📊', true));
    document.getElementById('viewAllRulesBtn').addEventListener('click', () => showToast('نمایش همه قوانین در حال توسعه است...', false));
    document.getElementById('firewallForm').addEventListener('submit', (e) => { e.preventDefault(); addFirewallRule(); });
    
    window.addEventListener('click', (e) => {
        if (e.target === firewallModal) closeModal(firewallModal);
        if (e.target === alertDetailModal) closeModal(alertDetailModal);
    });
    
    renderStatsCards();
    renderAlerts();
    renderFirewallRules();
    renderReports();
    renderRecommendations();
    updateSecurityScore();
    initAlertFilters();
    initHamburgerMenu();
</script>

</body>
</html>
@endsection('main')