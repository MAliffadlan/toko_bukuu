<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Spacer for fixed navbar -->
<div class="h-20"></div>

<div class="container mx-auto px-4 py-12">
    <!-- Header -->
    <div class="text-center mb-12 animate-fade-in-up">
        <div class="w-20 h-20 bg-gradient-to-br from-primary-400 to-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Perpustakaan Saya</h1>
        <p class="text-slate-600">Akses semua buku yang sudah Anda beli</p>
    </div>
    
    <?php if (!empty($books)): ?>
    <!-- Book Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-8">
        <?php foreach ($books as $index => $book): ?>
        <div class="group bg-white rounded-3xl shadow-lg overflow-hidden card-glow transition-all duration-300 transform hover:scale-105 hover:shadow-2xl animate-fade-in-up" style="animation-delay: <?= $index * 0.05 ?>s;">
            <!-- Cover Image -->
            <div class="aspect-[3/4] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 relative">
                <?php if ($book['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])): ?>
                <img src="/uploads/covers/<?= esc($book['cover_image']) ?>" 
                     alt="<?= esc($book['title']) ?>" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <?php else: ?>
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <?php endif; ?>
                
                <!-- Owned Badge -->
                <span class="absolute top-3 left-3 px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-semibold rounded-full shadow-lg flex items-center space-x-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Dimiliki</span>
                </span>
                
                <!-- Hover Actions -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-end pb-6 space-y-3">
                    <?php if ($book['pdf_file']): ?>
                    <a href="/library/read/<?= $book['id'] ?>" 
                       class="px-6 py-2 bg-primary-500 text-white rounded-full text-sm font-medium hover:bg-primary-600 transition-colors transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Baca</span>
                    </a>
                    <a href="/library/download/<?= $book['id'] ?>" 
                       class="px-6 py-2 bg-white text-slate-800 rounded-full text-sm font-medium hover:bg-slate-100 transition-colors transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 delay-75 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span>Download</span>
                    </a>
                    <?php else: ?>
                    <span class="px-4 py-2 bg-slate-500/80 text-white rounded-full text-xs">PDF segera hadir</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Info -->
            <div class="p-5">
                <span class="text-xs text-primary-600 font-medium"><?= esc($book['category_name']) ?></span>
                <h3 class="font-bold text-slate-800 line-clamp-2 mt-1 leading-tight">
                    <?= esc($book['title']) ?>
                </h3>
                <p class="text-sm text-slate-500 mt-1"><?= esc($book['author']) ?></p>
                <p class="text-xs text-slate-400 mt-2">
                    Dibeli: <?= date('d M Y', strtotime($book['purchase_date'])) ?>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <!-- Empty State -->
    <div class="text-center py-20 animate-fade-in">
        <div class="w-40 h-40 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-8">
            <svg class="w-20 h-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-700 mb-2">Perpustakaan Kosong</h3>
        <p class="text-slate-500 mb-8 max-w-md mx-auto">Anda belum memiliki buku. Beli buku pertama Anda dan mulai membaca!</p>
        <a href="/browser" class="inline-flex items-center space-x-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl btn-press">
            <span>Jelajahi Katalog</span>
        </a>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
