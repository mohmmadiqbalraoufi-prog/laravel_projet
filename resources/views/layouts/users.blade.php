<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لیست کاربران | سرویس ابری</title>
    <link rel="stylesheet" href="users.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
       @vite('resources/css/users.style.css'); 
       @vite('resources/css/homePage.style.css'); 
       @vite('resources/js/users.js'); 
    
</head>
<body>

<div class="container">
    <header>
        <h1><i class="fas fa-users"></i> لیست کاربران سیستم</h1>
        <p>دریافت شده از JSONPlaceholder API</p>
        <button id="refreshBtn" class="refresh-btn"><i class="fas fa-sync-alt"></i> بارگذاری مجدد</button>
    </header>

    <div class="loader" id="loader">
        <div class="spinner"></div>
        <p>در حال بارگذاری اطلاعات کاربران...</p>
    </div>

    <div class="users-grid" id="usersGrid"></div>

    <div class="error-message" id="errorMsg"></div>
</div>

<script src="users.js"></script>
</body>
</html>