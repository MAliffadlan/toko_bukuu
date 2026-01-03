<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-3xl">
    <!-- Header -->
    <div class="mb-6">
        <a href="/admin/books" class="text-slate-500 hover:text-primary-600 transition-colors inline-flex items-center space-x-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Tambah Buku Baru</h1>
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
        
        <form action="/admin/books/store" method="post" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>
            
            <!-- Cover Image Preview -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Cover Buku</label>
                <div class="flex items-start space-x-4">
                    <div class="w-32 h-44 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 border-2 border-dashed border-slate-300" id="preview-container">
                        <div class="w-full h-full flex items-center justify-center text-slate-400" id="preview-placeholder">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <img id="preview-image" class="hidden w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" 
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer"
                               onchange="previewImage(this)">
                        <p class="mt-2 text-xs text-slate-500">PNG, JPG, JPEG. Maksimal 2MB.</p>
                    </div>
                </div>
            </div>
            
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Judul Buku *</label>
                <input type="text" id="title" name="title" value="<?= old('title') ?>" 
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                       placeholder="Masukkan judul buku" required>
            </div>
            
            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-slate-700 mb-2">Kategori *</label>
                <select id="category_id" name="category_id" 
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['category_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Author -->
            <div>
                <label for="author" class="block text-sm font-medium text-slate-700 mb-2">Penulis *</label>
                <input type="text" id="author" name="author" value="<?= old('author') ?>" 
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                       placeholder="Nama penulis" required>
            </div>
            
            <!-- Publisher & Year -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="publisher" class="block text-sm font-medium text-slate-700 mb-2">Penerbit</label>
                    <input type="text" id="publisher" name="publisher" value="<?= old('publisher') ?>" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                           placeholder="Nama penerbit">
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-slate-700 mb-2">Tahun Terbit</label>
                    <input type="number" id="year" name="year" value="<?= old('year') ?>" min="1900" max="<?= date('Y') ?>"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                           placeholder="<?= date('Y') ?>">
                </div>
            </div>
            
            <!-- Price & Stock -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-slate-700 mb-2">Harga (Rp) *</label>
                    <input type="number" id="price" name="price" value="<?= old('price') ?>" min="0" step="1000"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                           placeholder="50000" required>
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-slate-700 mb-2">Stok *</label>
                    <input type="number" id="stock" name="stock" value="<?= old('stock') ?? 0 ?>" min="0"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                           placeholder="10" required>
                </div>
            </div>
            
            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all resize-none"
                          placeholder="Deskripsi singkat tentang buku..."><?= old('description') ?></textarea>
            </div>
            
            <!-- PDF File -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">File PDF (E-Book)</label>
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" 
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                        <p class="mt-2 text-xs text-slate-500">Format PDF. Maksimal 50MB. Pembeli bisa mengakses file ini setelah pembayaran.</p>
                    </div>
                </div>
            </div>
            
            <!-- Submit -->
            <div class="flex items-center space-x-4">
                <button type="submit" 
                        class="px-6 py-3 bg-primary-500 text-white rounded-xl font-semibold hover:bg-primary-600 transition-colors shadow-lg hover:shadow-xl">
                    Simpan Buku
                </button>
                <a href="/admin/books" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-medium hover:bg-slate-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function previewImage(input) {
    const preview = document.getElementById('preview-image');
    const placeholder = document.getElementById('preview-placeholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?= $this->endSection() ?>
