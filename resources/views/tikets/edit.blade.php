<h1>Editar Ticket</h1>

<form method="POST" action="{{ route('projectes.tickets.update', [$projecte, $ticket]) }}">
    @csrf
    @method('PATCH')

    <label>Títol</label>
    <input type="text" name="titol" value="{{ old('titol', $ticket->titol) }}">

    <label>Descripció</label>
    <textarea name="descripcio">{{ old('descripcio', $ticket->descripcio) }}</textarea>

    <button type="submit">Guardar</button>
</form>
