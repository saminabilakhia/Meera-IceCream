-- Meera Icecream Database
CREATE DATABASE IF NOT EXISTS meera_icecream;
USE meera_icecream;

-- Franchise requests table
CREATE TABLE franchise_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    city VARCHAR(100) NOT NULL,
    investment VARCHAR(50) NOT NULL,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin users table
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, password) VALUES 
('admin', 'admin123');


-- Contact messages table
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    category ENUM('cone', 'cup', 'family') NOT NULL,
    price DECIMAL(10,2),
    description TEXT,
    image_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO franchise_requests (name, email, phone, city, investment, message) VALUES
('Raj Patel', 'raj@example.com', '9876543210', 'Ahmedabad', '10–20 Lakhs', 'Interested in opening a franchise in Ahmedabad'),
('Priya Shah', 'priya@example.com', '9876543211', 'Vadodara', '5–10 Lakhs', 'Looking for a small investment opportunity');

INSERT INTO contact_messages (name, email, phone, subject, message) VALUES
('John Doe', 'john@example.com', '9876543212', 'General Inquiry', 'I love your ice creams! When will you open in Mumbai?'),
('Sarah Smith', 'sarah@example.com', '9876543213', 'Bulk Orders', 'Need ice cream for a wedding. Please contact me.');

INSERT INTO products (name, category, price, description, image_url) VALUES
('Chocolate Cone', 'cone', 45.00, 'Rich chocolate ice cream in crispy cone', 'https://images.unsplash.com/photo-1567206563064-6f60f40a2b57?w=300&h=200&fit=crop'),
('Strawberry Cup', 'cup', 40.00, 'Fresh strawberry ice cream in cup', 'https://images.unsplash.com/photo-1488900128323-21503983a07e?w=300&h=200&fit=crop'),
('Mixed Family Pack', 'family', 250.00, 'Assorted flavors family pack (1kg)', 'https://images.unsplash.com/photo-1559656914-a30970c1affd?w=300&h=200&fit=crop'),
('Vanilla Cone', 'cone', 40.00, 'Classic vanilla in waffle cone', 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=300&h=200&fit=crop');