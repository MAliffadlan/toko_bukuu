<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Spacer for fixed navbar -->
<div class="h-20"></div>

<div class="min-h-screen bg-slate-900">
    <!-- Header Bar -->
    <div class="bg-slate-800 border-b border-slate-700 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="/library" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-white font-semibold truncate max-w-xs md:max-w-md"><?= esc($book['title']) ?></h1>
                <p class="text-slate-400 text-sm"><?= esc($book['author']) ?></p>
            </div>
        </div>
        
        <div class="flex items-center space-x-2">
            <a href="/library/download/<?= $book['id'] ?>" 
               class="hidden md:flex items-center space-x-2 px-4 py-2 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span>Download PDF</span>
            </a>
            <button onclick="toggleFullscreen()" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="fullscreen-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- PDF Viewer -->
    <div class="pdf-container" id="pdf-container" style="height: calc(100vh - 140px);">
        <?php 
        $pdfPath = '/uploads/pdfs/' . $book['pdf_file'];
        $pdfExists = file_exists(FCPATH . 'uploads/pdfs/' . $book['pdf_file']);
        ?>
        
        <?php if ($pdfExists): ?>
        <iframe 
            src="<?= $pdfPath ?>#toolbar=0&navpanes=0" 
            class="w-full h-full border-0"
            title="<?= esc($book['title']) ?>"
        ></iframe>
        <?php else: ?>
        <div class="flex items-center justify-center h-full">
            <div class="text-center">
                <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">File PDF Tidak Tersedia</h3>
                <p class="text-slate-400 mb-6">Maaf, file PDF untuk buku ini belum tersedia.</p>
                <a href="/library" class="px-6 py-3 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors">
                    Kembali ke Perpustakaan
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function toggleFullscreen() {
    const container = document.getElementById('pdf-container');
    const icon = document.getElementById('fullscreen-icon');
    
    if (!document.fullscreenElement) {
        container.requestFullscreen().then(() => {
            container.style.height = '100vh';
        });
    } else {
        document.exitFullscreen().then(() => {
            container.style.height = 'calc(100vh - 140px)';
        });
    }
}

document.addEventListener('fullscreenchange', () => {
    const container = document.getElementById('pdf-container');
    if (!document.fullscreenElement) {
        container.style.height = 'calc(100vh - 140px)';
    }
});
</script>
<?= $this->endSection() ?>
