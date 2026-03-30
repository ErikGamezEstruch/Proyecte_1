<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentariController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'text' => 'required'
        ]);

        $ticket->comentaris()->create([
            'autor_id' => Auth::id(),
            'text' => $request->text,
        ]);

        return back()->with('success', 'Comentari afegit correctament');
    }

    /**
     * Remove the specified comment
     */
    public function destroy(Comentari $comentari)
    {
        $comentari->delete();

        return back()->with('success', 'Comentari eliminat correctament');
    }
}
