<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;

class BookController extends BaseController
{
    protected BookModel $bookModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Daftar semua buku
     */
    public function index()
    {
        $search = $this->request->getGet('search');
        $categoryId = $this->request->getGet('category');

        $filters = [];
        if ($search) $filters['search'] = $search;
        if ($categoryId) $filters['category_id'] = $categoryId;

        $result = $this->bookModel->getBooksWithCategory(10, $filters);

        return view('admin/books/index', [
            'title'      => 'Kelola Buku - Admin',
            'books'      => $result['books'],
            'pager'      => $result['pager'],
            'categories' => $this->categoryModel->findAll(),
            'search'     => $search,
            'categoryId' => $categoryId,
        ]);
    }

    /**
     * Form tambah buku
     */
    public function create()
    {
        return view('admin/books/create', [
            'title'      => 'Tambah Buku - Admin',
            'categories' => $this->categoryModel->findAll(),
        ]);
    }

    /**
     * Simpan buku baru
     */
    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[2]|max_length[255]',
            'category_id' => 'required|integer',
            'author'      => 'required|min_length[2]|max_length[100]',
            'price'       => 'required|numeric|greater_than_equal_to[0]',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'cover_image' => 'permit_empty|max_size[cover_image,2048]|is_image[cover_image]',
            'pdf_file'    => 'permit_empty|max_size[pdf_file,51200]|ext_in[pdf_file,pdf]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'slug'        => url_title($this->request->getPost('title'), '-', true),
            'category_id' => $this->request->getPost('category_id'),
            'author'      => $this->request->getPost('author'),
            'publisher'   => $this->request->getPost('publisher'),
            'year'        => $this->request->getPost('year'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
        ];

        // Handle upload gambar
        $coverImage = $this->request->getFile('cover_image');
        if ($coverImage && $coverImage->isValid() && !$coverImage->hasMoved()) {
            $newName = $coverImage->getRandomName();
            $coverImage->move(FCPATH . 'uploads/covers', $newName);
            $data['cover_image'] = $newName;
        }

        // Handle upload PDF
        $pdfFile = $this->request->getFile('pdf_file');
        if ($pdfFile && $pdfFile->isValid() && !$pdfFile->hasMoved()) {
            $pdfName = $pdfFile->getRandomName();
            $pdfFile->move(FCPATH . 'uploads/pdfs', $pdfName);
            $data['pdf_file'] = $pdfName;
        }

        if ($this->bookModel->insert($data)) {
            return redirect()->to('/admin/books')->with('success', 'Buku berhasil ditambahkan!');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan buku.');
    }

    /**
     * Form edit buku
     */
    public function edit($id)
    {
        $book = $this->bookModel->find($id);
        if (!$book) {
            return redirect()->to('/admin/books')->with('error', 'Buku tidak ditemukan.');
        }

        return view('admin/books/edit', [
            'title'      => 'Edit Buku - Admin',
            'book'       => $book,
            'categories' => $this->categoryModel->findAll(),
        ]);
    }

    /**
     * Update buku
     */
    public function update($id)
    {
        $book = $this->bookModel->find($id);
        if (!$book) {
            return redirect()->to('/admin/books')->with('error', 'Buku tidak ditemukan.');
        }

        $rules = [
            'title'       => 'required|min_length[2]|max_length[255]',
            'category_id' => 'required|integer',
            'author'      => 'required|min_length[2]|max_length[100]',
            'price'       => 'required|numeric|greater_than_equal_to[0]',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'cover_image' => 'permit_empty|max_size[cover_image,2048]|is_image[cover_image]',
            'pdf_file'    => 'permit_empty|max_size[pdf_file,51200]|ext_in[pdf_file,pdf]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'slug'        => url_title($this->request->getPost('title'), '-', true),
            'category_id' => $this->request->getPost('category_id'),
            'author'      => $this->request->getPost('author'),
            'publisher'   => $this->request->getPost('publisher'),
            'year'        => $this->request->getPost('year'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
        ];

        // Handle upload gambar baru
        $coverImage = $this->request->getFile('cover_image');
        if ($coverImage && $coverImage->isValid() && !$coverImage->hasMoved()) {
            // Hapus gambar lama
            if ($book['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])) {
                unlink(FCPATH . 'uploads/covers/' . $book['cover_image']);
            }
            $newName = $coverImage->getRandomName();
            $coverImage->move(FCPATH . 'uploads/covers', $newName);
            $data['cover_image'] = $newName;
        }

        // Handle upload PDF baru
        $pdfFile = $this->request->getFile('pdf_file');
        if ($pdfFile && $pdfFile->isValid() && !$pdfFile->hasMoved()) {
            // Hapus PDF lama
            if (!empty($book['pdf_file']) && file_exists(FCPATH . 'uploads/pdfs/' . $book['pdf_file'])) {
                unlink(FCPATH . 'uploads/pdfs/' . $book['pdf_file']);
            }
            $pdfName = $pdfFile->getRandomName();
            $pdfFile->move(FCPATH . 'uploads/pdfs', $pdfName);
            $data['pdf_file'] = $pdfName;
        }

        if ($this->bookModel->update($id, $data)) {
            return redirect()->to('/admin/books')->with('success', 'Buku berhasil diupdate!');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengupdate buku.');
    }

    /**
     * Hapus buku (hanya admin)
     */
    public function delete($id)
    {
        $book = $this->bookModel->find($id);
        if (!$book) {
            return redirect()->to('/admin/books')->with('error', 'Buku tidak ditemukan.');
        }

        // Hapus gambar
        if ($book['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])) {
            unlink(FCPATH . 'uploads/covers/' . $book['cover_image']);
        }

        if ($this->bookModel->delete($id)) {
            return redirect()->to('/admin/books')->with('success', 'Buku berhasil dihapus!');
        }

        return redirect()->to('/admin/books')->with('error', 'Gagal menghapus buku.');
    }
}
