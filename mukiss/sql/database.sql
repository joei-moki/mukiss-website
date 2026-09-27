-- =====================================================
-- MUKISS - Database Schema
-- School Project Prototype (Fictional Brand)
-- =====================================================

CREATE DATABASE IF NOT EXISTS mukiss_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE mukiss_db;

-- =====================================================
-- TABLE: users
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABLE: products
-- =====================================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    flavor_profile VARCHAR(150),
    design VARCHAR(150),
    finish VARCHAR(100),
    image VARCHAR(255) DEFAULT 'placeholder.jpg',
    status ENUM('active', 'draft', 'archived') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABLE: flavors
-- =====================================================
CREATE TABLE IF NOT EXISTS flavors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    profile VARCHAR(100) NOT NULL,
    description TEXT,
    category ENUM('FRUITY', 'SWEET', 'COOL', 'TROPICAL') NOT NULL,
    image VARCHAR(255) DEFAULT 'placeholder.jpg',
    status ENUM('active', 'draft', 'archived') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABLE: inventory
-- =====================================================
CREATE TABLE IF NOT EXISTS inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    status ENUM('In Stock', 'Low Stock', 'Out of Stock') NOT NULL DEFAULT 'In Stock',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABLE: inquiries
-- =====================================================
CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('New', 'Read', 'Resolved') NOT NULL DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABLE: verification_codes
-- =====================================================
CREATE TABLE IF NOT EXISTS verification_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    code VARCHAR(10) NOT NULL,
    expires_at DATETIME NOT NULL,
    verified TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- SAMPLE / DEMO DATA (fictional only)
-- =====================================================

-- Demo admin account: email admin@mukiss.test / password: Admin123!
-- Demo customer account: email demo@mukiss.test / password: Demo123!
-- Password hashes below are generated with PHP password_hash() (bcrypt).
INSERT INTO users (name, email, password, role, is_verified) VALUES
('MUKISS Admin', 'admin@mukiss.test', '$2b$12$ppYFdgnHJ.6Z9EXEJDCr6.eu.BwgOIUjpmWUw8vWr6f8ayZxxdIF6', 'admin', 1),
('Demo Customer', 'demo@mukiss.test', '$2b$12$ppYFdgnHJ.6Z9EXEJDCr6.YhMKNRFKifQObipmnbYlAOMppD.uAZu', 'customer', 1);

INSERT INTO products (name, category, description, flavor_profile, design, finish, image, status) VALUES
('Mango Ice', 'Signature Line', 'A crisp, chilled mango profile balanced with a cool exhale.', 'Mango / Menthol', 'Slim Barrel', 'Matte', 'mango-ice.jpg', 'active'),
('Blue Razz', 'Signature Line', 'A bold blue raspberry profile with a tangy, sweet finish.', 'Blue Raspberry', 'Slim Barrel', 'Gloss', 'blue-razz.jpg', 'active'),
('Strawberry Lush', 'Signature Line', 'A soft, rounded strawberry profile with a smooth character.', 'Strawberry / Cream', 'Curved Barrel', 'Matte', 'strawberry-lush.jpg', 'active'),
('Pineapple Coco', 'Tropical Line', 'A tropical pineapple and coconut pairing, bright and rounded.', 'Pineapple / Coconut', 'Curved Barrel', 'Satin', 'pineapple-coco.jpg', 'active');

INSERT INTO flavors (name, profile, description, category, image, status) VALUES
('Mango Ice', 'Mango / Menthol', 'A crisp, chilled mango profile balanced with a cool exhale.', 'COOL', 'mango-ice.jpg', 'active'),
('Blue Razz', 'Blue Raspberry', 'A bold blue raspberry profile with a tangy, sweet finish.', 'SWEET', 'blue-razz.jpg', 'active'),
('Strawberry Lush', 'Strawberry / Cream', 'A soft, rounded strawberry profile with a smooth character.', 'SWEET', 'strawberry-lush.jpg', 'active'),
('Pineapple Coco', 'Pineapple / Coconut', 'A tropical pineapple and coconut pairing, bright and rounded.', 'TROPICAL', 'pineapple-coco.jpg', 'active'),
('Mango Berry', 'Mango / Mixed Berry', 'A layered mango and berry profile with a juicy character.', 'FRUITY', 'mango-berry.jpg', 'active'),
('Watermelon Chill', 'Watermelon / Menthol', 'A refreshing watermelon profile with a light cooling finish.', 'COOL', 'watermelon-chill.jpg', 'active');

INSERT INTO inventory (product_id, quantity, status) VALUES
(1, 42, 'In Stock'),
(2, 8, 'Low Stock'),
(3, 0, 'Out of Stock'),
(4, 25, 'In Stock');

INSERT INTO inquiries (name, email, subject, message, status) VALUES
('Jamie Cruz', 'jamie@example.test', 'Question about flavor lineup', 'Hi, will Watermelon Chill be added to the signature line?', 'New'),
('Alex Rivera', 'alex@example.test', 'Website feedback', 'The specifications page looks great, nice project!', 'Read');
