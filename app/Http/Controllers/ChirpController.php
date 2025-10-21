<?php

namespace App\Http\Controllers;

use App\Models\Chirp;    
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    public function index()
        {
            $chirps = Chirp::with('user')
            ->latest()
            ->take(50)
            ->get();

    return view('home', ['chirps' => $chirps]);
        }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }
    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $validated = $request->validate([
        'message' => 'required|string|max:255|min:5',
    ]);
        Chirp::create([
        'message' => $validated['message'],
        'user_id' => null, // We'll add authentication in lesson 11
        ]);
        return redirect('/')->with('success', 'Chirp created!');

    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Chirp $chirp)
    {
    // We'll add authorization in lesson 11
    return view('chirps.edit', compact('chirp'));
    }

    public function update(Request $request, Chirp $chirp)
    {
        // Validate
        $validated = $request->validate([
        'message' => 'required|string|max:255',
        ]);

        // Update
        $chirp->update($validated);
        return redirect('/')->with('success', 'Chirp updated!');
    }

    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();

        return redirect('/')->with('success', 'Chirp deleted!');
    }
}
