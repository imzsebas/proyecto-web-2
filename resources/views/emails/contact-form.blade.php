<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
            display: block;
        }
        .field-value {
            background-color: white;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            word-wrap: break-word;
        }
        .message-field {
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nuevo Mensaje de Contacto</h1>
        <p>Mi Refugio</p>
    </div>
    
    <div class="content">
        <div class="field">
            <span class="field-label">Nombre:</span>
            <div class="field-value">{{ $data['name'] }}</div>
        </div>
        
        <div class="field">
            <span class="field-label">Correo Electrónico:</span>
            <div class="field-value">{{ $data['email'] }}</div>
        </div>
        
        <div class="field">
            <span class="field-label">Teléfono:</span>
            <div class="field-value">{{ $data['phone'] }}</div>
        </div>
        
        <div class="field">
            <span class="field-label">Mensaje:</span>
            <div class="field-value message-field">{{ $data['message'] }}</div>
        </div>
    </div>
</body>
</html>