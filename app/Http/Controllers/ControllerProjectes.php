<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracioProjecte;
use App\Models\Projectes;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerProjectes extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Projectes::class, 'projecte');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'ADMIN' || $user->role === 'GESTOR') {
            $proyectes = Projectes::query();
        }
        elseif ($user->role === 'CLIENT') {
            $proyectes = Projectes::where('client_id', $user->client_id);
        }
        elseif ($user->role === 'DESENVOLUPADOR') {
            $proyectes = Projectes::whereHas('devs', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }
        else {
            // 🔥 fallback seguro
            $proyectes = Projectes::query()->whereRaw('0 = 1');
        }

        return view('proyects.index', [
            'proyectos' => $proyectes->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('actiu', 1)->get();
        $gestors = User::all(); // todos los gestores

        $projecte = new Projectes(); // objeto vacío para el formulario

        return view('proyects.form', compact('projecte', 'clients', 'gestors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'codi_projecte' => 'required|string|max:50',
            'client_id' => 'required|exists:clients,id',
            'gestor_id' => 'required|exists:users,id',
            'pressupost_hores_estimades' => 'required|numeric|min:1',
            'data_inici' => 'required|date',
            'estat' => 'required|in:en_curs,finalitzat,pausat,cancelat',
        ]);

        $projecte = Projectes::create($request->only(
            'nom',
            'codi_projecte',
            'client_id',
            'gestor_id',
            'pressupost_hores_estimades',
            'data_inici',
            'estat',
            'data_fi_prevista',
            'description',
            'pressupost_hores_reals'
        ));

        // Crear configuración inicial si aplica
        ConfiguracioProjecte::create([
            'projecte_id' => $projecte->id,
        ]);

        return redirect()->route('proyects.show', $projecte->id)
            ->with('success', 'Projecte creat correctament');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Cargar el proyecto con su cliente y gestor
        $projecte = Projectes::with(['client', 'gestor'])->findOrFail($id);

        return view('proyects.show', compact('projecte'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $projecte = Projectes::with(['client', 'gestor'])->findOrFail($id);

        // Traer clientes activos
        $clients = Client::where('actiu', 1)->get();

        // Traer gestores (usuarios que gestionan proyectos)
        $gestors = User::all(); // o filtrar según tu lógica

        // Retornar la vista pasando todas las variables
        return view('proyects.form', compact('projecte', 'clients', 'gestors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $projecte = Projectes::findOrFail($id);
        $projecte->update($request->only([
            'nom',
            'codi_projecte',
            'client_id',
            'gestor_id',
            'estat',
            'data_inici',
            'data_fi_prevista',
            'pressupost_hores_estimades',
            'pressupost_hores_reals'
        ]));

        return redirect()->route('proyects.show', $projecte->id)
            ->with('success', 'Projecte actualitzat correctament');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projecte = Projectes::findOrFail($id);
        $projecte->delete();

        return redirect()->route('proyects.index')
            ->with('success', 'Projecte eliminat correctament');
    }

    public function canviarEstat(Request $request, Projectes $projecte)
    {
        $request->validate([
            'estat' => 'required|in:PLANIFICACIO,EN_CURS,PAUSAT,FINALIZAT,CANCELAT'
        ]);

        $nouEstat = $request->estat;
        $estatActual = $projecte->estat;

        if ($nouEstat === 'CANCELAT') {
            $projecte->estat = 'CANCELAT';
            $projecte->save();

            return redirect()->route('proyects.show', $projecte->id)
                ->with('success', 'Projecte cancel·lat correctament.');
        }

        if ($estatActual === 'PLANIFICACIO' && $nouEstat === 'EN_CURS') {

            if (!$projecte->data_inici) {
                return back()->withErrors('Cal definir data d\'inici abans de començar el projecte.');
            }

            $projecte->estat = 'EN_CURS';
            $projecte->save();

            return redirect()->route('proyects.show', $projecte->id)
                ->with('success', 'Projecte iniciat.');
        }

        if ($estatActual === 'EN_CURS' && $nouEstat === 'PAUSAT') {
            $projecte->estat = 'PAUSAT';
            $projecte->save();

            return redirect()->route('proyects.show', $projecte->id)
                ->with('success', 'Projecte pausat.');
        }

        if ($estatActual === 'PAUSAT' && $nouEstat === 'EN_CURS') {
            $projecte->estat = 'EN_CURS';
            $projecte->save();

            return redirect()->route('proyects.show', $projecte->id)
                ->with('success', 'Projecte reprès.');
        }

        if ($estatActual === 'EN_CURS' && $nouEstat === 'FINALIZAT') {

            $projecte->estat = 'FINALIZAT';
            $projecte->data_fi_real = now();
            $projecte->save();

            return redirect()->route('proyects.show', $projecte->id)
                ->with('success', 'Projecte finalitzat.');
        }

        return back()->withErrors('Transició d\'estat no permesa.');
    }
    public function assignDev(Request $request, $id)
    {
        $projecte = Projectes::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->role !== 'DESENVOLUPADOR') {
            return back()->withErrors('Només es poden assignar desenvolupadors');
        }

        $projecte->devs()->syncWithoutDetaching([$user->id]);

        return back()->with('success', 'Dev assignat correctament');
    }

}
