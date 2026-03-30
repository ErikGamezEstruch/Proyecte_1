<h1>Crear Ticket</h1>

<form method="POST" action="{{ route('projectes.tickets.store', $projecte) }}">
    @csrf

    <label>Codi ticket</label>
    <input type="text" name="codi_ticket" value="{{ old('codi_ticket') }}">
    @error('codi_ticket') <p>{{ $message }}</p> @enderror

    <label>Títol</label>
    <input type="text" name="titol" value="{{ old('titol') }}">
    @error('titol') <p>{{ $message }}</p> @enderror

    <label>Descripció</label>
    <textarea name="descripcio">{{ old('descripcio') }}</textarea>

    <button type="submit">Crear</button>
</form>
