<?php
$pageTitle = 'Тіркелу — Кітапхана';
$current = 'register';
$mainClass = 'auth';
require_once 'includes/functions.php';
require_once 'includes/db.php';

$errors = [];
$success = false;
$name = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = post('name');
    $email    = post('email');
    $password = (string)($_POST['password'] ?? '');
    $confirm  = (string)($_POST['confirm'] ?? '');

    if (mb_strlen($name) < 2) {
        $errors['name'] = 'Аты-жөніңізді жазыңыз (кемінде 2 таңба).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Дұрыс электрондық пошта енгізіңіз.';
    }
    if (strlen($password) < 8 || !preg_match('/\d/', $password)) {
        $errors['password'] = 'Кемінде 8 таңба және бір сан қажет.';
    }
    if ($password !== $confirm) {
        $errors['confirm'] = 'Құпиясөздер сәйкес емес.';
    }

    if (!$errors) {
        $check = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $check->execute([':email' => $email]);

        if ($check->fetch()) {
            $errors['email'] = 'Бұл электрондық пошта бұрын тіркелген.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare(
                'INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :hash)'
            );
            $ins->execute([
                ':name'  => $name,
                ':email' => $email,
                ':hash'  => $hash,
            ]);

            $success = true;
            $name = $email = '';
        }
    }
}
include 'includes/header.php';
?>