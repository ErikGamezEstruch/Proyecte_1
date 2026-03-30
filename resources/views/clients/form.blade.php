<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Formulari</title>
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
        .btn-edit {
            background-color: #ffc107;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-back {
            background-color: #6c757d;
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
<h1>Formulari de Client</h1>
@if(session('success'))
    <div style="color:green; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif
<div class="form-container">
    <form action="#" method="POST">
        <div class="form-group">
            <label for="nom">Nom del Client:</label>
            <input type="text" id="nom" name="nom" required>
            @error('nom')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="cif">CIF del Client:</label>
            <input type="text" id="cif" name="cif" required>
        </div>
        <div class="form-group">
            <label for="email">Email del Client:</label>
            <input type="email" id="email" name="email_contacte" required>
        </div>
        <div class="form-group">
            <label for="telefon">Telèfon del Client:</label>
            <input type="text" id="telefon" name="telefon" required>
        </div>
        <div class="form-group">
            <label for="direccio">Direcció:</label>
            <textarea id="direccio" name="direccio" rows="3"></textarea>
        </div>
        <div class="btn-group">
            <button type="submit" class="btn btn-edit">Editar</button>
            <button type="submit" class="btn btn-delete">Desactivar</button>
            <a href="#" class="btn btn-back">Tornar</a>
        </div>
    </form>
</div>

</body>
</html>
