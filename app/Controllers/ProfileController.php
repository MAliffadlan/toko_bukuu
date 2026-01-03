<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return redirect()->to('/logout');
        }
        
        return view('profile/index', [
            'title' => 'Profil Saya',
            'user' => $user
        ]);
    }
    
    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return redirect()->to('/logout');
        }
        
        $rules = [
            'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$userId}]",
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
        ];
        
        // Check if password change is requested
        if ($this->request->getPost('new_password')) {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'required|min_length[6]';
            $rules['confirm_password'] = 'required|matches[new_password]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        // Verify current password if changing password
        if ($this->request->getPost('new_password')) {
            if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', ['current_password' => 'Password saat ini tidak benar']);
            }
        }
        
        // Prepare data for update
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
        ];
        
        // Add new password if provided
        if ($this->request->getPost('new_password')) {
            $data['password'] = $this->request->getPost('new_password');
        }
        
        // Update user
        $this->userModel->update($userId, $data);
        
        // Update session data
        session()->set([
            'username' => $data['username'],
            'email' => $data['email'],
        ]);
        
        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
