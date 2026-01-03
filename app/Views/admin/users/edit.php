<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl">
    <!-- Header -->
    <div class="mb-6">
        <a href="/admin/users" class="text-slate-500 hover:text-primary-600 transition-colors inline-flex items-center space-x-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Edit User</h1>
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
        
        <!-- User Info -->
        <div class="flex items-center space-x-4 mb-6 p-4 bg-slate-50 rounded-xl">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br <?= getAvatarTailwind($user['email']) ?> flex items-center justify-center text-white text-xl font-bold">
                <?= getInitials($user['username']) ?>
            </div>
            <div>
                <p class="font-semibold text-slate-800"><?= esc($user['username']) ?></p>
                <p class="text-sm text-slate-500"><?= esc($user['email']) ?></p>
            </div>
        </div>
        
        <form action="/admin/users/update/<?= $user['id'] ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>
            
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Username *</label>
                <input type="text" id="username" name="username" value="<?= old('username', $user['username']) ?>" 
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                       placeholder="contoh: john_doe" required>
            </div>
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email *</label>
                <input type="email" id="email" name="email" value="<?= old('email', $user['email']) ?>" 
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                       placeholder="contoh@email.com" required>
            </div>
            
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                <input type="password" id="password" name="password" 
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all"
                       placeholder="Kosongkan jika tidak ingin mengubah">
                <p class="mt-2 text-xs text-slate-500">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.</p>
            </div>
            
            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Role *</label>
                <select id="role" name="role" 
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all" required>
                    <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="staff" <?= old('role', $user['role']) === 'staff' ? 'selected' : '' ?>>Staff</option>
                    <option value="customer" <?= old('role', $user['role']) === 'customer' ? 'selected' : '' ?>>Customer</option>
                </select>
            </div>
            
            <!-- Submit -->
            <div class="flex items-center space-x-4">
                <button type="submit" 
                        class="px-6 py-3 bg-primary-500 text-white rounded-xl font-semibold hover:bg-primary-600 transition-colors shadow-lg hover:shadow-xl">
                    Update User
                </button>
                <a href="/admin/users" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-medium hover:bg-slate-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
