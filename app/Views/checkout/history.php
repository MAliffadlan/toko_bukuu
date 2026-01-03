<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Spacer for fixed navbar -->
<div class="h-20"></div>

<div class="container mx-auto px-4 py-12">
    <!-- Header -->
    <div class="text-center mb-12 animate-fade-in-up">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Pesanan Saya</h1>
        <p class="text-slate-600">Lacak dan kelola semua pesanan Anda di sini</p>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <?php
        $statusCounts = ['pending' => 0, 'paid' => 0, 'shipped' => 0, 'cancelled' => 0];
        foreach ($transactions as $t) {
            $statusCounts[$t['status']]++;
        }
        ?>
        <div class="bg-white rounded-2xl shadow-lg p-5 text-center animate-fade-in-up">
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-slate-800"><?= $statusCounts['pending'] ?></p>
            <p class="text-sm text-slate-500">Menunggu</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-5 text-center animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-slate-800"><?= $statusCounts['paid'] ?></p>
            <p class="text-sm text-slate-500">Dibayar</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-5 text-center animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-slate-800"><?= $statusCounts['shipped'] ?></p>
            <p class="text-sm text-slate-500">Dikirim</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-5 text-center animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-slate-800"><?= $statusCounts['cancelled'] ?></p>
            <p class="text-sm text-slate-500">Dibatalkan</p>
        </div>
    </div>
    
    <?php if (!empty($transactions)): ?>
    <!-- Orders List -->
    <div class="space-y-4">
        <?php foreach ($transactions as $index => $trx): ?>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 animate-fade-in-up" style="animation-delay: <?= ($index + 4) * 0.05 ?>s;">
            <div class="p-6">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <?php
                            $statusConfig = [
                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Menunggu Pembayaran'],
                                'paid' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Sudah Dibayar'],
                                'shipped' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'M5 13l4 4L19 7', 'label' => 'Dikirim'],
                                'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'M6 18L18 6M6 6l12 12', 'label' => 'Dibatalkan'],
                            ];
                            $config = $statusConfig[$trx['status']];
                            ?>
                            <span class="flex items-center space-x-2 px-3 py-1.5 <?= $config['bg'] ?> <?= $config['text'] ?> rounded-full text-sm font-semibold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $config['icon'] ?>"></path>
                                </svg>
                                <span><?= $config['label'] ?></span>
                            </span>
                        </div>
                        <p class="font-mono text-lg font-bold text-slate-800"><?= esc($trx['transaction_code']) ?></p>
                        <p class="text-sm text-slate-500 mt-1">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?= date('d M Y, H:i', strtotime($trx['created_at'])) ?> WIB
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500">Total Pembayaran</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                            Rp <?= number_format($trx['total_price'], 0, ',', '.') ?>
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <div class="flex items-center space-x-2 text-sm text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Pesanan ini memiliki beberapa item buku</span>
                    </div>
                    <a href="/orders/<?= $trx['id'] ?>" 
                       class="inline-flex items-center space-x-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-medium hover:bg-primary-50 hover:text-primary-600 transition-all duration-200 btn-press">
                        <span>Lihat Detail</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <!-- Empty State -->
    <div class="text-center py-20 animate-fade-in">
        <div class="w-40 h-40 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-8">
            <svg class="w-20 h-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-700 mb-2">Belum Ada Pesanan</h3>
        <p class="text-slate-500 mb-8 max-w-md mx-auto">Anda belum pernah melakukan pembelian. Yuk, temukan buku-buku menarik untuk koleksi Anda!</p>
        <a href="/browser" class="inline-flex items-center space-x-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl btn-press">
            <span>Mulai Belanja</span>
        </a>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
