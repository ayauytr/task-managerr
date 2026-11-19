<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';

// ?id= параметрін санға айналдырып, кітапты іздейміз
$id = (int)get('id');
$book = $books[$id] ?? null;

$current = 'books';
$message = '';

if ($book === null) {
    http_response_code(404);
    $pageTitle = 'Кітап табылмады — Кітапхана';
    include 'includes/header.php';
    ?>
  <div class="container">
    <p class="crumb"><a href="books.php">← Каталогқа оралу</a></p>
    <p>Кітап табылмады. <a href="books.php">Каталогқа оралыңыз</a>.</p>
  </div>
    <?php
    include 'includes/footer.php';
    exit;
}

$ok = $book['avail'] === 'ok';

// Брондау формасы (POST). Нақты сақтау дерекқор қосылғанда жасалады.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && post('action') === 'reserve') {
    $message = $ok
        ? 'Бронь қабылданды (демо). 3 күн ішінде кітапханадан алыңыз. Нақты сақтау 12-аптада қосылады.'
        : 'Сіз кезекке тұрдыңыз (демо). Нақты кезек 12-аптада қосылады.';
}

$pageTitle = $book['title'] . ' — Кітапхана';
include 'includes/header.php';
?>
  <div class="container">
    <p class="crumb"><a href="books.php">← Каталогқа оралу</a></p>
    <div class="detail">
      <img class="detail-cover" src="img/covers/<?= (int)$book['id'] ?>.svg" alt="<?= e($book['title']) ?> — мұқаба" width="300" height="400">
      <div>
        <h1><?= e($book['title']) ?></h1>
        <p class="meta"><?= e($book['author']) ?></p>
        <span class="badge <?= e($book['avail']) ?>"><?= $ok ? 'Қолжетімді' : 'Берілген' ?></span>
        <p class="desc"><?= e($book['desc']) ?></p>
        <dl class="facts-list">
          <div><dt>Санат</dt><dd><?= e($categories[$book['cat']]) ?></dd></div>
          <div><dt>Жылы</dt><dd><?= (int)$book['year'] ?></dd></div>
          <div><dt>Беті</dt><dd><?= (int)$book['pages'] ?></dd></div>
        </dl>
        <?php if ($message !== ''): ?>
          <div class="form-note show" role="status"><?= e($message) ?></div>
        <?php endif; ?>
        <form method="post" action="book.php?id=<?= (int)$book['id'] ?>">
          <input type="hidden" name="action" value="reserve">
          <button class="btn btn-primary" type="submit"<?= $message !== '' ? ' disabled' : '' ?>>
            <?= $message !== '' ? ($ok ? 'Брондалды' : 'Кезекте') : ($ok ? 'Брондау' : 'Кезекке тұру') ?>
          </button>
        </form>
      </div>
    </div>
  </div>
<?php include 'includes/footer.php'; ?>
