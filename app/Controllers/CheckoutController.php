<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\BookModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class CheckoutController extends BaseController
{
    protected CartModel $cartModel;
    protected BookModel $bookModel;
    protected TransactionModel $transactionModel;
    protected TransactionDetailModel $detailModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->bookModel = new BookModel();
        $this->transactionModel = new TransactionModel();
        $this->detailModel = new TransactionDetailModel();
    }

    /**
     * Halaman checkout
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $cartItems = $this->cartModel->getCartItems($userId);

        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja kosong.');
        }

        $total = $this->cartModel->getCartTotal($userId);

        return view('checkout/index', [
            'title'     => 'Checkout - Toko Buku',
            'cartItems' => $cartItems,
            'total'     => $total,
        ]);
    }

    /**
     * Proses checkout
     */
    public function process()
    {
        $userId = session()->get('user_id');
        $cartItems = $this->cartModel->getCartItems($userId);

        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja kosong.');
        }

        // Validasi stok semua item
        foreach ($cartItems as $item) {
            $book = $this->bookModel->find($item['book_id']);
            if ($book['stock'] < $item['qty']) {
                return redirect()->to('/cart')->with('error', 'Stok buku "' . $item['title'] . '" tidak mencukupi.');
            }
        }

        // Hitung total
        $total = $this->cartModel->getCartTotal($userId);

        // Buat transaksi
        $transactionData = [
            'user_id'          => $userId,
            'transaction_code' => $this->transactionModel->generateCode(),
            'total_price'      => $total,
            'status'           => 'pending',
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Insert transaksi
            $this->transactionModel->insert($transactionData);
            $transactionId = $this->transactionModel->getInsertID();

            // Insert detail transaksi
            $this->detailModel->createFromCart($transactionId, $cartItems);

            // Kurangi stok
            foreach ($cartItems as $item) {
                $this->bookModel->reduceStock($item['book_id'], $item['qty']);
            }

            // Kosongkan keranjang
            $this->cartModel->clearCart($userId);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return redirect()->to('/orders/' . $transactionId)->with('success', 'Checkout berhasil! Pesanan Anda sedang diproses.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/checkout')->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }

    /**
     * Riwayat pesanan
     */
    public function history()
    {
        $userId = session()->get('user_id');
        $transactions = $this->transactionModel->getUserTransactions($userId);

        return view('checkout/history', [
            'title'        => 'Riwayat Pesanan - Toko Buku',
            'transactions' => $transactions,
        ]);
    }

    /**
     * Detail pesanan
     */
    public function detail($id)
    {
        $userId = session()->get('user_id');
        $transaction = $this->transactionModel->getTransactionWithDetails($id);

        if (!$transaction || $transaction['user_id'] != $userId) {
            // Admin/staff bisa lihat semua
            if (!in_array(session()->get('role'), ['admin', 'staff'])) {
                return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
            }
        }

        return view('checkout/detail', [
            'title'       => 'Detail Pesanan - Toko Buku',
            'transaction' => $transaction,
        ]);
    }

    /**
     * Konfirmasi pembayaran (simulasi)
     */
    public function pay($id)
    {
        $userId = session()->get('user_id');
        $transaction = $this->transactionModel->find($id);

        // Validate ownership
        if (!$transaction || $transaction['user_id'] != $userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan.'
            ]);
        }

        // Only pending transactions can be paid
        if ($transaction['status'] !== 'pending') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Transaksi ini tidak dalam status menunggu pembayaran.'
            ]);
        }

        // Update status to paid
        $this->transactionModel->update($id, ['status' => 'paid']);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Pembayaran berhasil dikonfirmasi!'
        ]);
    }
}
