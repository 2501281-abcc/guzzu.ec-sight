<?php
/**
 * admin/item-list.php ― 管理者用 商品一覧（CRUDの入口）
 *
 * 注意：この時点ではまだログイン・権限チェックを実装していません。
 * 第9回で require_admin() を先頭に追加し、一般ユーザーがアクセスできないようにします。
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

$items = $pdo->query('SELECT id, name, price, stock, category FROM items ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品管理 ― Tsuchi-to-Hi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header><a href="../index.php">Tsuchi-to-Hi</a></header>
    <main>
        <h1>商品管理</h1>
        <p><a class="btn" href="item-add.php">＋ 新規登録</a></p>

        <table class="admin-table">
            <tr><th>ID</th><th>商品名</th><th>価格</th><th>在庫</th><th>カテゴリ</th><th></th></tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= (int) $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>¥<?= number_format($item['price']) ?></td>
                    <td><?= (int) $item['stock'] ?></td>
                    <td><?= htmlspecialchars($item['category'] ?? '') ?></td>
                    <td>
                        <a href="item-edit.php?id=<?= (int) $item['id'] ?>">編集</a>
                        &nbsp;
                        <form action="item-delete.php" method="post" style="display:inline"
                              onsubmit="return confirm('本当に削除しますか？');">
                            <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                            <button type="submit" class="btn danger">削除</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>
