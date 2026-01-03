<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Daftar semua kategori
     */
    public function index()
    {
        return view('admin/categories/index', [
            'title'      => 'Kelola Kategori - Admin',
            'categories' => $this->categoryModel->getCategoriesWithCount(),
        ]);
    }

    /**
     * Form tambah kategori
     */
    public function create()
    {
        return view('admin/categories/create', [
            'title' => 'Tambah Kategori - Admin',
        ]);
    }

    /**
     * Simpan kategori baru
     */
    public function store()
    {
        $rules = [
            'category_name' => 'required|min_length[2]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'slug'          => url_title($this->request->getPost('category_name'), '-', true),
        ];

        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil ditambahkan!');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan kategori.');
    }

    /**
     * Form edit kategori
     */
    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('admin/categories/edit', [
            'title'    => 'Edit Kategori - Admin',
            'category' => $category,
        ]);
    }

    /**
     * Update kategori
     */
    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan.');
        }

        $rules = [
            'category_name' => 'required|min_length[2]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'slug'          => url_title($this->request->getPost('category_name'), '-', true),
        ];

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diupdate!');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengupdate kategori.');
    }

    /**
     * Hapus kategori (hanya admin)
     */
    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan.');
        }

        try {
            if ($this->categoryModel->delete($id)) {
                return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus!');
            }
        } catch (\Exception $e) {
            return redirect()->to('/admin/categories')->with('error', 'Tidak dapat menghapus kategori yang masih memiliki buku.');
        }

        return redirect()->to('/admin/categories')->with('error', 'Gagal menghapus kategori.');
    }
}
