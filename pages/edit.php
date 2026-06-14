<?php
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

global $connect;

$errors = [];
$old = $_POST ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($old['title'] ?? '');
    $description = trim($old['description'] ?? '');

    if ($title === '') {
        $errors['title'] = 'Введите название стикера';
    }

    if (!isset($_FILES['image_path']) || $_FILES['image_path']['error'] !== UPLOAD_ERR_OK) {
        $errors['image_path'] = 'Загрузите фотографию';
    } else {
        $file = $_FILES['image_path'];
        
        $image_info = getimagesize($file['tmp_name']);
        if ($image_info === false) {
            $errors['image_path'] = 'Файл не является изображением';
        } else {
            $filename = time() . '_' . basename($file['name']);
            $destination = 'uploads/' . $filename;
            
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                $errors['image_path'] = 'Ошибка при сохранении файла';
            } else {
                $final_image_path = 'uploads/' . $filename;
            }
        }
    }

    if (empty($errors)) {
        $stmt = $connect->prepare("INSERT INTO stickers (title, description, image_path) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$title, $description, $final_image_path]);
            header('Location: index.php?page=main');
            exit;
        } catch (PDOException $e) {
            $errors['general'] = 'Ошибка при сохранении в базу данных.';
        }
    }
}
?>

<div class="forms content py">
    <div class="form">
        <h2>Добавить стикер</h2>

        <?php if (!empty($errors['general'])): ?>
        <div class="error-message"
            style="background: #f44336; color: white; padding: 10px; text-align: center; margin-bottom:15px;">
            <?= htmlspecialchars($errors['general']) ?>
        </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="input">
                <label for="image_path">Фотография <span style='color:red;'>*</span></label>
                <input type="file" id="image_path" name="image_path" accept="image/png, image/jpeg, image/webp">
                <?php if(!empty($errors['image_path'])): ?>
                <p class="error"><?= htmlspecialchars($errors['image_path']) ?></p>
                <?php endif; ?>
            </div>

            <div class="input">
                <label for="title">Название <span style='color:red;'>*</span></label>
                <input type="text" id="title" name="title" placeholder="Введите название"
                    value="<?= htmlspecialchars($old['title'] ?? '') ?>">
                <?php if(!empty($errors['title'])): ?>
                <p class="error"><?= htmlspecialchars($errors['title']) ?></p>
                <?php endif; ?>
            </div>

            <div class="input">
                <label for="description">Описание</label>
                <input type="text" id="description" name="description" placeholder="Введите описание (необязательно)"
                    value="<?= htmlspecialchars($old['description'] ?? '') ?>">
                <?php if(!empty($errors['description'])): ?>
                <p class="error"><?= htmlspecialchars($errors['description']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit">Добавить стикер</button>
        </form>
    </div>
    <img src="/images/cow.png" alt="">
</div>