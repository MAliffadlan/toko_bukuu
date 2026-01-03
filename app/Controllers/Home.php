<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    protected BookModel $bookModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Halaman utama - Katalog buku
     */
    public function index()
    {
        $search = $this->request->getGet('search');
        $categoryId = $this->request->getGet('category');

        $filters = [];
        if ($search) $filters['search'] = $search;
        if ($categoryId) $filters['category_id'] = $categoryId;

        $result = $this->bookModel->getBooksWithCategory(12, $filters);

        return view('home/index', [
            'title'      => 'Toko Buku Online',
            'books'      => $result['books'],
            'pager'      => $result['pager'],
            'categories' => $this->categoryModel->findAll(),
            'search'     => $search,
            'categoryId' => $categoryId,
        ]);
    }

    /**
     * Detail buku
     */
    public function detail($slug)
    {
        $book = $this->bookModel->findBySlug($slug);
        if (!$book) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Buku tidak ditemukan');
        }

        return view('home/detail', [
            'title' => $book['title'] . ' - Toko Buku',
            'book'  => $book,
        ]);
    }

    /**
     * Filter berdasarkan kategori
     */
    public function category($slug)
    {
        $category = $this->categoryModel->findBySlug($slug);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori tidak ditemukan');
        }

        $result = $this->bookModel->getBooksWithCategory(12, ['category_id' => $category['id']]);

        return view('home/index', [
            'title'           => $category['category_name'] . ' - Toko Buku',
            'books'           => $result['books'],
            'pager'           => $result['pager'],
            'categories'      => $this->categoryModel->findAll(),
            'search'          => null,
            'categoryId'      => $category['id'],
            'currentCategory' => $category,
        ]);
    }
}
