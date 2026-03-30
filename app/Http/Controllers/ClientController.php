<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Projectes;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::where('actiu', 1)->paginate(10);
        return view('clients.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cif' => 'required|string',
            'email_contacte' => 'required|email',
            'direccio' => 'nullable|string  ',
            'telefon' => 'nullable|string',
        ]);

        Client::create($request->only('nombre', 'cif', 'email_contacte', 'direccio', 'telefon'));

        return redirect()->route('clients.show');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return redirect()->route('clients.show', $client->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $client->update($request->only('nombre', 'email_contacte'));

        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function projectes(Client $client){
        $projectes = Projectes::where('actiu', 1)->get();
        return view('proyects.projectes', compact('projectes'));
    }
}
