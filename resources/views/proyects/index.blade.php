<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Projectes</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            margin:40px;
        }
        h1{
            margin-bottom:20px;
        }
        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
        }
        table{
            width:100%;
            border-collapse: collapse;
        }
        th, td{
            border:1px solid #ddd;
            padding:10px;
            text-align:left;
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
        .badge-en_curs{
            background:green;
        }
        .badge-finalitzat{
            background:blue;
        }
        .badge-pausat{
            background:orange;
        }
        .badge-cancelat{
            background:red;
        }
        .btn{
            padding:6px 10px;
            text-decoration:none;
            border-radius:4px;
            color:white;
            font-size:14px;
        }
        .btn-create{
            background:#007bff;
        }
        .btn-view{
            background:#17a2b8;
        }
        .btn-edit{
            background:#ffc107;
            color:black;
        }
        .actions a{
            margin-right:5px;
        }
        .pagination{
            margin-top:20px;
        }
    </style>
</head>
<body>
<div class="top-bar">
    <h1>Llista de Projectes</h1>
    <a href="{{ route('proyects.create') }}" class="btn btn-create">Crear Projecte</a>
</div>

@if($proyectos->count())
    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Codi del Projecte</th>
            <th>Client</th>
            <th>Gestor</th>
            <th>Data Inici</th>
            <th>Data Fi Prevista</th>
            <th>Estat</th>
            <th>Accions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($proyectos as $projecte)
            <tr>
                <td>{{ $projecte->nom }}</td>
                <td>{{ $projecte->codi_projecte }}</td>
                <td>{{ $projecte->client->nom }}</td>
                <td>{{ $projecte->gestor->name ?? 'Sense Gestor' }}</td>
                <td>{{ $projecte->data_inici }}</td>
                <td>{{ $projecte->data_fi_prevista }}</td>
                <td>
                    <span class="badge
                        @if($projecte->estat == 'en_curs') badge-en_curs
                        @elseif($projecte->estat == 'finalitzat') badge-finalitzat
                        @elseif($projecte->estat == 'pausat') badge-pausat
                        @elseif($projecte->estat == 'cancelat') badge-cancelat
                        @endif">
                        {{ $projecte->estat }}
                    </span>
                </td>
                <td class="actions">
                    <a href="{{ route('proyects.show', $projecte->id) }}" class="btn btn-view">Veure</a>
                    <a href="{{ route('proyects.edit', $projecte->id) }}" class="btn btn-edit">Editar</a>
                    <form action="{{ route('proyects.destroy', $projecte->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $proyectos->links() }}
    </div>
@else
    <p>No hi ha projectes registrats.</p>
@endif
</body>
</html>
