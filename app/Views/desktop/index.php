<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TokoBuku - Windows 11</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; user-select: none; }
        
        /* Windows 11 Bloom Wallpaper */
        .win11-bloom { background: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=1920&q=80') center/cover no-repeat fixed; }
        .win11-bloom-fallback { background: radial-gradient(ellipse at 30% 80%, #6366f1 0%, transparent 50%), radial-gradient(ellipse at 70% 20%, #0ea5e9 0%, transparent 40%), linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); }
        
        /* Acrylic Effect */
        .acrylic-dark { background: rgba(28, 43, 57, 0.75); backdrop-filter: blur(30px) saturate(180%); -webkit-backdrop-filter: blur(30px) saturate(180%); }
        
        /* Animations */
        .window-animate-in { animation: windowPopIn 0.3s cubic-bezier(0.16,1,0.3,1) forwards; }
        @keyframes windowPopIn { 0% { opacity:0; transform:scale(0.95) translateY(20px); } 100% { opacity:1; transform:scale(1) translateY(0); } }
        .window-animate-out { animation: windowPopOut 0.2s ease-out forwards; }
        @keyframes windowPopOut { 100% { opacity:0; transform:scale(0.95); } }
        .start-menu-animate { animation: slideUp 0.2s cubic-bezier(0.16,1,0.3,1) forwards; }
        @keyframes slideUp { 0% { opacity:0; transform:translateY(10px); } 100% { opacity:1; transform:translateY(0); } }
        
        /* Taskbar Icon */
        .taskbar-icon { width: 44px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 4px; transition: all 0.15s ease; position: relative; }
        .taskbar-icon:hover { background: rgba(255, 255, 255, 0.1); }
        .taskbar-icon:active { background: rgba(255, 255, 255, 0.05); transform: scale(0.95); }
        .taskbar-icon.active::after { content: ''; position: absolute; bottom: 2px; left: 50%; transform: translateX(-50%); width: 16px; height: 3px; background: linear-gradient(90deg, #60CDFF, #0078D4); border-radius: 2px; box-shadow: 0 0 8px rgba(96, 205, 255, 0.6); }
        
        /* Desktop Icon */
        .desktop-icon { transition: all 0.15s ease; border-radius: 4px; }
        .desktop-icon:hover { background: rgba(255, 255, 255, 0.08); }
        
        /* Browser Tab */
        .browser-tab { min-width: 100px; max-width: 180px; height: 34px; padding: 0 10px; display: flex; align-items: center; border-radius: 8px 8px 0 0; cursor: pointer; transition: all 0.15s ease; background: rgba(255,255,255,0.05); }
        .browser-tab.active { background: #202020; }
        .browser-tab:not(.active):hover { background: rgba(255,255,255,0.1); }
        .browser-tab .close-btn { opacity: 0; transition: opacity 0.15s; }
        .browser-tab:hover .close-btn { opacity: 1; }
        
        /* Window Controls */
        .win-ctrl { width: 46px; height: 32px; display: flex; align-items: center; justify-content: center; transition: background 0.1s; }
        .win-ctrl:hover { background: rgba(255,255,255,0.1); }
        .win-ctrl.close:hover { background: #c42b1c; }
        
        /* Loading Spinner */
        .spinner { border: 2px solid rgba(255,255,255,0.1); border-top-color: #60CDFF; border-radius: 50%; width: 16px; height: 16px; animation: spin 0.6s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        
        /* Tab Frame */
        .tab-frame { display: none; position: absolute; inset: 0; }
        .tab-frame.active { display: block; }
        
        /* ========== RESIZE HANDLES ========== */
        .resize-handle { position: absolute; z-index: 50; }
        .resize-handle:hover { background: rgba(96, 205, 255, 0.1); }
        
        /* Edge handles */
        .resize-n { top: 0; left: 8px; right: 8px; height: 5px; cursor: n-resize; }
        .resize-s { bottom: 0; left: 8px; right: 8px; height: 5px; cursor: s-resize; }
        .resize-w { left: 0; top: 8px; bottom: 8px; width: 5px; cursor: w-resize; }
        .resize-e { right: 0; top: 8px; bottom: 8px; width: 5px; cursor: e-resize; }
        
        /* Corner handles */
        .resize-nw { top: 0; left: 0; width: 10px; height: 10px; cursor: nw-resize; }
        .resize-ne { top: 0; right: 0; width: 10px; height: 10px; cursor: ne-resize; }
        .resize-sw { bottom: 0; left: 0; width: 10px; height: 10px; cursor: sw-resize; }
        .resize-se { bottom: 0; right: 0; width: 10px; height: 10px; cursor: se-resize; }
        
        /* Disable transitions during resize */
        .resizing, .resizing * { transition: none !important; }
        
        /* Disable iframe pointer events during resize/drag */
        .no-pointer iframe { pointer-events: none; }
        
        /* ========== BOOT & LOCK SCREEN STYLES ========== */
        /* Windows 11 Spotlight Lock Screen */
        .win11-lockscreen { 
            background: url('/wallpapers/blue-wave.jpg') center/cover no-repeat;
        }
        
        /* Lock screen time font */
        .lock-time { font-family: 'Segoe UI Light', 'Segoe UI', system-ui, sans-serif; font-weight: 300; }
        
        /* Smooth transitions */
        .boot-fade { transition: opacity 0.7s ease; }
        .lock-slide { transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
        
        /* ========== CALENDAR FLYOUT STYLES ========== */
        .calendar-flyout {
            background: rgba(32, 32, 32, 0.85);
            backdrop-filter: blur(40px) saturate(180%);
            -webkit-backdrop-filter: blur(40px) saturate(180%);
        }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
        .calendar-day { 
            width: 36px; height: 36px; 
            display: flex; align-items: center; justify-content: center; 
            border-radius: 50%; cursor: pointer; transition: all 0.15s; 
            font-size: 13px;
        }
        .calendar-day:hover:not(.today):not(.other-month) { background: rgba(255,255,255,0.1); }
        .calendar-day.today { background: #0078D4; color: white; font-weight: 600; }
        .calendar-day.other-month { color: rgba(255,255,255,0.3); }
        .calendar-animate-in { animation: calendarSlideUp 0.2s cubic-bezier(0.16,1,0.3,1) forwards; }
        .calendar-animate-out { animation: calendarSlideDown 0.15s ease-out forwards; }
        @keyframes calendarSlideUp { 0% { opacity:0; transform:translateY(10px); } 100% { opacity:1; transform:translateY(0); } }
        @keyframes calendarSlideDown { 100% { opacity:0; transform:translateY(10px); } }
        
        /* ========== FILE EXPLORER & SETTINGS STYLES ========== */
        .win-window {
            background: rgba(32, 32, 32, 0.95);
            backdrop-filter: blur(40px) saturate(180%);
            -webkit-backdrop-filter: blur(40px) saturate(180%);
        }
        .explorer-sidebar { background: rgba(40, 40, 40, 0.9); }
        .explorer-item { transition: all 0.1s ease; }
        .explorer-item:hover { background: rgba(255,255,255,0.08); }
        .explorer-item.active { background: rgba(96, 205, 255, 0.15); }
        .file-item { transition: all 0.1s ease; }
        .file-item:hover { background: rgba(255,255,255,0.05); }
        .file-item.selected { background: rgba(96, 205, 255, 0.2); }
        .settings-nav-item { transition: all 0.1s ease; border-left: 3px solid transparent; }
        .settings-nav-item:hover { background: rgba(255,255,255,0.05); }
        .settings-nav-item.active { background: rgba(96, 205, 255, 0.1); border-left-color: #60CDFF; }
        .wallpaper-option { transition: all 0.15s ease; border: 2px solid transparent; }
        .wallpaper-option:hover { border-color: rgba(255,255,255,0.3); }
        .wallpaper-option.selected { border-color: #60CDFF; box-shadow: 0 0 0 2px rgba(96,205,255,0.3); }
    </style>
</head>
<body class="win11-bloom win11-bloom-fallback h-screen w-screen overflow-hidden flex flex-col">

    <!-- ==================== STARTUP BOOT SCREEN (z-[100]) ==================== -->
    <div id="boot-screen" class="fixed inset-0 z-[100] bg-black flex flex-col items-center justify-center boot-fade">
        <!-- Windows 11 Logo -->
        <svg class="w-24 h-24 mb-12" viewBox="0 0 88 88" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 12.5L35.7 7.8V42.3H0V12.5Z" fill="#0078D4"/>
            <path d="M40 7.2L88 0V42.3H40V7.2Z" fill="#0078D4"/>
            <path d="M0 46.2H35.7V80.7L0 76V46.2Z" fill="#0078D4"/>
            <path d="M40 46.2H88V88L40 81.2V46.2Z" fill="#0078D4"/>
        </svg>
        <!-- Loading Spinner -->
        <div class="w-8 h-8 border-[3px] border-white/20 border-t-white rounded-full animate-spin"></div>
    </div>

    <!-- ==================== LOCK SCREEN (z-[90]) ==================== -->
    <div id="lock-screen" class="fixed inset-0 z-[90] win11-lockscreen flex flex-col items-center justify-between py-16 cursor-pointer lock-slide">
        <!-- Time & Date (Center-Top) -->
        <!-- Time & Date (Center-Top) -->
        <div class="flex flex-col items-center mt-32 text-white text-center">
            <div id="lock-time" class="lock-time text-[96px] leading-none drop-shadow-lg font-semibold">00:00</div>
            <div id="lock-date" class="text-2xl font-light mt-4 drop-shadow-md">Loading...</div>
        </div>
        
        <!-- Unlock Hint (Hidden) -->
        <div class="text-white/80 text-sm mb-8 animate-pulse hidden">Click anywhere or press any key to unlock</div>
        
        <!-- System Tray Icons (Bottom-Right) -->
        <div class="absolute bottom-4 right-6 flex items-center gap-3">
            <!-- Wi-Fi Icon -->
            <svg class="w-5 h-5 text-white drop-shadow" fill="currentColor" viewBox="0 0 24 24">
                <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/>
            </svg>
            <!-- Battery Icon -->
            <svg class="w-5 h-5 text-white drop-shadow" fill="currentColor" viewBox="0 0 24 24">
                <path d="M15.67 4H14V2h-4v2H8.33C7.6 4 7 4.6 7 5.33v15.33C7 21.4 7.6 22 8.33 22h7.33c.74 0 1.34-.6 1.34-1.33V5.33C17 4.6 16.4 4 15.67 4zM9 20V6h6v14H9z"/>
            </svg>
        </div>
    </div>

    <!-- Desktop Area -->
    <div class="flex-1 p-3 relative" id="desktop-area">
        <div class="flex flex-col gap-1 w-20">
            <!-- This PC / File Explorer -->
            <div class="desktop-icon flex flex-col items-center p-2 cursor-pointer" ondblclick="appManager.open('explorer')">
                <svg class="w-11 h-11 drop-shadow" viewBox="0 0 48 48">
                    <rect x="4" y="12" width="40" height="28" rx="2" fill="#FFC107"/>
                    <path d="M4 14a2 2 0 012-2h12l4 4h22a2 2 0 012 2v20a2 2 0 01-2 2H6a2 2 0 01-2-2V14z" fill="#FFD54F"/>
                </svg>
                <span class="text-white text-[11px] text-center mt-1 drop-shadow-lg">This PC</span>
            </div>
            <!-- Recycle Bin -->
            <div class="desktop-icon flex flex-col items-center p-2 cursor-pointer">
                <svg class="w-11 h-11 drop-shadow" viewBox="0 0 48 48"><path d="M12 14h24v26c0 2-2 4-4 4H16c-2 0-4-2-4-4V14z" fill="#607d8b"/><rect x="10" y="10" width="28" height="4" rx="1" fill="#78909c"/></svg>
                <span class="text-white text-[11px] text-center mt-1 drop-shadow-lg">Recycle Bin</span>
            </div>
            <!-- Edge Browser -->
            <div class="desktop-icon flex flex-col items-center p-2 cursor-pointer" ondblclick="windowsManager.openBrowser()">
                <svg class="w-11 h-11 drop-shadow" viewBox="0 0 48 48"><defs><linearGradient id="edgeGrad1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#0C59A4"/><stop offset="100%" stop-color="#1B9CE2"/></linearGradient><linearGradient id="edgeGrad2" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" stop-color="#1B9CE2"/><stop offset="100%" stop-color="#3DCFCF"/></linearGradient></defs><path d="M44 24c0 11-9 20-20 20-8.3 0-15.4-5-18.5-12.2 1.8 3.8 5.7 6.4 10.2 6.4 6.2 0 11.3-5 11.3-11.2 0-2-.5-3.8-1.5-5.4C29.5 18 35.5 14 42.5 14c.5 0 1 0 1.5.1V24z" fill="url(#edgeGrad2)"/><path d="M4 24c0-11 9-20 20-20 7.4 0 13.8 4 17.3 10-6-4.5-14-5-20.5-1.5C14.5 16 10 22.5 10 30c0 2.8.8 5.5 2.2 7.8C6 34 4 29.3 4 24z" fill="url(#edgeGrad1)"/></svg>
                <span class="text-white text-[11px] text-center mt-1 drop-shadow-lg">Edge</span>
            </div>
            <!-- Settings -->
            <div class="desktop-icon flex flex-col items-center p-2 cursor-pointer" ondblclick="appManager.open('settings')">
                <svg class="w-11 h-11 drop-shadow" viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="18" fill="#455A64"/>
                    <circle cx="24" cy="24" r="8" fill="#78909C"/>
                    <g fill="#CFD8DC">
                        <rect x="22" y="4" width="4" height="8" rx="1"/>
                        <rect x="22" y="36" width="4" height="8" rx="1"/>
                        <rect x="4" y="22" width="8" height="4" rx="1"/>
                        <rect x="36" y="22" width="8" height="4" rx="1"/>
                        <rect x="9" y="9" width="4" height="8" rx="1" transform="rotate(-45 11 13)"/>
                        <rect x="35" y="31" width="4" height="8" rx="1" transform="rotate(-45 37 35)"/>
                        <rect x="9" y="31" width="4" height="8" rx="1" transform="rotate(45 11 35)"/>
                        <rect x="35" y="9" width="4" height="8" rx="1" transform="rotate(45 37 13)"/>
                    </g>
                </svg>
                <span class="text-white text-[11px] text-center mt-1 drop-shadow-lg">Settings</span>
            </div>
            <!-- Terminal -->
            <div class="desktop-icon flex flex-col items-center p-2 cursor-pointer" ondblclick="appManager.open('terminal')">
                <svg class="w-11 h-11 drop-shadow" viewBox="0 0 48 48">
                    <rect x="4" y="8" width="40" height="32" rx="2" fill="#333333"/>
                    <rect x="4" y="8" width="40" height="6" rx="2" fill="#444444"/>
                    <path d="M10 20L16 26L10 32" stroke="#4CC2FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="20" y1="32" x2="30" y2="32" stroke="#4CC2FF" stroke-width="3" stroke-linecap="round"/>
                </svg>
                <span class="text-white text-[11px] text-center mt-1 drop-shadow-lg">Terminal</span>
            </div>
        </div>
        <div id="windows-container"></div>
    </div>

    <!-- About Modal -->
    <div id="about-modal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[50] bg-[#202020] rounded-xl shadow-2xl w-[500px] border border-white/10 p-6 flex flex-col">
        <h2 class="text-xl font-semibold text-white mb-4">About</h2>
        <div class="space-y-4 text-sm text-gray-300">
            <p>Windows 11 Web Simulation built with CodeIgniter 4 & Tailwind CSS.</p>
            <p>Project by Alif, Diko, Nopen, Wisnu - Management Informatics.</p>
            <p>Not affiliated with Microsoft.</p>
        </div>
        <div class="mt-6 flex justify-end">
            <button onclick="closeAboutModal()" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-md transition font-medium text-sm">Ok, I understand</button>
        </div>
    </div>

    <!-- Context Menu -->
    <div id="context-menu" class="hidden fixed w-48 bg-[#2b2b2b]/95 backdrop-blur-xl border border-white/10 rounded-lg shadow-2xl py-1.5 z-[200] text-sm text-white select-none origin-top-left transition-all duration-100">
        <div class="px-1">
            <div class="flex items-center px-3 py-1.5 hover:bg-white/10 rounded-md cursor-pointer gap-3 opacity-50">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                <span>View</span>
                <span class="ml-auto text-xs">›</span>
            </div>
            <div class="flex items-center px-3 py-1.5 hover:bg-white/10 rounded-md cursor-pointer gap-3 opacity-50">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M3 12h12M3 18h6"/></svg>
                <span>Sort by</span>
                <span class="ml-auto text-xs">›</span>
            </div>
            <div class="flex items-center px-3 py-1.5 hover:bg-white/10 rounded-md cursor-pointer gap-3" onclick="window.location.reload()">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                <span>Refresh</span>
            </div>
        </div>
        <div class="h-[1px] bg-white/10 my-1 mx-1"></div>
        <div class="px-1">
            <div class="flex items-center px-3 py-1.5 hover:bg-white/10 rounded-md cursor-pointer gap-3" onclick="appManager.open('settings')">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1Z"/></svg>
                <span>Personalize</span>
            </div>
            <div class="flex items-center px-3 py-1.5 hover:bg-white/10 rounded-md cursor-pointer gap-3" onclick="windowsManager.openBrowser()">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1 4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                <span>Open Browser</span>
            </div>
        </div>
    </div>

    <!-- Start Menu (Windows 11 Style with Pinned Apps) -->
    <div id="start-menu" class="hidden fixed bottom-14 left-0 right-0 mx-auto w-[640px] rounded-xl border border-white/10 shadow-2xl z-[100] start-menu-animate overflow-hidden" style="background: rgba(32, 32, 32, 0.85); backdrop-filter: blur(40px) saturate(180%);">
        <!-- Search Bar -->
        <div class="p-6 pb-4">
            <div class="bg-white/5 hover:bg-white/10 rounded-full px-4 py-2.5 flex items-center cursor-text border border-white/5">
                <svg class="w-4 h-4 text-white/50 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round"/></svg>
                <span class="text-white/40 text-sm">Type here to search</span>
            </div>
        </div>
        
        <!-- Pinned Section -->
        <div class="px-6 pb-2">
            <div class="flex justify-between items-center mb-3">
                <span class="text-white text-sm font-semibold">Pinned</span>
                <button class="text-xs text-white/60 hover:text-white hover:bg-white/10 px-3 py-1 rounded-md transition">All apps &rarr;</button>
            </div>
            <div class="grid grid-cols-6 gap-1">
                <!-- Row 1 -->
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition" onclick="windowsManager.openBrowser(); windowsManager.toggleStartMenu();">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><defs><linearGradient id="smEdge" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#0C59A4"/><stop offset="100%" stop-color="#1B9CE2"/></linearGradient></defs><path d="M44 24c0 11-9 20-20 20-8.3 0-15.4-5-18.5-12.2 1.8 3.8 5.7 6.4 10.2 6.4 6.2 0 11.3-5 11.3-11.2 0-2-.5-3.8-1.5-5.4C29.5 18 35.5 14 42.5 14c.5 0 1 0 1.5.1V24z" fill="#3DCFCF"/><path d="M4 24c0-11 9-20 20-20 7.4 0 13.8 4 17.3 10-6-4.5-14-5-20.5-1.5C14.5 16 10 22.5 10 30c0 2.8.8 5.5 2.2 7.8C6 34 4 29.3 4 24z" fill="url(#smEdge)"/></svg>
                    <span class="text-white text-[10px]">Edge</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><rect x="4" y="8" width="40" height="32" rx="2" fill="#185ABD"/><path d="M14 18l6 6-6 6M22 30h12" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/></svg>
                    <span class="text-white text-[10px]">Word</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><rect x="4" y="8" width="40" height="32" rx="2" fill="#107C41"/><rect x="10" y="16" width="28" height="16" fill="#fff" opacity="0.2"/></svg>
                    <span class="text-white text-[10px]">Excel</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><rect x="4" y="8" width="40" height="32" rx="2" fill="#C43E1C"/><rect x="12" y="18" width="24" height="12" fill="#fff" opacity="0.3"/></svg>
                    <span class="text-white text-[10px]">PowerPoint</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><circle cx="24" cy="24" r="20" fill="#1DB954"/><polygon points="20,16 20,32 34,24" fill="#fff"/></svg>
                    <span class="text-white text-[10px]">Spotify</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><rect x="4" y="10" width="40" height="28" rx="2" fill="#FFC107"/><rect x="4" y="10" width="40" height="8" fill="#FFB300"/></svg>
                    <span class="text-white text-[10px]">Files</span>
                </div>
                <!-- Row 2 -->
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><rect x="4" y="4" width="18" height="18" fill="#F25022"/><rect x="26" y="4" width="18" height="18" fill="#7FBA00"/><rect x="4" y="26" width="18" height="18" fill="#00A4EF"/><rect x="26" y="26" width="18" height="18" fill="#FFB900"/></svg>
                    <span class="text-white text-[10px]">Store</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><rect x="6" y="6" width="36" height="36" rx="8" fill="#0078D4"/><circle cx="24" cy="20" r="8" fill="#fff"/><ellipse cx="24" cy="38" rx="12" ry="6" fill="#fff"/></svg>
                    <span class="text-white text-[10px]">Mail</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><rect x="6" y="10" width="36" height="28" rx="2" fill="#333"/><rect x="8" y="34" width="32" height="4" fill="#555"/></svg>
                    <span class="text-white text-[10px]">Photos</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><circle cx="24" cy="24" r="18" fill="none" stroke="#0078D4" stroke-width="4"/><path d="M24 14v12l8 4" stroke="#0078D4" stroke-width="3" stroke-linecap="round"/></svg>
                    <span class="text-white text-[10px]">Clock</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><rect x="8" y="8" width="32" height="32" rx="4" fill="#444"/><circle cx="24" cy="24" r="10" fill="#888"/></svg>
                    <span class="text-white text-[10px]">Settings</span>
                </div>
                <div class="flex flex-col items-center p-3 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 mb-1" viewBox="0 0 48 48"><rect x="8" y="8" width="32" height="32" rx="4" fill="#5865F2"/><circle cx="24" cy="24" r="8" fill="#fff"/></svg>
                    <span class="text-white text-[10px]">Discord</span>
                </div>
            </div>
        </div>
        
        <!-- Recommended Section -->
        <div class="px-6 py-4 border-t border-white/10 mt-2">
            <div class="flex justify-between items-center mb-3">
                <span class="text-white text-sm font-semibold">Recommended</span>
                <button class="text-xs text-white/60 hover:text-white hover:bg-white/10 px-3 py-1 rounded-md transition">More &rarr;</button>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="flex items-center gap-3 p-2 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/></svg>
                    <div><div class="text-white text-xs font-medium">Document.pdf</div><div class="text-white/40 text-[10px]">Recently opened</div></div>
                </div>
                <div class="flex items-center gap-3 p-2 hover:bg-white/10 rounded-md cursor-pointer transition">
                    <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-8l-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z"/></svg>
                    <div><div class="text-white text-xs font-medium">Projects</div><div class="text-white/40 text-[10px]">Folder • Yesterday</div></div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="px-6 py-3 border-t border-white/10 flex justify-between items-center">
            <div class="flex items-center gap-3 hover:bg-white/10 px-3 py-2 rounded-md cursor-pointer transition">
                <span class="text-white text-sm">User</span>
            </div>
            <div class="relative">
                <button class="hover:bg-white/10 p-2.5 rounded-md transition" title="Power" onclick="powerManager.toggle()">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M13 3h-2v10h2V3zm4.83 2.17l-1.42 1.42A6.92 6.92 0 0119 12c0 3.87-3.13 7-7 7s-7-3.13-7-7c0-2.05.88-3.89 2.29-5.17l-1.42-1.42A8.96 8.96 0 003 12c0 4.97 4.03 9 9 9s9-4.03 9-9c0-2.65-1.15-5.03-2.97-6.68l-.2-.15z"/></svg>
                </button>
                <!-- Power Options Menu -->
                <div id="power-menu" class="hidden absolute bottom-12 right-0 w-40 bg-[#2d2d2d]/95 backdrop-blur-md rounded-lg shadow-xl py-1 overflow-hidden border border-white/10 z-[110] animate-in fade-in slide-in-from-bottom-2 duration-100 flex flex-col">
                    <div class="flex items-center gap-3 px-3 py-2 hover:bg-white/10 cursor-pointer transition text-white/90 text-sm" onclick="powerManager.triggerAction('lock')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"/><path d="M7 11V7a5 5 0 0110 0v4" stroke-width="2"/></svg>
                        Lock
                    </div>
                    <div class="flex items-center gap-3 px-3 py-2 hover:bg-white/10 cursor-pointer transition text-white/90 text-sm" onclick="powerManager.triggerAction('restart')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Restart
                    </div>
                    <div class="flex items-center gap-3 px-3 py-2 hover:bg-white/10 cursor-pointer transition text-white/90 text-sm" onclick="powerManager.triggerAction('shutdown')">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M13 3h-2v10h2V3zm4.83 2.17l-1.42 1.42A6.92 6.92 0 0119 12c0 3.87-3.13 7-7 7s-7-3.13-7-7c0-2.05.88-3.89 2.29-5.17l-1.42-1.42A8.96 8.96 0 003 12c0 4.97 4.03 9 9 9s9-4.03 9-9c0-2.65-1.15-5.03-2.97-6.68l-.2-.15z"/></svg>
                        Shutdown
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Taskbar -->
    <div class="acrylic-dark h-12 flex items-center justify-between px-3 border-t border-white/10">
        <div class="flex items-center w-32">
            <button class="taskbar-icon"><svg class="w-6 h-6" viewBox="0 0 24 24"><rect x="3" y="3" width="8" height="8" rx="2" fill="#60CDFF"/><rect x="3" y="13" width="8" height="8" rx="2" fill="#fff"/><rect x="13" y="3" width="8" height="18" rx="2" fill="#60CDFF"/></svg></button>
        </div>
        <div class="flex items-center gap-0.5">
            <button class="taskbar-icon" onclick="windowsManager.toggleStartMenu()" id="start-btn"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="#60CDFF"><rect x="1" y="1" width="10" height="10" rx="1"/><rect x="13" y="1" width="10" height="10" rx="1"/><rect x="1" y="13" width="10" height="10" rx="1"/><rect x="13" y="13" width="10" height="10" rx="1"/></svg></button>
            <button class="taskbar-icon"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" stroke-width="2"/><path d="m20 20-4-4" stroke-width="2" stroke-linecap="round"/></svg></button>
            <button class="taskbar-icon" id="explorer-taskbar" onclick="appManager.open('explorer')"><svg class="w-6 h-6" viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="14" rx="1" fill="#FFC107"/><path d="M2 7a1 1 0 011-1h6l2 2h10a1 1 0 011 1v10a1 1 0 01-1 1H3a1 1 0 01-1-1V7z" fill="#FFD54F"/></svg></button>
            <button class="taskbar-icon" id="edge-taskbar" onclick="windowsManager.openBrowser()"><svg class="w-6 h-6" viewBox="0 0 24 24"><defs><linearGradient id="edgeT1"><stop stop-color="#0C59A4"/><stop offset="1" stop-color="#1B9CE2"/></linearGradient><linearGradient id="edgeT2"><stop stop-color="#1B9CE2"/><stop offset="1" stop-color="#3DCFCF"/></linearGradient></defs><path d="M22 12c0 5.5-4.5 10-10 10-4.2 0-7.7-2.5-9.3-6.1.9 1.9 2.9 3.2 5.1 3.2 3.1 0 5.7-2.5 5.7-5.6 0-1-.3-1.9-.8-2.7 2-1.8 5-3.8 8.5-3.8.3 0 .5 0 .8 0V12z" fill="url(#edgeT2)"/><path d="M2 12c0-5.5 4.5-10 10-10 3.7 0 6.9 2 8.6 5-3-2.3-7-2.5-10.3-.8C7.3 8 5 11.3 5 15c0 1.4.4 2.8 1.1 3.9C3 17 2 14.6 2 12z" fill="url(#edgeT1)"/></svg></button>
            <button class="taskbar-icon" id="settings-taskbar" onclick="appManager.open('settings')"><svg class="w-5 h-5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="#455A64"/><circle cx="12" cy="12" r="4" fill="#78909C"/><g fill="#CFD8DC"><rect x="11" y="2" width="2" height="4" rx="0.5"/><rect x="11" y="18" width="2" height="4" rx="0.5"/><rect x="2" y="11" width="4" height="2" rx="0.5"/><rect x="18" y="11" width="4" height="2" rx="0.5"/></g></svg></button>
            <button class="taskbar-icon"><svg class="w-5 h-5" viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9" fill="#F25022"/><rect x="13" y="2" width="9" height="9" fill="#7FBA00"/><rect x="2" y="13" width="9" height="9" fill="#00A4EF"/><rect x="13" y="13" width="9" height="9" fill="#FFB900"/></svg></button>
        </div>
        <div class="flex items-center gap-1 w-32 justify-end">
            <button class="taskbar-icon !w-auto px-2 gap-1.5"><svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/></svg><svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3z"/></svg></button>
            <button class="taskbar-icon !w-auto px-2 text-right" id="clock-btn" onclick="calendarManager.toggle()"><div class="text-white text-xs leading-tight"><div id="taskbar-time" class="font-medium">23:51</div><div id="taskbar-date" class="text-[10px] text-white/80">02/01/2026</div></div></button>
        </div>
    </div>
    
    <!-- ==================== CALENDAR FLYOUT ==================== -->
    <div id="calendar-flyout" class="hidden fixed bottom-14 right-3 w-80 rounded-2xl border border-white/10 shadow-2xl z-[80] calendar-flyout overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-white/10">
            <button class="p-2 hover:bg-white/10 rounded-lg transition" onclick="calendarManager.prevMonth()">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <span id="calendar-header" class="text-white font-semibold">January 2026</span>
            <button class="p-2 hover:bg-white/10 rounded-lg transition" onclick="calendarManager.nextMonth()">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        
        <!-- Day Names -->
        <div class="calendar-grid px-4 pt-3">
            <div class="calendar-day text-white/50 text-xs font-medium cursor-default hover:bg-transparent">Su</div>
            <div class="calendar-day text-white/50 text-xs font-medium cursor-default hover:bg-transparent">Mo</div>
            <div class="calendar-day text-white/50 text-xs font-medium cursor-default hover:bg-transparent">Tu</div>
            <div class="calendar-day text-white/50 text-xs font-medium cursor-default hover:bg-transparent">We</div>
            <div class="calendar-day text-white/50 text-xs font-medium cursor-default hover:bg-transparent">Th</div>
            <div class="calendar-day text-white/50 text-xs font-medium cursor-default hover:bg-transparent">Fr</div>
            <div class="calendar-day text-white/50 text-xs font-medium cursor-default hover:bg-transparent">Sa</div>
        </div>
        
        <!-- Date Grid -->
        <div id="calendar-dates" class="calendar-grid px-4 pb-4 pt-2"></div>
        
        <!-- Today Button -->
        <div class="px-4 pb-4">
            <button class="w-full py-2 text-center text-white/70 hover:text-white hover:bg-white/10 rounded-lg text-sm transition" onclick="calendarManager.goToday()">Go to today</button>
        </div>
    </div>

    <script>
    function closeAboutModal() {
        const modal = document.getElementById('about-modal');
        if (modal) {
            modal.classList.remove('animate-in', 'zoom-in-95');
            modal.classList.add('animate-out', 'zoom-out-95', 'fade-out', 'duration-200');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('animate-out', 'zoom-out-95', 'fade-out', 'duration-200');
            }, 200);
        }
    }

    const contextMenuManager = {
        menu: null,
        init() {
            document.addEventListener('contextmenu', e => {
                if (window.systemState !== 'desktop') return;
                if (['INPUT', 'TEXTAREA', 'IFRAME'].includes(e.target.tagName)) return;
                e.preventDefault();
                this.show(e.clientX, e.clientY);
            });
            document.addEventListener('click', () => this.hide());
            window.addEventListener('blur', () => this.hide());
        },
        show(x, y) {
            this.menu = document.getElementById('context-menu');
            if (!this.menu) return;
            
            // Boundary check
            const w = 192; // Approx width
            if (x + w > window.innerWidth) x -= w;
            const h = 200; // Approx height
            if (y + h > window.innerHeight) y -= h;
            
            this.menu.classList.remove('hidden');
            this.menu.style.left = x + 'px';
            this.menu.style.top = y + 'px';
            
            // Anim
            this.menu.style.opacity = '0';
            this.menu.style.transform = 'scale(0.95)';
            requestAnimationFrame(() => {
                this.menu.style.opacity = '1';
                this.menu.style.transform = 'scale(1)';
            });
        },
        hide() {
            if (this.menu) this.menu.classList.add('hidden');
        }
    };
    contextMenuManager.init();

    // ==================== WINDOWS MANAGER ====================
    class WindowsManager {
        constructor() {
            this.tabs = {};
            this.activeTabId = null;
            this.tabCounter = 0;
            this.browserOpen = false;
            this.isMaximized = false;
            this.restoreState = null;
            this.zIndex = 100;
            this.MIN_WIDTH = 400;
            this.MIN_HEIGHT = 300;
            this.startClock();
        }

        startClock() {
            const update = () => {
                const now = new Date();
                document.getElementById('taskbar-time').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                document.getElementById('taskbar-date').textContent = now.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
            };
            update(); setInterval(update, 1000);
        }

        toggleStartMenu() {
            document.getElementById('start-menu').classList.toggle('hidden');
        }

        openBrowser() {
            if (this.browserOpen) {
                const win = document.getElementById('browser-window');
                if (win) { win.style.display = 'flex'; this.bringToFront(); }
                return;
            }
            this.renderBrowserWindow();
            this.addTab('/browser', 'TokoBuku - Toko Buku Online');
            this.browserOpen = true;
            document.getElementById('edge-taskbar').classList.add('active');
        }

        addTab(url = '', title = 'New Tab') {
            const id = ++this.tabCounter;
            const iframe = document.createElement('iframe');
            iframe.id = `frame-${id}`;
            iframe.className = 'tab-frame w-full h-full border-0';
            iframe.setAttribute('sandbox', 'allow-same-origin allow-scripts allow-forms allow-top-navigation-by-user-activation allow-popups');
            iframe.onload = () => { if (this.tabs[id]) { this.tabs[id].loading = false; this.updateUI(); } };
            this.tabs[id] = { id, url, title, iframe, loading: false };
            document.getElementById('frames-container')?.appendChild(iframe);
            if (url) this.navigateTo(url, id);
            this.switchTab(id);
            return id;
        }

        closeTab(id) {
            if (!this.tabs[id]) return;
            this.tabs[id].iframe.remove();
            delete this.tabs[id];
            if (Object.keys(this.tabs).length === 0) { this.closeBrowser(); return; }
            if (this.activeTabId === id) { const ids = Object.keys(this.tabs).map(Number); this.switchTab(ids[ids.length - 1]); }
            this.updateUI();
        }

        switchTab(id) {
            if (!this.tabs[id]) return;
            this.activeTabId = id;
            Object.values(this.tabs).forEach(t => t.iframe.classList.remove('active'));
            this.tabs[id].iframe.classList.add('active');
            const addrBar = document.getElementById('address-bar');
            if (addrBar) addrBar.value = this.tabs[id].url;
            this.updateUI();
        }

        navigateTo(input, tabId = null) {
            const id = tabId || this.activeTabId;
            if (!this.tabs[id]) return;
            let url = input.trim();
            const tab = this.tabs[id];
            
            // Check if it's a PDF file
            const isPDF = /\.pdf($|\?)/i.test(url);
            
            // Check if it's a URL pattern
            const isURL = /^(https?:\/\/|localhost|127\.0\.0\.1)/i.test(url) || /^[\w-]+\.(com|org|net|io|dev|co|id)/i.test(url);
            
            if (!url) {
                // Empty = New Tab page
                tab.url = '';
                tab.title = 'New Tab';
                tab.iframe.srcdoc = this.getNewTabHTML();
            } else if (isPDF) {
                // PDF file - use PDF.js viewer
                const pdfFilename = url.split('/').pop().split('?')[0];
                const viewerUrl = `/pdf/view/${encodeURIComponent(pdfFilename)}?src=${encodeURIComponent(url)}`;
                tab.url = url;
                tab.title = `${pdfFilename} - PDF Viewer`;
                tab.loading = true;
                tab.iframe.removeAttribute('srcdoc');
                tab.iframe.src = viewerUrl;
            } else if (url.includes('localhost') || url.includes('toko') || url.includes('127.0.0.1')) {
                // TokoBuku / localhost
                tab.url = 'http://localhost:8080/browser';
                tab.title = 'TokoBuku';
                tab.loading = true;
                tab.iframe.removeAttribute('srcdoc');
                tab.iframe.src = '/browser';
            } else if (isURL) {
                // Regular URL
                if (!/^https?:\/\//i.test(url)) url = 'https://' + url;
                tab.url = url;
                tab.title = url.replace(/^https?:\/\//, '').split('/')[0];
                tab.loading = true;
                tab.iframe.removeAttribute('srcdoc');
                tab.iframe.src = url;
            } else {
                // Search query
                const searchUrl = `https://www.bing.com/search?q=${encodeURIComponent(url)}`;
                tab.url = searchUrl;
                tab.title = `${url} - Bing`;
                tab.loading = true;
                tab.iframe.removeAttribute('srcdoc');
                tab.iframe.src = searchUrl;
            }
            this.updateUI();
        }

        // Open PDF in new tab
        openPdf(pdfUrl, title = 'PDF Viewer') {
            const id = this.addTab('', title);
            this.navigateTo(pdfUrl, id);
        }


        goBack() { try { this.tabs[this.activeTabId]?.iframe.contentWindow.history.back(); } catch(e) {} }
        goForward() { try { this.tabs[this.activeTabId]?.iframe.contentWindow.history.forward(); } catch(e) {} }
        refresh() { const t = this.tabs[this.activeTabId]; if (t) { t.loading = true; this.updateUI(); try { t.iframe.contentWindow.location.reload(); } catch(e) { t.iframe.src = t.iframe.src; } } }
        goHome() { this.navigateTo('localhost'); }

        updateUI() {
            const cont = document.getElementById('tabs-container');
            const load = document.getElementById('loading-indicator');
            if (cont) cont.innerHTML = Object.values(this.tabs).map(t => `<div class="browser-tab ${t.id === this.activeTabId ? 'active' : ''}" onclick="windowsManager.switchTab(${t.id})"><svg class="w-4 h-4 mr-2 flex-shrink-0" viewBox="0 0 24 24"><defs><linearGradient id="te${t.id}"><stop stop-color="#0C59A4"/><stop offset="1" stop-color="#1B9CE2"/></linearGradient></defs><circle cx="12" cy="12" r="10" fill="url(#te${t.id})"/></svg><span class="text-white/80 text-xs truncate flex-1">${this.escapeHtml(t.title)}</span><button class="close-btn ml-1 w-5 h-5 rounded-full hover:bg-white/20 flex items-center justify-center text-white/60 hover:text-white" onclick="event.stopPropagation(); windowsManager.closeTab(${t.id})">×</button></div>`).join('');
            const addrBar = document.getElementById('address-bar');
            if (addrBar && this.tabs[this.activeTabId]) addrBar.value = this.tabs[this.activeTabId].url;
            if (load) load.classList.toggle('hidden', !this.tabs[this.activeTabId]?.loading);
        }

        bringToFront() {
            const win = document.getElementById('browser-window');
            if (win) win.style.zIndex = ++this.zIndex;
        }

        // ========== MAXIMIZE / RESTORE ==========
        toggleMaximize() {
            const win = document.getElementById('browser-window');
            if (!win) return;
            
            if (this.isMaximized) {
                // Restore
                win.style.transition = 'all 0.2s ease';
                win.style.top = this.restoreState.top;
                win.style.left = this.restoreState.left;
                win.style.width = this.restoreState.width;
                win.style.height = this.restoreState.height;
                win.style.borderRadius = '12px';
                this.isMaximized = false;
                setTimeout(() => win.style.transition = '', 200);
            } else {
                // Maximize
                this.restoreState = {
                    top: win.style.top || win.offsetTop + 'px',
                    left: win.style.left || win.offsetLeft + 'px',
                    width: win.style.width || win.offsetWidth + 'px',
                    height: win.style.height || win.offsetHeight + 'px'
                };
                win.style.transition = 'all 0.2s ease';
                win.style.top = '0';
                win.style.left = '0';
                win.style.width = '100%';
                win.style.height = '100%';
                win.style.borderRadius = '0';
                this.isMaximized = true;
                setTimeout(() => win.style.transition = '', 200);
            }
        }

        renderBrowserWindow() {
            document.getElementById('windows-container').innerHTML = `
            <div id="browser-window" class="absolute bg-[#1f1f1f] rounded-xl shadow-2xl overflow-hidden flex flex-col window-animate-in border border-white/10" style="display:flex;flex-direction:column;top:32px;left:48px;width:1000px;height:680px;z-index:${++this.zIndex}">
                <!-- 8 Resize Handles -->
                <div class="resize-handle resize-n" onmousedown="resizeManager.start(event, 'n')"></div>
                <div class="resize-handle resize-s" onmousedown="resizeManager.start(event, 's')"></div>
                <div class="resize-handle resize-w" onmousedown="resizeManager.start(event, 'w')"></div>
                <div class="resize-handle resize-e" onmousedown="resizeManager.start(event, 'e')"></div>
                <div class="resize-handle resize-nw" onmousedown="resizeManager.start(event, 'nw')"></div>
                <div class="resize-handle resize-ne" onmousedown="resizeManager.start(event, 'ne')"></div>
                <div class="resize-handle resize-sw" onmousedown="resizeManager.start(event, 'sw')"></div>
                <div class="resize-handle resize-se" onmousedown="resizeManager.start(event, 'se')"></div>
                
                <!-- Tab Bar -->
                <div class="h-9 bg-[#2b2b2b] flex items-center justify-between relative z-10" onmousedown="dragManager.start(event)">
                    <div class="flex items-center flex-1 overflow-x-auto px-2" id="tabs-container"></div>
                    <button class="px-2 py-1 text-white/50 hover:text-white hover:bg-white/10 rounded text-lg" onclick="windowsManager.addTab()">+</button>
                    <div class="flex">
                        <button class="win-ctrl" onclick="windowsManager.minimize()"><svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="11" width="16" height="2"/></svg></button>
                        <button class="win-ctrl" onclick="windowsManager.toggleMaximize()"><svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="1"/></svg></button>
                        <button class="win-ctrl close" onclick="windowsManager.closeBrowser()"><svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6l12 12M6 18L18 6" stroke-linecap="round"/></svg></button>
                    </div>
                </div>
                <!-- Address Bar -->
                <div class="h-10 bg-[#1f1f1f] flex items-center px-2 gap-1 border-b border-white/5 relative z-10">
                    <button class="p-2 text-white/50 hover:text-white hover:bg-white/10 rounded" onclick="windowsManager.goBack()"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg></button>
                    <button class="p-2 text-white/50 hover:text-white hover:bg-white/10 rounded" onclick="windowsManager.goForward()"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg></button>
                    <button class="p-2 text-white/50 hover:text-white hover:bg-white/10 rounded" onclick="windowsManager.refresh()"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v5h5M20 20v-5h-5"/><path d="M20.5 9A9 9 0 005.3 5.3M3.5 15a9 9 0 0015.2 3.7"/></svg></button>
                    <div id="loading-indicator" class="spinner hidden mx-1"></div>
                    <button class="p-2 text-white/50 hover:text-white hover:bg-white/10 rounded" onclick="windowsManager.goHome()" title="TokoBuku"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></button>
                    <input type="text" id="address-bar" class="flex-1 bg-[#2d2d2d] rounded-full px-4 py-1.5 text-white/80 text-sm outline-none focus:ring-1 focus:ring-blue-500 mx-2" placeholder="Search with Bing or enter address" onkeydown="if(event.key==='Enter') windowsManager.navigateTo(this.value)">
                    <button class="p-2 text-white/50 hover:text-white hover:bg-white/10 rounded"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></button>
                </div>
                <!-- Content -->
                <div id="frames-container" class="flex-1 relative bg-white"></div>
            </div>`;
        }

        getNewTabHTML() {
            return `<!DOCTYPE html><html><head><style>body{font-family:'Segoe UI',sans-serif;background:#1f1f1f;margin:0;height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center}input{width:500px;max-width:90%;padding:12px 20px;border-radius:24px;border:1px solid #3d3d3d;background:#2d2d2d;color:#fff;font-size:14px;outline:none}input:focus{border-color:#0078d4}.sc{width:80px;padding:10px;background:#2d2d2d;border-radius:8px;text-align:center;color:#aaa;cursor:pointer;font-size:11px;margin-top:20px}.sc:hover{background:#3d3d3d}</style></head><body><form onsubmit="parent.windowsManager.navigateTo(this.q.value);return false"><input name="q" placeholder="Search with Bing or enter address" autofocus></form><div class="sc" onclick="parent.windowsManager.navigateTo('localhost')">📚 TokoBuku</div></body></html>`;
        }

        escapeHtml(t) { const d = document.createElement('div'); d.textContent = t; return d.innerHTML; }
        minimize() { const w = document.getElementById('browser-window'); if (w) w.style.display = 'none'; }
        closeBrowser() {
            const w = document.getElementById('browser-window');
            if (w) {
                w.classList.remove('window-animate-in');
                w.classList.add('window-animate-out');
                setTimeout(() => { w.remove(); this.tabs = {}; this.activeTabId = null; this.tabCounter = 0; this.browserOpen = false; this.isMaximized = false; document.getElementById('edge-taskbar').classList.remove('active'); }, 200);
            }
        }
    }

    // ==================== RESIZE MANAGER ====================
    const resizeManager = {
        isResizing: false,
        direction: null,
        startX: 0, startY: 0,
        startWidth: 0, startHeight: 0,
        startTop: 0, startLeft: 0,

        start(e, dir) {
            e.stopPropagation();
            const win = document.getElementById('browser-window');
            if (!win || windowsManager.isMaximized) return;
            
            this.isResizing = true;
            this.direction = dir;
            this.startX = e.clientX;
            this.startY = e.clientY;
            this.startWidth = win.offsetWidth;
            this.startHeight = win.offsetHeight;
            this.startTop = win.offsetTop;
            this.startLeft = win.offsetLeft;
            
            win.classList.add('resizing', 'no-pointer');
            windowsManager.bringToFront();
            document.body.style.cursor = getComputedStyle(e.target).cursor;
        },

        move(e) {
            if (!this.isResizing) return;
            
            const win = document.getElementById('browser-window');
            if (!win) return;
            
            const dx = e.clientX - this.startX;
            const dy = e.clientY - this.startY;
            const MIN_W = windowsManager.MIN_WIDTH;
            const MIN_H = windowsManager.MIN_HEIGHT;
            
            let newWidth = this.startWidth;
            let newHeight = this.startHeight;
            let newTop = this.startTop;
            let newLeft = this.startLeft;
            
            // Calculate based on direction
            if (this.direction.includes('e')) newWidth = Math.max(MIN_W, this.startWidth + dx);
            if (this.direction.includes('w')) { newWidth = Math.max(MIN_W, this.startWidth - dx); newLeft = this.startLeft + (this.startWidth - newWidth); }
            if (this.direction.includes('s')) newHeight = Math.max(MIN_H, this.startHeight + dy);
            if (this.direction.includes('n')) { newHeight = Math.max(MIN_H, this.startHeight - dy); newTop = this.startTop + (this.startHeight - newHeight); }
            
            requestAnimationFrame(() => {
                win.style.width = newWidth + 'px';
                win.style.height = newHeight + 'px';
                win.style.top = newTop + 'px';
                win.style.left = newLeft + 'px';
            });
        },

        stop() {
            if (!this.isResizing) return;
            this.isResizing = false;
            const win = document.getElementById('browser-window');
            if (win) win.classList.remove('resizing', 'no-pointer');
            document.body.style.cursor = '';
        }
    };

    // ==================== DRAG MANAGER ====================
    const dragManager = {
        isDragging: false,
        startX: 0, startY: 0,
        startTop: 0, startLeft: 0,

        start(e) {
            if (e.target.tagName === 'BUTTON' || e.target.closest('button')) return;
            const win = document.getElementById('browser-window');
            if (!win || windowsManager.isMaximized) return;
            
            this.isDragging = true;
            this.startX = e.clientX;
            this.startY = e.clientY;
            this.startTop = win.offsetTop;
            this.startLeft = win.offsetLeft;
            
            win.classList.add('no-pointer');
            windowsManager.bringToFront();
        },

        move(e) {
            if (!this.isDragging) return;
            const win = document.getElementById('browser-window');
            if (!win) return;
            
            const dx = e.clientX - this.startX;
            const dy = e.clientY - this.startY;
            
            requestAnimationFrame(() => {
                win.style.left = (this.startLeft + dx) + 'px';
                win.style.top = Math.max(0, this.startTop + dy) + 'px';
            });
        },

        stop() {
            if (!this.isDragging) return;
            this.isDragging = false;
            const win = document.getElementById('browser-window');
            if (win) win.classList.remove('no-pointer');
        }
    };

    // ==================== APP MANAGER (File Explorer & Settings) ====================
    const appManager = {
        zIndex: 200,
        windows: {},
        currentPath: 'This PC',
        settingsSection: 'system',
        
        // Virtual File System
        fileSystem: {
            'This PC': { type: 'root', children: ['Documents', 'Downloads', 'Desktop', 'Pictures', 'Local Disk (C:)'] },
            'Documents': { type: 'folder', parent: 'This PC', children: ['Work', 'Personal', 'Report.pdf', 'Notes.txt'] },
            'Downloads': { type: 'folder', parent: 'This PC', children: ['Setup.exe', 'Image.png', 'Archive.zip'] },
            'Desktop': { type: 'folder', parent: 'This PC', children: ['Edge.lnk', 'TokoBuku.lnk', 'Readme.txt'] },
            'Pictures': { type: 'folder', parent: 'This PC', children: ['Vacation', 'Screenshots', 'wallpaper.jpg'] },
            'Local Disk (C:)': { type: 'drive', parent: 'This PC', children: ['Program Files', 'Windows', 'Users'] },
            'Work': { type: 'folder', parent: 'Documents', children: ['Project.docx', 'Budget.xlsx'] },
            'Personal': { type: 'folder', parent: 'Documents', children: ['Diary.txt'] },
            'Vacation': { type: 'folder', parent: 'Pictures', children: ['beach.jpg', 'mountain.jpg'] },
            'Screenshots': { type: 'folder', parent: 'Pictures', children: ['screen1.png'] },
            'Program Files': { type: 'folder', parent: 'Local Disk (C:)', children: ['Microsoft Edge'] },
            'Windows': { type: 'folder', parent: 'Local Disk (C:)', children: ['System32'] },
            'Users': { type: 'folder', parent: 'Local Disk (C:)', children: ['Admin', 'Guest'] },
        },
        
        // Wallpapers
        wallpapers: [
            { id: 'bloom', name: 'Bloom', url: 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=1920&q=80' },
            { id: 'blue-wave', name: 'Blue Wave', url: '/wallpapers/blue-wave.jpg' },
            { id: 'mountain', name: 'Sunrise', url: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&q=80' },
            { id: 'sunset', name: 'Glow', url: 'https://images.unsplash.com/photo-1495616811223-4d98c6e9c869?w=1920&q=80' },
            { id: 'forest', name: 'Flow', url: 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?w=1920&q=80' },
            { id: 'ocean', name: 'Captured Motion', url: 'https://images.unsplash.com/photo-1541701494587-cb58502866ab?w=1920&q=80' },
            { id: 'dark', name: 'Dark', url: 'https://images.unsplash.com/photo-1614850523459-c2f4c699c52e?w=1920&q=80' },
        ],
        
        open(appType) {
            if (window.systemState !== 'desktop') return;
            const winId = `${appType}-window`;
            
            if (this.windows[appType]) {
                const win = document.getElementById(winId);
                if (win) { win.style.display = 'flex'; this.bringToFront(winId); }
                return;
            }
            
            if (appType === 'explorer') this.renderExplorer();
            if (appType === 'settings') this.renderSettings();
            if (appType === 'terminal') this.renderTerminal();
            
            this.windows[appType] = true;
            document.getElementById(`${appType}-taskbar`)?.classList.add('active');
        },
        
        close(appType) {
            const winId = `${appType}-window`;
            const win = document.getElementById(winId);
            if (win) {
                win.classList.remove('window-animate-in');
                win.classList.add('window-animate-out');
                setTimeout(() => {
                    win.remove();
                    delete this.windows[appType];
                    document.getElementById(`${appType}-taskbar`)?.classList.remove('active');
                }, 200);
            }
        },
        
        minimize(appType) {
            const win = document.getElementById(`${appType}-window`);
            if (win) win.style.display = 'none';
        },
        
        bringToFront(winId) {
            const win = document.getElementById(winId);
            if (win) win.style.zIndex = ++this.zIndex;
        },
        
        // ========== FILE EXPLORER ==========
        renderExplorer() {
            const html = `
            <div id="explorer-window" class="absolute win-window rounded-xl shadow-2xl overflow-hidden flex flex-col window-animate-in border border-white/10" style="display:flex;flex-direction:column;top:60px;left:100px;width:900px;height:600px;z-index:${++this.zIndex}" onmousedown="appManager.bringToFront('explorer-window')">
                <!-- Title Bar -->
                <div class="h-9 bg-[#2b2b2b] flex items-center justify-between px-2" onmousedown="appManager.startDrag(event, 'explorer-window')">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="14" rx="1" fill="#FFC107"/><path d="M2 7a1 1 0 011-1h6l2 2h10a1 1 0 011 1v10a1 1 0 01-1 1H3a1 1 0 01-1-1V7z" fill="#FFD54F"/></svg>
                        <span class="text-white/80 text-sm">File Explorer</span>
                    </div>
                    <div class="flex">
                        <button class="win-ctrl" onclick="appManager.minimize('explorer')"><svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="11" width="16" height="2"/></svg></button>
                        <button class="win-ctrl close" onclick="appManager.close('explorer')"><svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6l12 12M6 18L18 6" stroke-linecap="round"/></svg></button>
                    </div>
                </div>
                <!-- Toolbar -->
                <div class="h-10 bg-[#2b2b2b] flex items-center px-2 gap-2 border-b border-white/10">
                    <button class="p-1.5 hover:bg-white/10 rounded" onclick="appManager.navigateUp()"><svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg></button>
                    <button class="p-1.5 hover:bg-white/10 rounded" onclick="appManager.goBack()"><svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg></button>
                    <div id="explorer-breadcrumb" class="flex-1 flex items-center gap-1 px-3 py-1 bg-[#1f1f1f] rounded text-white/70 text-sm">
                        <span class="cursor-pointer hover:text-white" onclick="appManager.navigateTo('This PC')">This PC</span>
                    </div>
                    <div class="flex items-center bg-[#1f1f1f] rounded px-2">
                        <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" stroke-width="2"/><path d="m20 20-3-3" stroke-width="2"/></svg>
                        <input type="text" class="bg-transparent text-white/80 text-sm px-2 py-1 outline-none w-32" placeholder="Search">
                    </div>
                </div>
                <!-- Content -->
                <div class="flex flex-1 overflow-hidden">
                    <!-- Sidebar -->
                    <div class="w-48 explorer-sidebar p-2 overflow-y-auto">
                        <div class="text-white/50 text-xs font-medium px-2 py-1">Quick access</div>
                        <div class="explorer-item flex items-center gap-2 px-2 py-1.5 rounded cursor-pointer text-white/80 text-sm" onclick="appManager.navigateTo('Desktop')"><svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><rect x="8" y="17" width="8" height="2"/><rect x="6" y="19" width="12" height="2" rx="1"/></svg>Desktop</div>
                        <div class="explorer-item flex items-center gap-2 px-2 py-1.5 rounded cursor-pointer text-white/80 text-sm" onclick="appManager.navigateTo('Documents')"><svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-8l-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z"/></svg>Documents</div>
                        <div class="explorer-item flex items-center gap-2 px-2 py-1.5 rounded cursor-pointer text-white/80 text-sm" onclick="appManager.navigateTo('Downloads')"><svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>Downloads</div>
                        <div class="explorer-item flex items-center gap-2 px-2 py-1.5 rounded cursor-pointer text-white/80 text-sm" onclick="appManager.navigateTo('Pictures')"><svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>Pictures</div>
                        <div class="text-white/50 text-xs font-medium px-2 py-1 mt-3">This PC</div>
                        <div class="explorer-item flex items-center gap-2 px-2 py-1.5 rounded cursor-pointer text-white/80 text-sm" onclick="appManager.navigateTo('Local Disk (C:)')"><svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"/><rect x="6" y="14" width="12" height="4" fill="#60CDFF"/></svg>Local Disk (C:)</div>
                        <div class="text-white/50 text-xs font-medium px-2 py-1 mt-3">Other</div>
                        <div class="explorer-item flex items-center gap-2 px-2 py-1.5 rounded cursor-pointer text-white/80 text-sm"><svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5z"/></svg>Recycle Bin</div>
                    </div>
                    <!-- Main Area -->
                    <div id="explorer-files" class="flex-1 p-4 overflow-y-auto">
                        <div class="grid grid-cols-6 gap-4" id="files-grid"></div>
                    </div>
                </div>
            </div>`;
            document.getElementById('windows-container').insertAdjacentHTML('beforeend', html);
            this.navigateTo('This PC');
        },
        
        navigateTo(path) {
            this.currentPath = path;
            const item = this.fileSystem[path];
            if (!item) return;
            
            // Update breadcrumb
            const breadcrumb = document.getElementById('explorer-breadcrumb');
            if (breadcrumb) {
                const parts = this.getBreadcrumbPath(path);
                breadcrumb.innerHTML = parts.map((p, i) => 
                    `<span class="cursor-pointer hover:text-white" onclick="appManager.navigateTo('${p}')">${p}</span>${i < parts.length - 1 ? '<span class="text-white/30">›</span>' : ''}`
                ).join('');
            }
            
            // Render files
            const grid = document.getElementById('files-grid');
            if (grid && item.children) {
                grid.innerHTML = item.children.map(child => {
                    const childItem = this.fileSystem[child];
                    const isFolder = childItem || child.includes('Disk') || ['Work', 'Personal', 'Vacation', 'Screenshots', 'Program Files', 'Windows', 'Users', 'Microsoft Edge', 'System32', 'Admin', 'Guest'].includes(child);
                    const icon = this.getFileIcon(child, isFolder);
                    return `<div class="file-item flex flex-col items-center p-3 rounded-lg cursor-pointer" ondblclick="appManager.openItem('${child}')" onclick="this.classList.toggle('selected')">
                        ${icon}
                        <span class="text-white/80 text-xs text-center mt-1 truncate w-full">${child}</span>
                    </div>`;
                }).join('');
            }
        },
        
        openItem(name) {
            if (name.endsWith('.lnk')) {
                if (name.includes('Edge') || name.includes('TokoBuku')) {
                    windowsManager.openBrowser();
                }
                return;
            }
            if (name.endsWith('.pdf')) {
                windowsManager.openBrowser();
                setTimeout(() => windowsManager.navigateTo(`/sample.pdf`), 500);
                return;
            }
            if (this.fileSystem[name] || name.includes('Disk')) {
                this.navigateTo(name);
            }
        },
        
        getBreadcrumbPath(path) {
            const parts = [path];
            let current = this.fileSystem[path];
            while (current && current.parent) {
                parts.unshift(current.parent);
                current = this.fileSystem[current.parent];
            }
            return parts;
        },
        
        navigateUp() {
            const current = this.fileSystem[this.currentPath];
            if (current && current.parent) {
                this.navigateTo(current.parent);
            }
        },
        
        goBack() { this.navigateUp(); },
        
        getFileIcon(name, isFolder) {
            if (isFolder || name.includes('Disk')) {
                return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="4" y="12" width="40" height="28" rx="2" fill="#FFC107"/><path d="M4 14a2 2 0 012-2h12l4 4h22a2 2 0 012 2v20a2 2 0 01-2 2H6a2 2 0 01-2-2V14z" fill="#FFD54F"/></svg>';
            }
            if (name.endsWith('.pdf')) return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" fill="#F44336"/><text x="24" y="30" text-anchor="middle" fill="white" font-size="10" font-weight="bold">PDF</text></svg>';
            if (name.endsWith('.txt')) return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" fill="#90A4AE"/><rect x="12" y="12" width="24" height="2" fill="white"/><rect x="12" y="18" width="20" height="2" fill="white"/><rect x="12" y="24" width="16" height="2" fill="white"/></svg>';
            if (name.endsWith('.docx') || name.endsWith('.doc')) return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" fill="#2196F3"/><text x="24" y="30" text-anchor="middle" fill="white" font-size="8" font-weight="bold">DOC</text></svg>';
            if (name.endsWith('.xlsx')) return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" fill="#4CAF50"/><text x="24" y="30" text-anchor="middle" fill="white" font-size="8" font-weight="bold">XLS</text></svg>';
            if (name.endsWith('.png') || name.endsWith('.jpg')) return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="8" y="8" width="32" height="32" rx="2" fill="#9C27B0"/><circle cx="18" cy="18" r="4" fill="white"/><path d="M40 32L30 22L16 36H40V32Z" fill="white" opacity="0.7"/></svg>';
            if (name.endsWith('.exe')) return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" fill="#607D8B"/><rect x="18" y="18" width="12" height="12" fill="#60CDFF"/></svg>';
            if (name.endsWith('.zip')) return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" fill="#795548"/><rect x="20" y="8" width="8" height="32" fill="#5D4037"/></svg>';
            if (name.endsWith('.lnk')) return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="8" y="8" width="32" height="32" rx="4" fill="#1E88E5"/><path d="M24 16v16l8-8z" fill="white"/></svg>';
            return '<svg class="w-12 h-12" viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" fill="#BDBDBD"/></svg>';
        },
        
        // ========== SETTINGS ==========
        renderSettings() {
            const html = `
            <div id="settings-window" class="absolute win-window rounded-xl shadow-2xl overflow-hidden flex flex-col window-animate-in border border-white/10" style="display:flex;flex-direction:column;top:40px;left:150px;width:950px;height:650px;z-index:${++this.zIndex}" onmousedown="appManager.bringToFront('settings-window')">
                <!-- Title Bar -->
                <div class="h-9 bg-[#2b2b2b] flex items-center justify-between px-2" onmousedown="appManager.startDrag(event, 'settings-window')">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="#455A64"/><circle cx="12" cy="12" r="4" fill="#78909C"/></svg>
                        <span class="text-white/80 text-sm">Settings</span>
                    </div>
                    <div class="flex">
                        <button class="win-ctrl" onclick="appManager.minimize('settings')"><svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="11" width="16" height="2"/></svg></button>
                        <button class="win-ctrl close" onclick="appManager.close('settings')"><svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6l12 12M6 18L18 6" stroke-linecap="round"/></svg></button>
                    </div>
                </div>
                <!-- Content -->
                <div class="flex flex-1 overflow-hidden">
                    <!-- Sidebar -->
                    <div class="w-56 bg-[#1f1f1f] p-3 overflow-y-auto">
                        <div class="flex items-center gap-3 p-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center text-white text-xl font-medium">U</div>
                            <div><div class="text-white font-medium">User</div><div class="text-white/50 text-xs">Local Account</div></div>
                        </div>
                        <div class="settings-nav-item flex items-center gap-3 px-3 py-2.5 rounded cursor-pointer text-white/80 ${this.settingsSection === 'system' ? 'active' : ''}" onclick="appManager.showSettingsSection('system')"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" stroke-width="2"/><path d="M9 9h6M9 12h6M9 15h4" stroke-width="2"/></svg>System</div>
                        <div class="settings-nav-item flex items-center gap-3 px-3 py-2.5 rounded cursor-pointer text-white/80 ${this.settingsSection === 'personalization' ? 'active' : ''}" onclick="appManager.showSettingsSection('personalization')"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/><circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/><path d="M21 15l-5-5L5 21" stroke-width="2"/></svg>Personalization</div>
                        <div class="settings-nav-item flex items-center gap-3 px-3 py-2.5 rounded cursor-pointer text-white/80 ${this.settingsSection === 'accounts' ? 'active' : ''}" onclick="appManager.showSettingsSection('accounts')"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke-width="2"/><path d="M20 21a8 8 0 10-16 0" stroke-width="2"/></svg>Accounts</div>
                        <div class="settings-nav-item flex items-center gap-3 px-3 py-2.5 rounded cursor-pointer text-white/80 ${this.settingsSection === 'about' ? 'active' : ''}" onclick="appManager.showSettingsSection('about')"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path d="M12 16v-4M12 8h.01" stroke-width="2" stroke-linecap="round"/></svg>About</div>
                    </div>
                    <!-- Main Area -->
                    <div id="settings-content" class="flex-1 p-6 overflow-y-auto"></div>
                </div>
            </div>`;
            document.getElementById('windows-container').insertAdjacentHTML('beforeend', html);
            this.showSettingsSection('system');
        },
        
        showSettingsSection(section) {
            this.settingsSection = section;
            const content = document.getElementById('settings-content');
            
            // Update sidebar active state
            document.querySelectorAll('.settings-nav-item').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.settings-nav-item')[['system', 'personalization', 'accounts', 'about'].indexOf(section)]?.classList.add('active');
            
            if (section === 'system') {
                content.innerHTML = `
                    <h2 class="text-white text-2xl font-light mb-6">System</h2>
                    <div class="space-y-4">
                        <div class="bg-white/5 rounded-lg p-4"><div class="flex justify-between items-center"><div><div class="text-white">Display</div><div class="text-white/50 text-sm">Monitor, brightness, night light</div></div><svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg></div></div>
                        <div class="bg-white/5 rounded-lg p-4"><div class="flex justify-between items-center"><div><div class="text-white">Sound</div><div class="text-white/50 text-sm">Volume, output, input devices</div></div><svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg></div></div>
                        <div class="bg-white/5 rounded-lg p-4"><div class="flex justify-between items-center"><div><div class="text-white">Notifications</div><div class="text-white/50 text-sm">Alerts from apps and system</div></div><svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg></div></div>
                        <div class="bg-white/5 rounded-lg p-4"><div class="flex justify-between items-center"><div><div class="text-white">Storage</div><div class="text-white/50 text-sm">128 GB used of 256 GB</div></div><div class="w-32 h-2 bg-white/10 rounded-full overflow-hidden"><div class="w-1/2 h-full bg-blue-500"></div></div></div></div>
                    </div>`;
            }
            
            if (section === 'personalization') {
                const currentWallpaper = localStorage.getItem('wallpaper') || 'bloom';
                content.innerHTML = `
                    <h2 class="text-white text-2xl font-light mb-6">Personalization</h2>
                    <div class="mb-6"><div class="text-white mb-3">Background</div><div class="text-white/50 text-sm mb-4">Choose your desktop wallpaper</div>
                    <div class="grid grid-cols-3 gap-4" id="wallpaper-options">
                        ${this.wallpapers.map(w => `<div class="wallpaper-option rounded-lg overflow-hidden cursor-pointer aspect-video ${w.id === currentWallpaper ? 'selected' : ''}" onclick="appManager.setWallpaper('${w.id}')" style="background:url('${w.url}') center/cover"><div class="h-full w-full flex items-end p-2 bg-gradient-to-t from-black/50 to-transparent"><span class="text-white text-xs">${w.name}</span></div></div>`).join('')}
                    </div></div>
                    <div class="mt-8"><div class="text-white mb-3">Colors</div><div class="flex gap-3">${['#0078D4', '#9C27B0', '#E91E63', '#4CAF50', '#FF9800', '#795548'].map(c => `<div class="w-10 h-10 rounded-full cursor-pointer hover:scale-110 transition" style="background:${c}"></div>`).join('')}</div></div>`;
            }
            
            if (section === 'accounts') {
                content.innerHTML = `
                    <h2 class="text-white text-2xl font-light mb-6">Accounts</h2>
                    <div class="bg-white/5 rounded-lg p-4 mb-4 flex items-center gap-4"><div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-medium">U</div><div><div class="text-white text-lg">User</div><div class="text-white/50">Local Account</div><div class="text-blue-400 text-sm mt-1 cursor-pointer hover:underline">Manage my Microsoft account</div></div></div>
                    <div class="text-white mb-3">User Management</div>
                    <div class="bg-white/5 rounded-lg overflow-hidden"><table class="w-full"><thead class="bg-white/5"><tr><th class="text-left text-white/70 p-3 text-sm">Username</th><th class="text-left text-white/70 p-3 text-sm">Email</th><th class="text-left text-white/70 p-3 text-sm">Role</th><th class="text-white/70 p-3 text-sm">Actions</th></tr></thead><tbody><tr class="border-t border-white/5"><td class="text-white p-3">Admin</td><td class="text-white/70 p-3">admin@tokobuku.com</td><td class="p-3"><span class="bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded text-xs">Admin</span></td><td class="p-3 text-center"><button class="text-blue-400 hover:underline text-sm mr-2">Edit</button><button class="text-red-400 hover:underline text-sm">Delete</button></td></tr><tr class="border-t border-white/5"><td class="text-white p-3">Guest</td><td class="text-white/70 p-3">guest@tokobuku.com</td><td class="p-3"><span class="bg-gray-500/20 text-gray-400 px-2 py-0.5 rounded text-xs">User</span></td><td class="p-3 text-center"><button class="text-blue-400 hover:underline text-sm mr-2">Edit</button><button class="text-red-400 hover:underline text-sm">Delete</button></td></tr></tbody></table></div>`;
            }
            
            if (section === 'about') {
                content.innerHTML = `
                    <h2 class="text-white text-2xl font-light mb-6">About</h2>
                    <div class="flex items-start gap-6 mb-8"><svg class="w-20 h-20 flex-shrink-0" viewBox="0 0 88 88" fill="none"><path d="M0 12.5L35.7 7.8V42.3H0V12.5Z" fill="#0078D4"/><path d="M40 7.2L88 0V42.3H40V7.2Z" fill="#0078D4"/><path d="M0 46.2H35.7V80.7L0 76V46.2Z" fill="#0078D4"/><path d="M40 46.2H88V88L40 81.2V46.2Z" fill="#0078D4"/></svg><div><div class="text-white text-xl">Windows 11 CI4 Edition</div><div class="text-white/50 mt-1">Version 26.01.03</div><div class="text-white/50 text-sm mt-4">© 2026 TokoBuku. All rights reserved.</div></div></div>
                    <div class="grid grid-cols-2 gap-4"><div class="bg-white/5 rounded-lg p-4"><div class="text-white/50 text-sm">Device</div><div class="text-white mt-1">TokoBuku Desktop</div></div><div class="bg-white/5 rounded-lg p-4"><div class="text-white/50 text-sm">Processor</div><div class="text-white mt-1">Intel Core i7-12700</div></div><div class="bg-white/5 rounded-lg p-4"><div class="text-white/50 text-sm">RAM</div><div class="text-white mt-1">16 GB</div></div><div class="bg-white/5 rounded-lg p-4"><div class="text-white/50 text-sm">System Type</div><div class="text-white mt-1">64-bit OS</div></div></div>
                    <div class="mt-6 bg-white/5 rounded-lg p-4"><div class="text-white/50 text-sm">User Profile</div><div class="text-white mt-2">Semester: 3 </div><div class="text-white">Kelompok: Alif, Diko, Wisnu, Nopen</div><div class="text-white">University: Politeknik LP3I Ciputat</div></div>`;
            }
        },
        
        setWallpaper(id) {
            const wallpaper = this.wallpapers.find(w => w.id === id);
            if (!wallpaper) return;
            
            document.body.style.backgroundImage = `url('${wallpaper.url}')`;
            if (id === 'blue-wave') {
                document.body.style.backgroundSize = '100% 100%';
            } else {
                document.body.style.backgroundSize = 'cover';
            }
            document.body.style.backgroundPosition = 'center';
            localStorage.setItem('wallpaper', id);
            
            // Update selection UI
            document.querySelectorAll('.wallpaper-option').forEach(el => el.classList.remove('selected'));
            if (window.event && event.currentTarget) event.currentTarget.classList.add('selected');
        },
        
        // ========== WINDOW DRAG ==========
        dragState: { isDragging: false, winId: null, startX: 0, startY: 0, startTop: 0, startLeft: 0 },
        
        startDrag(e, winId) {
            if (e.target.tagName === 'BUTTON' || e.target.closest('button')) return;
            const win = document.getElementById(winId);
            if (!win) return;
            
            this.dragState = {
                isDragging: true,
                winId,
                startX: e.clientX,
                startY: e.clientY,
                startTop: win.offsetTop,
                startLeft: win.offsetLeft
            };
            win.classList.add('no-pointer');
            this.bringToFront(winId);
        },
        
        handleDrag(e) {
            if (!this.dragState.isDragging) return;
            const win = document.getElementById(this.dragState.winId);
            if (!win) return;
            
            const dx = e.clientX - this.dragState.startX;
            const dy = e.clientY - this.dragState.startY;
            
            requestAnimationFrame(() => {
                win.style.left = (this.dragState.startLeft + dx) + 'px';
                win.style.top = Math.max(0, this.dragState.startTop + dy) + 'px';
            });
        },
        
        renderTerminal() {
            const container = document.getElementById('windows-container');
            if (document.getElementById('terminal-window')) return;
            
            const html = `
            <div id="terminal-window" class="win-window hidden flex flex-col absolute top-20 left-20 w-[700px] h-[500px] bg-black/95 backdrop-blur-md rounded-lg shadow-2xl overflow-hidden border border-white/10 animate-in fade-in zoom-in-95 duration-200" style="z-index: ${windowsManager.zIndex++}">
                <!-- Titlebar -->
                <div class="h-8 bg-[#202020]/90 flex items-center justify-between px-3 select-none" onmousedown="appManager.startDrag(event, 'terminal-window')">
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-white/50">Administrator: Windows PowerShell</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 flex items-center justify-center hover:bg-white/10 rounded transition cursor-pointer" onclick="appManager.minimize('terminal-window')">
                            <svg class="w-3 h-3 text-white" viewBox="0 0 10 1"><path fill="currentColor" d="M0 0h10v1H0z"/></svg>
                        </div>
                        <div class="w-8 h-8 flex items-center justify-center hover:bg-red-500 rounded transition cursor-pointer" onclick="appManager.close('terminal')">
                            <svg class="w-3 h-3 text-white" viewBox="0 0 10 10"><path fill="currentColor" d="M0 0l10 10m0-10L0 10" stroke="currentColor" stroke-width="1.5"/></svg>
                        </div>
                    </div>
                </div>
                <!-- Content -->
                <div class="flex-1 p-2 font-mono text-sm text-gray-200 overflow-y-auto custom-scrollbar" id="terminal-content" onclick="document.getElementById('terminal-input').focus()">
                    <div class="mb-2">Windows PowerShell<br>Copyright (C) Microsoft Corporation. All rights reserved.<br><br>Install the latest PowerShell for new features and improvements! https://aka.ms/PSWindows<br><br></div>
                    <div id="terminal-history"></div>
                    <div class="flex items-center">
                        <span class="text-[#4CC2FF] mr-2">PS C:\\Users\\Mectov></span>
                        <input type="text" id="terminal-input" class="flex-1 bg-transparent border-none outline-none text-gray-200 font-mono" autocomplete="off" onkeydown="terminalManager.handleInput(event)">
                    </div>
                </div>
            </div>`;
            
            container.insertAdjacentHTML('beforeend', html);
            this.makeDraggable('terminal-window');
            setTimeout(() => document.getElementById('terminal-input').focus(), 100);
        },
        
        stopDrag() {
            if (!this.dragState.isDragging) return;
            const win = document.getElementById(this.dragState.winId);
            if (win) win.classList.remove('no-pointer');
            this.dragState.isDragging = false;
        }
    };
    


    const terminalManager = {
        handleInput(e) {
            if (e.key === 'Enter') {
                const input = e.target;
                const cmd = input.value.trim();
                const history = document.getElementById('terminal-history');
                
                // Print command
                history.innerHTML += `<div class="mb-1"><span class="text-[#4CC2FF] mr-2">PS C:\\Users\\Mectov></span><span>${this.escapeHtml(cmd)}</span></div>`;
                
                // Process
                if (cmd) this.processCommand(cmd, history);
                
                // Clear and Scroll
                input.value = '';
                const content = document.getElementById('terminal-content');
                content.scrollTop = content.scrollHeight;
            }
        },
        processCommand(cmd, container) {
            const args = cmd.split(' ');
            const command = args[0].toLowerCase();
            
            let output = '';
            switch(command) {
                case 'ver': output = 'Microsoft Windows [Version 10.0.22000.1]'; break;
                case 'date': output = 'Current Loading Date: ' + new Date().toString(); break;
                case 'echo': output = args.slice(1).join(' '); break;
                case 'cls': 
                    container.innerHTML = ''; 
                    return;
                case 'exit': 
                    appManager.close('terminal');
                    return;
                case 'help':
                    output = 'Supported commands: ver, date, echo, cls, exit, help';
                    break;
                default:
                    output = `<span class="text-red-400">'${command}' is not recognized as an internal or external command, operable program or batch file.</span>`;
            }
            
            if (output) container.innerHTML += `<div class="mb-3 text-gray-300">${output}</div>`;
        },
        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    };
    
    const powerManager = {
        isOpen: false,
        toggle() {
            const menu = document.getElementById('power-menu');
            if (this.isOpen) menu.classList.add('hidden');
            else menu.classList.remove('hidden');
            this.isOpen = !this.isOpen;
        },
        triggerAction(action) {
            this.toggle(); // Close menu
            document.getElementById('start-menu').classList.add('hidden'); // Close start menu

            const bootScreen = document.getElementById('boot-screen');
            const logo = bootScreen.querySelector('svg');
            const spinner = bootScreen.querySelector('.animate-spin');

            if (action === 'lock') {
                 const lockScreen = document.getElementById('lock-screen');
                 lockScreen.style.display = 'flex';
                 lockScreen.style.opacity = '1';
                 // Force reflow
                 void lockScreen.offsetWidth;
                 lockScreen.style.transform = 'translateY(0)';
                 bootManager.state = 'locked';
                 window.systemState = 'locked';
                 return;
            }

            // For Restart/Shutdown
            bootScreen.style.display = 'flex';
            bootScreen.style.backgroundColor = 'black';
            bootScreen.style.opacity = '1';
            
            // Show Logo/Spinner
            if (logo) logo.style.display = 'block';
            if (spinner) spinner.style.display = 'block';
            
            if (action === 'shutdown') {
                setTimeout(() => {
                    if (logo) logo.style.display = 'none';
                    if (spinner) spinner.style.display = 'none';
                    
                    // Add wake button
                    const wakeBtn = document.createElement('button');
                    wakeBtn.className = 'fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white/30 hover:text-white transition animate-pulse text-sm';
                    wakeBtn.innerText = 'System is off. Click to boot.';
                    wakeBtn.onclick = () => window.location.reload();
                    bootScreen.appendChild(wakeBtn);
                }, 3000);
            }
            
            if (action === 'restart') {
                setTimeout(() => {
                     if (logo) logo.style.display = 'none';
                     if (spinner) spinner.style.display = 'none';
                     setTimeout(() => window.location.reload(), 800);
                }, 3000);
            }
        }
    };
    
    // Load saved wallpaper
    document.addEventListener('DOMContentLoaded', () => {
        const savedWallpaper = localStorage.getItem('wallpaper');
        if (savedWallpaper) {
            const wp = appManager.wallpapers.find(w => w.id === savedWallpaper);
            if (wp) {
                document.body.style.backgroundImage = `url('${wp.url}')`;
                if (savedWallpaper === 'blue-wave') {
                    document.body.style.backgroundSize = '100% 100%';
                } else {
                    document.body.style.backgroundSize = 'cover';
                }
                document.body.style.backgroundPosition = 'center';
            }
        }
    });
    
    // Add drag listeners for appManager
    document.addEventListener('mousemove', e => appManager.handleDrag(e));
    document.addEventListener('mouseup', () => appManager.stopDrag());

    // ==================== INIT ====================
    const windowsManager = new WindowsManager();

    // ==================== BOOT & LOCK SCREEN MANAGER ====================
    const bootManager = {
        state: 'booting', // 'booting' | 'locked' | 'desktop'
        bootDuration: 3500, // 3.5 seconds
        
        init() {
            window.systemState = this.state;
            this.updateLockClock();
            setInterval(() => this.updateLockClock(), 1000);
            
            // Start boot sequence
            setTimeout(() => this.finishBoot(), this.bootDuration);
        },
        
        updateLockClock() {
            const now = new Date();
            const timeEl = document.getElementById('lock-time');
            const dateEl = document.getElementById('lock-date');
            
            if (timeEl) {
                timeEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
            }
            if (dateEl) {
                // Format: Saturday 3 January
                const options = { weekday: 'long', day: 'numeric', month: 'long' };
                // Creating manually or using locale. id-ID puts day first: Sabtu, 3 Januari
                // en-US puts month first: Saturday, January 3
                // en-GB puts day first: Saturday 3 January
                dateEl.textContent = now.toLocaleDateString('en-GB', options);
            }
        },
        
        finishBoot() {
            const bootScreen = document.getElementById('boot-screen');
            if (bootScreen) {
                bootScreen.style.opacity = '0';
                setTimeout(() => {
                    bootScreen.style.display = 'none';
                }, 700);
            }
            this.state = 'locked';
            window.systemState = this.state;
            
            // Add lock screen event listeners
            this.addLockListeners();
        },
        
        addLockListeners() {
            const lockScreen = document.getElementById('lock-screen');
            
            const unlock = (e) => {
                if (this.state !== 'locked') return;
                this.unlockScreen();
            };
            
            lockScreen?.addEventListener('click', unlock);
            document.addEventListener('keydown', unlock, { once: false });
        },
        
        unlockScreen() {
            if (this.state !== 'locked') return;
            this.state = 'unlocking';
            
            const lockScreen = document.getElementById('lock-screen');
            const startupSound = document.getElementById('startup-sound');
            
            if (lockScreen) {
                lockScreen.style.transform = 'translateY(-100%)';
                
                if (startupSound) {
                    startupSound.volume = 0.4;
                    startupSound.play().catch(e => console.log('Audio play failed:', e));
                }
                
                setTimeout(() => {
                    lockScreen.style.display = 'none';
                    this.state = 'desktop';
                    window.systemState = 'desktop';
                    
                    // Show About Modal if not shown in this session
                    if (!sessionStorage.getItem('aboutShown')) {
                        const aboutModal = document.getElementById('about-modal');
                        if (aboutModal) {
                            aboutModal.classList.remove('hidden');
                            aboutModal.classList.add('animate-in', 'zoom-in-95', 'duration-300');
                            sessionStorage.setItem('aboutShown', 'true');
                        }
                    }
                }, 700);
            }
        }
    };
    
    // Initialize boot sequence
    bootManager.init();

    // ==================== CALENDAR MANAGER ====================
    const calendarManager = {
        isOpen: false,
        currentDate: new Date(),
        viewYear: new Date().getFullYear(),
        viewMonth: new Date().getMonth(),
        
        toggle() {
            if (window.systemState !== 'desktop') return;
            const flyout = document.getElementById('calendar-flyout');
            if (this.isOpen) {
                flyout.classList.add('calendar-animate-out');
                setTimeout(() => {
                    flyout.classList.add('hidden');
                    flyout.classList.remove('calendar-animate-out');
                }, 150);
                this.isOpen = false;
            } else {
                this.viewYear = this.currentDate.getFullYear();
                this.viewMonth = this.currentDate.getMonth();
                this.render();
                flyout.classList.remove('hidden');
                flyout.classList.add('calendar-animate-in');
                setTimeout(() => flyout.classList.remove('calendar-animate-in'), 200);
                this.isOpen = true;
            }
        },
        
        close() {
            if (!this.isOpen) return;
            const flyout = document.getElementById('calendar-flyout');
            flyout.classList.add('calendar-animate-out');
            setTimeout(() => {
                flyout.classList.add('hidden');
                flyout.classList.remove('calendar-animate-out');
            }, 150);
            this.isOpen = false;
        },
        
        prevMonth() {
            this.viewMonth--;
            if (this.viewMonth < 0) { this.viewMonth = 11; this.viewYear--; }
            this.render();
        },
        
        nextMonth() {
            this.viewMonth++;
            if (this.viewMonth > 11) { this.viewMonth = 0; this.viewYear++; }
            this.render();
        },
        
        goToday() {
            this.viewYear = this.currentDate.getFullYear();
            this.viewMonth = this.currentDate.getMonth();
            this.render();
        },
        
        render() {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            document.getElementById('calendar-header').textContent = `${months[this.viewMonth]} ${this.viewYear}`;
            
            const container = document.getElementById('calendar-dates');
            container.innerHTML = '';
            
            const firstDay = new Date(this.viewYear, this.viewMonth, 1).getDay();
            const daysInMonth = new Date(this.viewYear, this.viewMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(this.viewYear, this.viewMonth, 0).getDate();
            
            const today = new Date();
            const isCurrentMonth = this.viewYear === today.getFullYear() && this.viewMonth === today.getMonth();
            
            // Previous month days
            for (let i = firstDay - 1; i >= 0; i--) {
                const day = document.createElement('div');
                day.className = 'calendar-day text-white other-month';
                day.textContent = daysInPrevMonth - i;
                container.appendChild(day);
            }
            
            // Current month days
            for (let i = 1; i <= daysInMonth; i++) {
                const day = document.createElement('div');
                day.className = 'calendar-day text-white' + (isCurrentMonth && i === today.getDate() ? ' today' : '');
                day.textContent = i;
                container.appendChild(day);
            }
            
            // Next month days (fill remaining)
            const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
            const remaining = totalCells - (firstDay + daysInMonth);
            for (let i = 1; i <= remaining; i++) {
                const day = document.createElement('div');
                day.className = 'calendar-day text-white other-month';
                day.textContent = i;
                container.appendChild(day);
            }
        }
    };

    // Global event listeners
    document.addEventListener('mousemove', e => { resizeManager.move(e); dragManager.move(e); });
    document.addEventListener('mouseup', () => { resizeManager.stop(); dragManager.stop(); });
    document.addEventListener('click', e => {
        if (window.systemState !== 'desktop') return; // Don't process clicks during boot/lock
        
        // Start Menu close logic
        const menu = document.getElementById('start-menu');
        const btn = document.getElementById('start-btn');
        if (!menu.contains(e.target) && !btn.contains(e.target)) menu.classList.add('hidden');
        
        // Calendar close logic
        const calFlyout = document.getElementById('calendar-flyout');
        const clockBtn = document.getElementById('clock-btn');
        if (calendarManager.isOpen && !calFlyout.contains(e.target) && !clockBtn.contains(e.target)) {
            calendarManager.close();
        }
    });
    </script>
</body>
</html>
