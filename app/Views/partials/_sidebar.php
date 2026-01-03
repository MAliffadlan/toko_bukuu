<?php
$currentUri = current_url();
$isAdmin = session()->get('role') === 'admin';
?>
<aside class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white shadow-2xl z-40">
    <!-- Logo -->
    <div class="p-6 border-b border-slate-700">
        <a href="/admin/dashboard" class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-white">TokoBuku</h1>
                <p class="text-xs text-slate-400">Admin Panel</p>
            </div>
        </a>
    </div>
    
    <!-- Navigation -->
    <nav class="p-4 space-y-2">
        <!-- Dashboard -->
        <a href="/admin/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 <?= strpos($currentUri, 'dashboard') !== false ? 'bg-primary-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>
        
        <!-- Buku -->
        <a href="/admin/books" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 <?= strpos($currentUri, 'books') !== false ? 'bg-primary-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span class="font-medium">Kelola Buku</span>
        </a>
        
        <!-- Kategori -->
        <a href="/admin/categories" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 <?= strpos($currentUri, 'categories') !== false ? 'bg-primary-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <span class="font-medium">Kategori</span>
        </a>
        
        <!-- Transaksi -->
        <a href="/admin/transactions" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 <?= strpos($currentUri, 'transactions') !== false ? 'bg-primary-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <span class="font-medium">Transaksi</span>
        </a>
        
        <?php if ($isAdmin): ?>
        <!-- Users (Admin Only) -->
        <a href="/admin/users" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 <?= strpos($currentUri, 'users') !== false ? 'bg-primary-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span class="font-medium">Kelola Users</span>
        </a>
        <?php endif; ?>
        
        <hr class="border-slate-700 my-4">
        
        <!-- Kembali ke Toko -->
        <a href="/browser" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-700/50 hover:text-white transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="font-medium">Kembali ke Toko</span>
        </a>
    </nav>
    
    <!-- User Info -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700 bg-slate-800/50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br <?= getAvatarTailwind(session()->get('email') ?? session()->get('username')) ?> rounded-full flex items-center justify-center font-bold text-white">
                <?= getInitials(session()->get('username')) ?>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate"><?= esc(session()->get('username')) ?></p>
                <p class="text-xs text-slate-400 capitalize"><?= session()->get('role') ?></p>
            </div>
        </div>
    </div>
</aside>
