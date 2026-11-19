# Кітапхана — онлайн кітапхана жүйесі

PHP және MySQL курсының жеке жобасы.

## Орындалған апталар
- [x] 8-апта: жоспарлау
- [x] 9-апта: frontend (HTML, CSS, JS)
- [x] 10-апта: PHP негіздері, `include`, `$_GET` / `$_POST`, серверлік валидация
- [ ] 11-апта: MySQL, PDO, тіркелу / кіру / шығу

## Құрылым
```
library-app/
├── index.php        # басты бет
├── books.php        # каталог: іздеу және сүзу ($_GET)
├── book.php         # кітап беті (?id=) және брондау формасы ($_POST)
├── login.php        # кіру формасы ($_POST, валидация)
├── register.php     # тіркелу формасы ($_POST, валидация)
├── includes/
│   ├── header.php   # жалпы жоғарғы бөлік
│   ├── footer.php   # жалпы төменгі бөлік
│   ├── functions.php# e(), post(), get() және т.б.
│   └── data.php     # уақытша деректер (11-12 аптада MySQL)
├── css/style.css
├── js/main.js       # мәзір, құпиясөзді көрсету, клиент валидациясы
└── img/covers/      # мұқабалар
```

## Іске қосу
- XAMPP: қалтаны `C:\xampp\htdocs\` ішіне көшіріп, `http://localhost/library-app/` ашыңыз.
- Немесе қалта ішінде: `php -S localhost:8000`
