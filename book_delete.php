<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

// Тек POST әдісімен ғана жоюға рұқсат береміз (CSRF қорғауы)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: manage_books.php');
    exit;
}

if (!verify_csrf()) {
    set_flash('error', 'Қауіпсіздік токені сәйкес келмеді. Жою орындалмады.');
    header('Location: manage_books.php');
    exit;
}

$id = (int)post('id');
if ($id <= 0) {
    set_flash('error', 'Жою үшін жарамсыз кітап ID берілді.');
    header('Location: manage_books.php');
    exit;
}

// Алдымен кітап атауын хабарлама үшін аламыз (Prepared Statement)
$check = $pdo->prepare('SELECT title FROM books WHERE id = :id LIMIT 1');
$check->execute([':id' => $id]);
$book = $check->fetch();

if (!$book) {
    set_flash('error', 'Кітап табылмады немесе бұрын жойылған.');
    header('Location: manage_books.php');
    exit;
}

// DELETE: Дайындалған сұраныс (Prepared Statement) арқылы жою
$del = $pdo->prepare('DELETE FROM books WHERE id = :id');
$del->execute([':id' => $id]);

set_flash('success', '«' . $book['title'] . '» кітабы дерекқордан сәтті жойылды.');
header('Location: manage_books.php');
exit;
