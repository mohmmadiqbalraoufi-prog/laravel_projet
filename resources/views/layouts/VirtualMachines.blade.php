@extends('layouts.sidebar')

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>ماشین مجازی | Azure IaaS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="VirtualMachines.css">
    <link rel="stylesheet" href="HomePage.css">
    <link rel="stylesheet" href="dashboard.css"
     @vite('resources/css/VirtualMachines.style.css'); 
  
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

            <a href="/Dashboard"><i class="fas fa-tachometer-alt"></i> داشبورد</a>
            <a href="/VirtualMachines" class="active"><i class="fas fa-server"></i> ماشین مجازی</a>
            <a href="/Storage"><i class="fas fa-database"></i> ذخیره‌سازی</a>
            <a href="/Networking"><i class="fas fa-network-wired"></i> شبکه</a>
            <a href="/Security"><i class="fas fa-shield-alt"></i> امنیت</a>
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
                <h3><i class="fas fa-server"></i> مدیریت ماشین‌های مجازی</h3>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="جستجوی ماشین مجازی...">
                </div>
                <button class="create-btn" id="createVmBtn"><i class="fas fa-plus-circle"></i> ایجاد ماشین مجازی</button>
            </div>
        </div>

        <!-- کارت‌های آمار -->
        <div class="stats-cards" id="statsCards"></div>

        <!-- جدول ماشین‌های مجازی -->
        <div class="table-section">
            <div class="section-header">
                <h3><i class="fas fa-list"></i> لیست ماشین‌های مجازی</h3>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">همه</button>
                    <button class="filter-btn" data-filter="active">فعال</button>
                    <button class="filter-btn" data-filter="stopped">متوقف</button>
                    <button class="filter-btn" data-filter="warning">هشدار</button>
                </div>
            </div>
            <div class="table-wrapper">
                <table id="vmsTable">
                    <thead>
                        <tr><th>نام</th><th>وضعیت</th><th>CPU</th><th>RAM</th><th>نوع</th><th>منطقه</th><th>عملیات</th></tr>
                    </thead>
                    <tbody id="vmsTableBody"></tbody>
                </table>
            </div>
            <div class="table-footer" id="tableFooter"></div>
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
<!-- مودال ایجاد/ویرایش ماشین مجازی -->
<div id="vmModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle"><i class="fas fa-plus-circle"></i> ایجاد ماشین مجازی</h2>
            <span class="close-modal" id="closeModalBtn">&times;</span>
        </div>
        <form id="vmForm">
            <input type="hidden" id="vmId">
            <div class="form-group">
                <label><i class="fas fa-tag"></i> نام ماشین</label>
                <input type="text" id="vmName" placeholder="مثال: VM-WebServer">
                <small class="error-message" id="vmNameError"></small>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-microchip"></i> CPU (هسته)</label>
                    <select id="vmCpu">
                        <option value="1">1 vCPU</option>
                        <option value="2">2 vCPU</option>
                        <option value="4">4 vCPU</option>
                        <option value="8">8 vCPU</option>
                        <option value="16">16 vCPU</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-memory"></i> RAM</label>
                    <select id="vmRam">
                        <option value="1GB">1 GB</option>
                        <option value="2GB">2 GB</option>
                        <option value="4GB">4 GB</option>
                        <option value="8GB">8 GB</option>
                        <option value="16GB">16 GB</option>
                        <option value="32GB">32 GB</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-layer-group"></i> نوع ماشین</label>
                    <select id="vmType">
                        <option value="B1s">B1s (اقتصادی)</option>
                        <option value="B2s">B2s (اقتصادی)</option>
                        <option value="D2s">D2s (عمومی)</option>
                        <option value="D4s">D4s (عمومی)</option>
                        <option value="E4s">E4s (بهینه حافظه)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-globe"></i> منطقه</label>
                    <select id="vmRegion">
                        <option value="North Europe">شمال اروپا</option>
                        <option value="West Europe">غرب اروپا</option>
                        <option value="East US">شرق آمریکا</option>
                        <option value="Southeast Asia">جنوب شرق آسیا</option>
                        <option value="UAE North">امارات متحده</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-image"></i> تصویر (OS)</label>
                <select id="vmImage">
                    <option value="Ubuntu 22.04 LTS">Ubuntu 22.04 LTS</option>
                    <option value="Windows Server 2022">Windows Server 2022</option>
                    <option value="CentOS 8">CentOS 8</option>
                    <option value="Debian 11">Debian 11</option>
                </select>
            </div>
            <button type="submit" class="modal-submit-btn" id="submitBtn">ایجاد ماشین</button>
        </form>
    </div>
</div>

<!-- مودال حذف -->
<div id="deleteModal" class="modal">
    <div class="modal-content delete-modal">
        <div class="modal-header">
            <h2><i class="fas fa-trash-alt"></i> حذف ماشین مجازی</h2>
            <span class="close-modal" id="closeDeleteModalBtn">&times;</span>
        </div>
        <div class="modal-body">
            <p>آیا از حذف ماشین <strong id="deleteVmName"></strong> مطمئن هستید؟</p>
            <p class="warning-text">این عمل غیرقابل بازگشت است!</p>
        </div>
        <div class="modal-buttons">
            <button id="confirmDeleteBtn" class="btn-danger">بله، حذف شود</button>
            <button id="cancelDeleteBtn" class="btn-secondary">انصراف</button>
        </div>
    </div>
</div>

<!-- پیام Toast -->
<div id="toastMessage" class="toast"></div>

<script>
                /// virtualMachines adding dynamically
let virtualMachines = [
        { id: 1, name: "WebServer-01", status: "active", cpu: 42, ram: "8GB", type: "B2s", region: "North Europe", image: "Ubuntu 22.04 LTS" },
        { id: 2, name: "Database-02", status: "active", cpu: 68, ram: "16GB", type: "D4s", region: "West Europe", image: "Windows Server 2022" },
        { id: 3, name: "Backup-Server", status: "stopped", cpu: 0, ram: "4GB", type: "B1s", region: "East US", image: "Ubuntu 22.04 LTS" },
        { id: 4, name: "K8s-Master", status: "active", cpu: 23, ram: "8GB", type: "D2s", region: "Southeast Asia", image: "Debian 11" },
        { id: 5, name: "Monitoring", status: "warning", cpu: 89, ram: "4GB", type: "B2s", region: "North Europe", image: "Ubuntu 22.04 LTS" },
        { id: 6, name: "App-Server", status: "active", cpu: 35, ram: "8GB", type: "D2s", region: "UAE North", image: "Windows Server 2022" }
    ];

    let currentFilter = "all";
    let currentEditId = null;
    let deleteId = null;

        // a tost masssage
    function showToast(message, isSuccess = true) {
        const toast = document.getElementById('toastMessage');
        toast.textContent = message;
        toast.className = `toast show ${isSuccess ? 'success' : 'error'}`;
        setTimeout(() => { toast.className = 'toast'; }, 3000);
    }

    function getStatusBadge(status) {
        const statusMap = {
            active: '<span class="status-badge status-active"><i class="fas fa-play-circle"></i> فعال</span>',
            stopped: '<span class="status-badge status-stopped"><i class="fas fa-stop-circle"></i> متوقف</span>',
            warning: '<span class="status-badge status-warning"><i class="fas fa-exclamation-triangle"></i> هشدار</span>'
        };
        return statusMap[status] || statusMap.stopped;
    }

    // ========== رندر کارت‌های آمار ==========
    function renderStatsCards() {             //// filter b/c ex from arry of male and famel take femal
        const activeCount = virtualMachines.filter(vm => vm.status === 'active').length;  // number of active vm
        const stoppedCount = virtualMachines.filter(vm => vm.status === 'stopped').length; /// number of stoped vm
        const warningCount = virtualMachines.filter(vm => vm.status === 'warning').length;  // // number of warning 
        const totalCpu = virtualMachines.reduce((sum, vm) => sum + vm.cpu, 0);
        const avgCpu = virtualMachines.length ? (totalCpu / virtualMachines.length).toFixed(1) : 0;
            
        const container = document.getElementById('statsCards');
        container.innerHTML = `
            <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-microchip"></i></div><div class="stat-info"><h4>کل ماشین‌ها</h4><p>${virtualMachines.length}</p></div></div>
            <div class="stat-card"><div class="stat-icon green"><i class="fas fa-play-circle"></i></div><div class="stat-info"><h4>فعال</h4><p>${activeCount}</p></div></div>
            <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-stop-circle"></i></div><div class="stat-info"><h4>متوقف</h4><p>${stoppedCount}</p></div></div>
            <div class="stat-card"><div class="stat-icon red"><i class="fas fa-exclamation-triangle"></i></div><div class="stat-info"><h4>هشدار</h4><p>${warningCount}</p></div></div>
            <div class="stat-card"><div class="stat-icon purple"><i class="fas fa-chart-line"></i></div><div class="stat-info"><h4>میانگین CPU</h4><p>${avgCpu}%</p></div></div>
        `;
    }

    // ========== رندر جدول ==========
    function renderTable() {
        const tbody = document.getElementById('vmsTableBody');
        const footer = document.getElementById('tableFooter');
        
        let filteredVMs = virtualMachines;
        if (currentFilter !== 'all') {
            filteredVMs = virtualMachines.filter(vm => vm.status === currentFilter);
        }
        
        const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
        if (searchTerm) {
            filteredVMs = filteredVMs.filter(vm => vm.name.toLowerCase().includes(searchTerm));
        }
        
        tbody.innerHTML = '';
        
        if (filteredVMs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="empty-row"><i class="fas fa-server"></i> هیچ ماشین مجازی یافت نشد</td></tr>';
            footer.innerHTML = '';
            return;
        }
        
        filteredVMs.forEach(vm => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><i class="fas fa-server"></i> ${vm.name}</td>
                <td>${getStatusBadge(vm.status)}</td>
                <td><div class="cpu-progress"><div class="cpu-fill" style="width: ${vm.cpu}%"></div><span>${vm.cpu}%</span></div></td>
                <td>${vm.ram}</td>
                <td>${vm.type}</td>
                <td><i class="fas fa-map-marker-alt"></i> ${vm.region}</td>
                <td class="vm-actions">
                    <i class="fas fa-play-circle" data-id="${vm.id}" data-action="start" title="شروع"></i>
                    <i class="fas fa-stop-circle" data-id="${vm.id}" data-action="stop" title="توقف"></i>
                    <i class="fas fa-sync-alt" data-id="${vm.id}" data-action="restart" title="راه‌اندازی مجدد"></i>
                    <i class="fas fa-edit" data-id="${vm.id}" data-action="edit" title="ویرایش"></i>
                    <i class="fas fa-trash-alt" data-id="${vm.id}" data-action="delete" title="حذف"></i>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        footer.innerHTML = `<span>نمایش ${filteredVMs.length} از ${virtualMachines.length} ماشین مجازی</span>`;
        
        // اضافه کردن رویدادها
        document.querySelectorAll('.vm-actions i').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(btn.getAttribute('data-id'));
                const action = btn.getAttribute('data-action');
                handleVMAction(id, action);
            });
        });
    }
    
    // ========== عملیات روی ماشین‌ها ==========
    function handleVMAction(id, action) {
        const vm = virtualMachines.find(v => v.id === id);
        if (!vm) return;
        
        const actionText = { start: 'شروع', stop: 'توقف', restart: 'راه‌اندازی مجدد', edit: 'ویرایش', delete: 'حذف' };
        
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
            renderStatsCards();
            renderTable();
        } else if (action === 'stop') {
            vm.status = 'stopped';
            showToast(`${vm.name} متوقف شد ⏹️`, true);
            renderStatsCards();
            renderTable();
        } else if (action === 'restart') {
            showToast(`${vm.name} در حال راه‌اندازی مجدد... 🔄`, true);
            setTimeout(() => {
                vm.cpu = Math.floor(Math.random() * 80) + 10;
                renderTable();
                renderStatsCards();
                showToast(`${vm.name} راه‌اندازی مجدد شد ✅`, true);
            }, 1500);
        } else if (action === 'edit') {
            openEditModal(vm);
        } else if (action === 'delete') {
            openDeleteModal(vm);
        }
    }
    
    // ========== مودال ایجاد/ویرایش ==========
    const vmModal = document.getElementById('vmModal');
    const deleteModal = document.getElementById('deleteModal');
    
    function openModal(modal) { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    function closeModal(modal) { modal.style.display = 'none'; document.body.style.overflow = ''; }
    
    function resetForm() {
        document.getElementById('vmId').value = '';
        document.getElementById('vmName').value = '';
        document.getElementById('vmCpu').value = '2';
        document.getElementById('vmRam').value = '4GB';
        document.getElementById('vmType').value = 'B2s';
        document.getElementById('vmRegion').value = 'North Europe';         
        document.getElementById('vmImage').value = 'Ubuntu 22.04 LTS';
        document.getElementById('vmNameError').textContent = '';
        currentEditId = null;
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
    
    function openCreateModal() {
        resetForm();
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> ایجاد ماشین مجازی';
        document.getElementById('submitBtn').textContent = 'ایجاد ماشین';
        openModal(vmModal);
    }
    
    function openEditModal(vm) {
        resetForm();
        currentEditId = vm.id;
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit"></i> ویرایش ماشین مجازی';
        document.getElementById('submitBtn').textContent = 'ذخیره تغییرات';
        document.getElementById('vmId').value = vm.id;
        document.getElementById('vmName').value = vm.name;
        document.getElementById('vmCpu').value = vm.cpu.toString();
        document.getElementById('vmRam').value = vm.ram;
        document.getElementById('vmType').value = vm.type;
        document.getElementById('vmRegion').value = vm.region;
        document.getElementById('vmImage').value = vm.image;
        openModal(vmModal);
    }
    
    function openDeleteModal(vm) {
        deleteId = vm.id;
        document.getElementById('deleteVmName').textContent = vm.name;
        openModal(deleteModal);
    }
    
    function saveVM() {
        const name = document.getElementById('vmName').value.trim();
        
        if (!name) {
            document.getElementById('vmNameError').textContent = 'نام ماشین الزامی است';
            return;
        }
        if (name.length < 3) {
            document.getElementById('vmNameError').textContent = 'نام باید حداقل ۳ کاراکتر باشد';
            return;
        }
        document.getElementById('vmNameError').textContent = '';
        
        const cpu = parseInt(document.getElementById('vmCpu').value);
        const ram = document.getElementById('vmRam').value;
        const type = document.getElementById('vmType').value;
        const region = document.getElementById('vmRegion').value;
        const image = document.getElementById('vmImage').value;
        
        if (currentEditId) {
            // ویرایش
            const index = virtualMachines.findIndex(v => v.id === currentEditId);
            if (index !== -1) {
                virtualMachines[index] = {
                    ...virtualMachines[index],
                    name, cpu, ram, type, region, image
                };
                showToast(`ماشین ${name} با موفقیت ویرایش شد ✏️`, true);
            }
        } else {
            // ایجاد جدید
            const newId = Math.max(...virtualMachines.map(v => v.id), 0) + 1;
            const newVM = {
                id: newId,
                name: name,
                status: 'stopped',
                cpu: 0,
                ram: ram,
                type: type,
                region: region,
                image: image
            };
            virtualMachines.push(newVM);
            showToast(`ماشین ${name} با موفقیت ایجاد شد 🎉`, true);
        }
        
        renderStatsCards();
        renderTable();
        closeModal(vmModal);
    }
    
    function deleteVM() {
        if (deleteId) {
            const vm = virtualMachines.find(v => v.id === deleteId);
            virtualMachines = virtualMachines.filter(v => v.id !== deleteId);
            showToast(`ماشین ${vm?.name} حذف شد 🗑️`, true);
            renderStatsCards();
            renderTable();
            closeModal(deleteModal);
            deleteId = null;
        }
    }
    
    // ========== فیلتر و جستجو ==========
    function initFilters() {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentFilter = btn.getAttribute('data-filter');
                renderTable();
            });
        });
        
        document.getElementById('searchInput').addEventListener('input', () => {
            renderTable();
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
    document.getElementById('createVmBtn').addEventListener('click', openCreateModal);
    document.getElementById('closeModalBtn').addEventListener('click', () => closeModal(vmModal));
    document.getElementById('closeDeleteModalBtn').addEventListener('click', () => closeModal(deleteModal));
    document.getElementById('cancelDeleteBtn').addEventListener('click', () => closeModal(deleteModal));
    document.getElementById('confirmDeleteBtn').addEventListener('click', deleteVM);
    document.getElementById('vmForm').addEventListener('submit', (e) => {
        e.preventDefault();
        saveVM();
    });
    
    window.addEventListener('click', (e) => {
        if (e.target === vmModal) closeModal(vmModal);
        if (e.target === deleteModal) closeModal(deleteModal);
    });
    
    renderStatsCards();
    renderTable();
    initFilters();
    initHamburgerMenu();
</script>

</body>
</html>
@endsection('main')