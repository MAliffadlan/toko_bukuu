<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Kelola Transaksi</h1>
    <p class="text-slate-500">Daftar semua transaksi pelanggan</p>
</div>

<!-- Transactions Table -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Kode Transaksi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Customer</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Total</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Tanggal</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $trx): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono font-semibold text-slate-800"><?= esc($trx['transaction_code']) ?></td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-slate-800"><?= esc($trx['username']) ?></p>
                            <p class="text-sm text-slate-500"><?= esc($trx['email']) ?></p>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">Rp <?= number_format($trx['total_price'], 0, ',', '.') ?></td>
                        <td class="px-6 py-4">
                            <?php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'paid' => 'bg-blue-100 text-blue-700',
                                'shipped' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                            $statusLabels = [
                                'pending' => 'Pending',
                                'paid' => 'Dibayar',
                                'shipped' => 'Dikirim',
                                'cancelled' => 'Batal',
                            ];
                            ?>
                            <span class="px-3 py-1 text-sm font-medium rounded-full <?= $statusColors[$trx['status']] ?>"><?= $statusLabels[$trx['status']] ?></span>
                        </td>
                        <td class="px-6 py-4 text-slate-600"><?= date('d M Y, H:i', strtotime($trx['created_at'])) ?></td>
                        <td class="px-6 py-4">
                            <a href="/admin/transactions/<?= $trx['id'] ?>" 
                               class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium text-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        Belum ada transaksi.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if (!empty($transactions)): ?>
    <div class="px-6 py-4 border-t border-slate-200">
        <?= $pager->links() ?>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
