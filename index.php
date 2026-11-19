<?php
$pageTitle = 'Кітапхана — онлайн кітапхана жүйесі';
$current = 'home';
include 'includes/header.php';
?>
  <section class="hero">
    <div class="container">
      <div class="hero-text">
        <h1>Кітапты іздеңіз, брондаңыз, кітапханада алыңыз</h1>
        <p>Университет кітапханасының қорын үйден қараңыз: қай кітап қолжетімді екенін көріп, оқырман билетінсіз-ақ брондап қойыңыз.</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="books.php">Каталогты ашу</a>
          <a class="btn btn-ghost" href="register.php">Оқырман болу</a>
        </div>
      </div>
      <div class="shelf" aria-hidden="true">
        <span class="spine s1">Абай жолы</span><span class="spine s2">Көшпенділер</span><span class="spine s3">Қан мен тер</span>
        <span class="spine s4 tilt">Қазақстан тарихы</span><span class="spine s5">Физика негіздері</span><span class="spine s6">PHP және MySQL</span>
        <span class="spine s7">Алгоритмдер</span><span class="spine s8">Дерекқорлар</span>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-head"><h2>Жүйе не істей алады</h2></div>
      <div class="facts">
        <div class="fact"><h3>Іздеу және сүзу</h3><p>Атауы немесе авторы бойынша іздеңіз, санатты және қолжетімділікті таңдаңыз.</p></div>
        <div class="fact"><h3>Онлайн брондау</h3><p>Кітапты 3 күнге бронь жасап қойыңыз — кітапханашы дайындап қояды.</p></div>
        <div class="fact"><h3>Жеке кабинет</h3><p>Қолыңыздағы кітаптар мен қайтару мерзімін бір жерден қараңыз.</p></div>
      </div>
    </div>
  </section>

  <section class="section alt">
    <div class="container">
      <div class="section-head"><h2>Кітап алу үш қадамда</h2></div>
      <ol class="steps">
        <li><h3>Тіркеліңіз</h3><p>Аты-жөніңізді, поштаңызды көрсетіп, есептік жазба ашыңыз.</p></li>
        <li><h3>Кітап таңдаңыз</h3><p>Каталогтан керек кітапты тауып, «Брондау» батырмасын басыңыз.</p></li>
        <li><h3>Кітапханада алыңыз</h3><p>Бронь мерзімі аяқталмай тұрып келіп, кітабыңызды алыңыз.</p></li>
      </ol>
    </div>
  </section>
<?php include 'includes/footer.php'; ?>
