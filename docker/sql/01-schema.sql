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

CREATE TABLE `categories`
(
    `id`          INT AUTO_INCREMENT PRIMARY KEY,
    `name`        VARCHAR(50)  NOT NULL UNIQUE,
    `description` VARCHAR(255) NOT NULL DEFAULT ''
) DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- M:N relationship products <-> categories (junction table)
CREATE TABLE `product_categories`
(
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `productId`  INT NOT NULL,
    `categoryId` INT NOT NULL,
    UNIQUE KEY `uq_product_category` (`productId`, `categoryId`),
    CONSTRAINT `fk_pc_product` FOREIGN KEY (`productId`) REFERENCES `products` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pc_category` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;