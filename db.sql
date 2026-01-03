-- =====================================================
-- SISTEM MANAJEMEN TOKO BUKU - DATABASE SCHEMA
-- Database: db_tokobuku
-- =====================================================

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS db_tokobuku CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_tokobuku;

-- =====================================================
-- TABEL: users
-- Menyimpan data user dengan role berbeda
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'customer') NOT NULL DEFAULT 'customer',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (role),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL: categories
-- Kategori buku dengan slug untuk URL friendly
-- =====================================================
CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    category_name VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL: books
-- Katalog buku dengan relasi ke kategori
-- =====================================================
CREATE TABLE IF NOT EXISTS books (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    author VARCHAR(100) NOT NULL,
    publisher VARCHAR(100) DEFAULT NULL,
    year YEAR DEFAULT NULL,
    price DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    stock INT UNSIGNED NOT NULL DEFAULT 0,
    cover_image VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_category (category_id),
    INDEX idx_title (title),
    INDEX idx_author (author),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL: cart
-- Keranjang belanja sementara untuk customer
-- =====================================================
CREATE TABLE IF NOT EXISTS cart (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    book_id INT UNSIGNED NOT NULL,
    qty INT UNSIGNED NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_book (book_id),
    UNIQUE KEY unique_user_book (user_id, book_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL: wishlists
-- Wishlist/Favorit buku customer
-- =====================================================
CREATE TABLE IF NOT EXISTS wishlists (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    book_id INT UNSIGNED NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_book (book_id),
    UNIQUE KEY unique_user_book (user_id, book_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL: transactions
-- Rekaman transaksi/order dari customer
-- =====================================================
CREATE TABLE IF NOT EXISTS transactions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    transaction_code VARCHAR(50) NOT NULL UNIQUE,
    total_price DECIMAL(15, 2) NOT NULL DEFAULT 0.00,
    status ENUM('pending', 'paid', 'shipped', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_code (transaction_code),
    INDEX idx_status (status),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL: transaction_details
-- Detail item dalam setiap transaksi
-- =====================================================
CREATE TABLE IF NOT EXISTS transaction_details (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT UNSIGNED NOT NULL,
    book_id INT UNSIGNED NOT NULL,
    qty INT UNSIGNED NOT NULL DEFAULT 1,
    price_at_time DECIMAL(12, 2) NOT NULL,
    subtotal DECIMAL(15, 2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_transaction (transaction_id),
    INDEX idx_book (book_id),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATA AWAL: Admin user default
-- Password: admin123 (di-hash dengan password_hash PHP)
-- =====================================================
INSERT INTO users (username, email, password_hash, role) VALUES
('admin', 'admin@tokobuku.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('staff', 'staff@tokobuku.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff');

-- =====================================================
-- DATA AWAL: Kategori buku sample
-- =====================================================
INSERT INTO categories (slug, category_name) VALUES
('fiksi', 'Fiksi'),
('non-fiksi', 'Non-Fiksi'),
('teknologi', 'Teknologi & Komputer'),
('bisnis', 'Bisnis & Ekonomi'),
('pendidikan', 'Pendidikan'),
('anak-anak', 'Buku Anak-Anak');

-- =====================================================
-- DATA AWAL: Buku sample
-- =====================================================
INSERT INTO books (category_id, title, slug, author, publisher, year, price, stock, description) VALUES
(1, 'Laskar Pelangi', 'laskar-pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 85000.00, 50, 'Novel inspiratif tentang perjuangan anak-anak Belitung dalam mengejar pendidikan.'),
(1, 'Bumi Manusia', 'bumi-manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, 95000.00, 35, 'Novel sejarah yang mengisahkan kehidupan di era kolonial Belanda.'),
(2, 'Sapiens: A Brief History of Humankind', 'sapiens', 'Yuval Noah Harari', 'Harper', 2015, 150000.00, 25, 'Sejarah singkat umat manusia dari zaman prasejarah hingga modern.'),
(3, 'Clean Code', 'clean-code', 'Robert C. Martin', 'Prentice Hall', 2008, 250000.00, 20, 'Panduan menulis kode yang bersih dan mudah dipelihara.'),
(3, 'The Pragmatic Programmer', 'pragmatic-programmer', 'David Thomas & Andrew Hunt', 'Addison-Wesley', 2019, 275000.00, 15, 'Tips dan teknik untuk menjadi programmer yang lebih baik.'),
(4, 'Rich Dad Poor Dad', 'rich-dad-poor-dad', 'Robert Kiyosaki', 'Warner Books', 1997, 120000.00, 40, 'Pelajaran tentang keuangan dan investasi dari dua perspektif berbeda.'),
(5, 'Atomic Habits', 'atomic-habits', 'James Clear', 'Avery', 2018, 135000.00, 30, 'Cara membangun kebiasaan baik dan menghilangkan kebiasaan buruk.'),
(6, 'Si Kancil dan Buaya', 'si-kancil-buaya', 'Cerita Rakyat', 'Gramedia Kids', 2020, 45000.00, 60, 'Cerita klasik Indonesia untuk anak-anak.');
