<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود | Azure IaaS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0b2b3f 0%, #0a1e2c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-container {
            background: white;
            border-radius: 32px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo i {
            font-size: 3rem;
            color: #0078d4;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 12px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1rem 0;
        }
        button {
            width: 100%;
            background: #0078d4;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1rem;
        }
        .error-msg {
            background: #fee;
            color: red;
            padding: 10px;
            border-radius: 12px;
            margin-top: 1rem;
            display: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo">
        <i class="fab fa-microsoft"></i>
        <h2>Azure IaaS</h2>
    </div>
    
    <form id="loginForm">
        <div class="form-group">
            <label>نام کاربری</label>
            <input type="text" id="username" placeholder="admin">
        </div>
        <div class="form-group">
            <label>رمز عبور</label>
            <input type="password" id="password" placeholder="admin123">
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="rememberMe">
            <label>مرا به خاطر بسپار</label>
        </div>
        <button type="submit">ورود</button>
        <div id="errorMsg" class="error-msg"></div>
    </form>
</div>

<script src="auth.js"></script>
<script>
    const DEMO_USERS = [
        { username: "admin", password: "admin123", name: "مدیر سیستم" }
    ];
    
    document.getElementById('loginForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const rememberMe = document.getElementById('rememberMe').checked;
        
        const user = DEMO_USERS.find(u => u.username === username && u.password === password);
        
        if (user) {
            AuthStorage.saveUser({ username: user.username, name: user.name }, rememberMe);
            window.location.href = 'dashboard.html';
        } else {
            const errorMsg = document.getElementById('errorMsg');
            errorMsg.textContent = 'نام کاربری یا رمز عبور اشتباه است';
            errorMsg.style.display = 'block';
        }
    });
</script>

</body>
</html>