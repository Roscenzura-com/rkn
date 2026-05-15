<?php
$host = 'localhost';
$dbname = 'reestr';
$username = 'root';
$password = '';
$inputFile = 'domains.txt'; // Полный путь к файлу на сервере
$table = 'domains';
$column = 'domain';

/* Таблица для импорта */

/*
CREATE TABLE `domains` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
  `domain` varchar(88) NOT NULL,
  `pass` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domain_2` (`domain`);
*/

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "LOAD DATA INFILE '$inputFile'
			  IGNORE INTO TABLE `$table`
              FIELDS TERMINATED BY ''
              LINES TERMINATED BY '\\n'
              IGNORE 1 ROWS
              (`$column`)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

  echo "Данные успешно загружены в таблицу `$table`.";

} catch (PDOException $e) {
    echo "Ошибка загрузки данных: " . $e->getMessage();
}
