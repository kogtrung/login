<?php
session_start();
require_once 'database.php';
require_once 'UserModel.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

// Kiểm tra Unicode
function contains_unicode($str)
{
    return preg_match('/[^\x00-\x7F]/', $str);
}

// Kiểm tra rỗng
if ($username === '' || $password === '') {
    $_SESSION['error'] = "Điền đầy đủ username và password";
    header("Location: index.php");
    exit;
}
// Kiểm tra ký tự unicode
if (contains_unicode($username)) {
    $_SESSION['error'] = "Username không được dùng kí tự unicode";
    header("Location: index.php");
    exit;
}
if (contains_unicode($password)) {
    $_SESSION['error'] = "Password không được dùng kí tự unicode";
    header("Location: index.php");
    exit;
}

// Kết nối DB và tìm người dùng
try {
    $db = (new Database())->getConnection();
    $userModel = new UserModel($db);
    $user = $userModel->findByUsername($username);

    // Kiểm tra user và password
    if (!$user) {
        $_SESSION['error'] = "Username '$username' không tồn tại";
        header("Location: index.php");
        exit;
    }

    if (!password_verify($password, $user['password_hash'])) {
        $_SESSION['error'] = "Mật khẩu không đúng cho username '$username'";
        header("Location: index.php");
        exit;
    }

    // Đăng nhập thành công
    if ($remember) {
        setcookie("user", $username, time() + (86400 * 30), "/");
    } else {
        $_SESSION['user'] = $username;
    }
    header("Location: home.php");
    exit;

} catch (Exception $e) {
    $_SESSION['error'] = "Lỗi hệ thống: " . $e->getMessage();
    header("Location: index.php");
    exit;
}
