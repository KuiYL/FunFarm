<?php
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

global $connect;

$stmt = $connect->prepare("SELECT id, full_name, email, role, created_at FROM users ORDER BY id DESC");
$stmt->execute(); 

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="forms content py">
    <div class="profile">
        <div class="n">
            <h2>Пользователи</h2>
            <a href="index.php?page=profile">/ Профиль</a>
        </div>
        <div class="users">
            <?php if (empty($users)): ?>
            <p style="text-align:center; padding:30px; color:#666;">Пользователей пока нет</p>
            <?php else: ?>
            <?php foreach ($users as $userData): ?>
            <div class="user">
                <p><?= htmlspecialchars($userData['created_at'] ?? 'Дата неизвестна') ?></p>
                <h3><?= htmlspecialchars($userData['full_name']) ?></h3>
                <p><?= htmlspecialchars($userData['email']) ?></p>
                <p><small>Роль: <?= htmlspecialchars($userData['role']) ?></small></p>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>