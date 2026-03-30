<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Formulari de Projectes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f7fc;
        }
        h1 {
            color: #333;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .btn-group {
            margin-top: 20px;
            text-align: center;
        }
        .btn-group a,
        .btn-group button {
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
        }
        .btn-create {
            background-color: #007bff;
        }
        .btn-edit {
            background-color: #ffc107;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-back {
            background-color: #6c757d;
        }
        .btn-create:hover {
            background-color: #0056b3;
        }
        .btn-edit:hover {
            background-color: #e0a800;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<h1>Formulari de Projectes</h1>
@if(session('success'))
    <div style="background: #d4edda; padding: 10px; border-radius: 5px; color: #155724; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background: #f8d7da; padding: 10px; border-radius: 5px; color: #721c24; margin-bottom: 20px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $isEdit = isset($projecte) && $projecte->id;
@endphp

<div class="form-container">
    <form method="POST" action="{{ $isEdit ? route('proyects.update', $projecte->id) : route('proyects.store') }}">
        @csrf
        @if($isEdit)
            @method('PATCH')
        @endif

        <div class="form-group">
            <label for="nom">Nom del Projecte:</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom', $projecte->nom ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="codi_projecte">Codi del Projecte:</label>
            <input type="text" id="codi_projecte" name="codi_projecte" value="{{ old('codi_projecte', $projecte->codi_projecte ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="client_id">Client:</label>
            <select id="client_id" name="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @if(old('client_id', $projecte->client_id ?? '') == $client->id) selected @endif>
                        {{ $client->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="gestor_id">Gestor:</label>
            <select id="gestor_id" name="gestor_id" required>
                @foreach($gestors as $gestor)
                    <option value="{{ $gestor->id }}" @if(old('gestor_id', $projecte->gestor_id ?? '') == $gestor->id) selected @endif>
                        {{ $gestor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="descripcio">Descripció:</label>
            <textarea id="description" name="description" rows="4">{{ old('description', $projecte->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="data_inici">Data d'Inici:</label>
            <input type="date" id="data_inici" name="data_inici" value="{{ old('data_inici', $projecte->data_inici ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="data_fi_prevista">Data Fi Prevista:</label>
            <input type="date" id="data_fi_prevista" name="data_fi_prevista" value="{{ old('data_fi_prevista', $projecte->data_fi_prevista ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="estat">Estat:</label>
            <select id="estat" name="estat" required>
                <option value="en_curs" @if(old('estat', $projecte->estat ?? '') == 'en_curs') selected @endif>En Curs</option>
                <option value="finalitzat" @if(old('estat', $projecte->estat ?? '') == 'finalitzat') selected @endif>Finalitzat</option>
                <option value="pausat" @if(old('estat', $projecte->estat ?? '') == 'pausat') selected @endif>Pausat</option>
                <option value="cancelat" @if(old('estat', $projecte->estat ?? '') == 'cancelat') selected @endif>Cancelat</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pressupost_hores_estimades">Hores Estimades:</label>
            <input type="number" id="pressupost_hores_estimades" name="pressupost_hores_estimades" value="{{ old('pressupost_hores_estimades', $projecte->pressupost_hores_estimades ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="pressupost_hores_reals">Hores Reals:</label>
            <input type="number" id="pressupost_hores_reals" name="pressupost_hores_reals" value="{{ old('pressupost_hores_reals', $projecte->pressupost_hores_reals ?? '') }}">
        </div>

        <div class="btn-group">
            <button type="submit" class="btn {{ $isEdit ? 'btn-edit' : 'btn-create' }}">
                {{ $isEdit ? 'Guardar' : 'Crear' }}
            </button>
            <a href="{{ route('proyects.index') }}" class="btn btn-back">Tornar</a>
        </div>
    </form>
</div>
</body>
</html>
