<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    protected $table            = 'transaction_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['transaction_id', 'book_id', 'qty', 'price_at_time', 'subtotal'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    // Validation
    protected $validationRules = [
        'transaction_id' => 'required|integer',
        'book_id'        => 'required|integer',
        'qty'            => 'required|integer|greater_than[0]',
        'price_at_time'  => 'required|numeric',
        'subtotal'       => 'required|numeric',
    ];

    protected $skipValidation = false;

    /**
     * Get details for a transaction
     */
    public function getDetails(int $transactionId): array
    {
        return $this->select('transaction_details.*, books.title, books.slug, books.author, books.cover_image')
                    ->join('books', 'books.id = transaction_details.book_id')
                    ->where('transaction_details.transaction_id', $transactionId)
                    ->findAll();
    }

    /**
     * Create details from cart items
     */
    public function createFromCart(int $transactionId, array $cartItems): bool
    {
        $details = [];
        foreach ($cartItems as $item) {
            $subtotal = $item['qty'] * $item['price'];
            $details[] = [
                'transaction_id' => $transactionId,
                'book_id'        => $item['book_id'],
                'qty'            => $item['qty'],
                'price_at_time'  => $item['price'],
                'subtotal'       => $subtotal,
            ];
        }
        
        return $this->insertBatch($details);
    }
}
