<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Header -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Users</h1>
        <p class="text-slate-500">Daftar semua pengguna sistem</p>
    </div>
    <a href="/admin/users/create" class="px-4 py-2 bg-primary-500 text-white rounded-lg font-medium hover:bg-primary-600 transition-colors flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
        </svg>
        <span>Tambah User</span>
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <form action="/admin/users" method="get" class="flex flex-wrap gap-4">
        <div class="w-48">
            <select name="role" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-500 outline-none transition-all">
                <option value="">Semua Role</option>
                <option value="admin" <?= $selectedRole === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="staff" <?= $selectedRole === 'staff' ? 'selected' : '' ?>>Staff</option>
                <option value="customer" <?= $selectedRole === 'customer' ? 'selected' : '' ?>>Customer</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors font-medium">
            Filter
        </button>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">User</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Bergabung</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br <?= getAvatarTailwind($user['email']) ?> flex items-center justify-center text-white font-bold">
                                    <?= getInitials($user['username']) ?>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800"><?= esc($user['username']) ?></p>
                                    <p class="text-sm text-slate-500"><?= esc($user['email']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <?php
                            $roleColors = [
                                'admin' => 'bg-red-100 text-red-700',
                                'staff' => 'bg-blue-100 text-blue-700',
                                'customer' => 'bg-green-100 text-green-700',
                            ];
                            $roleColor = $roleColors[$user['role']] ?? 'bg-slate-100 text-slate-700';
                            ?>
                            <span class="px-3 py-1 <?= $roleColor ?> text-sm rounded-full font-medium capitalize"><?= $user['role'] ?></span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            <?= date('d M Y', strtotime($user['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="/admin/users/edit/<?= $user['id'] ?>" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <?php if ($user['id'] != session()->get('user_id')): ?>
                                <form action="/admin/users/delete/<?= $user['id'] ?>" method="post" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                        Tidak ada user ditemukan.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if (!empty($users)): ?>
    <div class="px-6 py-4 border-t border-slate-200">
        <?= $pager->links() ?>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
