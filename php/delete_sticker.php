<?php
session_start();
require_once __DIR__ . '/connect.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?page=main');
    exit;
}


$sticker_id = (int)($_POST['sticker_id'] ?? 0);

if ($sticker_id > 0) {
    $stmt = $connect->prepare("SELECT image_path FROM stickers WHERE id = ?");
    $stmt->execute([$sticker_id]);
    $sticker = $stmt->fetch();
    if ($sticker && !empty($sticker['image_path'])) {
        $file_path = __DIR__ . '/' . $sticker['image_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $stmt = $connect->prepare("DELETE FROM stickers WHERE id = ?");
    $stmt->execute([$sticker_id]);
}
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?page=main'));
exit;
?>