<?php
$pageTitle = 'Жаңа кітап қосу (Create) — Кітапхана';
$current = 'manage';
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/db.php';

$errors = [];
$form = [
    'title'       => '',
    'author'      => '',
    'cat'         => 'lit',
    'avail'       => 'ok',
    'year'        => date('Y'),
    'pages'       => '',
    'cover'       => '1.svg',
    'description' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = [
        'title'       => post('title'),
        'author'      => post('author'),
        'cat'         => post('cat'),
        'avail'       => post('avail'),
        'year'        => post('year'),
        'pages'       => post('pages'),
        'cover'       => post('cover'),
        'description' => post('description'),
    ];

    if (!verify_csrf()) {
        $errors['csrf'] = 'Қауіпсіздік токені жарамсыз. Қайта жіберіңіз.';
    } else {
        $errors = validate_book_input($form, $categories);
    }

    if (!$errors) {
        // CREATE: SQL инъекциясынан қорғалған дайындалған сұраныс (Prepared Statement)
        $stmt = $pdo->prepare('
            INSERT INTO books (title, author, cat, avail, year, pages, cover, description)
            VALUES (:title, :author, :cat, :avail, :year, :pages, :cover, :description)
        ');
        $stmt->execute([
            ':title'       => $form['title'],
            ':author'      => $form['author'],
            ':cat'         => $form['cat'],
            ':avail'       => $form['avail'],
            ':year'        => (int)$form['year'],
            ':pages'       => (int)$form['pages'],
            ':cover'       => $form['cover'],
            ':description' => $form['description'],
        ]);

        set_flash('success', 'Жаңа кітап «' . $form['title'] . '» дерекқорға сәтті қосылды!');
        header('Location: manage_books.php');
        exit;
    }
}

include 'includes/header.php';
?>
  <div class="container">
    <p class="crumb"><a href="manage_books.php">← Кітаптар тізіміне оралу</a></p>
    <div class="form-card">
      <h1>Жаңа кітап қосу (Create)</h1>
      <p class="subtitle">Барлық өрістер сервер жағында тексеріледі және PDO prepared statement арқылы сақталады.</p>

      <?php if (isset($errors['csrf'])): ?>
        <div class="form-note show form-note-error"><?= e($errors['csrf']) ?></div>
      <?php endif; ?>

      <form method="post" action="book_create.php" novalidate>
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

        <div class="field<?= invalid_class($errors, 'title') ?>">
          <label for="title">Кітап атауы *</label>
          <input type="text" id="title" name="title" value="<?= e($form['title']) ?>" required>
          <span class="error"><?= e($errors['title'] ?? '') ?></span>
        </div>

        <div class="field<?= invalid_class($errors, 'author') ?>">
          <label for="author">Авторы *</label>
          <input type="text" id="author" name="author" value="<?= e($form['author']) ?>" required>
          <span class="error"><?= e($errors['author'] ?? '') ?></span>
        </div>

        <div class="form-row">
          <div class="field<?= invalid_class($errors, 'cat') ?>">
            <label for="cat">Санат *</label>
            <select id="cat" name="cat">
              <?php foreach ($categories as $key => $label): ?>
                <option value="<?= e($key) ?>"<?= $form['cat'] === $key ? ' selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
            <span class="error"><?= e($errors['cat'] ?? '') ?></span>
          </div>

          <div class="field<?= invalid_class($errors, 'avail') ?>">
            <label for="avail">Қолжетімділік *</label>
            <select id="avail" name="avail">
              <option value="ok"<?= $form['avail'] === 'ok' ? ' selected' : '' ?>>Қолжетімді</option>
              <option value="out"<?= $form['avail'] === 'out' ? ' selected' : '' ?>>Берілген</option>
            </select>
            <span class="error"><?= e($errors['avail'] ?? '') ?></span>
          </div>
        </div>

        <div class="form-row">
          <div class="field<?= invalid_class($errors, 'year') ?>">
            <label for="year">Шыққан жылы *</label>
            <input type="number" id="year" name="year" value="<?= e($form['year']) ?>" min="1000" max="<?= (int)date('Y') + 1 ?>" required>
            <span class="error"><?= e($errors['year'] ?? '') ?></span>
          </div>

          <div class="field<?= invalid_class($errors, 'pages') ?>">
            <label for="pages">Бет саны *</label>
            <input type="number" id="pages" name="pages" value="<?= e($form['pages']) ?>" min="1" max="10000" required>
            <span class="error"><?= e($errors['pages'] ?? '') ?></span>
          </div>
        </div>

        <div class="field<?= invalid_class($errors, 'cover') ?>">
          <label for="cover">Мұқаба шаблоны</label>
          <select id="cover" name="cover">
            <?php for ($i = 1; $i <= 8; $i++): $svg = $i . '.svg'; ?>
              <option value="<?= e($svg) ?>"<?= $form['cover'] === $svg ? ' selected' : '' ?>>Мұқаба #<?= $i ?> (<?= e($svg) ?>)</option>
            <?php endfor; ?>
          </select>
          <span class="error"><?= e($errors['cover'] ?? '') ?></span>
        </div>

        <div class="field<?= invalid_class($errors, 'description') ?>">
          <label for="description">Қысқаша сипаттама *</label>
          <textarea id="description" name="description" rows="4" required><?= e($form['description']) ?></textarea>
          <span class="error"><?= e($errors['description'] ?? '') ?></span>
        </div>

        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Сақтау (Create)</button>
          <a class="btn btn-ghost" href="manage_books.php">Бас тарту</a>
        </div>
      </form>
    </div>
  </div>
<?php include 'includes/footer.php'; ?>
