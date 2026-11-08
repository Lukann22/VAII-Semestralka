CREATE TABLE `products`
(
    `id`          INT AUTO_INCREMENT PRIMARY KEY,
    `name`        VARCHAR(100)  NOT NULL,
    `type`        VARCHAR(20)   NOT NULL,
    `description` VARCHAR(255)  NOT NULL DEFAULT '',
    `price`       DECIMAL(8, 2) NOT NULL,
    `inStock`     TINYINT(1)    NOT NULL DEFAULT 1
) DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;