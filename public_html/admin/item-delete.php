<?php
/**
 * admin/item-delete.php ― 商品削除（POSTのみ受け付ける）
 */
require_once __DIR__ . '/../../includes/config.php';
session_start();
 
// ① 認証：ログインしていなければ、ログイン画面へ戻す
if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_error'] = '続けるにはログインが必要です';
    header('Location: ../login.php');
    exit;
}
 
// ② 認可：管理者でなければ、ここで止める（403 = 権限が無い）
if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo 'このページにアクセスする権限がありません。<a href="../mypage.php">マイページへ戻る</a>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: item-list.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

// 画像ファイルも一緒に削除する
$stmt = $pdo->prepare('SELECT image FROM items WHERE id = ?');
$stmt->execute([$id]);
$image = $stmt->fetchColumn();
if ($image) {
    $path = __DIR__ . '/../uploads/items/' . $image;
    if (is_file($path)) {
        unlink($path);
    }
}

// TODO（初級）: items テーブルから該当行を DELETE する（必ずプレースホルダを使うこと）
$del = $pdo->prepare('DELETE FROM items WHERE id = ?');
$del->execute([$id]);

header('Location: item-list.php');
exit;

