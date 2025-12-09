<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\Pemilik;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        // eager load pets and the related user to display owner name
        $owners = Pemilik::with(['pets','user'])->paginate($perPage);
        if ($request->wantsJson()) {
            return response()->json($owners);
        }
        return view('resepsionis.owners.index', ['owners' => $owners]);
    }

    /**
     * Show the form for creating a new owner.
     */
    public function create()
    {
        // create view: nama + email fields (email will be used to create/link User)
        return view('resepsionis.owners.create');
    }

    /**
     * Show the form for editing the specified owner.
     */
    public function edit($id)
    {
        $owner = Pemilik::with('pets')->findOrFail($id);
        return view('resepsionis.owners.edit', ['owner' => $owner]);
    }

    public function store(StoreOwnerRequest $request)
    {
        $data = $request->validated();

        // Find or create user by email. Use provided nama for user.nama.
        $email = $data['email'];
        $name = $data['nama'];

        $user = User::where('email', $email)->first();
        if (! $user) {
            $user = User::create([
                'nama' => $name,
                'email' => $email,
                'password' => Str::random(12),
            ]);
        } else {
            // ensure user's nama is set/updated if provided
            if (! empty($name) && $user->nama !== $name) {
                $user->nama = $name;
                $user->save();
            }
        }

        // Attach pemilik role if exists
        $role = Role::where('nama_role', 'pemilik')->orWhere('nama_role', 'Pemilik')->first();
        if ($role) {
            // qualify the column to avoid ambiguity between `role.idrole` and `role_user.idrole`
            if (! $user->roles()->wherePivot('idrole', $role->idrole)->exists()) {
                $user->roles()->attach($role->idrole, ['status' => 1]);
            }
        }

        // Create pemilik record, linking to the user
        $owner = Pemilik::create([
            'no_wa' => $data['no_wa'],
            'alamat' => $data['alamat'],
            'iduser' => $user->iduser,
        ]);

        if ($request->wantsJson()) {
            return response()->json($owner, 201);
        }
        return redirect()->route('resepsionis.owners.index')->with('success', 'Owner created');
    }

    public function update(UpdateOwnerRequest $request, $id)
    {
        $owner = Pemilik::findOrFail($id);
        $data = $request->validated();

        // If email provided, find or create user and link
        if (! empty($data['email'])) {
            $user = User::where('email', $data['email'])->first();
            if (! $user) {
                $user = User::create([
                    'nama' => $data['nama'] ?? null,
                    'email' => $data['email'],
                    'password' => Str::random(12),
                ]);
            } else {
                if (! empty($data['nama']) && $user->nama !== $data['nama']) {
                    $user->nama = $data['nama'];
                    $user->save();
                }
            }

            // attach role pemilik if needed
            $role = Role::where('nama_role', 'pemilik')->orWhere('nama_role', 'Pemilik')->first();
            if ($role && ! $user->roles()->wherePivot('idrole', $role->idrole)->exists()) {
                $user->roles()->attach($role->idrole, ['status' => 1]);
            }

            $data['iduser'] = $user->iduser;
        }

        // Only update allowed pemilik fields
        $owner->update(array_filter([
            'no_wa' => $data['no_wa'] ?? null,
            'alamat' => $data['alamat'] ?? null,
            'iduser' => $data['iduser'] ?? $owner->iduser,
        ], function ($v) { return ! is_null($v); }));

        if ($request->wantsJson()) {
            return response()->json($owner);
        }
        return redirect()->route('resepsionis.owners.index')->with('success', 'Owner updated');
    }

    public function destroy($id)
    {
        $owner = Pemilik::findOrFail($id);
        $owner->delete(); // soft delete
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Deleted (soft)'], 200);
        }
        return redirect()->back()->with('success', 'Owner deleted');
    }

    public function restore($id)
    {
        $owner = Pemilik::withTrashed()->where('idpemilik', $id)->firstOrFail();
        $owner->restore();
        if (request()->wantsJson()) {
            return response()->json($owner);
        }
        return redirect()->route('resepsionis.owners.index')->with('success', 'Owner restored');
    }
}
