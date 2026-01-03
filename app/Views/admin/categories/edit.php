<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-xl">
    <!-- Header -->
    <div class="mb-6">
        <a href="/admin/categories" class="text-slate-500 hover:text-primary-600 transition-colors inline-flex items-center space-x-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Edit Kategori</h1>
    </div>
    
    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <?php if (session()->getFlashdata('errors')): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <ul class="text-sm text-red-600 space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <form action="/admin/categories/update/<?= $category['id'] ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>
            
            <div>
                <label for="category_name" class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori *</label>
                <input type="text" id="category_name" name="category_name" value="<?= old('category_name', $category['category_name']) ?>" 
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                       placeholder="Contoh: Fiksi, Teknologi, Bisnis..." required>
            </div>
            
            <div class="flex items-center space-x-4">
                <button type="submit" 
                        class="px-6 py-3 bg-primary-500 text-white rounded-xl font-semibold hover:bg-primary-600 transition-colors shadow-lg hover:shadow-xl">
                    Update Kategori
                </button>
                <a href="/admin/categories" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-medium hover:bg-slate-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
