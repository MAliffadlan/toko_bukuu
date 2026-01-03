<?php 
$cartCount = 0;
$wishlistCount = 0;
if (session()->get('isLoggedIn')) {
    $cartModel = new \App\Models\CartModel();
    $wishlistModel = new \App\Models\WishlistModel();
    $cartCount = $cartModel->getCartCount(session()->get('user_id'));
    $wishlistCount = $wishlistModel->getWishlistCount(session()->get('user_id'));
}
$isHomePage = current_url() == base_url() || current_url() == base_url('/') || current_url() == base_url('browser');
?>
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 <?= $isHomePage ? 'bg-transparent' : 'bg-white/95 backdrop-blur-md shadow-lg' ?>">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="/browser" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 bg-gradient-to-br from-primary-500 to-accent-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-105 transition-all duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <span class="text-2xl font-bold gradient-text">TokoBuku</span>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/browser" class="font-medium text-slate-700 hover:text-primary-600 transition-colors">Beranda</a>
                <a href="/browser#katalog" class="font-medium text-slate-700 hover:text-primary-600 transition-colors">Katalog</a>
                <?php if (session()->get('isLoggedIn')): ?>
                <a href="/orders" class="font-medium text-slate-700 hover:text-primary-600 transition-colors">Pesanan</a>
                <?php endif; ?>
            </div>
            
            <!-- Right Menu -->
            <div class="flex items-center space-x-4">
                <!-- Search Button -->
                <button onclick="toggleSearch()" class="p-2 text-slate-600 hover:text-primary-600 hover:bg-slate-100 rounded-full transition-all duration-200 btn-press">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                
                <?php if (session()->get('isLoggedIn')): ?>
                    <!-- Wishlist Icon with Badge -->
                    <a href="/wishlist" class="relative p-2 text-slate-600 hover:text-pink-600 hover:bg-pink-50 rounded-full transition-all duration-200 btn-press" title="Wishlist">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <?php if ($wishlistCount > 0): ?>
                        <span class="absolute -top-1 -right-1 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold" id="wishlist-count-badge"><?= $wishlistCount ?></span>
                        <?php endif; ?>
                    </a>
                    
                    <!-- Cart Icon with Badge -->
                    <a href="/cart" class="relative p-2 text-slate-600 hover:text-primary-600 hover:bg-slate-100 rounded-full transition-all duration-200 btn-press" id="cart-icon-nav">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <?php if ($cartCount > 0): ?>
                        <span class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold animate-bounce-in" id="cart-count-badge"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 p-2 rounded-full hover:bg-slate-100 transition-all duration-200">
                            <div class="w-9 h-9 bg-gradient-to-br <?= getAvatarTailwind(session()->get('email') ?? session()->get('username')) ?> rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                <?= getInitials(session()->get('username')) ?>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="font-semibold text-slate-800"><?= esc(session()->get('username')) ?></p>
                                <p class="text-sm text-slate-500"><?= esc(session()->get('email')) ?></p>
                            </div>
                            
                            <?php if (in_array(session()->get('role'), ['admin', 'staff'])): ?>
                            <a href="/admin/dashboard" class="flex items-center space-x-3 px-4 py-3 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                                </svg>
                                <span>Dashboard Admin</span>
                            </a>
                            <?php endif; ?>
                            
                            <a href="/profile" class="flex items-center space-x-3 px-4 py-3 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profil Saya</span>
                            </a>
                            
                            <a href="/orders" class="flex items-center space-x-3 px-4 py-3 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span>Pesanan Saya</span>
                            </a>
                            
                            <a href="/library" class="flex items-center space-x-3 px-4 py-3 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Perpustakaan Saya</span>
                            </a>
                            
                            <div class="border-t border-slate-100 mt-2 pt-2">
                                <a href="/logout" class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="hidden md:inline-block font-medium text-slate-700 hover:text-primary-600 transition-colors">Login</a>
                    <a href="/register" class="px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-full font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 btn-press">
                        Daftar Gratis
                    </a>
                <?php endif; ?>
                
                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-slate-600 hover:text-primary-600 hover:bg-slate-100 rounded-full transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="menu-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Search Overlay - Semi-transparent with backdrop blur -->
        <div id="search-overlay" class="hidden absolute left-0 right-0 top-full bg-white/80 backdrop-blur-xl shadow-2xl border-t border-slate-200/50 p-6 animate-slide-down">
            <form action="/browser" method="get" class="max-w-2xl mx-auto">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" placeholder="Cari buku, penulis, atau kategori..." 
                           class="w-full rounded-xl border-0 bg-white/70 py-4 pl-12 pr-12 text-slate-900 ring-1 ring-inset ring-slate-300/50 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 backdrop-blur-sm transition-all duration-300" autofocus>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <button type="submit" class="p-2 rounded-lg bg-primary-500 hover:bg-primary-600 text-white transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <p class="mt-3 text-center text-sm text-slate-500">Tekan <kbd class="px-2 py-1 bg-slate-100 rounded text-xs font-mono">ESC</kbd> untuk menutup</p>
            </form>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 py-4 animate-slide-down">
            <div class="space-y-2">
                <a href="/browser" class="block px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-lg font-medium">Beranda</a>
                <a href="/browser#katalog" class="block px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-lg font-medium">Katalog</a>
                <?php if (session()->get('isLoggedIn')): ?>
                <a href="/orders" class="block px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-lg font-medium">Pesanan Saya</a>
                <a href="/profile" class="block px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-lg font-medium">Profil</a>
                <?php else: ?>
                <a href="/login" class="block px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-lg font-medium">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleSearch() {
    const overlay = document.getElementById('search-overlay');
    overlay.classList.toggle('hidden');
    if (!overlay.classList.contains('hidden')) {
        overlay.querySelector('input').focus();
    }
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

// Close search on escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('search-overlay').classList.add('hidden');
    }
});
</script>
