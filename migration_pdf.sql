-- =====================================================
-- MIGRASI: Tambah kolom pdf_file ke tabel books
-- =====================================================
ALTER TABLE books ADD COLUMN pdf_file VARCHAR(255) DEFAULT NULL AFTER cover_image;

-- Update sample books dengan PDF dummy (untuk testing)
-- Catatan: Silakan upload file PDF ke folder public/uploads/pdfs/
UPDATE books SET pdf_file = 'sample-book.pdf' WHERE id > 0;
