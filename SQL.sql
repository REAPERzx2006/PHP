CREATE TABLE `products` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `image` VARCHAR(255),
    `stock_quantity` INT(11) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `products` (`name`, `description`, `price`, `image`, `stock_quantity`)
VALUES 
('Sample Product 1', 'This is a description for Product 1.', 19.99, 'product1.jpg', 100),
('Sample Product 2', 'This is a description for Product 2.', 29.99, 'product2.jpg', 50),
('Sample Product 3', 'This is a description for Product 3.', 39.99, 'product3.jpg', 25);
