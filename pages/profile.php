<?php
session_start();
global $connect;

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

$stmt = $connect->prepare("SELECT id, full_name, email, role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header('Location: index.php?page=login');
    exit;
}
?>

<div class="forms content py">
    <div class="profile">
        <div class="n">
            <h2>Профиль</h2>
            <?php if (($user['role'] ?? '') === 'admin'): ?>
            <a href="index.php?page=users">/ Пользователи</a>
            <?php endif; ?>
        </div>
        <div class="prof">
            <div class="p">
                <p>Личная информация</p>
                <h3><?= htmlspecialchars($user['full_name']) ?></h3>
            </div>
            <div class="p">
                <p>Почта</p>
                <h3><?= htmlspecialchars($user['email']) ?></h3>
            </div>
            <a href="php/logout.php">Выйти из аккаунта</a>
        </div>
    </div>
    <img src="/images/cow.png" alt="">
</div>