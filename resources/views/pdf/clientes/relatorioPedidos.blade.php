<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Teste PDF</title>
</head>
<body>
    <h1>PDF TESTE</h1>

    <pre style="font-size: 10px;">
        @php
            print_r($pedidos->toArray()); // O ->toArray() deixa o output bem mais limpo se for um Eloquent Collection
        @endphp
    </pre>
</body>
</html>