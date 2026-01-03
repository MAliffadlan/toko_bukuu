<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table            = 'books';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id', 'title', 'slug', 'author', 'publisher', 
        'year', 'price', 'stock', 'cover_image', 'pdf_file', 'description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation - minimal validation, skip di controller untuk flexibility
    protected $validationRules = [];

    // Skip validation di model, handle di controller
    protected $skipValidation = true;

    protected $validationMessages = [
        'title' => [
            'required'   => 'Judul buku wajib diisi.',
            'min_length' => 'Judul buku minimal 2 karakter.',
        ],
        'author' => [
            'required'   => 'Nama penulis wajib diisi.',
        ],
        'price' => [
            'required' => 'Harga wajib diisi.',
            'numeric'  => 'Harga harus berupa angka.',
        ],
        'stock' => [
            'required' => 'Stok wajib diisi.',
            'integer'  => 'Stok harus berupa angka bulat.',
        ],
    ];

    // Callbacks
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    /**
     * Generate slug from title
     */
    protected function generateSlug(array $data): array
    {
        if (isset($data['data']['title']) && !isset($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['title'], '-', true);
        }
        return $data;
    }

    /**
     * Get books with category
     */
    public function getBooksWithCategory(int $perPage = 12, array $filters = []): array
    {
        $builder = $this->select('books.*, categories.category_name')
                        ->join('categories', 'categories.id = books.category_id');
        
        // Apply filters
        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('books.title', $filters['search'])
                    ->orLike('books.author', $filters['search'])
                    ->orLike('books.publisher', $filters['search'])
                    ->orLike('categories.category_name', $filters['search'])
                    ->groupEnd();
        }
        
        if (!empty($filters['category_id'])) {
            $builder->where('books.category_id', $filters['category_id']);
        }
        
        return [
            'books' => $builder->orderBy('books.created_at', 'DESC')->paginate($perPage),
            'pager' => $this->pager,
        ];
    }

    /**
     * Find by slug with category
     */
    public function findBySlug(string $slug): ?array
    {
        return $this->select('books.*, categories.category_name')
                    ->join('categories', 'categories.id = books.category_id')
                    ->where('books.slug', $slug)
                    ->first();
    }

    /**
     * Get latest books
     */
    public function getLatestBooks(int $limit = 8): array
    {
        return $this->select('books.*, categories.category_name')
                    ->join('categories', 'categories.id = books.category_id')
                    ->orderBy('books.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Reduce stock after purchase
     */
    public function reduceStock(int $bookId, int $qty): bool
    {
        $book = $this->find($bookId);
        if ($book && $book['stock'] >= $qty) {
            return $this->update($bookId, ['stock' => $book['stock'] - $qty]);
        }
        return false;
    }
}
