<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'PDF Viewer') ?> - PDF Viewer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <style>
        * { font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background: #1f1f1f; margin: 0; }
        
        /* Toolbar */
        .pdf-toolbar {
            background: #2d2d2d;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .toolbar-btn {
            padding: 6px 10px;
            border-radius: 4px;
            color: #fff;
            font-size: 13px;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .toolbar-btn:hover { background: rgba(255,255,255,0.1); }
        .toolbar-btn:disabled { opacity: 0.4; cursor: not-allowed; }
        
        .toolbar-input {
            background: #3d3d3d;
            border: 1px solid #4d4d4d;
            border-radius: 4px;
            color: #fff;
            padding: 4px 8px;
            width: 60px;
            text-align: center;
            font-size: 13px;
        }
        .toolbar-input:focus { outline: none; border-color: #0078d4; }
        
        /* Canvas Container */
        #pdf-container {
            overflow: auto;
            height: calc(100vh - 48px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            gap: 20px;
        }
        
        .pdf-page {
            background: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }
        
        /* Loading */
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(31,31,31,0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }
        .loading-spinner {
            border: 4px solid #3d3d3d;
            border-top-color: #0078d4;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        
        /* Error */
        .error-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #fff;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay">
        <div class="loading-spinner mb-4"></div>
        <div class="text-white text-sm">Loading PDF...</div>
    </div>
    
    <!-- Toolbar -->
    <div class="pdf-toolbar h-12 flex items-center justify-between px-4">
        <!-- Left: File info -->
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 2l5 5h-5V4zM6 20V4h6v6h6v10H6z"/>
            </svg>
            <span class="text-white text-sm font-medium truncate max-w-[200px]"><?= esc($title ?? 'Document') ?></span>
        </div>
        
        <!-- Center: Navigation -->
        <div class="flex items-center gap-2">
            <button class="toolbar-btn" onclick="prevPage()" id="btn-prev" title="Previous Page">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            </button>
            
            <div class="flex items-center gap-1 text-white text-sm">
                <input type="number" id="page-input" class="toolbar-input" value="1" min="1" onchange="goToPage(this.value)">
                <span class="text-white/60">/ <span id="page-count">0</span></span>
            </div>
            
            <button class="toolbar-btn" onclick="nextPage()" id="btn-next" title="Next Page">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </button>
            
            <div class="w-px h-6 bg-white/20 mx-2"></div>
            
            <button class="toolbar-btn" onclick="zoomOut()" title="Zoom Out">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></svg>
            </button>
            
            <select id="zoom-select" class="toolbar-input !w-20" onchange="setZoom(this.value)">
                <option value="0.5">50%</option>
                <option value="0.75">75%</option>
                <option value="1" selected>100%</option>
                <option value="1.25">125%</option>
                <option value="1.5">150%</option>
                <option value="2">200%</option>
            </select>
            
            <button class="toolbar-btn" onclick="zoomIn()" title="Zoom In">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
            </button>
        </div>
        
        <!-- Right: Actions -->
        <div class="flex items-center gap-1">
            <button class="toolbar-btn" onclick="printPdf()" title="Print">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-4 0H8m0 0v4h8v-4"/></svg>
                <span class="hidden sm:inline">Print</span>
            </button>
            
            <button class="toolbar-btn" onclick="downloadPdf()" title="Download">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                <span class="hidden sm:inline">Download</span>
            </button>
        </div>
    </div>
    
    <!-- PDF Container -->
    <div id="pdf-container"></div>
    
    <!-- Error Container (hidden by default) -->
    <div id="error-container" class="error-container hidden">
        <svg class="w-16 h-16 text-red-400 mb-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        <h2 class="text-xl font-medium mb-2">Unable to load PDF</h2>
        <p class="text-white/60 text-sm mb-4">The PDF file could not be loaded. Please try again.</p>
        <button onclick="location.reload()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
            Retry
        </button>
    </div>

    <script>
        // PDF.js worker
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        
        // State
        let pdfDoc = null;
        let currentPage = 1;
        let totalPages = 0;
        let currentScale = 1;
        const pdfUrl = <?= json_encode($pdfUrl ?? null) ?>;
        
        // Elements
        const container = document.getElementById('pdf-container');
        const loadingOverlay = document.getElementById('loading-overlay');
        const errorContainer = document.getElementById('error-container');
        const pageInput = document.getElementById('page-input');
        const pageCount = document.getElementById('page-count');
        const zoomSelect = document.getElementById('zoom-select');
        
        // Load PDF
        async function loadPdf() {
            if (!pdfUrl) {
                showError();
                return;
            }
            
            try {
                pdfDoc = await pdfjsLib.getDocument(pdfUrl).promise;
                totalPages = pdfDoc.numPages;
                pageCount.textContent = totalPages;
                pageInput.max = totalPages;
                
                // Render all pages
                await renderAllPages();
                
                loadingOverlay.classList.add('hidden');
            } catch (error) {
                console.error('Error loading PDF:', error);
                showError();
            }
        }
        
        // Render all pages
        async function renderAllPages() {
            container.innerHTML = '';
            
            for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
                const page = await pdfDoc.getPage(pageNum);
                const viewport = page.getViewport({ scale: currentScale * 1.5 });
                
                const canvas = document.createElement('canvas');
                canvas.className = 'pdf-page';
                canvas.id = `page-${pageNum}`;
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                
                const ctx = canvas.getContext('2d');
                await page.render({ canvasContext: ctx, viewport: viewport }).promise;
                
                container.appendChild(canvas);
            }
        }
        
        // Navigation
        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                scrollToPage(currentPage);
            }
        }
        
        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                scrollToPage(currentPage);
            }
        }
        
        function goToPage(num) {
            const page = parseInt(num);
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                scrollToPage(currentPage);
            }
        }
        
        function scrollToPage(num) {
            const pageEl = document.getElementById(`page-${num}`);
            if (pageEl) {
                pageEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                pageInput.value = num;
            }
        }
        
        // Zoom
        function zoomIn() {
            const options = [0.5, 0.75, 1, 1.25, 1.5, 2];
            const idx = options.indexOf(currentScale);
            if (idx < options.length - 1) {
                setZoom(options[idx + 1]);
                zoomSelect.value = options[idx + 1];
            }
        }
        
        function zoomOut() {
            const options = [0.5, 0.75, 1, 1.25, 1.5, 2];
            const idx = options.indexOf(currentScale);
            if (idx > 0) {
                setZoom(options[idx - 1]);
                zoomSelect.value = options[idx - 1];
            }
        }
        
        async function setZoom(scale) {
            currentScale = parseFloat(scale);
            await renderAllPages();
            scrollToPage(currentPage);
        }
        
        // Print
        function printPdf() {
            window.print();
        }
        
        // Download
        function downloadPdf() {
            if (pdfUrl) {
                const a = document.createElement('a');
                a.href = pdfUrl;
                a.download = <?= json_encode($filename ?? 'document.pdf') ?>;
                a.click();
            }
        }
        
        // Show error
        function showError() {
            loadingOverlay.classList.add('hidden');
            container.classList.add('hidden');
            document.querySelector('.pdf-toolbar').classList.add('hidden');
            errorContainer.classList.remove('hidden');
        }
        
        // Track scroll position for page number
        container.addEventListener('scroll', () => {
            const pages = container.querySelectorAll('.pdf-page');
            for (let i = 0; i < pages.length; i++) {
                const rect = pages[i].getBoundingClientRect();
                if (rect.top >= 0 && rect.top < window.innerHeight / 2) {
                    currentPage = i + 1;
                    pageInput.value = currentPage;
                    break;
                }
            }
        });
        
        // Initialize
        loadPdf();
    </script>
</body>
</html>
