<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\TransactionModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $bookModel = new BookModel();
        $categoryModel = new CategoryModel();
        $transactionModel = new TransactionModel();
        $userModel = new UserModel();

        $stats = $transactionModel->getStats();
        
        // Get user counts by role
        $db = \Config\Database::connect();
        $adminCount = $db->table('users')->where('role', 'admin')->countAllResults();
        $staffCount = $db->table('users')->where('role', 'staff')->countAllResults();
        $customerCount = $db->table('users')->where('role', 'customer')->countAllResults();
        
        // Get monthly stats
        $currentMonth = date('Y-m');
        $monthlyTransactions = $db->table('transactions')
            ->where("DATE_FORMAT(created_at, '%Y-%m') =", $currentMonth)
            ->whereIn('status', ['paid', 'shipped'])
            ->countAllResults();
        $monthlyRevenue = $db->table('transactions')
            ->selectSum('total_price')
            ->where("DATE_FORMAT(created_at, '%Y-%m') =", $currentMonth)
            ->whereIn('status', ['paid', 'shipped'])
            ->get()->getRow()->total_price ?? 0;
        
        // Get low stock count
        $lowStockCount = $db->table('books')->where('stock <=', 5)->countAllResults();

        $data = [
            'title'               => 'Dashboard - Admin Toko Buku',
            'total_books'         => $bookModel->countAll(),
            'total_categories'    => $categoryModel->countAll(),
            'total_users'         => $userModel->countAll(),
            'total_transactions'  => $stats['total_transactions'],
            'pending_orders'      => $stats['pending_count'],
            'total_revenue'       => $stats['total_revenue'],
            'latest_books'        => $bookModel->getLatestBooks(5),
            // Admin only stats
            'admin_count'         => $adminCount,
            'staff_count'         => $staffCount,
            'customer_count'      => $customerCount,
            'monthly_transactions' => $monthlyTransactions,
            'monthly_revenue'     => $monthlyRevenue,
            'low_stock_count'     => $lowStockCount,
        ];

        return view('admin/dashboard', $data);
    }
}
