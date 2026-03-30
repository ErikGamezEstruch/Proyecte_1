<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Detalls del Projecte</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
        }
        .card {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            background: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background: #f4f4f4;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            color: white;
            font-size: 12px;
        }
        .planificacio { background: gray; }
        .en_curs { background: green; }
        .pausat { background: orange; }
        .finalitzat { background: blue; }
        .cancelat { background: red; }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            margin-right: 5px;
        }
        .btn-edit { background: #ffc107; color: black; }
        .btn-delete { background: #dc3545; }
        .btn-back { background: #6c757d; }
    </style>
</head>
<body>
<h1>Detalls del Projecte</h1>
<h3>Assignar desenvolupador</h3>
<form method="POST" action="{{ route('project.assignDev', $projecte->id) }}">
    @csrf

    <select name="user_id">
        @foreach(\App\Models\User::where('role','DESENVOLUPADOR')->get() as $dev)
            <option value="{{ $dev->id }}">{{ $dev->name }}</option>
        @endforeach
    </select>

    <button type="submit">Assignar</button>
</form>
<h3>Equip del projecte</h3>

@foreach($projecte->devs as $dev)
    <p>{{ $dev->name }}</p>
@endforeach
<div class="card">
    <p><strong>Id client:</strong> {{ $projecte->client_id }}</p>
    <p><strong>Id gestor:</strong> {{ $projecte->gestor_id }}</p>
    <p><strong>Nom:</strong> {{ $projecte->nom }}</p>
    <p><strong>Descripcio:</strong> {{ $projecte->descripcio }}</p>
    <p><strong>Codi del Projecte:</strong> {{ $projecte->codi_projecte }}</p>
    <p>
        <strong>Estat:</strong>
        <span class="badge {{ strtolower($projecte->estat) }}">
            {{ $projecte->estat }}
        </span>
    </p>
    <p><strong>Data inici:</strong> {{ $projecte->data_inici }}</p>
    <p><strong>Data fi prevista:</strong> {{ $projecte->data_fi_prevista }}</p>
    <p><strong>Data fi real:</strong> {{ $projecte->data_fi_real }}</p>
    <p><strong>Hores estimades:</strong> {{ $projecte->pressupost_hores_estimades }}</p>
    <p><strong>Hores reals:</strong> {{ $projecte->pressupost_hores_reals }}</p>
</div>
<h2>Clients en el Projecte</h2>
@if($projecte->client_id)
    <table>
        <thead>
        <tr>
            <th>Id client</th>
            <th>Id gestor</th>
            <th>Nom</th>
            <th>Descripcio</th>
            <th>Codi del Projecte</th>
            <th>Estat</th>
            <th>Data inici</th>
            <th>Data fi prevista</th>
            <th>Data fi real</th>
            <th>Hores estimades</th>
            <th>Hores reals</th>
        </tr>
        </thead>
        <tbody>
        @if($projecte->client)
            <tr>
                <td>{{ $projecte->client->id }}</td>
                <td>{{ $projecte->client->gestor_id ?? '' }}</td>
                <td>{{ $projecte->client->nombre }}</td>
                <td>{{ $projecte->client->descripcio ?? '' }}</td>
                <td>{{ $projecte->codi_projecte }}</td>
                <td>
        <span class="badge {{ strtolower($projecte->estat) }}">
            {{ $projecte->estat }}
        </span>
                </td>
                <td>{{ $projecte->data_inici }}</td>
                <td>{{ $projecte->data_fi_prevista }}</td>
                <td>{{ $projecte->data_fi_real }}</td>
                <td>{{ $projecte->pressupost_hores_estimades }}</td>
                <td>{{ $projecte->pressupost_hores_reals }}</td>
            </tr>
        @else
            <tr>
                <td colspan="11">Aquest projecte no té client associat.</td>
            </tr>
        @endif
        </tbody>
    </table>
@else
    <p>Aquest projecte no té clients associats.</p>
@endif
<br>
<a href="{{ route('proyects.edit', $projecte->id) }}" class="btn btn-edit">
    Editar
</a>
<form method="POST" action="{{ route('proyects.destroy', $projecte->id) }}" style="display:inline;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="actiu" value="0">
    <button type="submit" class="btn btn-delete">
        Desactivar
    </button>
</form>
<a href="{{ route('proyects.index') }}" class="btn btn-back">
    Tornar
</a>
</body>
</html>
