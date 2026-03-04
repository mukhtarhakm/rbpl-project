<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RKASController extends Controller
{
    public function create()
    {
        // For now, we'll just show the view. 
        // In a real app, we might pass available budget data here.
        return view('bendahara.rkas-create');
    }

    public function store(Request $request)
    {
        // Validation and logic for saving RKAS would go here.
        // For matching the Figma experience, we'll just redirect back with success.
        return redirect()->back()->with('success', 'RKAS berhasil dibuat');
    }
}
