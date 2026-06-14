<?php
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

global $connect;

$sticker_id = (int)($_GET['id'] ?? 0);
if ($sticker_id <= 0) {
    header('Location: index.php?page=main');
    exit;
}

$stmt = $connect->prepare("SELECT id, title, description, image_path FROM stickers WHERE id = ?");
$stmt->execute([$sticker_id]);
$sticker = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sticker) {
    header('Location: index.php?page=main');
    exit;
}

$errors = [];
$old = $_POST ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($old['title'] ?? '');
    $description = trim($old['description'] ?? '');

    if ($title === '') {
        $errors['title'] = 'Введите название стикера';
    }

    $final_image_path = $sticker['image_path'];

    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image_path'];
        
        $image_info = getimagesize($file['tmp_name']);
        if ($image_info === false) {
            $errors['image_path'] = 'Файл не является изображением';
        } else {
            $filename = time() . '_' . basename($file['name']);
            $new_path = 'uploads/' . $filename;
            
            $old_file_path = __DIR__ . '/' . $sticker['image_path'];
            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }
            
            if (!move_uploaded_file($file['tmp_name'], $new_path)) {
                $errors['image_path'] = 'Ошибка при сохранении файла';
            } else {
                $final_image_path = $new_path;
            }
        }
    }

    if (empty($errors)) {
        $stmt = $connect->prepare("UPDATE stickers SET title = ?, description = ?, image_path = ? WHERE id = ?");
        try {
            $stmt->execute([$title, $description, $final_image_path, $sticker_id]);
            header('Location: index.php?page=main');
            exit;
        } catch (PDOException $e) {
            $errors['general'] = 'Ошибка при обновлении стикера.';
        }
    }
}
?>

<div class="forms content py">
    <div class="form">
        <h2>ИЗМЕНИТЬ СТИКЕР</h2>

        <?php if (!empty($errors['general'])): ?>
        <div class="error-message"
            style="background: #f44336; color: white; padding: 10px; margin-bottom:15px; text-align: center;">
            <?= htmlspecialchars($errors['general']) ?>
        </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">

            <?php if (!empty($sticker['image_path'])): ?>
            <div style="margin-bottom: 15px;">
                <p style="margin-bottom: 5px;">Текущее изображение:</p>
                <img src="<?= htmlspecialchars($sticker['image_path']) ?>"
                    alt="<?= htmlspecialchars($sticker['title']) ?>"
                    style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
            </div>
            <?php endif; ?>

            <div class="input">
                <label for="image_path">Заменить фотографию (необязательно)</label>
                <input type="file" id="image_path" name="image_path" accept="image/png, image/jpeg, image/webp">
                <?php if(!empty($errors['image_path'])): ?>
                <p class="error"><?= htmlspecialchars($errors['image_path']) ?></p>
                <?php endif; ?>
            </div>

            <div class="input">
                <label for="title">Название <span style='color:red;'>*</span></label>
                <input type="text" id="title" name="title" placeholder="Введите название"
                    value="<?= htmlspecialchars($old['title'] ?? $sticker['title']) ?>">
                <?php if(!empty($errors['title'])): ?>
                <p class="error"><?= htmlspecialchars($errors['title']) ?></p>
                <?php endif; ?>
            </div>

            <div class="input">
                <label for="description">Описание</label>
                <input type="text" id="description" name="description" placeholder="Введите описание"
                    value="<?= htmlspecialchars($old['description'] ?? $sticker['description']) ?>">
                <?php if(!empty($errors['description'])): ?>
                <p class="error"><?= htmlspecialchars($errors['description']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit">Сохранить стикер</button>
            <a href="index.php?page=stickers" style="display: block; margin-top: 10px; text-align: center;">Отмена</a>
        </form>
    </div>
    <img src="/images/cow.png" alt="">
</div>