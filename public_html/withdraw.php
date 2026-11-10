<?php
/**
 * withdraw.php ― 退会の確認画面（第12回 配布）
 *
 * ⚠ このフォームには CSRF 対策（トークン）が無い。
 *    第12回の中級で、トークンを埋め込む。
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>退会 ― Tsuchi-to-Hi</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header><a href="index.php">Tsuchi-to-Hi</a><a href="mypage.php">マイページ</a></header>
    <main>
        <h1>退会</h1>
        <p>退会すると、会員情報と書いたレビューがすべて消える。元には戻せない。</p>
        <form action="withdraw-process.php" method="post">
            <button type="submit" class="btn danger">退会する</button>
        </form>
    </main>
</body>
</html>
