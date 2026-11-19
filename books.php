<?php
$pageTitle = 'Каталог — Кітапхана';
$current = 'books';
require_once 'includes/functions.php';
require_once 'includes/data.php';

// GET арқылы келген іздеу параметрлері
$q     = get('q');
$cat   = get('cat');
$avail = get('avail');

// Белгісіз мәндерді қабылдамаймыз
if ($cat !== '' && !isset($categories[$cat])) {
    $cat = '';
}
if (!in_array($avail, ['', 'ok', 'out'], true)) {
    $avail = '';
}

// Сервер жағында сүзу
$result = array_filter($books, function ($b) use ($q, $cat, $avail) {
    if ($q !== '' && mb_stripos($b['title'] . ' ' . $b['author'], $q) === false) {
        return false;
    }
    if ($cat !== '' && $b['cat'] !== $cat) {
        return false;
    }
    if ($avail !== '' && $b['avail'] !== $avail) {
        return false;
    }
    return true;
});

include 'includes/header.php';
?>
  <div class="container">
    <div class="page-title">
      <h1>Кітаптар каталогы</h1>
    </div>
    <form class="filters" method="get" action="books.php" role="search" aria-label="Кітапты іздеу">
      <div><label for="q">Атауы немесе авторы</label>
        <input type="search" id="q" name="q" placeholder="Мысалы: Әуезов" value="<?= e($q) ?>"></div>
      <div><label for="cat">Санат</label>
        <select id="cat" name="cat">
          <option value="">Барлығы</option>
          <?php foreach ($categories as $key => $name): ?>
            <option value="<?= e($key) ?>"<?= $key === $cat ? ' selected' : '' ?>><?= e($name) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div><label for="avail">Қолжетімділік</label>
        <select id="avail" name="avail">
          <option value="">Барлығы</option>
          <option value="ok"<?= $avail === 'ok' ? ' selected' : '' ?>>Қолжетімді</option>
          <option value="out"<?= $avail === 'out' ? ' selected' : '' ?>>Берілген</option>
        </select></div>
      <div><button class="btn btn-primary" type="submit">Іздеу</button>
        <a class="btn btn-ghost" href="books.php">Тазалау</a></div>
    </form>
    <p class="result-count" aria-live="polite">Табылды: <?= count($result) ?> кітап</p>

    <?php if (count($result) > 0): ?>
    <div class="grid">
      <?php foreach ($result as $b): $ok = $b['avail'] === 'ok'; ?>
      <article class="book">
        <a href="book.php?id=<?= (int)$b['id'] ?>"><img class="cover-img" src="img/covers/<?= (int)$b['id'] ?>.svg" alt="<?= e($b['title']) ?> — мұқаба" width="300" height="400" loading="lazy"></a>
        <div class="book-body">
          <h3><a href="book.php?id=<?= (int)$b['id'] ?>"><?= e($b['title']) ?></a></h3>
          <span class="meta"><?= e($b['author']) ?> · <?= e($categories[$b['cat']]) ?></span>
          <span class="badge <?= e($b['avail']) ?>"><?= $ok ? 'Қолжетімді' : 'Берілген' ?></span>
          <a class="btn btn-primary" href="book.php?id=<?= (int)$b['id'] ?>"><?= $ok ? 'Брондау' : 'Кезекке тұру' ?></a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p class="empty show">Ештеңе табылмады. Іздеу сөзін өзгертіп көріңіз немесе сүзгілерді тазалаңыз.</p>
    <?php endif; ?>
  </div>
<?php include 'includes/footer.php'; ?>
