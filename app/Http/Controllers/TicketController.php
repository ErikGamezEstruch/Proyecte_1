<?php

namespace App\Http\Controllers;

use App\Models\Projectes;
use App\Models\RegistreTemps;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Projectes $projecte)
    {
        $tickets = $projecte->tickets;

        return view('tikets.index', compact('projecte', 'tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Projectes $projecte)
    {
        return view('tikets.create', compact('projecte'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Projectes $projecte)
    {
        $request->validate([
            'codi_ticket' => 'required|unique:tickets',
            'titol' => 'required',
            'projecte_id' => 'exists:projectes,id',
        ]);

        Ticket::create([
            'projecte_id' => $projecte->id,
            'creador_id' => auth()->id(),
            'codi_ticket' => $request->codi_ticket,
            'titol' => $request->titol,
            'descripcio' => $request->descripcio,
        ]);

        return redirect()->route('projectes.tickets.index', $projecte);
    }

    /**
     * Display the specified resource.
     */
    public function show(Projectes $projecte, Ticket $ticket)
    {
        $totalHores = $ticket->registresTemps->sum('hores');

        return view('tikets.show', compact('projecte', 'ticket', 'totalHores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projectes $projecte, Ticket $ticket)
    {
        return view('tikets.edit', compact('projecte', 'ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projectes $projecte, Ticket $ticket)
    {
        $ticket->update($request->all());

        return redirect()->route('projectes.tickets.show', [$projecte, $ticket]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeStatus(Request $request, Projectes $projecte, Ticket $ticket)
    {
        $request->validate([
            'estat' => 'required|in:NOU,ASSIGNAT,EN_PROGRES,EN_REVISIO,TANCAT'
        ]);

        $user = auth()->user();
        $nou = $request->estat;
        $actual = $ticket->estat;

        if ($actual === 'NOU' && $nou === 'ASSIGNAT') {

            $ticket->estat = 'ASSIGNAT';
        }

        elseif ($actual === 'ASSIGNAT' && $nou === 'EN_PROGRES') {

            if ($ticket->user_id !== $user->id) {
                return back()->withErrors('Només el desenvolupador assignat pot iniciar el ticket');
            }

            $ticket->estat = 'EN_PROGRES';
        }

        elseif ($actual === 'EN_PROGRES' && $nou === 'EN_REVISIO') {

            if ($ticket->user_id !== $user->id) {
                return back()->withErrors('Només el desenvolupador assignat pot enviar a revisió');
            }

            $ticket->estat = 'EN_REVISIO';
        }

        elseif ($actual === 'EN_REVISIO' && $nou === 'TANCAT') {

            if (!in_array($user->role, ['ADMIN', 'GESTOR'])) {
                return back()->withErrors('Només un gestor o admin pot tancar el ticket');
            }

            $ticket->estat = 'TANCAT';
        }

        else {
            return back()->withErrors('Transició no permesa');
        }

        $ticket->save();

        return back()->with('success', 'Estat actualitzat');
    }
    public function storeTime(Request $request, Projectes $projecte, Ticket $ticket)
    {
        $request->validate([
            'hores' => 'required|integer|min:1|max:12',
            'data' => 'required|date|before_or_equal:today',
            'descripcio' => 'nullable|string'
        ]);

        $user = auth()->user();

        // SOLO el dev asignado
        if ($ticket->user_id != $user->id) {
            return back()->withErrors('No pots registrar temps en aquest ticket');
        }

        RegistreTemps::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'hores' => $request->hores,
            'data' => $request->data,
            'descripcio' => $request->descripcio
        ]);

        return back()->with('success', 'Temps registrat');
    }
}
