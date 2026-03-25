<?php

namespace App\Http\Controllers;

use App\Models\NewsLetter;
use Illuminate\Http\Request;

class NewsLetterController extends Controller
{

    /**
     * Store a new newsletter subscription.
     */

    public function store(Request $request)
    {
        $validated=$request->validate([
            'email' => 'required|unique:news_letters|email'
        ]);

        $new_letters=NewsLetter::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thanks for signing up!',
            'new_letters'=> $new_letters
        ]);
    }
}
