<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Clients</title>
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
        .badge-actiu{
            background:green;
        }
        .badge-inactiu{
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
    <h1>Llista de Clients</h1>
    <a class="btn btn-create">
        Crear Client
    </a>
</div>
@if($clients->count())
    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>CIF</th>
            <th>Email</th>
            <th>Telèfon</th>
            <th>Numero Projectes</th>
            <th>Estat</th>
            <th>Accions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->nom }}</td>
                <td>{{ $client->cif }}</td>
                <td>{{ $client->email_contacte }}</td>
                <td>{{ $client->telefon }}</td>
                <td>{{ $client->projectes->count() }}</td>
                <td>
                    @if($client->actiu)
                        <span class="badge badge-actiu">Actiu</span>
                    @else
                        <span class="badge badge-inactiu">Inactiu</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $clients->links() }}
    </div>
@else
    <p>No hi ha clients registrats.</p>
@endif
</body>
</html>
