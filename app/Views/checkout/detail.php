<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Spacer for fixed navbar -->
<div class="h-20"></div>

<div class="container mx-auto px-4 py-12">
    <!-- Header -->
    <div class="mb-8 animate-fade-in-up">
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="/orders" class="text-slate-500 hover:text-primary-600 transition-colors">Pesanan Saya</a></li>
                <li><svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                <li class="text-slate-800 font-medium"><?= esc($transaction['transaction_code']) ?></li>
            </ol>
        </nav>
    </div>
    
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary-500 via-primary-600 to-accent-600 p-8 text-white relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white rounded-full"></div>
                    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white rounded-full"></div>
                </div>
                
                <div class="relative z-10">
                    <div class="flex flex-wrap items-start justify-between gap-6">
                        <div>
                            <p class="text-white/70 text-sm mb-1">Kode Transaksi</p>
                            <p class="text-3xl font-bold font-mono"><?= esc($transaction['transaction_code']) ?></p>
                            <p class="text-white/70 text-sm mt-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <?= date('d M Y, H:i', strtotime($transaction['created_at'])) ?> WIB
                            </p>
                        </div>
                        
                        <!-- Status Badge -->
                        <?php
                        $statusConfig = [
                            'pending' => ['bg' => 'bg-yellow-400', 'text' => 'text-yellow-900', 'label' => 'Menunggu Pembayaran', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'paid' => ['bg' => 'bg-blue-400', 'text' => 'text-blue-900', 'label' => 'Sudah Dibayar', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'shipped' => ['bg' => 'bg-green-400', 'text' => 'text-green-900', 'label' => 'Dikirim', 'icon' => 'M5 13l4 4L19 7'],
                            'cancelled' => ['bg' => 'bg-red-400', 'text' => 'text-red-900', 'label' => 'Dibatalkan', 'icon' => 'M6 18L18 6M6 6l12 12'],
                        ];
                        $config = $statusConfig[$transaction['status']];
                        ?>
                        <span class="flex items-center space-x-2 px-5 py-2.5 <?= $config['bg'] ?> <?= $config['text'] ?> rounded-full font-bold shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $config['icon'] ?>"></path>
                            </svg>
                            <span><?= $config['label'] ?></span>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Order Progress -->
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50">
                <div class="flex items-center justify-between max-w-lg mx-auto">
                    <?php
                    $steps = ['pending' => 1, 'paid' => 2, 'shipped' => 3, 'cancelled' => 0];
                    $currentStep = $steps[$transaction['status']];
                    $stepLabels = ['Pesanan', 'Pembayaran', 'Pengiriman', 'Selesai'];
                    ?>
                    <?php foreach ($stepLabels as $index => $label): ?>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300 <?= ($index + 1) <= $currentStep ? 'bg-primary-500 text-white' : 'bg-slate-200 text-slate-400' ?>">
                            <?php if (($index + 1) < $currentStep): ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <?php else: ?>
                            <span class="font-semibold"><?= $index + 1 ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="text-xs <?= ($index + 1) <= $currentStep ? 'text-primary-600 font-semibold' : 'text-slate-400' ?>"><?= $label ?></span>
                    </div>
                    <?php if ($index < 3): ?>
                    <div class="flex-1 h-1 mx-2 <?= ($index + 1) < $currentStep ? 'bg-primary-500' : 'bg-slate-200' ?>"></div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Order Info -->
            <div class="p-8 border-b border-slate-100">
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-sm text-slate-500 mb-1">Nama Pemesan</p>
                        <p class="font-semibold text-slate-800"><?= esc($transaction['username']) ?></p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-sm text-slate-500 mb-1">Email</p>
                        <p class="font-semibold text-slate-800"><?= esc($transaction['email']) ?></p>
                    </div>
                    <div class="p-4 bg-gradient-to-r from-primary-50 to-accent-50 rounded-xl">
                        <p class="text-sm text-primary-600 mb-1">Total Pembayaran</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                            Rp <?= number_format($transaction['total_price'], 0, ',', '.') ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="p-8">
                <h3 class="font-bold text-slate-800 mb-6 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Detail Pesanan</span>
                </h3>
                
                <div class="space-y-4">
                    <?php foreach ($transaction['details'] as $detail): ?>
                    <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                        <div class="w-16 h-22 rounded-xl overflow-hidden bg-white shadow flex-shrink-0">
                            <?php if ($detail['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $detail['cover_image'])): ?>
                            <img src="/uploads/covers/<?= esc($detail['cover_image']) ?>" 
                                 class="w-full h-full object-cover">
                            <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-accent-100">
                                <svg class="w-8 h-8 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13"></path>
                                </svg>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-slate-800"><?= esc($detail['title']) ?></h4>
                            <p class="text-sm text-slate-500"><?= esc($detail['author']) ?></p>
                            <p class="text-sm text-slate-600 mt-1">
                                <?= $detail['qty'] ?> × Rp <?= number_format($detail['price_at_time'], 0, ',', '.') ?>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-slate-800">Rp <?= number_format($detail['subtotal'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Total -->
                <div class="mt-6 p-4 bg-gradient-to-r from-primary-500 to-accent-600 rounded-xl text-white">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">Total Pembayaran</span>
                        <span class="text-2xl font-bold">Rp <?= number_format($transaction['total_price'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="mt-6 flex items-center justify-between">
            <a href="/orders" class="text-slate-600 hover:text-primary-600 transition-colors font-medium flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Kembali ke Daftar Pesanan</span>
            </a>
            
            <?php if ($transaction['status'] === 'pending'): ?>
            <button onclick="confirmPayment(<?= $transaction['id'] ?>)" class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl btn-press">
                Bayar Sekarang
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function confirmPayment(transactionId) {
    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        html: `
            <div class="text-left">
                <p class="mb-4">Total yang harus dibayar:</p>
                <p class="text-3xl font-bold text-green-600 mb-4">Rp <?= number_format($transaction['total_price'], 0, ',', '.') ?></p>
                <div class="p-4 bg-slate-100 rounded-lg text-sm">
                    <p class="font-semibold mb-2">Instruksi Transfer:</p>
                    <p>Bank BCA: 1234567890</p>
                    <p>a.n. Toko Buku Online</p>
                </div>
            </div>
        `,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sudah Bayar',
        cancelButtonText: 'Nanti Saja'
    }).then((result) => {
        if (result.isConfirmed) {
            // Simulasi konfirmasi pembayaran
            const formData = new FormData();
            formData.append('status', 'paid');
            
            fetch('/orders/pay/' + transactionId, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Dikonfirmasi!',
                        text: 'Terima kasih! Pesanan Anda sedang diproses.',
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Terjadi kesalahan'
                    });
                }
            })
            .catch(() => {
                location.reload();
            });
        }
    });
}
</script>
<?= $this->endSection() ?>
