<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();
        return view('admin.Role.index', compact('role'));
    }

    public function create()
    {
        return view('admin.Role.create');
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
            $this->createRecord($request);

            return redirect()->route('admin.role.index')
                ->with('success', 'Data role berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data role: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.Role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validator = $this->validateData($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $role->update([
                'nama_role' => $this->formatNama($request->nama_role),
            ]);

            return redirect()->route('admin.role.index')
                ->with('success', 'Data role berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data role: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->route('admin.role.index')
                ->with('success', 'Data role berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data role: ' . $e->getMessage());
        }
    }

    /**
     * Validate role data
     */
    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'nama_role' => 'required|string|max:255|unique:role,nama_role' . ($id ? ',' . $id . ',idrole' : ''),
        ];

        $messages = [
            'nama_role.required' => 'Nama role wajib diisi.',
            'nama_role.string' => 'Nama role harus berupa teks.',
            'nama_role.max' => 'Nama role maksimal 255 karakter.',
            'nama_role.unique' => 'Nama role sudah ada.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create new role record
     */
    private function createRecord(Request $request)
    {
        return Role::create([
            'nama_role' => $this->formatNama($request->nama_role),
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
