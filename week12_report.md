# 12-апта есебі: CRUD операциялары және SQL инъекциясынан қорғау

**Жоба:** Кітапхана (онлайн кітапхана жүйесі)

## Орындалған жұмыс
- **MySQL дерекқоры (`database.sql`):** `library_db` базасы, `books`, `users` және `reservations` кестелері құрылып, бастапқы 8 кітап енгізілді.
- **PDO қосылымы (`includes/db.php`):** `PDO::ATTR_EMULATE_PREPARES => false` параметрімен нақты дайындалған сұраныстар (Prepared Statements) күйге келтірілді.
- **Create (`book_create.php`):** Жаңа кітап қосу формасы, серверлік валидация және `INSERT INTO books ...` дайындалған сұранысы.
- **Read (`manage_books.php`, `books.php`, `book.php`):** Барлық кітаптарды кесте/каталог түрінде шығару, іздеу және санат бойынша сүзу (`SELECT ... WHERE ...` prepared statements).
- **Update (`book_edit.php`):** Таңдалған кітапты ID бойынша жүктеп, өзгерістерді `UPDATE books SET ... WHERE id = :id` сұранысымен жаңарту.
- **Delete (`book_delete.php`):** Тек `POST` сұранысы және CSRF токен тексерісі арқылы `DELETE FROM books WHERE id = :id` орындау.
- **Қауіпсіздік:** Барлық SQL сұраныстарда параметрленген placeholders (`:title`, `:id`, т.б.) қолданылды, шығатын деректер `e()` (`htmlspecialchars`) арқылы экрандалады, формалар CSRF токенмен қорғалған.
