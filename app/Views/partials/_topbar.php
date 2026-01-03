<header class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-30">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Page Title / Breadcrumb -->
        <div>
            <h2 class="text-xl font-bold text-slate-800"><?= esc($title ?? 'Dashboard') ?></h2>
        </div>
        
        <!-- Right Side -->
        <div class="flex items-center space-x-4">
            <!-- Notifications (placeholder) -->
            <button class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </button>
            
            <!-- User Dropdown -->
            <div class="relative group">
                <button class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-slate-100 transition-colors duration-200">
                    <div class="w-9 h-9 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                        <?= strtoupper(substr(session()->get('username'), 0, 1)) ?>
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-semibold text-slate-700"><?= esc(session()->get('username')) ?></p>
                        <p class="text-xs text-slate-500 capitalize"><?= session()->get('role') ?></p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <!-- Dropdown -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                    <a href="/browser" class="block px-4 py-2 text-slate-700 hover:bg-slate-100 transition-colors">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Ke Toko</span>
                        </span>
                    </a>
                    <hr class="my-2 border-slate-200">
                    <a href="/logout" class="block px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
