<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(to right, #f3e5f5, #e8f5e9);
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-container {
      background-color: #fff;
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      width: 350px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    .error-border {
      border: 2px solid red !important;
    }

    .hidden {
      display: none;
      color: red;
      font-size: 14px;
      margin-bottom: 12px;
    }

    .remember {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }

    .remember input {
      margin-right: 6px;
    }

    button {
      width: 100%;
      padding: 10px;
      border: none;
      background: #7e57c2;
      color: #fff;
      font-size: 15px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #5e35b1;
    }

    .links {
      text-align: center;
      margin-top: 15px;
    }

    .links a {
      color: #333;
      text-decoration: none;
      margin: 0 8px;
    }

    .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h2>🔐 Đăng nhập</h2>

    <form id="loginForm" method="POST" action="login.php" onsubmit="return validateForm()">
      <input type="text" id="username" name="username" placeholder="Tên đăng nhập">
      <input type="password" id="password" name="password" placeholder="Mật khẩu">

      <label id="errorLabel" class="hidden">⚠️</label>

      <div class="remember">
        <input type="checkbox" name="remember">
        <label>Nhớ đăng nhập</label>
      </div>

      <button type="submit">Đăng nhập</button>
    </form>

    <div class="links">
      <a href="register.php">Đăng ký</a> |
      <a href="forgotpassword.php">Quên mật khẩu?</a>
    </div>
  </div>

  <script>
    function containsUnicode(str) {
      return /[^\x00-\x7F]/.test(str);
    }

    function validateForm() {
      const username = document.getElementById("username");
      const password = document.getElementById("password");
      const errorLabel = document.getElementById("errorLabel");

      username.classList.remove("error-border");
      password.classList.remove("error-border");
      errorLabel.classList.add("hidden");

      if (!username.value || !password.value) {
        errorLabel.innerText = "⚠️ Điền đầy đủ username và password";
        errorLabel.classList.remove("hidden");
        username.classList.add("error-border");
        password.classList.add("error-border");
        return false;
      }

      if (containsUnicode(username.value)) {
        errorLabel.innerText = "⚠️ Username không được dùng kí tự unicode";
        errorLabel.classList.remove("hidden");
        username.classList.add("error-border");
        return false;
      }

      if (containsUnicode(password.value)) {
        errorLabel.innerText = "⚠️ Password không được dùng kí tự unicode";
        errorLabel.classList.remove("hidden");
        password.classList.add("error-border");
        return false;
      }

      return true;
    }
  </script>

  <?php
  if (isset($_SESSION['error'])) {
    echo "<script>
      const label = document.getElementById('errorLabel');
      label.innerText = '⚠️ " . $_SESSION['error'] . "';
      label.classList.remove('hidden');
    </script>";
    unset($_SESSION['error']);
  }
  ?>
</body>

</html>
