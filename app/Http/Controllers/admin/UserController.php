<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('roles')->get();
        return view('admin.User.index', compact('user'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.User.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = $this->validateData($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = $this->createRecord($request);

            // Attach role with status
            $user->roles()->attach($request->idrole, ['status' => $request->status]);

            return redirect()->route('admin.user.index')
                ->with('success', 'Data user berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('admin.User.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = $this->validateData($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $userData = [
                'nama' => $this->formatNama($request->nama),
                'email' => strtolower(trim($request->email)),
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Sync role with status
            $user->roles()->sync([$request->idrole => ['status' => $request->status]]);

            return redirect()->route('admin.user.index')
                ->with('success', 'Data user berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Detach all roles before deleting
            $user->roles()->detach();
            
            $user->delete();

            return redirect()->route('admin.user.index')
                ->with('success', 'Data user berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data user: ' . $e->getMessage());
        }
    }

    /**
     * Validate user data
     */
    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email' . ($id ? ',' . $id . ',iduser' : ''),
            'password' => ($id ? 'nullable' : 'required') . '|string|min:8|confirmed',
            'idrole' => 'required|exists:role,idrole',
            'status' => 'required|in:aktif,nonaktif',
        ];

        $messages = [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'idrole.required' => 'Role wajib dipilih.',
            'idrole.exists' => 'Role tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus aktif atau nonaktif.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create new user record
     */
    private function createRecord(Request $request)
    {
        return User::create([
            'nama' => $this->formatNama($request->nama),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Format nama with proper capitalization
     */
    private function formatNama($nama)
    {
        return ucwords(strtolower(trim($nama)));
    }
}
