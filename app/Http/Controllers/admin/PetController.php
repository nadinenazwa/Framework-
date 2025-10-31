<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with(['pemilik.user', 'rasHewan'])->paginate(10);
        return view('admin.pet.index', compact('pets'));
    }
}
