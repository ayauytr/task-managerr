<?php
$pageTitle = 'Тіркелу — Кітапхана';
$current = 'register';
$mainClass = 'auth';
require_once 'includes/functions.php';

$errors = [];
$success = false;
$name = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = post('name');
    $email    = post('email');
    $password = (string)($_POST['password'] ?? '');
    $confirm  = (string)($_POST['confirm'] ?? '');

    // Сервер жағындағы валидация
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

    // Дерекқорға сақтау (password_hash) 11-аптада қосылады
    if (!$errors) {
        $success = true;
        $name = $email = '';
    }
}
include 'includes/header.php';
?>
  <div class="card">
    <h1>Тіркелу</h1>
    <p>Оқырман болып, кітаптарды онлайн брондаңыз.</p>
    <?php if ($success): ?>
      <div class="form-note show" role="status">Деректер дұрыс. Дерекқорға сақтау 11-аптада қосылады.</div>
    <?php endif; ?>
    <form id="register-form" action="register.php" method="post" novalidate>
      <div class="field<?= invalid_class($errors, 'name') ?>"><label for="name">Аты-жөні</label>
        <input type="text" id="name" name="name" value="<?= e($name) ?>" autocomplete="name" required><span class="error" id="name-err"><?= e($errors['name'] ?? '') ?></span></div>
      <div class="field<?= invalid_class($errors, 'email') ?>"><label for="email">Электрондық пошта</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" autocomplete="email" required><span class="error" id="email-err"><?= e($errors['email'] ?? '') ?></span></div>
      <div class="field<?= invalid_class($errors, 'password') ?>"><label for="password">Құпиясөз (кемінде 8 таңба, бір сан)</label>
        <div class="pw"><input type="password" id="password" name="password" autocomplete="new-password" required><button type="button" data-toggle="password">Көрсету</button></div>
        <span class="error" id="password-err"><?= e($errors['password'] ?? '') ?></span></div>
      <div class="field<?= invalid_class($errors, 'confirm') ?>"><label for="confirm">Құпиясөзді қайталаңыз</label>
        <input type="password" id="confirm" name="confirm" autocomplete="new-password" required><span class="error" id="confirm-err"><?= e($errors['confirm'] ?? '') ?></span></div>
      <button class="btn btn-primary btn-block" type="submit">Тіркелу</button>
    </form>
    <p class="switch">Есептік жазбаңыз бар ма? <a href="login.php">Кіру</a></p>
  </div>
<?php include 'includes/footer.php'; ?>
