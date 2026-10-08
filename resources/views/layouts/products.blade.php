


<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فروشگاه محصولات | سرویس ابری</title>
    <link rel="stylesheet" href="products.css">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/products.style.css');
    
    
</head>
<body>

<div class="container">
    <header>
        <h1><i class="fas fa-store"></i> فروشگاه محصولات</h1>
        <p>دریافت شده از FakeStore API</p>
        <div class="filters-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="جستجوی محصول...">
            </div>
            <div class="category-filter">
                <button class="filter-btn active" data-category="all">همه</button>
                <button class="filter-btn" data-category="men's clothing">پوشاک مردانه</button>
                <button class="filter-btn" data-category="women's clothing">پوشاک زنانه</button>
                <button class="filter-btn" data-category="jewelery">جواهرات</button>
                <button class="filter-btn" data-category="electronics">الکترونیک</button>
            </div>
            <button id="refreshBtn" class="refresh-btn"><i class="fas fa-sync-alt"></i> بارگذاری مجدد</button>
        </div>
    </header>

    <div class="loader" id="loader">
        <div class="spinner"></div>
        <p>در حال بارگذاری محصولات...</p>
    </div>

    <div class="products-grid" id="productsGrid"></div>

    <div class="error-message" id="errorMsg"></div>
</div>

<!-- مودال نمایش جزئیات محصول -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">جزئیات محصول</h2>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body" id="modalBody"></div>
    </div>
</div>

<script src="products.js"></script>
</body>
</html>
