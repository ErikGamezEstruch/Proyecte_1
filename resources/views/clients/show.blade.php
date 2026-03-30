<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Client</title>
    <style>
        body{
            font-family: Arial;
            margin:40px;
        }
        .card{
            border:1px solid #ddd;
            padding:20px;
            margin-bottom:30px;
            border-radius:8px;
            background:#f9f9f9;
        }
        table{
            width:100%;
            border-collapse: collapse;
        }
        th, td{
            border:1px solid #ddd;
            padding:10px;
        }
        th{
            background:#f4f4f4;
        }
        .badge{
            padding:4px 8px;
            border-radius:6px;
            color:white;
            font-size:12px;
        }
        .planificacio{ background:gray; }
        .en_curs{ background:green; }
        .pausat{ background:orange; }
        .finalitzat{ background:blue; }
        .cancelat{ background:red; }
        .btn{
            padding:8px 12px;
            text-decoration:none;
            border-radius:4px;
            color:white;
            margin-right:5px;
        }
        .btn-edit{ background:#ffc107; color:black; }
        .btn-delete{ background:#dc3545; }
        .btn-back{ background:#6c757d; }
    </style>
</head>
<body>
<h1>Detalls del Client</h1>
<div class="card">
    <p><strong>Nom:</strong> {{ $client->nom }}</p>
    <p><strong>CIF:</strong> {{ $client->cif }}</p>
    <p><strong>Email:</strong> {{ $client->email_contacte }}</p>
    <p><strong>Telèfon:</strong> {{ $client->telefon }}</p>
    <p><strong>Direcció:</strong> {{ $client->direccio }}</p>
    <p>
        <strong>Estat:</strong>
        @if($client->actiu)
            <span class="badge en_curs">Actiu</span>
        @else
            <span class="badge cancelat">Inactiu</span>
        @endif
    </p>
</div>
<h2>Projectes del client</h2>
@if($client->projectes->count())
    <table>
        <thead>
        <tr>
            <th>Codi</th>
            <th>Nom</th>
            <th>Estat</th>
            <th>Data inici</th>
            <th>Data fi prevista</th>
        </tr>
        </thead>
        <tbody>
        @foreach($client->projectes as $projecte)
            <tr>
                <td>{{ $projecte->codi_projecte }}</td>
                <td>{{ $projecte->nom }}</td>
                <td>
                <span class="badge {{ strtolower($projecte->estat) }}">
                    {{ $projecte->estat }}
                </span>
                </td>
                <td>{{ $projecte->data_inici }}</td>
                <td>{{ $projecte->data_fi_prevista }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>Aquest client no té projectes.</p>
@endif
<br>
<a class="btn btn-edit">
    Editar
</a>
<form method="POST" style="display:inline;">
    @csrf
    @method('PUT')
    <input type="hidden" name="actiu" value="0">
    <button type="submit" class="btn btn-delete">
        Desactivar
    </button>
</form>
<a class="btn btn-back">
    Tornar
</a>
</body>
</html>
