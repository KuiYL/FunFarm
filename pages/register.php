<?php
global $connect;

if (isset($_SESSION['user_id'])) {
    header('Location: index.php?page=profile');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST;

    $full_name = trim($old['name'] ?? '');
    $email = trim($old['email'] ?? '');
    $password = $old['password'] ?? '';
    $password_confirm = $old['password_confirm'] ?? '';

    if ($full_name === '') {
        $errors['name'] = 'Укажите ФИО';
    } elseif (mb_strlen($full_name) < 2) {
        $errors['name'] = 'Минимум 2 символа';
    }

    if ($email === '') {
        $errors['email'] = 'Введите почту';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Неверный формат';
    } else {
        $stmt = $connect->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = 'Почта уже занята';
        }
    }

        if ($password === '') {
        $errors['password'] = 'Введите пароль';
    } elseif (mb_strlen($password) < 5) {
        $errors['password'] = 'Минимум 5 символов';
    }

    if ($password_confirm !== $password) {
        $errors['password_confirm'] = 'Пароли не совпадают';
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connect->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'user')");
        
        if ($stmt->execute([$full_name, $email, $hash])) {
            header('Location: index.php?page=login');
            exit;
        } else {
            $errors['general'] = 'Ошибка регистрации. Попробуйте позже.';
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
        <h2>Регистрация</h2>
        <form action="" method="post">
            <div class="input">
                <label for="name">ФИО <span style='color:red;'>*</span></label>
                <input type="text" id="name" name="name" placeholder="Введите ФИО"
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                <?php if(!empty($errors['name'])): ?><p class="error"><?= $errors['name'] ?></p><?php endif; ?>
            </div>
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
            <div class="input">
                <label for="">Повторите пароль <span style='color:red;'>*</span></label>
                <input type="password" id="password_confirm" name="password_confirm" placeholder="Введите пароль">
                <?php if(!empty($errors['password_confirm'])): ?><p class="error"><?= $errors['password_confirm'] ?></p>
                <?php endif; ?>
            </div>
            <button type="submit">Зарегистрироваться</button>
            <a href="?page=login">Есть учётная запись? Войти</a>
        </form>
    </div>
    <img src="/images/cow.png" alt="">
</div>