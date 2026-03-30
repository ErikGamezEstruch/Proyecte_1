<h1>{{ $ticket->titol }}</h1>

<p>{{ $ticket->descripcio }}</p>

<p>Estado: {{ $ticket->estat }}</p>

<p>Assignat a: {{ $ticket->user->name ?? 'No assignat' }}</p>

<hr>

<h2>Comentaris</h2>

@foreach ($ticket->comentaris as $comentari)
    <p>{{ $comentari->text }}</p>

    <form method="POST" action="{{ route('comentaris.destroy', $comentari) }}">
        @csrf
        @method('DELETE')
        <button>Eliminar</button>
    </form>
@endforeach

<hr>

<h3>Añadir comentario</h3>

<form method="POST" action="{{ route('comentaris.store', $ticket->id) }}">
    @csrf

    <textarea name="text"></textarea>

    @error('text') <p>{{ $message }}</p> @enderror

    <button>Enviar</button>
</form>

<h3>Canviar estat</h3>

<form method="POST" action="{{ route('tickets.changeStatus', [$projecte->id, $ticket->id]) }}">
    @csrf

    <select name="estat">
        @if($ticket->estat == 'NOU')
            <option value="ASSIGNAT">Assignat</option>
        @endif

        @if($ticket->estat == 'ASSIGNAT')
            <option value="EN_PROGRES">En progrés</option>
        @endif

        @if($ticket->estat == 'EN_PROGRES')
            <option value="EN_REVISIO">En revisió</option>
        @endif

        @if($ticket->estat == 'EN_REVISIO')
            <option value="TANCAT">Tancat</option>
        @endif
    </select>

    <button type="submit">Canviar estat</button>
</form>

<h3>Registrar temps</h3>

<form method="POST" action="{{ route('tickets.storeTime', [$projecte->id, $ticket->id]) }}">
    @csrf

    <input type="number" name="hores" placeholder="Hores" min="1" max="12">
    <input type="date" name="data">

    <textarea name="descripcio" placeholder="Descripció"></textarea>

    <button type="submit">Guardar temps</button>
</form>

<h3>Registre de temps</h3>

@foreach($ticket->registresTemps as $registre)
    <p>
        {{ $registre->data }} -
        {{ $registre->hores }}h -
        {{ $registre->descripcio }}
    </p>
@endforeach
