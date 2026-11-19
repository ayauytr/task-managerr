<?php
$pageTitle = 'Кітаптарды басқару (CRUD) — Кітапхана';
$current = 'manage';
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/db.php';

$q   = get('q');
$cat = get('cat');
if ($cat !== '' && !isset($categories[$cat])) {
    $cat = '';
}

// READ: Дайындалған сұраныспен барлық кітаптарды алу
$sql = 'SELECT id, title, author, cat, avail, year, pages, cover FROM books WHERE 1=1';
$params = [];

if ($q !== '') {
    $sql .= ' AND (title LIKE :q1 OR author LIKE :q2)';
    $params[':q1'] = '%' . $q . '%';
    $params[':q2'] = '%' . $q . '%';
}
if ($cat !== '') {
    $sql .= ' AND cat = :cat';
    $params[':cat'] = $cat;
}

$sql .= ' ORDER BY id DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$booksList = $stmt->fetchAll();

$flash = get_flash();
include 'includes/header.php';
?>
  <div class="container">
    <div class="page-title page-title-row">
      <div>
        <h1>Кітаптарды басқару (CRUD)</h1>
        <p class="subtitle">Негізгі объектіні құру (Create), көрсету (Read), өңдеу (Update) және жою (Delete).</p>
      </div>
      <a class="btn btn-primary" href="book_create.php">+ Жаңа кітап қосу (Create)</a>
    </div>

    <?php if ($flash): ?>
      <div class="form-note show <?= $flash['type'] === 'error' ? 'form-note-error' : '' ?>" role="status">
        <?= e($flash['msg']) ?>
      </div>
    <?php endif; ?>

    <form class="filters crud-filters" method="get" action="manage_books.php" role="search">
      <div>
        <label for="q">Іздеу (атауы немесе авторы)</label>
        <input type="search" id="q" name="q" placeholder="Кітап атауы..." value="<?= e($q) ?>">
      </div>
      <div>
        <label for="cat">Санат бойынша сүзу</label>
        <select id="cat" name="cat">
          <option value="">Барлық санаттар</option>
          <?php foreach ($categories as $key => $label): ?>
            <option value="<?= e($key) ?>"<?= $key === $cat ? ' selected' : '' ?>><?= e($label) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <button class="btn btn-primary" type="submit">Сүзу</button>
        <a class="btn btn-ghost" href="manage_books.php">Тазалау</a>
      </div>
    </form>

    <p class="result-count">Барлық жазбалар саны: <strong><?= count($booksList) ?></strong></p>

    <?php if (count($booksList) > 0): ?>
    <div class="table-wrap">
      <table class="crud-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Мұқаба</th>
            <th>Атауы және авторы</th>
            <th>Санат</th>
            <th>Жылы / Беті</th>
            <th>Күйі</th>
            <th>Әрекеттер (CRUD)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($booksList as $b): $ok = $b['avail'] === 'ok'; ?>
          <tr>
            <td>#<?= (int)$b['id'] ?></td>
            <td><img class="thumb-cover" src="img/covers/<?= e($b['cover']) ?>" alt="" width="42" height="56"></td>
            <td>
              <strong><a href="book.php?id=<?= (int)$b['id'] ?>"><?= e($b['title']) ?></a></strong><br>
              <span class="meta"><?= e($b['author']) ?></span>
            </td>
            <td><?= e($categories[$b['cat']] ?? $b['cat']) ?></td>
            <td><?= (int)$b['year'] ?> ж. · <?= (int)$b['pages'] ?> бет</td>
            <td><span class="badge <?= e($b['avail']) ?>"><?= $ok ? 'Қолжетімді' : 'Берілген' ?></span></td>
            <td class="actions-cell">
              <a class="btn btn-sm btn-ghost" href="book.php?id=<?= (int)$b['id'] ?>">Көру</a>
              <a class="btn btn-sm btn-primary" href="book_edit.php?id=<?= (int)$b['id'] ?>">Өңдеу</a>
              <form class="inline-form" method="post" action="book_delete.php" onsubmit="return confirm('«<?= e(addslashes($b['title'])) ?>» кітабын жоюды растайсыз ба?');">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                <button class="btn btn-sm btn-danger" type="submit">Жою</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
      <p class="empty show">Кітаптар табылмады. Жаңа кітап қосып көріңіз.</p>
    <?php endif; ?>
  </div>
<?php include 'includes/footer.php'; ?>
