<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\BookModel;
use CodeIgniter\HTTP\ResponseInterface;

class CartController extends BaseController
{
    protected CartModel $cartModel;
    protected BookModel $bookModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->bookModel = new BookModel();
    }

    /**
     * Tampilkan keranjang belanja
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $cartItems = $this->cartModel->getCartItems($userId);
        $total = $this->cartModel->getCartTotal($userId);

        return view('cart/index', [
            'title'     => 'Keranjang Belanja - Toko Buku',
            'cartItems' => $cartItems,
            'total'     => $total,
        ]);
    }

    /**
     * Helper untuk return JSON response
     */
    private function jsonResponse(bool $success, string $message, array $extra = []): ResponseInterface
    {
        return $this->response->setJSON(array_merge([
            'success' => $success,
            'message' => $message,
        ], $extra));
    }

    /**
     * Tambah ke keranjang
     */
    public function add()
    {
        // Always return JSON for this endpoint
        $this->response->setContentType('application/json');
        
        try {
            $userId = session()->get('user_id');
            $bookId = $this->request->getPost('book_id');
            $qty = (int) ($this->request->getPost('qty') ?? 1);

            // Validasi buku
            $book = $this->bookModel->find($bookId);
            if (!$book) {
                return $this->jsonResponse(false, 'Buku tidak ditemukan.');
            }

            // Cek stok
            if ($book['stock'] < $qty) {
                return $this->jsonResponse(false, 'Stok tidak mencukupi.');
            }

            if ($this->cartModel->addToCart($userId, $bookId, $qty)) {
                $cartCount = $this->cartModel->getCartCount($userId);
                return $this->jsonResponse(true, 'Buku berhasil ditambahkan ke keranjang!', [
                    'cartCount' => $cartCount,
                ]);
            }

            return $this->jsonResponse(false, 'Gagal menambahkan ke keranjang.');
        } catch (\Exception $e) {
            log_message('error', 'Cart add error: ' . $e->getMessage());
            return $this->jsonResponse(false, 'Terjadi kesalahan server.');
        }
    }

    /**
     * Update jumlah item
     */
    public function update()
    {
        $this->response->setContentType('application/json');
        
        try {
            $userId = session()->get('user_id');
            $cartId = $this->request->getPost('cart_id');
            $qty = (int) $this->request->getPost('qty');

            // Validasi cart item milik user
            $cartItem = $this->cartModel->find($cartId);
            if (!$cartItem || $cartItem['user_id'] != $userId) {
                return $this->jsonResponse(false, 'Item tidak ditemukan.');
            }

            // Cek stok jika menambah qty
            $book = $this->bookModel->find($cartItem['book_id']);
            if ($qty > $book['stock']) {
                return $this->jsonResponse(false, 'Stok tidak mencukupi.');
            }

            if ($this->cartModel->updateQty($cartId, $qty)) {
                $total = $this->cartModel->getCartTotal($userId);
                $cartCount = $this->cartModel->getCartCount($userId);
                
                return $this->jsonResponse(true, 'Keranjang berhasil diupdate!', [
                    'total'     => $total,
                    'cartCount' => $cartCount,
                ]);
            }

            return $this->jsonResponse(false, 'Gagal mengupdate keranjang.');
        } catch (\Exception $e) {
            log_message('error', 'Cart update error: ' . $e->getMessage());
            return $this->jsonResponse(false, 'Terjadi kesalahan server.');
        }
    }

    /**
     * Hapus item dari keranjang
     */
    public function remove()
    {
        $this->response->setContentType('application/json');
        
        try {
            $userId = session()->get('user_id');
            $cartId = $this->request->getPost('cart_id');

            if ($this->cartModel->removeItem($userId, $cartId)) {
                $total = $this->cartModel->getCartTotal($userId);
                $cartCount = $this->cartModel->getCartCount($userId);
                
                return $this->jsonResponse(true, 'Item berhasil dihapus dari keranjang!', [
                    'total'     => $total,
                    'cartCount' => $cartCount,
                ]);
            }

            return $this->jsonResponse(false, 'Gagal menghapus item.');
        } catch (\Exception $e) {
            log_message('error', 'Cart remove error: ' . $e->getMessage());
            return $this->jsonResponse(false, 'Terjadi kesalahan server.');
        }
    }
}
