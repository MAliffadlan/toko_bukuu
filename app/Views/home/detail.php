<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Spacer for fixed navbar -->
<div class="h-20"></div>

<div class="container mx-auto px-4 py-12">
    <!-- Breadcrumb -->
    <nav class="mb-8 animate-fade-in">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="/browser" class="text-slate-500 hover:text-primary-600 transition-colors">Beranda</a></li>
            <li><svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li><a href="/browser?category=<?= $book['category_id'] ?>#katalog" class="text-slate-500 hover:text-primary-600 transition-colors"><?= esc($book['category_name']) ?></a></li>
            <li><svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li class="text-slate-800 font-medium truncate max-w-xs"><?= esc($book['title']) ?></li>
        </ol>
    </nav>
    
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up">
        <div class="lg:flex">
            <!-- Cover Image -->
            <div class="lg:w-2/5 p-8 lg:p-12 bg-gradient-to-br from-slate-50 to-slate-100">
                <div class="aspect-[3/4] rounded-2xl overflow-hidden shadow-2xl bg-white relative group">
                    <?php if ($book['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])): ?>
                    <img src="/uploads/covers/<?= esc($book['cover_image']) ?>" 
                         alt="<?= esc($book['title']) ?>" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-accent-100">
                        <svg class="w-24 h-24 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Zoom Icon -->
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Details -->
            <div class="lg:w-3/5 p-8 lg:p-12">
                <!-- Category Badge -->
                <?php 
                $badgeColors = [
                    'fiksi' => 'from-blue-500 to-blue-600',
                    'non-fiksi' => 'from-green-500 to-green-600',
                    'teknologi' => 'from-purple-500 to-purple-600',
                    'bisnis' => 'from-yellow-500 to-orange-500',
                ];
                $badgeColor = $badgeColors[strtolower(url_title($book['category_name'], '-', true))] ?? 'from-primary-500 to-primary-600';
                ?>
                <span class="inline-block px-4 py-1.5 bg-gradient-to-r <?= $badgeColor ?> text-white text-sm font-semibold rounded-full mb-4">
                    <?= esc($book['category_name']) ?>
                </span>
                
                <!-- Title -->
                <h1 class="text-3xl lg:text-4xl font-bold text-slate-800 mb-3 leading-tight"><?= esc($book['title']) ?></h1>
                
                <!-- Author -->
                <p class="text-lg text-slate-600 mb-6">oleh <span class="font-semibold text-slate-800"><?= esc($book['author']) ?></span></p>
                
                <!-- Price -->
                <div class="mb-8">
                    <span class="text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                        Rp <?= number_format($book['price'], 0, ',', '.') ?>
                    </span>
                </div>
                
                <!-- Book Details Grid -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <?php if ($book['publisher']): ?>
                    <div class="flex items-center space-x-3 p-4 bg-slate-50 rounded-xl">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Penerbit</p>
                            <p class="font-medium text-slate-800"><?= esc($book['publisher']) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($book['year']): ?>
                    <div class="flex items-center space-x-3 p-4 bg-slate-50 rounded-xl">
                        <div class="w-10 h-10 bg-accent-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Tahun Terbit</p>
                            <p class="font-medium text-slate-800"><?= esc($book['year']) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex items-center space-x-3 p-4 bg-slate-50 rounded-xl">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Stok</p>
                            <?php if ($book['stock'] > 0): ?>
                            <p class="font-medium text-green-600"><?= $book['stock'] ?> tersedia</p>
                            <?php else: ?>
                            <p class="font-medium text-red-600">Habis</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <?php if ($book['description']): ?>
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-slate-800 mb-3">Tentang Buku Ini</h3>
                    <p class="text-slate-600 leading-relaxed"><?= nl2br(esc($book['description'])) ?></p>
                </div>
                <?php endif; ?>
                
                <!-- Add to Cart -->
                <?php if ($book['stock'] > 0): ?>
                    <?php if (session()->get('isLoggedIn')): ?>
                    <form id="add-to-cart-form" class="flex flex-wrap items-center gap-4">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        
                        <!-- Quantity Selector -->
                        <div class="flex items-center bg-slate-100 rounded-xl">
                            <button type="button" onclick="decrementQty()" class="w-12 h-12 flex items-center justify-center text-slate-600 hover:text-primary-600 hover:bg-slate-200 rounded-l-xl transition-colors btn-press">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input type="number" name="qty" id="qty" value="1" min="1" max="<?= $book['stock'] ?>" 
                                   class="w-16 text-center bg-transparent py-3 font-semibold text-slate-800 outline-none">
                            <button type="button" onclick="incrementQty()" class="w-12 h-12 flex items-center justify-center text-slate-600 hover:text-primary-600 hover:bg-slate-200 rounded-r-xl transition-colors btn-press">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Add to Cart Button -->
                        <button type="submit" id="add-to-cart-btn"
                                class="flex-1 min-w-[200px] px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 btn-press flex items-center justify-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Tambah ke Keranjang</span>
                        </button>
                        
                        <!-- Wishlist Button -->
                        <?php 
                        $inWishlist = false;
                        if (session()->get('isLoggedIn')) {
                            $wishlistModel = new \App\Models\WishlistModel();
                            $inWishlist = $wishlistModel->isInWishlist(session()->get('user_id'), $book['id']);
                        }
                        ?>
                        <button type="button" onclick="toggleWishlist(<?= $book['id'] ?>)" id="wishlist-btn"
                                class="p-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl btn-press <?= $inWishlist ? 'bg-pink-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-pink-100 hover:text-pink-600' ?>">
                            <svg class="w-6 h-6" fill="<?= $inWishlist ? 'currentColor' : 'none' ?>" stroke="currentColor" viewBox="0 0 24 24" id="wishlist-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </form>
                    
                    <!-- Buy Now Button -->
                    <button onclick="buyNow()" class="w-full mt-4 px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl btn-press flex items-center justify-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Beli Sekarang</span>
                    </button>
                    <?php else: ?>
                    <a href="/login" class="block w-full px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-center rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl btn-press">
                        Login untuk Membeli
                    </a>
                    <?php endif; ?>
                <?php else: ?>
                <button disabled class="w-full px-8 py-4 bg-slate-300 text-slate-500 rounded-xl font-semibold cursor-not-allowed">
                    Stok Habis
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const maxStock = <?= $book['stock'] ?>;

function incrementQty() {
    const input = document.getElementById('qty');
    if (parseInt(input.value) < maxStock) {
        input.value = parseInt(input.value) + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('qty');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// AJAX Add to Cart with SweetAlert animation
document.getElementById('add-to-cart-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('add-to-cart-btn');
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span>Menambahkan...</span>';
    btn.disabled = true;
    
    const formData = new FormData(this);
    
    fetch('/cart/add', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
        
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil! 🎉',
                text: data.message,
                showConfirmButton: true,
                confirmButtonText: 'Lihat Keranjang',
                showCancelButton: true,
                cancelButtonText: 'Lanjut Belanja',
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#64748b',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/cart';
                }
            });
            
            // Update cart badge
            updateCartBadge(data.cartCount);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data.message || 'Terjadi kesalahan'
            });
        }
    })
    .catch(error => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
        console.error('Error:', error);
        Swal.fire({
            icon: 'info',
            title: 'Berhasil!',
            text: 'Buku ditambahkan ke keranjang',
            confirmButtonText: 'Lihat Keranjang',
            showCancelButton: true,
            cancelButtonText: 'Lanjut Belanja',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/cart';
            }
        });
    });
});

function buyNow() {
    const formData = new FormData(document.getElementById('add-to-cart-form'));
    
    fetch('/cart/add', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '/checkout';
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data.message || 'Terjadi kesalahan'
            });
        }
    })
    .catch(() => {
        // Assume success if error parsing, redirect anyway
        window.location.href = '/checkout';
    });
}

function updateCartBadge(count) {
    let badge = document.getElementById('cart-count-badge');
    const cartIcon = document.getElementById('cart-icon-nav');
    
    if (badge) {
        badge.textContent = count;
        badge.classList.add('animate-bounce-in');
    } else if (cartIcon && count > 0) {
        const newBadge = document.createElement('span');
        newBadge.id = 'cart-count-badge';
        newBadge.className = 'absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold animate-bounce-in';
        newBadge.textContent = count;
        cartIcon.appendChild(newBadge);
    }
}

// Toggle Wishlist
function toggleWishlist(bookId) {
    fetch(`/wishlist/toggle/${bookId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const btn = document.getElementById('wishlist-btn');
            const icon = document.getElementById('wishlist-icon');
            
            if (data.in_wishlist) {
                btn.classList.remove('bg-slate-100', 'text-slate-600', 'hover:bg-pink-100', 'hover:text-pink-600');
                btn.classList.add('bg-pink-500', 'text-white');
                icon.setAttribute('fill', 'currentColor');
            } else {
                btn.classList.add('bg-slate-100', 'text-slate-600', 'hover:bg-pink-100', 'hover:text-pink-600');
                btn.classList.remove('bg-pink-500', 'text-white');
                icon.setAttribute('fill', 'none');
            }
            
            // Update navbar badge
            updateWishlistBadge(data.count);
            
            // Show toast
            Swal.fire({
                icon: 'success',
                title: data.in_wishlist ? '❤️ Ditambahkan!' : 'Dihapus',
                text: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }
    });
}

function updateWishlistBadge(count) {
    let badge = document.getElementById('wishlist-count-badge');
    
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
        } else {
            badge.remove();
        }
    } else if (count > 0) {
        // Create new badge if needed
        const wishlistLink = document.querySelector('a[href="/wishlist"]');
        if (wishlistLink) {
            const newBadge = document.createElement('span');
            newBadge.id = 'wishlist-count-badge';
            newBadge.className = 'absolute -top-1 -right-1 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold';
            newBadge.textContent = count;
            wishlistLink.appendChild(newBadge);
        }
    }
}
</script>
<?= $this->endSection() ?>
