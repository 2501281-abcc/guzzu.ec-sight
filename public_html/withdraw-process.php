<?php
/**
 * withdraw-process.php ― 退会の処理（第12回 配布）
 *
 * ⚠ ログインしているか（＝セッションに user_id があるか）しか見ていない。
 *    だから、どこから送られたフォームでも受け付けてしまう（CSRF）。
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: withdraw.php');
    exit;
}

// 会員を削除する（書いたレビューも一緒に消える）
$stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);

// ログアウトと同じく、セッションを捨てる
$_SESSION = [];
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>退会しました ― Tsuchi-to-Hi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header><a href="index.php">Tsuchi-to-Hi</a></header>
    <main>
        <h1>退会しました</h1>
        <p>ご利用ありがとうございました。</p>
        <p><a href="index.php">トップへ</a></p>
    </main>
</body>
</html>
