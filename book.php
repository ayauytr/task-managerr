<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/db.php';

// ?id= параметрін санға айналдырып, дайындалған сұраныс (prepared statement) арқылы кітапты іздейміз (READ)
$id = (int)get('id');
$stmt = $pdo->prepare('SELECT id, title, author, cat, avail, year, pages, cover, description FROM books WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $id]);
$book = $stmt->fetch() ?: null;

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

// Брондау формасы (POST, Prepared Statement)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && post('action') === 'reserve') {
    if (!verify_csrf()) {
        $message = 'Қауіпсіздік токені сәйкес келмеді. Бетті жаңартып қайта көріңіз.';
    } else {
        $user = current_user();
        if ($user) {
            $status = $ok ? 'reserved' : 'queued';
            $ins = $pdo->prepare('INSERT INTO reservations (user_id, book_id, status) VALUES (:uid, :bid, :status)');
            $ins->execute([
                ':uid'    => (int)$user['id'],
                ':bid'    => (int)$book['id'],
                ':status' => $status,
            ]);
            if ($ok) {
                $upd = $pdo->prepare('UPDATE books SET avail = :avail WHERE id = :id');
                $upd->execute([':avail' => 'out', ':id' => (int)$book['id']]);
                $book['avail'] = 'out';
                $ok = false;
            }
            $message = $status === 'reserved'
                ? 'Бронь дерекқорға сәтті сақталды! 3 күн ішінде кітапханадан алыңыз.'
                : 'Сіз кезекке тіркелдіңіз және дерекқорға сақталды.';
        } else {
            $message = $ok
                ? 'Бронь қабылданды. Толық сақтау үшін жүйеге кіріңіз.'
                : 'Сіз кезекке тұрдыңыз. Толық сақтау үшін жүйеге кіріңіз.';
        }
    }
}

$pageTitle = $book['title'] . ' — Кітапхана';
include 'includes/header.php';
?>
  <div class="container">
    <p class="crumb"><a href="books.php">← Каталогқа оралу</a></p>
    <div class="detail">
      <img class="detail-cover" src="img/covers/<?= e($book['cover']) ?>" alt="<?= e($book['title']) ?> — мұқаба" width="300" height="400">
      <div>
        <h1><?= e($book['title']) ?></h1>
        <p class="meta"><?= e($book['author']) ?></p>
        <span class="badge <?= e($book['avail']) ?>"><?= $ok ? 'Қолжетімді' : 'Берілген' ?></span>
        <p class="desc"><?= e($book['description']) ?></p>
        <dl class="facts-list">
          <div><dt>Санат</dt><dd><?= e($categories[$book['cat']] ?? $book['cat']) ?></dd></div>
          <div><dt>Жылы</dt><dd><?= (int)$book['year'] ?></dd></div>
          <div><dt>Беті</dt><dd><?= (int)$book['pages'] ?></dd></div>
        </dl>
        <?php if ($message !== ''): ?>
          <div class="form-note show" role="status"><?= e($message) ?></div>
        <?php endif; ?>
        <div class="detail-actions">
          <form method="post" action="book.php?id=<?= (int)$book['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="reserve">
            <button class="btn btn-primary" type="submit"<?= $message !== '' ? ' disabled' : '' ?>>
              <?= $message !== '' ? ($ok ? 'Брондалды' : 'Кезекте') : ($ok ? 'Брондау' : 'Кезекке тұру') ?>
            </button>
          </form>
          <a class="btn btn-ghost" href="book_edit.php?id=<?= (int)$book['id'] ?>">Өңдеу (Update)</a>
          <form method="post" action="book_delete.php" onsubmit="return confirm('Бұл кітапты шынымен жойғыңыз келе ме?');">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="id" value="<?= (int)$book['id'] ?>">
            <button class="btn btn-danger" type="submit">Жою (Delete)</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php include 'includes/footer.php'; ?>
