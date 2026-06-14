<?php
global $connect;

if (isset($_SESSION['user_id'])) {
    header('Location: index.php?page=profile');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST;

    $email = trim($old['email'] ?? '');
    $password = $old['password'] ?? '';

    if ($email === '') {
        $errors['email'] = 'Введите почту';
    }
    if ($password === '') {
        $errors['password'] = 'Введите пароль';
    }

    if (empty($errors)) {
        $stmt = $connect->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role'];
            
            header('Location: index.php?page=profile');
            exit;
        } else {
            $errors['general'] = 'Неверный телефон или пароль';
        }
    }
}
?>
<!-- сообщение об ошибке -->
<?php if (!empty($errors['general'])): ?>
<div class="error-message"
    style="background: #f44336; color: white; padding: 10px; text-align: center; margin-bottom:15px;">
    <?= htmlspecialchars($errors['general']) ?>
</div>
<?php endif; ?>

<div class="forms content py">
    <div class="form">
        <h2>Авторизация</h2>
        <form action="" method="post">
            <div class="input">
                <label for="email">Почта <span style='color:red;'>*</span></label>
                <input type="email" id="email" name="email" placeholder="Введите почту"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <?php if(!empty($errors['email'])): ?><p class="error"><?= $errors['email'] ?></p><?php endif; ?>
            </div>
            <div class="input">
                <label for="password">Пароль <span style='color:red;'>*</span></label>
                <input type="password" id="password" name="password" placeholder="Введите пароль">
                <?php if(!empty($errors['password'])): ?><p class="error"><?= $errors['password'] ?></p><?php endif; ?>
            </div>
            <button type="submit">Войти</button>
            <a href="?page=register">Зарегистрироваться</a>
        </form>
    </div>
    <img src="/images/cow.png" alt="">
</div>