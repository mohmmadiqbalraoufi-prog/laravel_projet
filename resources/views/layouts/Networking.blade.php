@extends('layouts.sidebar')
   <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>شبکه | Azure IaaS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="Networking.css">
    <link rel="stylesheet" href="HomePage.css   ">
    @vite('resources/css/Networking.style.css'); 
    @vite('resources/css/homePage.style.css'); 
    

</head>
<body>

<div class="layout">
    <!-- سایدبار -->
     <!-- <aside class="sidebar">
        <h2><i class="fab fa-microsoft"></i> Azure</h2>
        <nav class="sidebar-nav">
            <a href="HomePage.html" class="active"><i class="fas fa-tachometer-alt"></i>صفحه اصلی</a>

            <a href="Dashboard.html"><i class="fas fa-tachometer-alt"></i> داشبورد</a>
            <a href="VirtualMachines.html"><i class="fas fa-server"></i> ماشین مجازی</a>
            <a href="Storage.html"><i class="fas fa-database"></i> ذخیره‌سازی</a>
            <a href="Networking.html" class="active"><i class="fas fa-network-wired"></i> شبکه</a>
            <a href="Security.html"><i class="fas fa-shield-alt"></i> امنیت</a>
            <a href="Pricing.html"><i class="fas fa-tag"></i> قیمت</a>
    </nav> 
    </aside>  -->
 @section('main') 
    <!-- محتوای اصلی -->
    <main class="main">
        <div class="topbar">
            <div class="topbar-left">
                <div class="hamburger" id="hamburgerBtn">
                    <i class="fas fa-bars"></i>
                </div>
                <h3><i class="fas fa-network-wired"></i> مدیریت شبکه</h3>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="جستجوی شبکه...">
                </div>
                <button class="create-btn" id="createVNetBtn"><i class="fas fa-plus-circle"></i> ایجاد شبکه مجازی</button>
            </div>
        </div>

        <!-- کارت‌های آمار -->
        <div class="stats-cards" id="statsCards"></div>

        <!-- بخش شبکه‌های مجازی -->
        <div class="table-section">
            <div class="section-header">
                <h3><i class="fas fa-cloud"></i> شبکه‌های مجازی (VNet)</h3>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">همه</button>
                    <button class="filter-btn" data-filter="active">فعال</button>
                    <button class="filter-btn" data-filter="provisioning">در حال تامین</button>
                </div>
            </div>
            <div class="table-wrapper">
                <table id="vnetTable">
                    <thead>
                        <tr><th>نام</th><th>فضای آدرس</th><th>زیرشبکه‌ها</th><th>دستگاه‌های متصل</th><th>وضعیت</th><th>منطقه</th><th>عملیات</th></tr>
                    </thead>
                    <tbody id="vnetTableBody"></tbody>
                </table>
            </div>
            <div class="table-footer" id="tableFooter"></div>
        </div>

        <!-- بخش زیرشبکه‌ها برای VNet انتخاب شده -->
        <div class="subnets-section" id="subnetsSection" style="display: none;">
            <div class="section-header">
                <h3><i class="fas fa-diagram-project"></i> زیرشبکه‌های <span id="selectedVNetName"></span></h3>
                <button class="add-subnet-btn" id="addSubnetBtn"><i class="fas fa-plus-circle"></i> افزودن زیرشبکه</button>
            </div>
            <div class="table-wrapper">
                <table id="subnetsTable">
                    <thead>
                        <tr><th>نام زیرشبکه</th><th>فضای آدرس</th><th>IP‌های موجود</th><th>تعداد دستگاه‌ها</th><th>عملیات</th></tr>
                    </thead>
                    <tbody id="subnetsTableBody"></tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- مودال ایجاد/ویرایش VNet -->
<div id="vnetModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle"><i class="fas fa-plus-circle"></i> ایجاد شبکه مجازی</h2>
            <span class="close-modal" id="closeModalBtn">&times;</span>
        </div>
        <form id="vnetForm">
            <input type="hidden" id="vnetId">
            <div class="form-group">
                <label><i class="fas fa-tag"></i> نام شبکه</label>
                <input type="text" id="vnetName" placeholder="مثال: vnet-prod">
                <small class="error-message" id="vnetNameError"></small>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-globe"></i> منطقه</label>
                    <select id="vnetRegion">
                        <option value="North Europe">شمال اروپا</option>
                        <option value="West Europe">غرب اروپا</option>
                        <option value="East US">شرق آمریکا</option>
                        <option value="Southeast Asia">جنوب شرق آسیا</option>
                        <option value="UAE North">امارات متحده</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-ip"></i> فضای آدرس (CIDR)</label>
                    <select id="vnetAddressSpace">
                        <option value="10.0.0.0/16">10.0.0.0/16 (65,536 IP)</option>
                        <option value="172.16.0.0/16">172.16.0.0/16 (65,536 IP)</option>
                        <option value="192.168.0.0/16">192.168.0.0/16 (65,536 IP)</option>
                        <option value="10.1.0.0/20">10.1.0.0/20 (4,096 IP)</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-router"></i> زیرشبکه پیش‌ فرض</label>
                <input type="text" id="defaultSubnet" placeholder="مثال: subnet-default" value="default-subnet">
            </div>
            <button type="submit" class="modal-submit-btn" id="submitBtn">ایجاد شبکه</button>
        </form>
    </div>
</div>

<!-- مودال حذف -->
<div id="deleteModal" class="modal">
    <div class="modal-content delete-modal">
        <div class="modal-header">
            <h2><i class="fas fa-trash-alt"></i> حذف شبکه مجازی</h2>
            <span class="close-modal" id="closeDeleteModalBtn">&times;</span>
        </div>
        <div class="modal-body">
            <p>آیا از حذف شبکه <strong id="deleteVNetName"></strong> مطمئن هستید؟</p>
            <p class="warning-text">تمامی زیرشبکه‌ها و منابع متصل نیز حذف خواهند شد!</p>
        </div>
        <div class="modal-buttons">
            <button id="confirmDeleteBtn" class="btn-danger">بله، حذف شود</button>
            <button id="cancelDeleteBtn" class="btn-secondary">انصراف</button>
        </div>
    </div>
</div>

<!-- مودال افزودن/ویرایش زیرشبکه -->
<div id="subnetModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="subnetModalTitle"><i class="fas fa-plus-circle"></i> افزودن زیرشبکه</h2>
            <span class="close-modal" id="closeSubnetModalBtn">&times;</span>
        </div>
        <form id="subnetForm">
            <input type="hidden" id="subnetId">
            <div class="form-group">
                <label><i class="fas fa-tag"></i> نام زیرشبکه</label>
                <input type="text" id="subnetName" placeholder="مثال: subnet-web">
                <small class="error-message" id="subnetNameError"></small>
            </div>
            <div class="form-group">
                <label><i class="fas fa-ip"></i> فضای آدرس (CIDR)</label>
                <select id="subnetAddressSpace">
                    <option value="10.0.1.0/24">10.0.1.0/24 (256 IP)</option>
                    <option value="10.0.2.0/24">10.0.2.0/24 (256 IP)</option>
                    <option value="10.0.3.0/24">10.0.3.0/24 (256 IP)</option>
                    <option value="10.0.4.0/24">10.0.4.0/24 (256 IP)</option>
                    <option value="172.16.1.0/24">172.16.1.0/24 (256 IP)</option>
                    <option value="10.0.0.0/24">10.0.0.0/24 (256 IP)</option>
                </select>
                <small class="hint-message">فضای آدرس باید در محدوده شبکه اصلی باشد</small>
            </div>
            <button type="submit" class="modal-submit-btn" id="subnetSubmitBtn">افزودن زیرشبکه</button>
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
    let vnets = [
        { 
            id: 1, name: "vnet-prod", region: "North Europe", addressSpace: "10.0.0.0/16", status: "active", 
            subnets: [
                { id: 101, name: "subnet-web", cidr: "10.0.1.0/24", availableIps: 251, devices: 5 },
                { id: 102, name: "subnet-db", cidr: "10.0.2.0/24", availableIps: 254, devices: 2 },
                { id: 103, name: "subnet-app", cidr: "10.0.3.0/24", availableIps: 253, devices: 3 }
            ]
        },
        { 
            id: 2, name: "vnet-dev", region: "West Europe", addressSpace: "172.16.0.0/16", status: "active", 
            subnets: [
                { id: 201, name: "subnet-frontend", cidr: "172.16.1.0/24", availableIps: 252, devices: 4 },
                { id: 202, name: "subnet-backend", cidr: "172.16.2.0/24", availableIps: 254, devices: 2 }
            ]
        },
        { 
            id: 3, name: "vnet-test", region: "East US", addressSpace: "192.168.0.0/16", status: "active", 
            subnets: [
                { id: 301, name: "subnet-test", cidr: "192.168.1.0/24", availableIps: 253, devices: 1 }
            ]
        },
        { 
            id: 4, name: "vnet-hub", region: "Southeast Asia", addressSpace: "10.1.0.0/20", status: "provisioning", 
            subnets: [
                { id: 401, name: "subnet-hub", cidr: "10.1.1.0/24", availableIps: 254, devices: 0 }
            ]
        }
    ];

    let currentFilter = "all";
    let currentVNetId = null;
    let deleteId = null;
    let currentSubnetId = null;
    let nextSubnetId = 500;

    // ========== توابع کمکی ==========
    function showToast(message, isSuccess = true) {
        const toast = document.getElementById('toastMessage');
        toast.textContent = message;
        toast.className = `toast show ${isSuccess ? 'success' : 'error'}`;
        setTimeout(() => { toast.className = 'toast'; }, 3000);
    }

    function getStatusBadge(status) {
        if (status === 'active') {
            return '<span class="status-badge status-active"><i class="fas fa-check-circle"></i> فعال</span>';
        } else {
            return '<span class="status-badge status-provisioning"><i class="fas fa-spinner fa-pulse"></i> در حال تامین</span>';
        }
    }

    function getIpCount(cidr) {
        const match = cidr.match(/\/(\d+)/);
        if (match) {
            const prefix = parseInt(match[1]);
            const totalIps = Math.pow(2, 32 - prefix);
            return totalIps - 5; // کم کردن آدرس‌های رزرو شده
        }
        return 250;
    }

    // ========== رندر کارت‌های آمار ==========
    function renderStatsCards() {
        const totalVnets = vnets.length;
        const totalSubnets = vnets.reduce((sum, v) => sum + v.subnets.length, 0);
        const totalDevices = vnets.reduce((sum, v) => sum + v.subnets.reduce((s, sub) => s + sub.devices, 0), 0);
        const activeVnets = vnets.filter(v => v.status === 'active').length;

        const container = document.getElementById('statsCards');
        container.innerHTML = `
            <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-cloud"></i></div><div class="stat-info"><h4>شبکه‌های مجازی</h4><p>${totalVnets}</p></div></div>
            <div class="stat-card"><div class="stat-icon green"><i class="fas fa-diagram-project"></i></div><div class="stat-info"><h4>زیرشبکه‌ها</h4><p>${totalSubnets}</p></div></div>
            <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-server"></i></div><div class="stat-info"><h4>دستگاه‌های متصل</h4><p>${totalDevices}</p></div></div>
            <div class="stat-card"><div class="stat-icon purple"><i class="fas fa-check-circle"></i></div><div class="stat-info"><h4>شبکه‌های فعال</h4><p>${activeVnets}</p></div></div>
        `;
    }

    // ========== رندر جدول VNetها ==========
    function renderVNetTable() {
        const tbody = document.getElementById('vnetTableBody');
        const footer = document.getElementById('tableFooter');
        
        let filteredVnets = vnets;
        if (currentFilter !== 'all') {
            filteredVnets = vnets.filter(v => v.status === currentFilter);
        }
        
        const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
        if (searchTerm) {
            filteredVnets = filteredVnets.filter(v => v.name.toLowerCase().includes(searchTerm));
        }
        
        tbody.innerHTML = '';
        
        if (filteredVnets.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="empty-row"><i class="fas fa-network-wired"></i> هیچ شبکه‌ای یافت نشد</td></tr>';
            footer.innerHTML = '';
            return;
        }
        
        filteredVnets.forEach(vnet => {
            const totalDevices = vnet.subnets.reduce((sum, sub) => sum + sub.devices, 0);
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><i class="fas fa-cloud"></i> ${vnet.name}</td>
                <td>${vnet.addressSpace}</td>
                <td>${vnet.subnets.length}</td>
                <td>${totalDevices}</td>
                <td>${getStatusBadge(vnet.status)}</td>
                <td><i class="fas fa-map-marker-alt"></i> ${vnet.region}</td>
                <td class="actions">
                    <i class="fas fa-diagram-project" data-id="${vnet.id}" data-action="view" title="مشاهده زیرشبکه‌ها"></i>
                    <i class="fas fa-edit" data-id="${vnet.id}" data-action="edit" title="ویرایش"></i>
                    <i class="fas fa-trash-alt" data-id="${vnet.id}" data-action="delete" title="حذف"></i>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        footer.innerHTML = `<span>نمایش ${filteredVnets.length} از ${vnets.length} شبکه مجازی</span>`;
        
        document.querySelectorAll('.actions i').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(btn.getAttribute('data-id'));
                const action = btn.getAttribute('data-action');
                handleVNetAction(id, action);
            });
        });
    }
    
    // ========== عملیات روی VNetها ==========
    function handleVNetAction(id, action) {
        const vnet = vnets.find(v => v.id === id);
        if (!vnet) return;
        
        if (action === 'view') {
            viewSubnets(vnet);
        } else if (action === 'edit') {
            openEditModal(vnet);
        } else if (action === 'delete') {
            openDeleteModal(vnet);
        }
    }
    
    // ========== مشاهده زیرشبکه‌های VNet ==========
    function viewSubnets(vnet) {
        currentVNetId = vnet.id;
        document.getElementById('selectedVNetName').textContent = vnet.name;
        document.getElementById('subnetsSection').style.display = 'block';
        renderSubnetsTable();
    }
    
    function renderSubnetsTable() {
        const vnet = vnets.find(v => v.id === currentVNetId);
        if (!vnet) return;
        
        const tbody = document.getElementById('subnetsTableBody');
        tbody.innerHTML = '';
        
        if (vnet.subnets.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="empty-row"><i class="fas fa-diagram-project"></i> هیچ زیرشبکه‌ای وجود ندارد</td></tr>';
            return;
        }
        
        vnet.subnets.forEach(subnet => {
            const totalIps = getIpCount(subnet.cidr);
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><i class="fas fa-diagram-project"></i> ${subnet.name}</td>
                <td>${subnet.cidr}</td>
                <td>${subnet.availableIps} / ${totalIps}</td>
                <td>${subnet.devices} دستگاه</td>
                <td class="actions">
                    <i class="fas fa-edit" data-subnet-id="${subnet.id}" data-action="edit-subnet" title="ویرایش"></i>
                    <i class="fas fa-trash-alt" data-subnet-id="${subnet.id}" data-action="delete-subnet" title="حذف"></i>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        document.querySelectorAll('#subnetsTable .actions i').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const subnetId = parseInt(btn.getAttribute('data-subnet-id'));
                const action = btn.getAttribute('data-action');
                handleSubnetAction(subnetId, action);
            });
        });
    }
    
    function handleSubnetAction(subnetId, action) {
        const vnet = vnets.find(v => v.id === currentVNetId);
        const subnet = vnet?.subnets.find(s => s.id === subnetId);
        
        if (action === 'edit-subnet') {
            openEditSubnetModal(subnet);
        } else if (action === 'delete-subnet') {
            if (confirm(`آیا از حذف زیرشبکه ${subnet?.name} مطمئن هستید؟`)) {
                const index = vnet.subnets.findIndex(s => s.id === subnetId);
                if (index !== -1) {
                    vnet.subnets.splice(index, 1);
                    renderSubnetsTable();
                    renderVNetTable();
                    renderStatsCards();
                    showToast(`زیرشبکه ${subnet.name} حذف شد`, true);
                }
            }
        }
    }
    
    // ========== مودال ایجاد/ویرایش VNet ==========
    const vnetModal = document.getElementById('vnetModal');
    const deleteModal = document.getElementById('deleteModal');
    const subnetModal = document.getElementById('subnetModal');
    
    function openModal(modal) { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    function closeModal(modal) { modal.style.display = 'none'; document.body.style.overflow = ''; }
    
    function resetForm() {
        document.getElementById('vnetId').value = '';
        document.getElementById('vnetName').value = '';
        document.getElementById('vnetRegion').value = 'North Europe';
        document.getElementById('vnetAddressSpace').value = '10.0.0.0/16';
        document.getElementById('defaultSubnet').value = 'default-subnet';
        document.getElementById('vnetNameError').textContent = '';
    }
    
    function openCreateModal() {
        resetForm();
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> ایجاد شبکه مجازی';
        document.getElementById('submitBtn').textContent = 'ایجاد شبکه';
        openModal(vnetModal);
    }
    
    function openEditModal(vnet) {
        resetForm();
        document.getElementById('vnetId').value = vnet.id;
        document.getElementById('vnetName').value = vnet.name;
        document.getElementById('vnetRegion').value = vnet.region;
        document.getElementById('vnetAddressSpace').value = vnet.addressSpace;
        document.getElementById('defaultSubnet').value = vnet.subnets[0]?.name || 'default-subnet';
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit"></i> ویرایش شبکه مجازی';
        document.getElementById('submitBtn').textContent = 'ذخیره تغییرات';
        openModal(vnetModal);
    }
    
    function saveVNet() {
        const name = document.getElementById('vnetName').value.trim();
        const vnetId = document.getElementById('vnetId').value;
        
        if (!name) {
            document.getElementById('vnetNameError').textContent = 'نام شبکه الزامی است';
            return;
        }
        if (name.length < 3) {
            document.getElementById('vnetNameError').textContent = 'نام باید حداقل ۳ کاراکتر باشد';
            return;
        }
        document.getElementById('vnetNameError').textContent = '';
        
        const region = document.getElementById('vnetRegion').value;
        const addressSpace = document.getElementById('vnetAddressSpace').value;
        const defaultSubnet = document.getElementById('defaultSubnet').value.trim();
        
        if (vnetId) {
            const index = vnets.findIndex(v => v.id === parseInt(vnetId));
            if (index !== -1) {
                vnets[index] = { ...vnets[index], name, region, addressSpace };
                showToast(`شبکه ${name} با موفقیت ویرایش شد ✏️`, true);
            }
        } else {
            const newId = Math.max(...vnets.map(v => v.id), 0) + 1;
            const newSubnet = {
                id: nextSubnetId++,
                name: defaultSubnet,
                cidr: addressSpace.replace('/16', '/24'),
                availableIps: 251,
                devices: 0
            };
            vnets.push({
                id: newId, name, region, addressSpace, status: 'active',
                subnets: [newSubnet]
            });
            showToast(`شبکه ${name} با موفقیت ایجاد شد 🎉`, true);
        }
        
        renderStatsCards();
        renderVNetTable();
        closeModal(vnetModal);
    }
    
    function openDeleteModal(vnet) {
        deleteId = vnet.id;
        document.getElementById('deleteVNetName').textContent = vnet.name;
        openModal(deleteModal);
    }
    
    function deleteVNet() {
        if (deleteId) {
            const vnet = vnets.find(v => v.id === deleteId);
            vnets = vnets.filter(v => v.id !== deleteId);
            showToast(`شبکه ${vnet?.name} حذف شد 🗑️`, true);
            renderStatsCards();
            renderVNetTable();
            if (currentVNetId === deleteId) {
                document.getElementById('subnetsSection').style.display = 'none';
                currentVNetId = null;
            }
            closeModal(deleteModal);
            deleteId = null;
        }
    }
    
    // ========== مدیریت زیرشبکه‌ها ==========
    function openAddSubnetModal() {
        if (!currentVNetId) {
            showToast('لطفاً ابتدا یک شبکه را انتخاب کنید', false);
            return;
        }
        document.getElementById('subnetId').value = '';
        document.getElementById('subnetName').value = '';
        document.getElementById('subnetAddressSpace').value = '10.0.1.0/24';
        document.getElementById('subnetModalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> افزودن زیرشبکه';
        document.getElementById('subnetSubmitBtn').textContent = 'افزودن زیرشبکه';
        document.getElementById('subnetNameError').textContent = '';
        openModal(subnetModal);
    }
    
    function openEditSubnetModal(subnet) {
        currentSubnetId = subnet.id;
        document.getElementById('subnetId').value = subnet.id;
        document.getElementById('subnetName').value = subnet.name;
        document.getElementById('subnetAddressSpace').value = subnet.cidr;
        document.getElementById('subnetModalTitle').innerHTML = '<i class="fas fa-edit"></i> ویرایش زیرشبکه';
        document.getElementById('subnetSubmitBtn').textContent = 'ذخیره تغییرات';
        document.getElementById('subnetNameError').textContent = '';
        openModal(subnetModal);
    }
    
    function saveSubnet() {
        const name = document.getElementById('subnetName').value.trim();
        const cidr = document.getElementById('subnetAddressSpace').value;
        const subnetId = document.getElementById('subnetId').value;
        
        if (!name) {
            document.getElementById('subnetNameError').textContent = 'نام زیرشبکه الزامی است';
            return;
        }
        document.getElementById('subnetNameError').textContent = '';
        
        const vnet = vnets.find(v => v.id === currentVNetId);
        
        if (subnetId) {
            const index = vnet.subnets.findIndex(s => s.id === parseInt(subnetId));
            if (index !== -1) {
                vnet.subnets[index] = { ...vnet.subnets[index], name, cidr };
                showToast(`زیرشبکه ${name} ویرایش شد ✏️`, true);
            }
        } else {
            const newId = nextSubnetId++;
            vnet.subnets.push({
                id: newId, name, cidr, availableIps: 251, devices: 0
            });
            showToast(`زیرشبکه ${name} با موفقیت اضافه شد 🎉`, true);
        }
        
        renderSubnetsTable();
        renderVNetTable();
        renderStatsCards();
        closeModal(subnetModal);
    }
    
    // ========== فیلتر و جستجو ==========
    function initFilters() {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentFilter = btn.getAttribute('data-filter');
                renderVNetTable();
            });
        });
        
        document.getElementById('searchInput').addEventListener('input', () => {
            renderVNetTable();
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
    document.getElementById('createVNetBtn').addEventListener('click', openCreateModal);
    document.getElementById('addSubnetBtn').addEventListener('click', openAddSubnetModal);
    document.getElementById('closeModalBtn').addEventListener('click', () => closeModal(vnetModal));
    document.getElementById('closeDeleteModalBtn').addEventListener('click', () => closeModal(deleteModal));
    document.getElementById('closeSubnetModalBtn').addEventListener('click', () => closeModal(subnetModal));
    document.getElementById('cancelDeleteBtn').addEventListener('click', () => closeModal(deleteModal));
    document.getElementById('confirmDeleteBtn').addEventListener('click', deleteVNet);
    document.getElementById('vnetForm').addEventListener('submit', (e) => { e.preventDefault(); saveVNet(); });
    document.getElementById('subnetForm').addEventListener('submit', (e) => { e.preventDefault(); saveSubnet(); });
    
    window.addEventListener('click', (e) => {
        if (e.target === vnetModal) closeModal(vnetModal);
        if (e.target === deleteModal) closeModal(deleteModal);
        if (e.target === subnetModal) closeModal(subnetModal);
    });
    
    renderStatsCards();
    renderVNetTable();
    initFilters();
    initHamburgerMenu();
</script>

</body>
</html>
@endsection('main')