<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Spacer for fixed navbar -->
<div class="h-20"></div>

<div class="container mx-auto px-4 py-12">
    <!-- Header -->
    <div class="text-center mb-12 animate-fade-in-up">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Keranjang Belanja</h1>
        <p class="text-slate-600">Review item sebelum checkout</p>
    </div>
    
    <?php if (!empty($cartItems)): ?>
    <div class="lg:flex lg:gap-8">
        <!-- Cart Items -->
        <div class="lg:w-2/3 space-y-4 mb-8 lg:mb-0">
            <?php foreach ($cartItems as $index => $item): ?>
            <div class="cart-item bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row items-start md:items-center gap-6 animate-fade-in-up transition-all duration-300" 
                 data-cart-id="<?= $item['id'] ?>" style="animation-delay: <?= $index * 0.1 ?>s;">
                <!-- Cover -->
                <a href="/book/<?= esc($item['slug']) ?>" class="w-24 h-32 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 shadow-md hover:shadow-xl transition-shadow">
                    <?php if ($item['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $item['cover_image'])): ?>
                    <img src="/uploads/covers/<?= esc($item['cover_image']) ?>" 
                         alt="<?= esc($item['title']) ?>" 
                         class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                        <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <?php endif; ?>
                </a>
                
                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-lg text-slate-800 hover:text-primary-600 transition-colors">
                        <a href="/book/<?= esc($item['slug']) ?>"><?= esc($item['title']) ?></a>
                    </h3>
                    <p class="text-sm text-slate-500 mb-2"><?= esc($item['author']) ?></p>
                    <p class="text-xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                        Rp <?= number_format($item['price'], 0, ',', '.') ?>
                    </p>
                </div>
                
                <!-- Quantity -->
                <div class="flex items-center bg-slate-100 rounded-xl">
                    <button type="button" onclick="updateQty(<?= $item['id'] ?>, <?= $item['qty'] - 1 ?>)" 
                            class="w-10 h-10 flex items-center justify-center text-slate-600 hover:text-primary-600 hover:bg-slate-200 rounded-l-xl transition-colors btn-press">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <span class="w-12 text-center py-2 font-semibold text-slate-800"><?= $item['qty'] ?></span>
                    <button type="button" onclick="updateQty(<?= $item['id'] ?>, <?= $item['qty'] + 1 ?>)" 
                            class="w-10 h-10 flex items-center justify-center text-slate-600 hover:text-primary-600 hover:bg-slate-200 rounded-r-xl transition-colors btn-press">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Subtotal -->
                <div class="text-right min-w-[120px]">
                    <p class="text-xs text-slate-500 mb-1">Subtotal</p>
                    <p class="text-xl font-bold text-slate-800">Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?></p>
                </div>
                
                <!-- Remove -->
                <button onclick="removeItem(<?= $item['id'] ?>)" class="p-3 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-200 btn-press">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-28 animate-fade-in-up" style="animation-delay: 0.3s;">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Ringkasan Pesanan</h2>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal (<?= count($cartItems) ?> item)</span>
                        <span id="subtotal-display">Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Ongkos Kirim</span>
                        <span class="text-green-600 font-medium">GRATIS</span>
                    </div>
                    <hr class="border-slate-200">
                    <div class="flex justify-between text-xl font-bold text-slate-800">
                        <span>Total</span>
                        <span id="total-display" class="bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                            Rp <?= number_format($total, 0, ',', '.') ?>
                        </span>
                    </div>
                </div>
                
                <!-- Promo Code -->
                <div class="mb-6">
                    <div class="flex gap-2">
                        <input type="text" placeholder="Kode promo" 
                               class="flex-1 px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all">
                        <button class="px-4 py-3 bg-slate-100 text-slate-700 rounded-xl font-medium hover:bg-slate-200 transition-colors btn-press">
                            Terapkan
                        </button>
                    </div>
                </div>
                
                <!-- Checkout Button -->
                <a href="/checkout" class="block w-full py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-center rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 btn-press">
                    Lanjut ke Checkout
                </a>
                
                <a href="/browser" class="block text-center text-slate-600 hover:text-primary-600 mt-4 transition-colors font-medium">
                    ← Lanjut Belanja
                </a>
                
                <!-- Security Badge -->
                <div class="mt-6 flex items-center justify-center space-x-2 text-slate-400 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Transaksi Aman & Terpercaya</span>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Empty Cart -->
    <div class="text-center py-20 animate-fade-in">
        <div class="w-40 h-40 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-8">
            <svg class="w-20 h-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-700 mb-2">Keranjang Kosong</h3>
        <p class="text-slate-500 mb-8 max-w-md mx-auto">Wah, keranjang belanja Anda masih kosong. Yuk, temukan buku-buku menarik untuk koleksi Anda!</p>
        <a href="/browser" class="inline-flex items-center space-x-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl btn-press">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span>Mulai Belanja</span>
        </a>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function updateQty(cartId, qty) {
    if (qty < 1) {
        removeItem(cartId);
        return;
    }
    
    const formData = new FormData();
    formData.append('cart_id', cartId);
    formData.append('qty', qty);
    
    fetch('/cart/update', {
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
        if (data.success) {
            location.reload();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data.message || 'Terjadi kesalahan'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload(); // Fallback: just reload
    });
}

function removeItem(cartId) {
    Swal.fire({
        title: 'Hapus dari keranjang?',
        text: 'Item ini akan dihapus dari keranjang belanja',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Add fade out animation
            const item = document.querySelector(`[data-cart-id="${cartId}"]`);
            if (item) item.classList.add('fade-out');
            
            const formData = new FormData();
            formData.append('cart_id', cartId);
            
            fetch('/cart/remove', {
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
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Dihapus!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    if (item) item.classList.remove('fade-out');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: data.message || 'Gagal menghapus item'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                location.reload(); // Fallback: just reload
            });
        }
    });
}
</script>
<?= $this->endSection() ?>
