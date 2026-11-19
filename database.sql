-- 12-апта: Кітапхана жүйесінің MySQL дерекқоры
CREATE DATABASE IF NOT EXISTS library_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE library_db;

-- Пайдаланушылар кестесі (11-12 апта)
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Кітаптар кестесі (Негізгі объект - CRUD)
CREATE TABLE IF NOT EXISTS books (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(180) NOT NULL,
  cat ENUM('lit', 'hist', 'sci', 'tech') NOT NULL DEFAULT 'lit',
  avail ENUM('ok', 'out') NOT NULL DEFAULT 'ok',
  year SMALLINT UNSIGNED NOT NULL,
  pages SMALLINT UNSIGNED NOT NULL,
  cover VARCHAR(255) NOT NULL DEFAULT '1.svg',
  description TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Брондау кестесі (қосымша байланыс)
CREATE TABLE IF NOT EXISTS reservations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  book_id INT UNSIGNED NOT NULL,
  status ENUM('reserved', 'queued', 'cancelled') NOT NULL DEFAULT 'reserved',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_res_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_res_book FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Бастапқы кітаптар (8 кітап)
INSERT INTO books (id, title, author, cat, avail, year, pages, cover, description) VALUES
(1, 'Абай жолы', 'Мұхтар Әуезов', 'lit', 'ok', 1956, 1200, '1.svg', 'Қазақ әдебиетінің классикалық роман-эпопеясы. Абай Құнанбайұлының өмірі мен ХІХ ғасырдағы қазақ даласының тыныс-тіршілігі баяндалады.'),
(2, 'Қан мен тер', 'Әбдіжәміл Нұрпейісов', 'lit', 'out', 1970, 420, '2.svg', 'Арал өңірі қазақтарының тағдыры туралы «Күйреген тірлік» трилогиясының алғашқы кітабы.'),
(3, 'Көшпенділер', 'Ілияс Есенберлин', 'hist', 'ok', 1976, 780, '3.svg', 'Қазақ хандығының құрылуы мен қалыптасу кезеңін бейнелейтін тарихи романдар трилогиясы.'),
(4, 'Қазақстан тарихы', 'Ұжымдық еңбек', 'hist', 'ok', 2020, 560, '4.svg', 'Ежелгі дәуірден қазіргі кезеңге дейінгі Қазақстан тарихының оқу құралы.'),
(5, 'Физика негіздері', 'Ұжымдық еңбек', 'sci', 'out', 2018, 640, '5.svg', 'Механика, жылу және электр бөлімдерін қамтитын жоғары оқу орындарына арналған оқу құралы.'),
(6, 'Жоғары математика', 'Ұжымдық еңбек', 'sci', 'ok', 2019, 512, '6.svg', 'Сызықтық алгебра, талдау және ықтималдық теориясының негіздері.'),
(7, 'PHP және MySQL', 'Оқу құралы', 'tech', 'ok', 2022, 380, '7.svg', 'Серверлік бағдарламалау мен дерекқормен жұмыс істеуге арналған бастапқы курс.'),
(8, 'Алгоритмдер негіздері', 'Оқу құралы', 'tech', 'out', 2021, 450, '8.svg', 'Сұрыптау, іздеу және деректер құрылымдары туралы бастапқы курс.');
