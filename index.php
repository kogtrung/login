<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <style>
    .error-border {
      border: 2px solid red;
    }

    .hidden {
      display: none;
      color: red;
    }
  </style>
</head>

<body>

  <form id="loginForm" method="POST" action="login.php" onsubmit="return validateForm()">
    <label>Username:</label>
    <input type="text" id="username" name="username"><br>

    <label>Password:</label>
    <input type="password" id="password" name="password"><br>

    <input type="checkbox" name="remember"> Nhớ đăng nhập<br>

    <button type="submit">Đăng nhập</button><br>

    <label id="errorLabel" class="hidden">⚠️</label>
  </form>

  <a href="register.php">Đăng ký</a> |
  <a href="forgotpassword.php">Quên mật khẩu</a>

  <script>
    function containsUnicode(str) {
      return /[^\x00-\x7F]/.test(str);
    }

    function validateForm() {
      const username = document.getElementById("username");
      const password = document.getElementById("password");
      const errorLabel = document.getElementById("errorLabel");

      // Reset styles
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

      return true; // Cho phép submit nếu không vi phạm
    }
  </script>

  <?php
  // Xử lý lỗi từ PHP (session)
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
<?php
echo password_hash('123', PASSWORD_DEFAULT);
?>
</html>