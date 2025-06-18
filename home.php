<?php
session_start();
$user = $_SESSION['user'] ?? ($_COOKIE['user'] ?? null);

if (!$user) {
    header("Location: index.php");
    exit;
}

// Lấy thông tin chi tiết từ database
require_once 'database.php';
require_once 'UserModel.php';

try {
    $db = (new Database())->getConnection();
    $userModel = new UserModel($db);
    $userInfo = $userModel->findByUsername($user);
    
    if (!$userInfo) {
        // Nếu user không tồn tại trong DB, xóa session/cookie
        session_destroy();
        setcookie("user", "", time() - 3600, "/");
        header("Location: index.php");
        exit;
    }
} catch (Exception $e) {
    // Nếu có lỗi DB, vẫn hiển thị thông tin cơ bản
    $userInfo = null;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .welcome { background: #f0f8ff; padding: 20px; border-radius: 5px; }
        .user-info { margin: 20px 0; }
        .logout { background: #ff4444; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="welcome">
        <h2>Chào mừng <?php echo htmlspecialchars($user); ?>!</h2>
        <p>Bạn đã đăng nhập thành công.</p>
    </div>

    <?php if ($userInfo): ?>
    <div class="user-info">
        <h3>Thông tin tài khoản:</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($userInfo['username']); ?></p>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($userInfo['id']); ?></p>
    </div>
    <?php endif; ?>

    <a href="logout.php" class="logout">Đăng xuất</a>
</body>
</html>
