 
 <nav class="navbar">
        <div class="nav-container">
            <div class="hamburger" id="hamburgerBtn">
                <i class="fas fa-bars"></i>
            </div>

            <div class="logo">
                <div class="logo-icon">
                    <i class="fab fa-microsoft"></i>
                </div>
                <span>Azure IaaS<br><small>زیرساخت ابری</small></span>
            </div>

            <ul class="nav-menu" id="navMenu">
                <li><a href="/layouts/dashboard"><i class="fas fa-tachometer-alt"></i> داشبورد</a></li>
                <li><a href="/layouts/VirtualMachines"><i class="fas fa-server"></i> ماشین مجازی</a></li>
                <li><a href="/layouts/Storage"><i class="fas fa-database"></i> ذخیره‌سازی</a></li>
                <li><a href="/layouts/Networking"><i class="fas fa-network-wired"></i> شبکه</a></li>
                <li><a href="/layouts/Security"><i class="fas fa-shield-alt"></i> امنیت</a></li>
                <li><a href="/layouts/pricing"><i class="fas fa-tag"></i> قیمت</a></li>
                <li><a href="/layouts/users"><i class="fas fa-users"></i> کاربران</a></li>
                <li><a href="/layouts/products "><i class="fas fa-box"></i> محصولات</a></li>

            </ul>
            @yield('home')