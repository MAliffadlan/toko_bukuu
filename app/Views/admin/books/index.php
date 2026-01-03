<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Header -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Buku</h1>
        <p class="text-slate-500">Daftar semua buku yang tersedia di toko</p>
    </div>
    <a href="/admin/books/create" class="px-4 py-2 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Buku</span>
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <form action="/admin/books" method="get" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="<?= esc($search ?? '') ?>" 
                   placeholder="Cari judul atau penulis..." 
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all">
        </div>
        <div class="w-48">
            <select name="category" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all">
                <option value="">Semua Kategori</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $categoryId == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium">
            Filter
        </button>
    </form>
</div>

<!-- Books Table -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Buku</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Kategori</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Harga</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Stok</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (!empty($books)): ?>
                    <?php foreach ($books as $book): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-16 rounded-lg overflow-hidden bg-slate-100 flex-shrink-0">
                                    <?php if ($book['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])): ?>
                                    <img src="/uploads/covers/<?= esc($book['cover_image']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                    <div class="w-full h-full bg-primary-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13"></path>
                                        </svg>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800"><?= esc($book['title']) ?></p>
                                    <p class="text-sm text-slate-500"><?= esc($book['author']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-primary-50 text-primary-700 text-sm rounded-full"><?= esc($book['category_name']) ?></span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">Rp <?= number_format($book['price'], 0, ',', '.') ?></td>
                        <td class="px-6 py-4">
                            <?php if ($book['stock'] > 10): ?>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full"><?= $book['stock'] ?></span>
                            <?php elseif ($book['stock'] > 0): ?>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm rounded-full"><?= $book['stock'] ?></span>
                            <?php else: ?>
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded-full">Habis</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="/admin/books/edit/<?= $book['id'] ?>" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <?php if (session()->get('role') === 'admin'): ?>
                                <form action="/admin/books/delete/<?= $book['id'] ?>" method="post" class="inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
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
                        Tidak ada buku ditemukan.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if (!empty($books)): ?>
    <div class="px-6 py-4 border-t border-slate-200">
        <?= $pager->links() ?>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
