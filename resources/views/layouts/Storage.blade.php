@extends('layouts.sidebar')

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>ذخیره‌سازی | Azure IaaS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="Storage.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="HomePage.css">
    @vite('resources/css/storage.style.css'); 
  
    @vite('resources/css/homePage.style.css'); 
    @vite('resources/css/dashboard.style.css'); 

</head>
<body>

<div class="layout">
    <!-- سایدبار -->
    <!-- <aside class="sidebar">
        <h2><i class="fab fa-microsoft"></i> Azure</h2>
        <nav class="sidebar-nav">
            <a href="HomePage" class="active"><i class="fas fa-tachometer-alt"></i>صفحه اصلی</a>

            <a href="Dashboard"><i class="fas fa-tachometer-alt"></i> داشبورد</a>
            <a href="VirtualMachines"><i class="fas fa-server"></i> ماشین مجازی</a>
            <a href="Storage" class="active"><i class="fas fa-database"></i> ذخیره‌سازی</a>
            <a href="Networking"><i class="fas fa-network-wired"></i> شبکه</a>
            <a href="Security"><i class="fas fa-shield-alt"></i> امنیت</a>
            <a href="Pricing"><i class="fas fa-tag"></i> قیمت</a>
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
                <h3><i class="fas fa-database"></i> مدیریت ذخیره‌سازی</h3>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="جستجوی استوریج...">
                </div>
                <button class="create-btn" id="createStorageBtn"><i class="fas fa-plus-circle"></i> ایجاد استوریج</button>
            </div>
        </div>

        <!-- کارت‌های آمار -->
        <div class="stats-cards" id="statsCards"></div>

        <!-- نمودار مصرف فضای ذخیره‌سازی -->
        <div class="chart-container">
            <div class="chart-card">
                <h3><i class="fas fa-chart-pie"></i> مصرف فضای ذخیره‌سازی</h3>
                <div class="storage-bars" id="storageBars"></div>
            </div>
            <div class="usage-card">
                <h3><i class="fas fa-info-circle"></i> خلاصه مصرف</h3>
                <div class="usage-stats" id="usageStats"></div>
            </div>
        </div>

        <!-- جدول استوریج‌ها -->
        <div class="table-section">
            <div class="section-header">
                <h3><i class="fas fa-hdd"></i> لیست حساب‌های ذخیره‌سازی</h3>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">همه</button>
                    <button class="filter-btn" data-filter="active">فعال</button>
                    <button class="filter-btn" data-filter="readonly">فقط خواندنی</button>
                </div>
            </div>
            <div class="table-wrapper">
                <table id="storageTable">
                    <thead>
                        <tr><th>نام</th><th>نوع</th><th>فضای کل</th><th>فضای مصرفی</th><th>درصد مصرف</th><th>وضعیت</th><th>عملیات</th></tr>
                    </thead>
                    <tbody id="storageTableBody"></tbody>
                </table>
            </div>
            <div class="table-footer" id="tableFooter"></div>
        </div>

        <!-- بخش فایل‌ها برای استوریج انتخاب شده -->
        <div class="files-section" id="filesSection" style="display: none;">
            <div class="section-header">
                <h3><i class="fas fa-folder-open"></i> فایل‌های <span id="selectedStorageName"></span></h3>
                <button class="upload-btn" id="uploadFileBtn"><i class="fas fa-upload"></i> آپلود فایل</button>
            </div>
            <div class="table-wrapper">
                <table id="filesTable">
                    <thead>
                        <tr><th>نام فایل</th><th>نوع</th><th>اندازه</th><th>تاریخ آپلود</th><th>عملیات</th></tr>
                    </thead>
                    <tbody id="filesTableBody"></tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- مودال ایجاد/ویرایش استوریج -->
<div id="storageModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle"><i class="fas fa-plus-circle"></i> ایجاد حساب ذخیره‌سازی</h2>
            <span class="close-modal" id="closeModalBtn">&times;</span>
        </div>
        <form id="storageForm">
            <input type="hidden" id="storageId">
            <div class="form-group">
                <label><i class="fas fa-tag"></i> نام استوریج</label>
                <input type="text" id="storageName" placeholder="مثال: mystorageaccount">
                <small class="error-message" id="storageNameError"></small>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-layer-group"></i> نوع استوریج</label>
                    <select id="storageType">
                        <option value="Blob Storage">Blob Storage</option>
                        <option value="File Storage">File Storage</option>
                        <option value="Disk Storage">Disk Storage</option>
                        <option value="Archive Storage">Archive Storage</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-chart-line"></i> سطح عملکرد</label>
                    <select id="storageTier">
                        <option value="Standard">Standard (هزینه کمتر)</option>
                        <option value="Premium">Premium (عملکرد بالا)</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-database"></i> ظرفیت کل (GB)</label>
                    <select id="storageCapacity">
                        <option value="100">100 GB</option>
                        <option value="250">250 GB</option>
                        <option value="500">500 GB</option>
                        <option value="1024">1 TB</option>
                        <option value="2048">2 TB</option>
                        <option value="5120">5 TB</option>
                        <option value="10024"> 10 TB</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-globe"></i> منطقه</label>
                    <select id="storageRegion">
                        <option value="North Europe">شمال اروپا</option>
                        <option value="West Europe">غرب اروپا</option>
                        <option value="East US">شرق آمریکا</option>
                        <option value="Southeast Asia">جنوب شرق آسیا</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="modal-submit-btn" id="submitBtn">ایجاد استوریج</button>
        </form>
    </div>
</div>

<!-- مودال حذف -->
<div id="deleteModal" class="modal">
    <div class="modal-content delete-modal">
        <div class="modal-header">
            <h2><i class="fas fa-trash-alt"></i> حذف استوریج</h2>
            <span class="close-modal" id="closeDeleteModalBtn">&times;</span>
        </div>
        <div class="modal-body">
            <p>آیا از حذف استوریج <strong id="deleteStorageName"></strong> مطمئن هستید؟</p>
            <p class="warning-text">تمامی فایل‌های داخل این استوریج نیز حذف خواهند شد!</p>
        </div>
        <div class="modal-buttons">
            <button id="confirmDeleteBtn" class="btn-danger">بله، حذف شود</button>
            <button id="cancelDeleteBtn" class="btn-secondary">انصراف</button>
        </div>
    </div>
</div>

<!-- مودال آپلود فایل -->
<div id="uploadModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-upload"></i> آپلود فایل</h2>
            <span class="close-modal" id="closeUploadModalBtn">&times;</span>
        </div>
        <form id="uploadForm">
            <div class="form-group">
                <label><i class="fas fa-file"></i> انتخاب فایل</label>
                <input type="file" id="fileInput" accept="*/*">
                <small class="error-message" id="fileError"></small>
            </div>
            <button type="submit" class="modal-submit-btn">آپلود فایل</button>
        </form>
    </div>
</div>

<!-- مودال ویرایش فایل -->
<div id="renameFileModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> ویرایش نام فایل</h2>
            <span class="close-modal" id="closeRenameModalBtn">&times;</span>
        </div>
        <form id="renameForm">
            <div class="form-group">
                <label><i class="fas fa-tag"></i> نام جدید</label>
                <input type="text" id="newFileName" placeholder="نام فایل جدید">
                <small class="error-message" id="renameError"></small>
            </div>
            <button type="submit" class="modal-submit-btn">ذخیره تغییرات</button>
        </form>
    </div>
</div>

<!-- پیام Toast -->
<div id="toastMessage" class="toast"></div>
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
<script>
    // ========== داده‌های داینامیک ==========
    let storageAccounts = [
        { id: 1, name: "prod-blob", type: "Blob Storage", tier: "Standard", capacity: 1024, used: 425, region: "North Europe", status: "active", files: [] },
        { id: 2, name: "backup-files", type: "File Storage", tier: "Standard", capacity: 5120, used: 2140, region: "West Europe", status: "active", files: [] },
        { id: 3, name: "archive-data", type: "Archive Storage", tier: "Standard", capacity: 2048, used: 1890, region: "East US", status: "readonly", files: [] },
        { id: 4, name: "fast-disk", type: "Disk Storage", tier: "Premium", capacity: 500, used: 320, region: "Southeast Asia", status: "active", files: [] },
        { id: 5, name: "logs-storage", type: "Blob Storage", tier: "Standard", capacity: 250, used: 98, region: "North Europe", status: "active", files: [] }
    ];

    // اضافه کردن فایل‌های نمونه
    storageAccounts[0].files = [
        { id: 101, name: "website-logo.png", type: "image/png", size: 245000, date: "2024-01-15" },
        { id: 102, name: "app-settings.json", type: "application/json", size: 1200, date: "2024-01-20" },
        { id: 103, name: "backup.zip", type: "application/zip", size: 15200000, date: "2024-01-25" }
    ];
    storageAccounts[1].files = [
        { id: 201, name: "database-backup.bak", type: "application/sql", size: 524288000, date: "2024-01-28" },
        { id: 202, name: "config.ini", type: "text/plain", size: 3400, date: "2024-01-29" }
    ];

    let currentFilter = "all";
    let currentStorageId = null;
    let deleteId = null;
    let currentFileId = null;
    let currentFileStorageId = null;
    let nextFileId = 2000;

    // ========== توابع کمکی ==========
    function showToast(message, isSuccess = true) {
        const toast = document.getElementById('toastMessage');
        toast.textContent = message;
        toast.className = `toast show ${isSuccess ? 'success' : 'error'}`;
        setTimeout(() => { toast.className = 'toast'; }, 3000);
    }

    function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function formatSizeGB(gb) {
        if (gb >= 1024) return (gb / 1024).toFixed(1) + ' TB';
        return gb + ' GB';
    }

    function getStatusBadge(status) {
        if (status === 'active') return '<span class="status-badge status-active"><i class="fas fa-check-circle"></i> فعال</span>';
        return '<span class="status-badge status-readonly"><i class="fas fa-eye"></i> فقط خواندنی</span>';
    }

    // ========== رندر کارت‌های آمار ==========
    function renderStatsCards() {
        const totalCapacity = storageAccounts.reduce((sum, s) => sum + s.capacity, 0);
        const totalUsed = storageAccounts.reduce((sum, s) => sum + s.used, 0);
        const totalFiles = storageAccounts.reduce((sum, s) => sum + s.files.length, 0);
        const avgUsage = (totalUsed / totalCapacity * 100).toFixed(1);

        const container = document.getElementById('statsCards');
        container.innerHTML = `
            <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-database"></i></div><div class="stat-info"><h4>کل استوریج‌ها</h4><p>${storageAccounts.length}</p></div></div>
            <div class="stat-card"><div class="stat-icon green"><i class="fas fa-hdd"></i></div><div class="stat-info"><h4>فضای کل</h4><p>${formatSizeGB(totalCapacity)}</p></div></div>
            <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-chart-line"></i></div><div class="stat-info"><h4>فضای مصرفی</h4><p>${formatSizeGB(totalUsed)}</p></div></div>
            <div class="stat-card"><div class="stat-icon purple"><i class="fas fa-file"></i></div><div class="stat-info"><h4>تعداد فایل‌ها</h4><p>${totalFiles}</p></div></div>
            <div class="stat-card"><div class="stat-icon red"><i class="fas fa-chart-pie"></i></div><div class="stat-info"><h4>درصد مصرف</h4><p>${avgUsage}%</p></div></div>
        `;
    }

    //            bar graph
    function renderStorageBars() {
        const container = document.getElementById('storageBars');
        const usageContainer = document.getElementById('usageStats');
        
        let barsHtml = '';
        let totalUsed = 0;
        let totalCapacity = 0;
        
        storageAccounts.forEach(storage => {
            const percent = (storage.used / storage.capacity * 100).toFixed(1);
            let barColor = '#2ecc71';
            if (percent > 80) barColor = '#e74c3c';
            else if (percent > 60) barColor = '#f39c12';

            barsHtml += `
                <div class="storage-bar-item">
                    <div class="bar-label"><i class="fas fa-database"></i> ${storage.name}</div> 
                    <div class="bar-wrapper">
                        <div class="bar-fill" style="width: ${percent}%; background: ${barColor};"></div>
                        <span class="bar-percent">${percent}%</span>
                    </div>
                    <div class="bar-details">${formatSizeGB(storage.used)} / ${formatSizeGB(storage.capacity)}</div>
                </div>
            `;
            totalUsed += storage.used;
            totalCapacity += storage.capacity;
        });
        
        container.innerHTML = barsHtml;
        
        const overallPercent = (totalUsed / totalCapacity * 100).toFixed(1);
        usageContainer.innerHTML = `
            <div class="usage-item"><span>کل فضای مصرفی:</span><strong>${formatSizeGB(totalUsed)}</strong></div>
            <div class="usage-item"><span>کل فضای خالی:</span><strong>${formatSizeGB(totalCapacity - totalUsed)}</strong></div>
            <div class="usage-item"><span>مصرف کلی:</span><strong>${overallPercent}%</strong></div>
            <div class="usage-progress"><div class="usage-fill" style="width: ${overallPercent}%;"></div></div>
        `;
    }   

    // ========== رندر جدول استوریج‌ها ==========
    function renderStorageTable() {
        const tbody = document.getElementById('storageTableBody');
        const footer = document.getElementById('tableFooter');
        
        let filteredStorages = storageAccounts;
        if (currentFilter !== 'all') {
            filteredStorages = storageAccounts.filter(s => s.status === currentFilter);
        }
        
        const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
        if (searchTerm) {
            filteredStorages = filteredStorages.filter(s => s.name.toLowerCase().includes(searchTerm));
        }
        
        tbody.innerHTML = '';
        
        if (filteredStorages.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="empty-row"><i class="fas fa-database"></i> هیچ استوریجی یافت نشد</td></tr>';
            footer.innerHTML = '';
            return;
        }
        
        filteredStorages.forEach(storage => {
            const percent = (storage.used / storage.capacity * 100).toFixed(1);
            let percentColor = '#2ecc71';
            if (percent > 80) percentColor = '#e74c3c';
            else if (percent > 60) percentColor = '#f39c12';
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><i class="fas fa-folder"></i> ${storage.name}</td>
                <td>${storage.type} <small>(${storage.tier})</small></td>
                <td>${formatSizeGB(storage.capacity)}</td>
                <td>${formatSizeGB(storage.used)}</td>
                <td>><div class="percent-bar"><div class="percent-fill" style="width: ${percent}%; background: ${percentColor};"></div><span>${percent}%</span></div></td>
                <td>${getStatusBadge(storage.status)}</td>
                <td class="actions">
                    <i class="fas fa-folder-open" data-id="${storage.id}" data-action="view" title="مشاهده فایل‌ها"></i>
                    <i class="fas fa-edit" data-id="${storage.id}" data-action="edit" title="ویرایش"></i>
                    <i class="fas fa-trash-alt" data-id="${storage.id}" data-action="delete" title="حذف"></i>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        footer.innerHTML = `<span>نمایش ${filteredStorages.length} از ${storageAccounts.length} استوریج</span>`;
        
        document.querySelectorAll('.actions i').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(btn.getAttribute('data-id'));
                const action = btn.getAttribute('data-action');
                handleStorageAction(id, action);
            });
        });
    }
    
    // ========== عملیات روی استوریج‌ها ==========
    function handleStorageAction(id, action) {
        const storage = storageAccounts.find(s => s.id === id);
        if (!storage) return;
        
        if (action === 'view') {
            viewStorageFiles(storage);
        } else if (action === 'edit') {
            openEditModal(storage);
        } else if (action === 'delete') {
            openDeleteModal(storage);
        }
    }
    
    // ========== مشاهده فایل‌های استوریج ==========
    function viewStorageFiles(storage) {
        currentStorageId = storage.id;
        document.getElementById('selectedStorageName').textContent = storage.name;
        document.getElementById('filesSection').style.display = 'block';
        renderFilesTable();
    }
    
    function renderFilesTable() {
        const storage = storageAccounts.find(s => s.id === currentStorageId);
        if (!storage) return;
        
        const tbody = document.getElementById('filesTableBody');
        tbody.innerHTML = '';
        
        if (storage.files.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="empty-row"><i class="fas fa-file"></i> هیچ فایلی در این استوریج وجود ندارد</td></tr>';
            return;
        }
        
        storage.files.forEach(file => {
            const row = document.createElement('tr');
            const fileType = file.name.split('.').pop().toUpperCase();
            row.innerHTML = `
                <td><i class="fas ${getFileIcon(file.name)}"></i> ${file.name}</td>
                <td>${fileType}文件</td>
                <td>${formatBytes(file.size)}</td>
                <td>${file.date}</td>
                <td class="actions">
                    <i class="fas fa-download" data-file-id="${file.id}" data-action="download" title="دانلود"></i>
                    <i class="fas fa-edit" data-file-id="${file.id}" data-action="rename" title="تغییر نام"></i>
                    <i class="fas fa-trash-alt" data-file-id="${file.id}" data-action="delete-file" title="حذف"></i>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        document.querySelectorAll('#filesTable .actions i').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const fileId = parseInt(btn.getAttribute('data-file-id'));
                const action = btn.getAttribute('data-action');
                handleFileAction(fileId, action);
            });
        });
    }
    
    function getFileIcon(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        if (ext === 'png' || ext === 'jpg' || ext === 'jpeg' || ext === 'gif') return 'fa-image';
        if (ext === 'zip' || ext === 'rar' || ext === '7z') return 'fa-file-archive';
        if (ext === 'pdf') return 'fa-file-pdf';
        if (ext === 'doc' || ext === 'docx') return 'fa-file-word';
        if (ext === 'xls' || ext === 'xlsx') return 'fa-file-excel';
        if (ext === 'txt' || ext === 'json' || ext === 'xml') return 'fa-file-alt';
        return 'fa-file';
    }
    
    function handleFileAction(fileId, action) {
        const storage = storageAccounts.find(s => s.id === currentStorageId);
        const file = storage?.files.find(f => f.id === fileId);
        
        if (action === 'download') {
            showToast(`دانلود فایل ${file.name} شروع شد...`, true);
        } else if (action === 'rename') {
            currentFileId = fileId;
            currentFileStorageId = currentStorageId;
            document.getElementById('newFileName').value = file.name;
            openModal(document.getElementById('renameFileModal'));
        } else if (action === 'delete-file') {
            if (confirm(`آیا از حذف فایل ${file?.name} مطمئن هستید؟`)) {
                const index = storage.files.findIndex(f => f.id === fileId);
                if (index !== -1) {
                    storage.files.splice(index, 1);
                    renderFilesTable();
                    renderStorageTable();
                    renderStatsCards();
                    renderStorageBars();
                    showToast(`فایل ${file.name} حذف شد`, true);
                }
            }
        }
    }
    
    // ========== مودال ایجاد/ویرایش ==========
    const storageModal = document.getElementById('storageModal');
    const deleteModal = document.getElementById('deleteModal');
    const uploadModal = document.getElementById('uploadModal');
    const renameFileModal = document.getElementById('renameFileModal');
    
    function openModal(modal) { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    function closeModal(modal) { modal.style.display = 'none'; document.body.style.overflow = ''; }
    
    function resetForm() {
        document.getElementById('storageId').value = '';
        document.getElementById('storageName').value = '';
        document.getElementById('storageType').value = 'Blob Storage';
        document.getElementById('storageTier').value = 'Standard';
        document.getElementById('storageCapacity').value = '500';
        document.getElementById('storageRegion').value = 'North Europe';
        document.getElementById('storageNameError').textContent = '';
    }
    
    function openCreateModal() {
        resetForm();
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> ایجاد حساب ذخیره‌سازی';
        document.getElementById('submitBtn').textContent = 'ایجاد استوریج';
        openModal(storageModal);
    }
    
    function openEditModal(storage) {
        resetForm();
        document.getElementById('storageId').value = storage.id;
        document.getElementById('storageName').value = storage.name;
        document.getElementById('storageType').value = storage.type;
        document.getElementById('storageTier').value = storage.tier;
        document.getElementById('storageCapacity').value = storage.capacity;
        document.getElementById('storageRegion').value = storage.region;
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit"></i> ویرایش استوریج';
        document.getElementById('submitBtn').textContent = 'ذخیره تغییرات';
        openModal(storageModal);
    }
    
    function saveStorage() {
        const name = document.getElementById('storageName').value.trim();
        const storageId = document.getElementById('storageId').value;
        
        if (!name) {
            document.getElementById('storageNameError').textContent = 'نام استوریج الزامی است';
            return;
        }
        if (name.length < 3) {
            document.getElementById('storageNameError').textContent = 'نام باید حداقل ۳ کاراکتر باشد';
            return;
        }
        document.getElementById('storageNameError').textContent = '';
        
        const type = document.getElementById('storageType').value;
        const tier = document.getElementById('storageTier').value;
        const capacity = parseInt(document.getElementById('storageCapacity').value);
        const region = document.getElementById('storageRegion').value;
        
        if (storageId) {
            const index = storageAccounts.findIndex(s => s.id === parseInt(storageId));
            if (index !== -1) {
                storageAccounts[index] = { ...storageAccounts[index], name, type, tier, capacity, region };
                showToast(`استوریج ${name} با موفقیت ویرایش شد ✏️`, true);
            }
        } else {
            const newId = Math.max(...storageAccounts.map(s => s.id), 0) + 1;
            storageAccounts.push({
                id: newId, name, type, tier, capacity, used: 0, region, status: 'active', files: []
            });
            showToast(`استوریج ${name} با موفقیت ایجاد شد 🎉`, true);
        }
        
        renderStatsCards();
        renderStorageBars();
        renderStorageTable();
        closeModal(storageModal);
    }
    
    function openDeleteModal(storage) {
        deleteId = storage.id;
        document.getElementById('deleteStorageName').textContent = storage.name;
        openModal(deleteModal);
    }
    
    function deleteStorage() {
        if (deleteId) {
            const storage = storageAccounts.find(s => s.id === deleteId);
            storageAccounts = storageAccounts.filter(s => s.id !== deleteId);
            showToast(`استوریج ${storage?.name} حذف شد 🗑️`, true);
            renderStatsCards();
            renderStorageBars();
            renderStorageTable();
            if (currentStorageId === deleteId) {
                document.getElementById('filesSection').style.display = 'none';
                currentStorageId = null;
            }
            closeModal(deleteModal);
            deleteId = null;
        }
    }
    
    // ========== آپلود فایل ==========
    function openUploadModal() {
        if (!currentStorageId) {
            showToast('لطفاً ابتدا یک استوریج را انتخاب کنید', false);
            return;
        }
        document.getElementById('fileInput').value = '';
        document.getElementById('fileError').textContent = '';
        openModal(uploadModal);
    }
    
    function uploadFile() {
        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0];
        
        if (!file) {
            document.getElementById('fileError').textContent = 'لطفاً یک فایل انتخاب کنید';
            return;
        }
        
        const storage = storageAccounts.find(s => s.id === currentStorageId);
        if (storage) {
            const newFile = {
                id: nextFileId++,
                name: file.name,
                type: file.type || 'application/octet-stream',
                size: file.size,
                date: new Date().toISOString().split('T')[0]
            };
            storage.files.push(newFile);
            storage.used += Math.ceil(file.size / (1024 * 1024 * 1024));
            renderFilesTable();
            renderStorageTable();
            renderStatsCards();
            renderStorageBars();
            showToast(`فایل ${file.name} با موفقیت آپلود شد 📁`, true);
            closeModal(uploadModal);
        }
    }
    
    function renameFile() {
        const newName = document.getElementById('newFileName').value.trim();
        if (!newName) {
            document.getElementById('renameError').textContent = 'نام فایل الزامی است';
            return;
        }
        
        const storage = storageAccounts.find(s => s.id === currentFileStorageId);
        const file = storage?.files.find(f => f.id === currentFileId);
        
        if (file) {
            const oldName = file.name;
            file.name = newName;
            renderFilesTable();
            showToast(`فایل ${oldName} به ${newName} تغییر نام یافت ✏️`, true);
            closeModal(renameFileModal);
        }
    }
    
    // ========== فیلتر و جستجو ==========
    function initFilters() {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentFilter = btn.getAttribute('data-filter');
                renderStorageTable();
            });
        });
        
        document.getElementById('searchInput').addEventListener('input', () => {
            renderStorageTable();
        });
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
    }
    
    // ========== مقداردهی اولیه ==========
    document.getElementById('createStorageBtn').addEventListener('click', openCreateModal);
    document.getElementById('uploadFileBtn').addEventListener('click', openUploadModal);
    document.getElementById('closeModalBtn').addEventListener('click', () => closeModal(storageModal));
    document.getElementById('closeDeleteModalBtn').addEventListener('click', () => closeModal(deleteModal));
    document.getElementById('closeUploadModalBtn').addEventListener('click', () => closeModal(uploadModal));
    document.getElementById('closeRenameModalBtn').addEventListener('click', () => closeModal(renameFileModal));
    document.getElementById('cancelDeleteBtn').addEventListener('click', () => closeModal(deleteModal));
    document.getElementById('confirmDeleteBtn').addEventListener('click', deleteStorage);
    document.getElementById('storageForm').addEventListener('submit', (e) => { e.preventDefault(); saveStorage(); });
    document.getElementById('uploadForm').addEventListener('submit', (e) => { e.preventDefault(); uploadFile(); });
    document.getElementById('renameForm').addEventListener('submit', (e) => { e.preventDefault(); renameFile(); });
    
    window.addEventListener('click', (e) => {
        if (e.target === storageModal) closeModal(storageModal);
        if (e.target === deleteModal) closeModal(deleteModal);
        if (e.target === uploadModal) closeModal(uploadModal);
        if (e.target === renameFileModal) closeModal(renameFileModal);
    });
    
    renderStatsCards();
    renderStorageBars();
    renderStorageTable();
    initFilters();
    initHamburgerMenu();
</script>

</body>
</html>         
@endsection('main')