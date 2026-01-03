<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-primary-500 via-primary-600 to-accent-600 rounded-3xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white rounded-full"></div>
    </div>
    <div class="relative z-10">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang, <?= esc(session()->get('username')) ?>! 👋</h1>
        <p class="text-white/80">
            <?php if (session()->get('role') === 'admin'): ?>
            Anda login sebagai <span class="font-semibold text-yellow-300">Administrator</span> dengan akses penuh ke semua fitur.
            <?php else: ?>
            Anda login sebagai <span class="font-semibold">Staff</span>. Untuk menghapus data, hubungi Administrator.
            <?php endif; ?>
        </p>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Buku -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-primary-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm">Total Buku</p>
                <p class="text-3xl font-bold text-slate-800"><?= number_format($total_books) ?></p>
            </div>
            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Total Kategori -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm">Total Kategori</p>
                <p class="text-3xl font-bold text-slate-800"><?= number_format($total_categories) ?></p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Pending Orders -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm">Pesanan Pending</p>
                <p class="text-3xl font-bold text-slate-800"><?= number_format($pending_orders) ?></p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Total Revenue -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm">Total Pendapatan</p>
                <p class="text-2xl font-bold text-slate-800">Rp <?= number_format($total_revenue, 0, ',', '.') ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<?php if (session()->get('role') === 'admin'): ?>
<!-- Admin Only: Extra Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <p class="text-white/80">Total Users</p>
            <svg class="w-8 h-8 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </div>
        <p class="text-4xl font-bold"><?= number_format($total_users ?? 0) ?></p>
        <p class="text-sm text-white/60 mt-2">Admin: <?= $admin_count ?? 0 ?> | Staff: <?= $staff_count ?? 0 ?> | Customer: <?= $customer_count ?? 0 ?></p>
    </div>
    
    <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <p class="text-white/80">Transaksi Bulan Ini</p>
            <svg class="w-8 h-8 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <p class="text-4xl font-bold"><?= number_format($monthly_transactions ?? 0) ?></p>
        <p class="text-sm text-white/60 mt-2">Pendapatan: Rp <?= number_format($monthly_revenue ?? 0, 0, ',', '.') ?></p>
    </div>
    
    <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <p class="text-white/80">Stok Menipis</p>
            <svg class="w-8 h-8 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <p class="text-4xl font-bold"><?= number_format($low_stock_count ?? 0) ?></p>
        <p class="text-sm text-white/60 mt-2">Buku dengan stok ≤ 5</p>
    </div>
</div>
<?php endif; ?>

<!-- Quick Actions & Latest Books -->
<div class="grid lg:grid-cols-3 gap-6">
    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
            <a href="/admin/books/create" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="font-medium text-slate-700">Tambah Buku Baru</span>
            </a>
            <a href="/admin/categories/create" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="font-medium text-slate-700">Tambah Kategori</span>
            </a>
            <a href="/admin/transactions" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <span class="font-medium text-slate-700">Kelola Transaksi</span>
            </a>
            <?php if (session()->get('role') === 'admin'): ?>
            <a href="/admin/users" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <span class="font-medium text-slate-700">Kelola Users</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Latest Books -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-800">Buku Terbaru</h3>
            <a href="/admin/books" class="text-primary-600 hover:text-primary-700 text-sm font-medium">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-sm text-slate-500 border-b border-slate-200">
                        <th class="pb-3">Buku</th>
                        <th class="pb-3">Kategori</th>
                        <th class="pb-3">Harga</th>
                        <th class="pb-3">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($latest_books as $book): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-14 rounded overflow-hidden bg-slate-100 flex-shrink-0">
                                    <?php if ($book['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])): ?>
                                    <img src="/uploads/covers/<?= esc($book['cover_image']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                    <div class="w-full h-full bg-primary-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13"></path>
                                        </svg>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800 line-clamp-1"><?= esc($book['title']) ?></p>
                                    <p class="text-sm text-slate-500"><?= esc($book['author']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="text-sm text-slate-600"><?= esc($book['category_name']) ?></span>
                        </td>
                        <td class="py-3">
                            <span class="font-medium text-slate-800">Rp <?= number_format($book['price'], 0, ',', '.') ?></span>
                        </td>
                        <td class="py-3">
                            <?php if ($book['stock'] > 10): ?>
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-sm rounded-full"><?= $book['stock'] ?></span>
                            <?php elseif ($book['stock'] > 0): ?>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-sm rounded-full"><?= $book['stock'] ?></span>
                            <?php else: ?>
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-sm rounded-full">Habis</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
