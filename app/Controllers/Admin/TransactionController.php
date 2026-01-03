<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

class TransactionController extends BaseController
{
    protected TransactionModel $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    /**
     * Daftar semua transaksi
     */
    public function index()
    {
        $result = $this->transactionModel->getTransactionsWithUser(20);

        return view('admin/transactions/index', [
            'title'        => 'Kelola Transaksi - Admin',
            'transactions' => $result['transactions'],
            'pager'        => $result['pager'],
        ]);
    }

    /**
     * Detail transaksi
     */
    public function detail($id)
    {
        $transaction = $this->transactionModel->getTransactionWithDetails($id);
        if (!$transaction) {
            return redirect()->to('/admin/transactions')->with('error', 'Transaksi tidak ditemukan.');
        }

        return view('admin/transactions/detail', [
            'title'       => 'Detail Transaksi - Admin',
            'transaction' => $transaction,
        ]);
    }

    /**
     * Update status transaksi
     */
    public function updateStatus($id)
    {
        $transaction = $this->transactionModel->find($id);
        if (!$transaction) {
            return redirect()->to('/admin/transactions')->with('error', 'Transaksi tidak ditemukan.');
        }

        $status = $this->request->getPost('status');
        $allowedStatus = ['pending', 'paid', 'shipped', 'cancelled'];

        if (!in_array($status, $allowedStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        if ($this->transactionModel->updateStatus($id, $status)) {
            return redirect()->back()->with('success', 'Status transaksi berhasil diupdate!');
        }

        return redirect()->back()->with('error', 'Gagal mengupdate status transaksi.');
    }
}
