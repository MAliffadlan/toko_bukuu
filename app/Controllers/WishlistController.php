<?php

namespace App\Controllers;

use App\Models\WishlistModel;
use App\Models\BookModel;

class WishlistController extends BaseController
{
    protected WishlistModel $wishlistModel;
    protected BookModel $bookModel;

    public function __construct()
    {
        $this->wishlistModel = new WishlistModel();
        $this->bookModel = new BookModel();
    }

    /**
     * Display user's wishlist
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $wishlist = $this->wishlistModel->getUserWishlist($userId);

        return view('wishlist/index', [
            'title' => 'Wishlist Saya - TokoBuku',
            'items' => $wishlist['items'],
            'total' => $wishlist['total'],
        ]);
    }

    /**
     * Toggle wishlist (AJAX)
     */
    public function toggle($bookId)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $userId = session()->get('user_id');
        
        // Validate book exists
        $book = $this->bookModel->find($bookId);
        if (!$book) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Buku tidak ditemukan.'
            ]);
        }

        $result = $this->wishlistModel->toggleWishlist($userId, $bookId);
        $count = $this->wishlistModel->getWishlistCount($userId);

        return $this->response->setJSON([
            'success' => true,
            'action' => $result['action'],
            'in_wishlist' => $result['in_wishlist'],
            'count' => $count,
            'message' => $result['action'] === 'added' 
                ? 'Buku ditambahkan ke wishlist!' 
                : 'Buku dihapus dari wishlist.'
        ]);
    }

    /**
     * Add to wishlist (AJAX)
     */
    public function add($bookId)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $userId = session()->get('user_id');
        
        $book = $this->bookModel->find($bookId);
        if (!$book) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Buku tidak ditemukan.'
            ]);
        }

        if ($this->wishlistModel->isInWishlist($userId, $bookId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Buku sudah ada di wishlist.',
                'in_wishlist' => true
            ]);
        }

        $this->wishlistModel->addToWishlist($userId, $bookId);
        $count = $this->wishlistModel->getWishlistCount($userId);

        return $this->response->setJSON([
            'success' => true,
            'count' => $count,
            'message' => 'Buku ditambahkan ke wishlist!'
        ]);
    }

    /**
     * Remove from wishlist (AJAX)
     */
    public function remove($bookId)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $userId = session()->get('user_id');
        
        $this->wishlistModel->removeFromWishlist($userId, $bookId);
        $count = $this->wishlistModel->getWishlistCount($userId);

        return $this->response->setJSON([
            'success' => true,
            'count' => $count,
            'message' => 'Buku dihapus dari wishlist.'
        ]);
    }

    /**
     * Check if book is in wishlist (AJAX)
     */
    public function check($bookId)
    {
        $userId = session()->get('user_id');
        $inWishlist = $this->wishlistModel->isInWishlist($userId, $bookId);

        return $this->response->setJSON([
            'in_wishlist' => $inWishlist
        ]);
    }
}
