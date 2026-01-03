<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'cart';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'book_id', 'qty'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer',
        'book_id' => 'required|integer',
        'qty'     => 'required|integer|greater_than[0]',
    ];

    protected $skipValidation = false;

    /**
     * Get cart items with book details for a user
     */
    public function getCartItems(int $userId): array
    {
        return $this->select('cart.*, books.title, books.slug, books.price, books.stock, books.cover_image, books.author')
                    ->join('books', 'books.id = cart.book_id')
                    ->where('cart.user_id', $userId)
                    ->findAll();
    }

    /**
     * Get cart total for user
     */
    public function getCartTotal(int $userId): float
    {
        $items = $this->select('cart.qty, books.price')
                      ->join('books', 'books.id = cart.book_id')
                      ->where('cart.user_id', $userId)
                      ->findAll();
        
        $total = 0;
        foreach ($items as $item) {
            $total += $item['qty'] * $item['price'];
        }
        return $total;
    }

    /**
     * Get cart count for user
     */
    public function getCartCount(int $userId): int
    {
        return (int) $this->where('user_id', $userId)->countAllResults();
    }

    /**
     * Add or update cart item
     */
    public function addToCart(int $userId, int $bookId, int $qty = 1): bool
    {
        $existing = $this->where('user_id', $userId)
                         ->where('book_id', $bookId)
                         ->first();
        
        if ($existing) {
            return $this->update($existing['id'], ['qty' => $existing['qty'] + $qty]);
        }
        
        return $this->insert([
            'user_id' => $userId,
            'book_id' => $bookId,
            'qty'     => $qty,
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function updateQty(int $cartId, int $qty): bool
    {
        if ($qty <= 0) {
            return $this->delete($cartId);
        }
        return $this->update($cartId, ['qty' => $qty]);
    }

    /**
     * Clear cart for user
     */
    public function clearCart(int $userId): bool
    {
        return $this->where('user_id', $userId)->delete();
    }

    /**
     * Remove item from cart
     */
    public function removeItem(int $userId, int $cartId): bool
    {
        return $this->where('id', $cartId)
                    ->where('user_id', $userId)
                    ->delete();
    }
}
