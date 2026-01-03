<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Spacer for fixed navbar -->
<div class="h-20"></div>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in-up">
            <div class="w-24 h-24 bg-gradient-to-br from-primary-400 to-accent-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-2xl">
                <span class="text-4xl font-bold text-white"><?= strtoupper(substr(session()->get('username'), 0, 1)) ?></span>
            </div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Profil Saya</h1>
            <p class="text-slate-600">Kelola informasi akun Anda</p>
        </div>
        
        <!-- Profile Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s;">
            <?php if (session()->getFlashdata('errors')): ?>
            <div class="m-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <ul class="text-sm text-red-600 space-y-1">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span><?= esc($error) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <form action="/profile/update" method="post" class="p-8">
                <?= csrf_field() ?>
                
                <!-- Account Info Section -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Informasi Akun</span>
                    </h2>
                    
                    <div class="space-y-5">
                        <div>
                            <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="username" name="username" value="<?= old('username', $user['username']) ?>" 
                                       class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                                       required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" value="<?= old('email', $user['email']) ?>" 
                                       class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Password Section -->
                <div class="mb-8 pt-8 border-t border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Ubah Password</span>
                        <span class="text-xs font-normal text-slate-500">(Opsional)</span>
                    </h2>
                    
                    <div class="space-y-5">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">Password Saat Ini</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                </div>
                                <input type="password" id="current_password" name="current_password" 
                                       class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                                       placeholder="Masukkan password saat ini">
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input type="password" id="new_password" name="new_password" 
                                           class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                                           placeholder="Min. 6 karakter">
                                </div>
                            </div>
                            
                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <input type="password" id="confirm_password" name="confirm_password" 
                                           class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                                           placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit -->
                <div class="flex items-center justify-between">
                    <a href="/browser" class="text-slate-600 hover:text-primary-600 transition-colors font-medium">
                        ← Kembali ke Beranda
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 btn-press">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Account Info Card -->
        <div class="mt-8 bg-gradient-to-r from-primary-50 to-accent-50 rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 mb-1">Informasi Akun</h3>
                    <p class="text-sm text-slate-600">Role: <span class="font-medium capitalize"><?= esc($user['role']) ?></span></p>
                    <p class="text-sm text-slate-600">Bergabung sejak: <?= date('d M Y', strtotime($user['created_at'])) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
