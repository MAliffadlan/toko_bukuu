<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class LibraryController extends BaseController
{
    protected BookModel $bookModel;
    protected TransactionModel $transactionModel;
    protected TransactionDetailModel $detailModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->transactionModel = new TransactionModel();
        $this->detailModel = new TransactionDetailModel();
    }

    /**
     * Halaman Buku Saya (E-Library)
     */
    public function index()
    {
        $userId = session()->get('user_id');
        
        // Get all books purchased by this user (from paid transactions)
        $purchasedBooks = $this->getPurchasedBooks($userId);

        return view('library/index', [
            'title' => 'Buku Saya - Toko Buku',
            'books' => $purchasedBooks,
        ]);
    }

    /**
     * Get all purchased books for a user
     */
    private function getPurchasedBooks($userId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('transaction_details td')
            ->select('b.*, c.category_name, td.price_at_time as purchase_price, t.created_at as purchase_date, t.transaction_code')
            ->join('transactions t', 't.id = td.transaction_id')
            ->join('books b', 'b.id = td.book_id')
            ->join('categories c', 'c.id = b.category_id')
            ->where('t.user_id', $userId)
            ->whereIn('t.status', ['paid', 'shipped'])
            ->groupBy('b.id')
            ->orderBy('t.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Check if user has purchased a book
     */
    private function hasPurchased($userId, $bookId)
    {
        $db = \Config\Database::connect();
        
        $result = $db->table('transaction_details td')
            ->join('transactions t', 't.id = td.transaction_id')
            ->where('t.user_id', $userId)
            ->where('td.book_id', $bookId)
            ->whereIn('t.status', ['paid', 'shipped'])
            ->countAllResults();
        
        return $result > 0;
    }

    /**
     * View/Read PDF book
     */
    public function read($bookId)
    {
        $userId = session()->get('user_id');
        $book = $this->bookModel->find($bookId);

        if (!$book) {
            return redirect()->to('/library')->with('error', 'Buku tidak ditemukan.');
        }

        // Check if user has purchased this book
        if (!$this->hasPurchased($userId, $bookId)) {
            return redirect()->to('/library')->with('error', 'Anda belum membeli buku ini.');
        }

        // Check if PDF exists
        if (!$book['pdf_file'] || !file_exists(FCPATH . 'uploads/pdfs/' . $book['pdf_file'])) {
            return redirect()->to('/library')->with('error', 'File PDF tidak tersedia untuk buku ini.');
        }

        return view('library/reader', [
            'title' => 'Baca: ' . $book['title'],
            'book' => $book,
        ]);
    }

    /**
     * Download PDF book
     */
    public function download($bookId)
    {
        $userId = session()->get('user_id');
        $book = $this->bookModel->find($bookId);

        if (!$book) {
            return redirect()->to('/library')->with('error', 'Buku tidak ditemukan.');
        }

        // Check if user has purchased this book
        if (!$this->hasPurchased($userId, $bookId)) {
            return redirect()->to('/library')->with('error', 'Anda belum membeli buku ini.');
        }

        $filePath = FCPATH . 'uploads/pdfs/' . $book['pdf_file'];
        
        if (!file_exists($filePath)) {
            return redirect()->to('/library')->with('error', 'File PDF tidak tersedia.');
        }

        // Force download
        return $this->response->download($filePath, null)->setFileName($book['slug'] . '.pdf');
    }
}
