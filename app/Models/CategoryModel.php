<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['slug', 'category_name'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'category_name' => 'required|min_length[2]|max_length[100]',
        'slug'          => 'required|is_unique[categories.slug,id,{id}]',
    ];

    protected $validationMessages = [
        'category_name' => [
            'required'   => 'Nama kategori wajib diisi.',
            'min_length' => 'Nama kategori minimal 2 karakter.',
        ],
        'slug' => [
            'is_unique' => 'Slug sudah digunakan.',
        ],
    ];

    protected $skipValidation = false;

    // Callbacks
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    /**
     * Generate slug from category_name
     */
    protected function generateSlug(array $data): array
    {
        if (isset($data['data']['category_name']) && !isset($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['category_name'], '-', true);
        }
        return $data;
    }

    /**
     * Get all categories with book count
     */
    public function getCategoriesWithCount(): array
    {
        return $this->select('categories.*, COUNT(books.id) as book_count')
                    ->join('books', 'books.category_id = categories.id', 'left')
                    ->groupBy('categories.id')
                    ->findAll();
    }

    /**
     * Find by slug
     */
    public function findBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }
}
