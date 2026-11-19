<?php
$pageTitle = 'Кіру — Кітапхана';
$current = 'login';
$mainClass = 'auth';
require_once 'includes/functions.php';

$errors = [];
$success = false;
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = post('email');
    $password = (string)($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Дұрыс электрондық пошта енгізіңіз.';
    }
    if ($password === '') {
        $errors['password'] = 'Құпиясөзді енгізіңіз.';
    }

    // Нақты тексеру (дерекқор, сессия) 11-аптада қосылады
    if (!$errors) {
        $success = true;
    }
}
include 'includes/header.php';
?>
  <div class="card">
    <h1>Кіру</h1>
    <p>Бронь жасау үшін есептік жазбаңызға кіріңіз.</p>
    <?php if ($success): ?>
      <div class="form-note show" role="status">Форма дұрыс толтырылды. Аутентификация 11-аптада қосылады.</div>
    <?php endif; ?>
    <form id="login-form" action="login.php" method="post" novalidate>
      <div class="field<?= invalid_class($errors, 'email') ?>"><label for="email">Электрондық пошта</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" autocomplete="email" required><span class="error" id="email-err"><?= e($errors['email'] ?? '') ?></span></div>
      <div class="field<?= invalid_class($errors, 'password') ?>"><label for="password">Құпиясөз</label>
        <div class="pw"><input type="password" id="password" name="password" autocomplete="current-password" required><button type="button" data-toggle="password">Көрсету</button></div>
        <span class="error" id="password-err"><?= e($errors['password'] ?? '') ?></span></div>
      <button class="btn btn-primary btn-block" type="submit">Кіру</button>
    </form>
    <p class="switch">Есептік жазба жоқ па? <a href="register.php">Тіркелу</a></p>
  </div>
<?php include 'includes/footer.php'; ?>
