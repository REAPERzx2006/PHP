-- Insert sample orders
INSERT INTO orders (user_id, product_id, quantity, total_price, order_date, status) VALUES
(1, 1, 2, 39.98, '2024-09-01 10:00:00', 'Pending'),
(2, 2, 1, 1, 29.99, '2024-09-02 11:00:00', 'Shipped'),
(3, 3, 3, 3, 119.97, '2024-09-03 12:00:00', 'Delivered'),
(4, 4, 1, 1, 19.99, '2024-09-04 13:00:00', 'Cancelled'),
(5, 5, 2, 2, 59.98, '2024-09-05 14:00:00', 'Pending');
