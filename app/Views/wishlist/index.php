<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="pt-28 pb-16 min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-pink-500 to-red-500 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Wishlist Saya</h1>
            <p class="text-slate-600">
                <?php if ($total > 0): ?>
                <?= $total ?> buku dalam wishlist
                <?php else: ?>
                Simpan buku favoritmu di sini
                <?php endif; ?>
            </p>
        </div>

        <?php if (!empty($items)): ?>
        <!-- Wishlist Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-8">
            <?php foreach ($items as $index => $item): ?>
            <div class="group bg-white rounded-3xl shadow-lg overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-2xl animate-fade-in-up" 
                 style="animation-delay: <?= $index * 0.05 ?>s;"
                 id="wishlist-item-<?= $item['id'] ?>">
                <!-- Cover Image -->
                <a href="/book/<?= esc($item['slug']) ?>" class="block aspect-[3/4] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 relative">
                    <?php if ($item['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $item['cover_image'])): ?>
                    <img src="/uploads/covers/<?= esc($item['cover_image']) ?>" 
                         alt="<?= esc($item['title']) ?>" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Category Badge -->
                    <span class="absolute top-3 left-3 px-3 py-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-xs font-semibold rounded-full shadow-lg">
                        <?= esc($item['category_name']) ?>
                    </span>
                    
                    <!-- Remove from Wishlist Button -->
                    <button onclick="removeFromWishlist(<?= $item['id'] ?>)" 
                            class="absolute top-3 right-3 p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-lg text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </a>
                
                <!-- Info -->
                <div class="p-5">
                    <h3 class="font-bold text-slate-800 line-clamp-2 mb-1 group-hover:text-primary-600 transition-colors leading-tight">
                        <a href="/book/<?= esc($item['slug']) ?>"><?= esc($item['title']) ?></a>
                    </h3>
                    <p class="text-sm text-slate-500 mb-3"><?= esc($item['author']) ?></p>
                    
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                            Rp <?= number_format($item['price'], 0, ',', '.') ?>
                        </span>
                        <?php if ($item['stock'] > 0): ?>
                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-medium">Tersedia</span>
                        <?php else: ?>
                        <span class="text-xs text-red-600 bg-red-50 px-2 py-1 rounded-full font-medium">Habis</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Add to Cart Button -->
                    <?php if ($item['stock'] > 0): ?>
                    <button onclick="addToCartFromWishlist(<?= $item['id'] ?>)" 
                            class="w-full py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Tambah ke Keranjang</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-32 h-32 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-700 mb-2">Wishlist Masih Kosong</h3>
            <p class="text-slate-500 mb-6">Simpan buku favoritmu untuk dibeli nanti</p>
            <a href="/browser" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span>Jelajahi Buku</span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function removeFromWishlist(bookId) {
    fetch(`/wishlist/remove/${bookId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Animate and remove item
            const item = document.getElementById(`wishlist-item-${bookId}`);
            if (item) {
                item.style.transform = 'scale(0.8)';
                item.style.opacity = '0';
                setTimeout(() => {
                    item.remove();
                    // Check if empty
                    const grid = document.querySelector('.grid');
                    if (grid && grid.children.length === 0) {
                        location.reload();
                    }
                }, 300);
            }
            // Update badge
            updateWishlistBadge(data.count);
            // Show toast
            showToast(data.message, 'success');
        }
    });
}

function addToCartFromWishlist(bookId) {
    fetch(`/cart/add/${bookId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('Buku ditambahkan ke keranjang!', 'success');
            // Update cart badge if exists
            const cartBadge = document.getElementById('cart-count-badge');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count;
            }
        } else {
            showToast(data.message || 'Gagal menambahkan ke keranjang', 'error');
        }
    });
}

function updateWishlistBadge(count) {
    const badge = document.getElementById('wishlist-count-badge');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }
}

function showToast(message, type = 'success') {
    Swal.fire({
        icon: type,
        title: type === 'success' ? 'Berhasil!' : 'Oops!',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
}
</script>
<?= $this->endSection() ?>
