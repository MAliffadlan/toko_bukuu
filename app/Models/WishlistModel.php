<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table            = 'wishlists';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'book_id'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    /**
     * Get wishlist count for a user
     */
    public function getWishlistCount(int $userId): int
    {
        return $this->where('user_id', $userId)->countAllResults();
    }

    /**
     * Check if a book is in user's wishlist
     */
    public function isInWishlist(int $userId, int $bookId): bool
    {
        return $this->where('user_id', $userId)
                    ->where('book_id', $bookId)
                    ->countAllResults() > 0;
    }

    /**
     * Add book to wishlist
     */
    public function addToWishlist(int $userId, int $bookId): bool
    {
        if ($this->isInWishlist($userId, $bookId)) {
            return false;
        }

        return $this->insert([
            'user_id' => $userId,
            'book_id' => $bookId,
        ]);
    }

    /**
     * Remove book from wishlist
     */
    public function removeFromWishlist(int $userId, int $bookId): bool
    {
        return $this->where('user_id', $userId)
                    ->where('book_id', $bookId)
                    ->delete();
    }

    /**
     * Toggle wishlist (add if not exists, remove if exists)
     */
    public function toggleWishlist(int $userId, int $bookId): array
    {
        if ($this->isInWishlist($userId, $bookId)) {
            $this->removeFromWishlist($userId, $bookId);
            return ['action' => 'removed', 'in_wishlist' => false];
        } else {
            $this->addToWishlist($userId, $bookId);
            return ['action' => 'added', 'in_wishlist' => true];
        }
    }

    /**
     * Get user's wishlist with book details
     */
    public function getUserWishlist(int $userId, int $perPage = 12)
    {
        $builder = $this->db->table('wishlists w')
            ->select('w.id as wishlist_id, w.created_at as added_at, b.*, c.category_name')
            ->join('books b', 'b.id = w.book_id')
            ->join('categories c', 'c.id = b.category_id')
            ->where('w.user_id', $userId)
            ->orderBy('w.created_at', 'DESC');

        return [
            'items' => $builder->get()->getResultArray(),
            'total' => $this->where('user_id', $userId)->countAllResults(),
        ];
    }
}
