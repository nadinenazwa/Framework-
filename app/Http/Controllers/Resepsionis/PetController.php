<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $pets = Pet::with(['pemilik.user','rasHewan'])->paginate($perPage);
        // get all columns from the 'pet' table so the view can render them dynamically
        $columns = \Schema::getColumnListing('pet');
        if ($request->wantsJson()) {
            return response()->json($pets);
        }
        return view('resepsionis.pets.index', ['pets' => $pets, 'columns' => $columns]);
    }

    /**
     * Show the form for creating a new pet.
     */
    public function create()
    {
        // load owners for select dropdown
        $owners = \App\Models\Pemilik::with('user')->orderBy('idpemilik','desc')->get();
        $breeds = \App\Models\RasHewan::orderBy('nama_ras')->get();
        return view('resepsionis.pets.create', ['owners' => $owners, 'breeds' => $breeds]);
    }

    /**
     * Show the form for editing the specified pet.
     */
    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        $owners = \App\Models\Pemilik::with('user')->orderBy('idpemilik','desc')->get();
        $breeds = \App\Models\RasHewan::orderBy('nama_ras')->get();
        return view('resepsionis.pets.edit', ['pet' => $pet, 'owners' => $owners, 'breeds' => $breeds]);
    }

    public function store(StorePetRequest $request)
    {
        $data = $request->validated();
        $pet = Pet::create($data);
        if ($request->wantsJson()) {
            return response()->json($pet, 201);
        }
        return redirect()->route('resepsionis.pets.index')->with('success', 'Pet created');
    }

    public function update(UpdatePetRequest $request, $id)
    {
        $pet = Pet::findOrFail($id);
        $pet->update($request->validated());
        if ($request->wantsJson()) {
            return response()->json($pet);
        }
        return redirect()->route('resepsionis.pets.index')->with('success', 'Pet updated');
    }

    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete(); // soft delete
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Deleted (soft)'], 200);
        }
        return redirect()->back()->with('success', 'Pet deleted');
    }

    public function restore($id)
    {
        $pet = Pet::withTrashed()->where('idpet', $id)->firstOrFail();
        $pet->restore();
        if (request()->wantsJson()) {
            return response()->json($pet);
        }
        return redirect()->route('resepsionis.pets.index')->with('success', 'Pet restored');
    }
}
