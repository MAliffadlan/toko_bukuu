<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Header -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Kategori</h1>
        <p class="text-slate-500">Daftar semua kategori buku</p>
    </div>
    <a href="/admin/categories/create" class="px-4 py-2 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Kategori</span>
    </a>
</div>

<!-- Categories Table -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">#</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Nama Kategori</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Slug</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Jumlah Buku</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $i => $cat): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500"><?= $i + 1 ?></td>
                        <td class="px-6 py-4 font-semibold text-slate-800"><?= esc($cat['category_name']) ?></td>
                        <td class="px-6 py-4 font-mono text-sm text-slate-500"><?= esc($cat['slug']) ?></td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-primary-50 text-primary-700 text-sm rounded-full"><?= $cat['book_count'] ?? 0 ?> buku</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="/admin/categories/edit/<?= $cat['id'] ?>" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <?php if (session()->get('role') === 'admin'): ?>
                                <form action="/admin/categories/delete/<?= $cat['id'] ?>" method="post" class="inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini? Pastikan tidak ada buku dalam kategori ini.')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        Belum ada kategori.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
