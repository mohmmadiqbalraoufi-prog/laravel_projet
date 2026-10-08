const API_URL = 'https://jsonplaceholder.typicode.com/users';

const usersGrid = document.getElementById('usersGrid');
const loader = document.getElementById('loader');
const errorMsg = document.getElementById('errorMsg');
const refreshBtn = document.getElementById('refreshBtn');

// دریافت کاربران از API
/// async wating for API to take the data
async function fetchUsers() {
    // نمایش لودر و پاک کردن خطاها
    loader.classList.add('show');
    errorMsg.classList.remove('show');
    usersGrid.innerHTML = '';

    try {
        //////////////// await: wait to arrive the response
        const response = await fetch(API_URL);
        
        if (!response.ok) {
            throw new Error(`خطای شبکه: ${response.status}`);
        }
         /////////// when receved convert it in jason formate 
        const users = await response.json();
        /// if no user found show and error
        if (!users || users.length === 0) {
            throw new Error('هیچ کاربری یافت نشد');
        }
        
        renderUsers(users);
        
    } catch (error) {
        console.error('خطا در دریافت داده‌ها:', error);
        errorMsg.innerHTML = `<i class="fas fa-exclamation-triangle"></i> خطا در بارگذاری اطلاعات: ${error.message}`;
        errorMsg.classList.add('show');
    /// whether or not seccued hide the loading 
    } finally {
        loader.classList.remove('show');
    }
}

// رندر کاربران در صفحه
function renderUsers(users) {
    usersGrid.innerHTML = '';     /// make plase (empty)
    
    users.forEach(user => {    /// making card for every user 
        const card = document.createElement('div');
        card.className = 'user-card';
        
        // استخراج اطلاعات آدرس
        const address = user.address;
        const addressText = `${address.city}، ${address.street}، پلاک ${address.suite || ''}`;
        
        // استخراج نام شرکت
        const companyName = user.company?.name || 'نامشخص';  /// take the name of company if whare not write undefined 
        
        card.innerHTML = `
            <div class="card-header">
                <div class="avatar">
                    <i class="fas fa-user-circle"></i>   
                </div>
                <div class="user-info">
                    <div class="user-name">${escapeHtml(user.name)}</div>
                    <div class="user-username">@${escapeHtml(user.username)}</div>
                </div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:${escapeHtml(user.email)}">${escapeHtml(user.email)}</a>
                </div>
                <div class="info-row">
                    <i class="fas fa-phone"></i>
                    <span>${escapeHtml(user.phone)}</span>
                </div>
                <div class="info-row">
                    <i class="fas fa-globe"></i>
                    <a href="https://${user.website}" target="_blank" rel="noopener noreferrer">${escapeHtml(user.website)}</a>
                </div>
                <div class="company">
                    <i class="fas fa-building"></i> <strong>شرکت:</strong> ${escapeHtml(companyName)}
                </div>
                <div class="address">
                    <i class="fas fa-map-marker-alt"></i> <strong>آدرس:</strong> ${escapeHtml(addressText)}
                </div>
            </div>
        `;
        
        usersGrid.append(card);    /// apend add in the end
    });
}

// تابع ساده برای جلوگیری از XSS
function escapeHtml(str) {
    if (!str) return '';
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

// بارگذاری اولیه
fetchUsers();

// رفرش با کلیک دکمه
refreshBtn.addEventListener('click', fetchUsers);