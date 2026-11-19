<?php
$pageTitle = 'Кіру — Кітапхана';
$current = 'login';
$mainClass = 'auth';
require_once 'includes/functions.php';
require_once 'includes/db.php';

$errors = [];
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

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id, name, email, password_hash FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id'    => (int)$user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
            ];
            set_flash('success', 'Жүйеге сәтті кірдіңіз!');
            header('Location: manage_books.php');
            exit;
        } else {
            $errors['password'] = 'Электрондық пошта немесе құпиясөз қате.';
        }
    }
}
include 'includes/header.php';
?>
  <div class="card">
    <h1>Кіру</h1>
    <p>Бронь жасау үшін есептік жазбаңызға кіріңіз.</p>
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
