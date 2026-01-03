<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'transaction_code', 'total_price', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id'          => 'required|integer',
        'transaction_code' => 'required|is_unique[transactions.transaction_code,id,{id}]',
        'total_price'      => 'required|numeric',
        'status'           => 'required|in_list[pending,paid,shipped,cancelled]',
    ];

    protected $skipValidation = false;

    /**
     * Generate unique transaction code
     */
    public function generateCode(): string
    {
        $date = date('Ymd');
        $random = strtoupper(bin2hex(random_bytes(3)));
        return "TRX-{$date}-{$random}";
    }

    /**
     * Get transactions with user info
     */
    public function getTransactionsWithUser(int $perPage = 20): array
    {
        return [
            'transactions' => $this->select('transactions.*, users.username, users.email')
                                   ->join('users', 'users.id = transactions.user_id')
                                   ->orderBy('transactions.created_at', 'DESC')
                                   ->paginate($perPage),
            'pager' => $this->pager,
        ];
    }

    /**
     * Get transactions for a specific user
     */
    public function getUserTransactions(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get transaction with details
     */
    public function getTransactionWithDetails(int $transactionId): ?array
    {
        $transaction = $this->select('transactions.*, users.username, users.email')
                            ->join('users', 'users.id = transactions.user_id')
                            ->find($transactionId);
        
        if (!$transaction) {
            return null;
        }

        $detailModel = new TransactionDetailModel();
        $transaction['details'] = $detailModel->getDetails($transactionId);
        
        return $transaction;
    }

    /**
     * Update transaction status
     */
    public function updateStatus(int $transactionId, string $status): bool
    {
        return $this->update($transactionId, ['status' => $status]);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStats(): array
    {
        $db = \Config\Database::connect();
        
        return [
            'total_transactions' => $this->countAll(),
            'pending_count' => $this->where('status', 'pending')->countAllResults(),
            'paid_count' => $this->where('status', 'paid')->countAllResults(),
            'shipped_count' => $this->where('status', 'shipped')->countAllResults(),
            'total_revenue' => $db->table('transactions')
                                  ->selectSum('total_price')
                                  ->where('status !=', 'cancelled')
                                  ->get()
                                  ->getRow()
                                  ->total_price ?? 0,
        ];
    }
}
