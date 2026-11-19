# Кітапхана — онлайн кітапхана жүйесі

PHP және MySQL курсының жеке жобасы.

## Орындалған апталар
- [x] 8-апта: жоспарлау
- [x] 9-апта: frontend (HTML, CSS, JS)
- [x] 10-апта: PHP негіздері, `include`, `$_GET` / `$_POST`, серверлік валидация
- [x] 11-апта: MySQL, PDO, тіркелу / кіру / шығу
- [x] 12-апта: Негізгі объект (кітаптар) бойынша толық CRUD және PDO Prepared Statements

## Құрылым
```
library-app/
├── database.sql       # MySQL дерекқоры мен бастапқы кестелер
├── index.php          # басты бет
├── books.php          # каталог: іздеу және сүзу (Prepared Statements)
├── book.php           # кітап беті (?id=) және брондау
├── manage_books.php   # CRUD панелі: барлық кітаптар тізімі (Read)
├── book_create.php    # жаңа кітап қосу (Create)
├── book_edit.php      # кітап мәліметтерін өңдеу (Update)
├── book_delete.php    # кітапты жою (Delete, POST + CSRF)
├── login.php          # кіру
├── register.php       # тіркелу
├── logout.php         # шығу
├── includes/
│   ├── db.php         # PDO қосылымы (ATTR_EMULATE_PREPARES => false)
│   ├── header.php     # жалпы жоғарғы бөлік
│   ├── footer.php     # жалпы төменгі бөлік
│   ├── functions.php  # e(), post(), get(), CSRF, flash, валидация
│   └── data.php       # санаттар анықтамалығы
├── css/style.css
├── js/main.js
└── img/covers/
```

## Іске қосу
1. Қалтаны `C:\xampp\htdocs\library-app\` ішіне көшіріңіз.
2. `http://localhost/phpmyadmin` ашып, `database.sql` файлын импорттаңыз.
3. Браузерде `http://localhost/library-app/manage_books.php` ашыңыз.
