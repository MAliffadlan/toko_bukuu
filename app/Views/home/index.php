<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Hero Banner Carousel -->
<section class="relative pt-20 bg-gradient-to-b from-slate-100 to-white">
    <div class="container mx-auto px-4 py-8">
        <!-- Main Banner Slider -->
        <div class="relative rounded-3xl overflow-hidden shadow-2xl" id="hero-carousel">
            <!-- Slides Container -->
            <div class="relative h-[400px] md:h-[450px] overflow-hidden">
                <!-- Slide 1 -->
                <div class="carousel-slide absolute inset-0 transition-all duration-700 ease-in-out opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-800/95 to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-900/30 to-accent-900/30"></div>
                    <div class="relative z-20 h-full flex items-center">
                        <div class="px-8 md:px-16 max-w-2xl">
                            <span class="inline-block px-4 py-1 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-full text-sm font-bold mb-4">BEST SELLER</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                                Koleksi Buku<br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-400">Terlaris 2026</span>
                            </h2>
                            <p class="text-white/70 mb-6 text-lg">Temukan buku-buku bestseller pilihan pembaca Indonesia</p>
                            <a href="/browser#katalog" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg hover:shadow-xl">
                                Lihat Katalog
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                        <div class="hidden md:block absolute right-10 top-1/2 -translate-y-1/2">
                            <div class="relative">
                                <div class="w-48 h-64 bg-gradient-to-br from-primary-400 to-accent-500 rounded-2xl shadow-2xl transform rotate-6"></div>
                                <div class="absolute inset-0 w-48 h-64 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-2xl transform -rotate-6 -translate-x-4 translate-y-4 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="carousel-slide absolute inset-0 transition-all duration-700 ease-in-out opacity-0 translate-x-full">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-800/95 to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-green-900/30 to-teal-900/30"></div>
                    <div class="relative z-20 h-full flex items-center">
                        <div class="px-8 md:px-16 max-w-2xl">
                            <span class="inline-block px-4 py-1 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-full text-sm font-bold mb-4">PROMO SPESIAL</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                                Diskon Hingga<br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400">50% Off!</span>
                            </h2>
                            <p class="text-white/70 mb-6 text-lg">Promo spesial awal tahun untuk semua kategori buku</p>
                            <a href="/browser#katalog" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:from-green-600 hover:to-emerald-700 transition-all shadow-lg hover:shadow-xl">
                                Belanja Sekarang
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                        <div class="hidden md:block absolute right-10 top-1/2 -translate-y-1/2">
                            <div class="text-8xl font-black text-white/20">50%</div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 3 -->
                <div class="carousel-slide absolute inset-0 transition-all duration-700 ease-in-out opacity-0 translate-x-full">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-800/95 to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-900/30 to-indigo-900/30"></div>
                    <div class="relative z-20 h-full flex items-center">
                        <div class="px-8 md:px-16 max-w-2xl">
                            <span class="inline-block px-4 py-1 bg-gradient-to-r from-purple-500 to-indigo-500 text-white rounded-full text-sm font-bold mb-4">BARU RILIS</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                                E-Book Digital<br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400">Baca Di Mana Saja</span>
                            </h2>
                            <p class="text-white/70 mb-6 text-lg">Nikmati kemudahan membaca buku digital langsung dari browser</p>
                            <a href="/library" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl">
                                Perpustakaan Saya
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                        <div class="hidden md:block absolute right-10 top-1/2 -translate-y-1/2">
                            <svg class="w-32 h-32 text-purple-400/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Arrows -->
            <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <!-- Dots Indicator -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-30 flex space-x-2">
                <button onclick="goToSlide(0)" class="carousel-dot w-3 h-3 rounded-full bg-white transition-all duration-300"></button>
                <button onclick="goToSlide(1)" class="carousel-dot w-3 h-3 rounded-full bg-white/40 transition-all duration-300"></button>
                <button onclick="goToSlide(2)" class="carousel-dot w-3 h-3 rounded-full bg-white/40 transition-all duration-300"></button>
            </div>
        </div>
        
        <!-- Mini Banner Auto-Scroll (Marquee) -->
        <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-lg border border-slate-200 p-1">
            <div class="mini-scroll-container overflow-hidden">
                <div class="flex animate-marquee space-x-6 py-4 min-w-full">
                    <!-- Items -->
                    <?php 
                    $items = [
                        ['color' => 'orange', 'icon' => '🔥', 'title' => 'Flash Sale!', 'desc' => 'Diskon 30%'],
                        ['color' => 'blue', 'icon' => '📚', 'title' => 'Buku Baru', 'desc' => 'Rilis Minggu Ini'],
                        ['color' => 'green', 'icon' => '✨', 'title' => 'Gratis Ongkir', 'desc' => 'Min. Pembelian 100rb'],
                        ['color' => 'purple', 'icon' => '🎁', 'title' => 'Member Reward', 'desc' => 'Bonus Poin 2x'],
                        ['color' => 'yellow', 'icon' => '📖', 'title' => 'E-Book Ready', 'desc' => 'Baca Langsung'],
                    ];
                    // Repeat items 3 times for smooth infinite scroll
                    $displayItems = array_merge($items, $items, $items);
                    ?>
                    
                    <?php foreach($displayItems as $item): ?>
                    <a href="/browser#katalog" class="flex-shrink-0 group relative px-6 py-4 bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl flex items-center space-x-4 hover:bg-white hover:border-<?php echo $item['color']; ?>-200 hover:shadow-xl transition-all duration-300 shadow-sm">
                        <div class="w-12 h-12 rounded-xl bg-<?php echo $item['color']; ?>-50 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300 border border-<?php echo $item['color']; ?>-100/50">
                            <?= $item['icon'] ?>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 group-hover:text-primary-600 transition-colors"><?= $item['title'] ?></p>
                            <p class="text-xs text-slate-500 font-medium"><?= $item['desc'] ?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="bg-white py-12">
    <div class="container mx-auto px-4">
        <form action="/browser" method="get" class="max-w-3xl mx-auto">
            <div class="relative group">
                <input type="text" name="search" value="<?= esc($search ?? '') ?>" 
                       placeholder="Cari judul buku, nama penulis, atau genre..." 
                       class="w-full pl-14 pr-6 py-5 text-lg bg-white rounded-2xl border-2 border-transparent focus:border-primary-400 focus:ring-4 focus:ring-primary-100 outline-none transition-all duration-300 shadow-2xl text-slate-800 placeholder-slate-400">
                <svg class="absolute left-5 top-5 w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <button type="submit" class="absolute right-3 top-3 px-6 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-300 btn-press">
                    Cari
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Catalog Section -->
<section id="katalog" class="py-16 bg-slate-50">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-12 animate-fade-in-up">
            <?php if (isset($currentCategory)): ?>
                <span class="inline-block px-4 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4">Kategori</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4"><?= esc($currentCategory['category_name']) ?></h2>
            <?php elseif (!empty($search)): ?>
                <span class="inline-block px-4 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4">Hasil Pencarian</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">Hasil untuk "<?= esc($search) ?>"</h2>
            <?php else: ?>
                <span class="inline-block px-4 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-4">Koleksi Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">Katalog Buku Terlengkap</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Temukan buku impian Anda dari berbagai kategori pilihan</p>
            <?php endif; ?>
        </div>
        
        <!-- Category Pills -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <a href="/browser" class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 btn-press <?= empty($categoryId) && empty($search) ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 hover:border-primary-300' ?>">
                Semua Buku
            </a>
            <?php foreach ($categories as $cat): ?>
            <a href="/category/<?= esc($cat['slug']) ?>" 
               class="px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 btn-press <?= ($categoryId ?? null) == $cat['id'] ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 hover:border-primary-300' ?>">
                <?= esc($cat['category_name']) ?>
            </a>
            <?php endforeach; ?>
        </div>
        
        <!-- Books Grid -->
        <?php if (!empty($books)): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-8">
            <?php foreach ($books as $index => $book): ?>
            <div class="group bg-white rounded-3xl shadow-lg overflow-hidden card-glow transition-all duration-300 transform hover:scale-105 hover:shadow-2xl animate-fade-in-up" style="animation-delay: <?= $index * 0.05 ?>s;">
                <!-- Cover Image -->
                <a href="/book/<?= esc($book['slug']) ?>" class="block aspect-[3/4] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 relative">
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
                    
                    <!-- Category Badge -->
                    <span class="absolute top-3 left-3 px-3 py-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-xs font-semibold rounded-full shadow-lg">
                        <?= esc($book['category_name']) ?>
                    </span>
                    
                    <!-- Quick View Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                        <span class="px-4 py-2 bg-white text-slate-800 rounded-full text-sm font-medium transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            Lihat Detail →
                        </span>
                    </div>
                </a>
                
                <!-- Info -->
                <div class="p-5">
                    <h3 class="font-bold text-slate-800 line-clamp-2 mb-1 group-hover:text-primary-600 transition-colors leading-tight">
                        <a href="/book/<?= esc($book['slug']) ?>"><?= esc($book['title']) ?></a>
                    </h3>
                    <p class="text-sm text-slate-500 mb-3"><?= esc($book['author']) ?></p>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                                Rp <?= number_format($book['price'], 0, ',', '.') ?>
                            </span>
                        </div>
                        <?php if ($book['stock'] > 0): ?>
                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-medium">Tersedia</span>
                        <?php else: ?>
                        <span class="text-xs text-red-600 bg-red-50 px-2 py-1 rounded-full font-medium">Habis</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <?= $pager->links() ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20 animate-fade-in">
            <div class="w-32 h-32 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-700 mb-2">Buku Tidak Ditemukan</h3>
            <p class="text-slate-500 mb-6">Coba gunakan kata kunci lain atau jelajahi kategori kami</p>
            <a href="/browser" class="inline-flex items-center space-x-2 px-6 py-3 bg-primary-500 text-white rounded-xl font-semibold hover:bg-primary-600 transition-colors btn-press">
                <span>Lihat Semua Buku</span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Hero Carousel
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.carousel-dot');
const totalSlides = slides.length;

function updateSlides() {
    slides.forEach((slide, index) => {
        slide.classList.remove('opacity-100', 'opacity-0', 'translate-x-0', 'translate-x-full', '-translate-x-full');
        if (index === currentSlide) {
            slide.classList.add('opacity-100', 'translate-x-0');
        } else if (index < currentSlide) {
            slide.classList.add('opacity-0', '-translate-x-full');
        } else {
            slide.classList.add('opacity-0', 'translate-x-full');
        }
    });
    
    dots.forEach((dot, index) => {
        dot.classList.toggle('bg-white', index === currentSlide);
        dot.classList.toggle('bg-white/40', index !== currentSlide);
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateSlides();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateSlides();
}

function goToSlide(index) {
    currentSlide = index;
    updateSlides();
}

// Auto-play carousel
setInterval(nextSlide, 5000);
</script>

<style>
/* Marquee Animation for Mini Banner */
@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.animate-marquee {
    animation: marquee 20s linear infinite;
}

.mini-scroll-container:hover .animate-marquee {
    animation-play-state: paused;
}
</style>
<?= $this->endSection() ?>
