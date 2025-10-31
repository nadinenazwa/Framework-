<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetResepsionisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with(['pemilik.user', 'rasHewan'])->paginate(10);
        return view('resepsionis.pet.index', compact('pets'));
    }
}
