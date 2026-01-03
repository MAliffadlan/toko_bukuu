<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Spacer for fixed navbar -->
<div class="h-20"></div>

<div class="container mx-auto px-4 py-12">
    <!-- Header -->
    <div class="text-center mb-12 animate-fade-in-up">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Checkout</h1>
        <p class="text-slate-600">Satu langkah lagi untuk mendapatkan buku impian Anda</p>
    </div>
    
    <div class="lg:flex lg:gap-8 max-w-5xl mx-auto">
        <!-- Order Items -->
        <div class="lg:w-3/5 mb-8 lg:mb-0">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden animate-fade-in-up">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>Ringkasan Pesanan</span>
                    </h2>
                </div>
                
                <div class="divide-y divide-slate-100">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="p-5 flex items-center space-x-4">
                        <div class="w-16 h-20 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 shadow">
                            <?php if ($item['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $item['cover_image'])): ?>
                            <img src="/uploads/covers/<?= esc($item['cover_image']) ?>" 
                                 alt="<?= esc($item['title']) ?>" 
                                 class="w-full h-full object-cover">
                            <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13"></path>
                                </svg>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-slate-800 truncate"><?= esc($item['title']) ?></h3>
                            <p class="text-sm text-slate-500"><?= esc($item['author']) ?></p>
                            <p class="text-sm text-slate-600 mt-1">Qty: <?= $item['qty'] ?> × Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-slate-800">Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Shipping Info -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Informasi Pengiriman</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 p-4 bg-green-50 rounded-xl border border-green-200">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-green-800">Pengiriman Digital</p>
                            <p class="text-sm text-green-600">Buku akan dikirim ke email Anda setelah pembayaran dikonfirmasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Payment Summary -->
        <div class="lg:w-2/5">
            <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-28 animate-fade-in-up" style="animation-delay: 0.2s;">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Pembayaran</h2>
                
                <!-- Payment Method -->
                <div class="mb-6">
                    <p class="text-sm font-medium text-slate-700 mb-3">Metode Pembayaran</p>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-primary-500 bg-primary-50 rounded-xl cursor-pointer">
                            <input type="radio" name="payment" checked class="w-4 h-4 text-primary-600">
                            <span class="ml-3 font-medium text-slate-800">Bank Transfer</span>
                            <span class="ml-auto text-xs bg-primary-100 text-primary-700 px-2 py-1 rounded-full">Recommended</span>
                        </label>
                        <label class="flex items-center p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-slate-300 transition-colors">
                            <input type="radio" name="payment" class="w-4 h-4 text-primary-600">
                            <span class="ml-3 font-medium text-slate-800">E-Wallet</span>
                        </label>
                    </div>
                </div>
                
                <div class="space-y-3 mb-6 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal</span>
                        <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Ongkos Kirim</span>
                        <span class="text-green-600 font-medium">Gratis</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Pajak</span>
                        <span>Rp 0</span>
                    </div>
                    <hr class="border-slate-200">
                    <div class="flex justify-between text-xl font-bold text-slate-800">
                        <span>Total</span>
                        <span class="bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                            Rp <?= number_format($total, 0, ',', '.') ?>
                        </span>
                    </div>
                </div>
                
                <!-- Checkout Button -->
                <form action="/checkout/process" method="post" id="checkout-form">
                    <?= csrf_field() ?>
                    <button type="submit" id="checkout-btn"
                            class="w-full py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 btn-press flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Bayar Sekarang</span>
                    </button>
                </form>
                
                <a href="/cart" class="block text-center text-slate-600 hover:text-primary-600 mt-4 transition-colors font-medium">
                    ← Kembali ke Keranjang
                </a>
                
                <!-- Trust Badges -->
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <div class="flex items-center justify-center space-x-4 text-slate-400 text-xs">
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span>Aman</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>Instan</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span>Terpercaya</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    const btn = document.getElementById('checkout-btn');
    btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span class="ml-2">Memproses...</span>';
    btn.disabled = true;
});
</script>
<?= $this->endSection() ?>
