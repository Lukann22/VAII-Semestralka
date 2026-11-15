INSERT INTO `products` (`name`, `type`, `description`, `price`, `inStock`)
VALUES ('Darjeeling First Flush', 'black', 'Delicate floral aroma with muscatel notes', 14.90, 1),
       ('Sencha Uji', 'green', 'Fresh, grassy taste with a sweet finish', 12.50, 1),
       ('Bai Mu Dan', 'white', 'Light and honeyed with gentle fruity notes', 16.40, 1),
       ('Rooibos Vanilla', 'herbal', 'Caffeine-free, creamy and naturally sweet', 8.90, 1),
       ('Gyokuro Asahi', 'green', 'Shade-grown tea with a rich umami character', 24.90, 0),
       ('Assam Breakfast', 'black', 'Malty and bold, perfect with a splash of milk', 9.80, 1),
       ('Chamomile Blossom', 'herbal', 'Calming whole flowers with a soft apple note', 7.50, 1),
       ('Silver Needle', 'white', 'Rare buds with a clean, sweet and silky cup', 29.00, 1);

INSERT INTO `categories` (`name`, `description`)
VALUES ('Bestsellers', 'Our customers'' favourite teas'),
       ('Caffeine-free', 'Teas you can enjoy in the evening'),
       ('Gift ideas', 'Special teas that make a great present'),
       ('Japanese teas', 'Teas grown and processed in Japan'),
       ('Morning boost', 'Strong teas for a good start of the day');

-- products: 1 Darjeeling, 2 Sencha, 3 Bai Mu Dan, 4 Rooibos, 5 Gyokuro, 6 Assam, 7 Chamomile, 8 Silver Needle
-- categories: 1 Bestsellers, 2 Caffeine-free, 3 Gift ideas, 4 Japanese teas, 5 Morning boost
INSERT INTO `product_categories` (`productId`, `categoryId`)
VALUES (1, 1), (2, 1), (6, 1),
       (4, 2), (7, 2),
       (5, 3), (8, 3), (1, 3),
       (2, 4), (5, 4),
       (6, 5), (1, 5);