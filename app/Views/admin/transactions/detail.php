<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
        <a href="/admin/transactions" class="text-slate-500 hover:text-primary-600 transition-colors inline-flex items-center space-x-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Detail Transaksi</h1>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 p-6 text-white">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-primary-100 text-sm">Kode Transaksi</p>
                    <p class="text-2xl font-bold font-mono"><?= esc($transaction['transaction_code']) ?></p>
                </div>
                
                <!-- Status Update Form -->
                <form action="/admin/transactions/status/<?= $transaction['id'] ?>" method="post" class="flex items-center space-x-2">
                    <?= csrf_field() ?>
                    <select name="status" class="px-3 py-2 rounded-lg bg-white/20 text-white border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <option value="pending" <?= $transaction['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="paid" <?= $transaction['status'] == 'paid' ? 'selected' : '' ?>>Dibayar</option>
                        <option value="shipped" <?= $transaction['status'] == 'shipped' ? 'selected' : '' ?>>Dikirim</option>
                        <option value="cancelled" <?= $transaction['status'] == 'cancelled' ? 'selected' : '' ?>>Batal</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-white text-primary-600 rounded-lg font-medium hover:bg-white/90 transition-colors">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Order Info -->
        <div class="p-6 border-b border-slate-200">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-slate-500">Tanggal Pesan</p>
                    <p class="font-medium text-slate-800"><?= date('d M Y, H:i', strtotime($transaction['created_at'])) ?></p>
                </div>
                <div>
                    <p class="text-slate-500">Nama Pemesan</p>
                    <p class="font-medium text-slate-800"><?= esc($transaction['username']) ?></p>
                </div>
                <div>
                    <p class="text-slate-500">Email</p>
                    <p class="font-medium text-slate-800"><?= esc($transaction['email']) ?></p>
                </div>
                <div>
                    <p class="text-slate-500">Total Pembayaran</p>
                    <p class="font-bold text-primary-600 text-lg">Rp <?= number_format($transaction['total_price'], 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
        
        <!-- Order Items -->
        <div class="p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Detail Pesanan</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Buku</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-slate-700">Qty</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-slate-700">Harga Satuan</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-slate-700">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($transaction['details'] as $detail): ?>
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-14 rounded overflow-hidden bg-slate-100 flex-shrink-0">
                                        <?php if ($detail['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $detail['cover_image'])): ?>
                                        <img src="/uploads/covers/<?= esc($detail['cover_image']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                        <div class="w-full h-full bg-primary-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13"></path>
                                            </svg>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800"><?= esc($detail['title']) ?></p>
                                        <p class="text-sm text-slate-500"><?= esc($detail['author']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center text-slate-600"><?= $detail['qty'] ?></td>
                            <td class="px-4 py-3 text-right text-slate-600">Rp <?= number_format($detail['price_at_time'], 0, ',', '.') ?></td>
                            <td class="px-4 py-3 text-right font-semibold text-slate-800">Rp <?= number_format($detail['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-slate-50 border-t-2 border-slate-200">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-semibold text-slate-700">Total</td>
                            <td class="px-4 py-3 text-right font-bold text-lg text-primary-600">Rp <?= number_format($transaction['total_price'], 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
