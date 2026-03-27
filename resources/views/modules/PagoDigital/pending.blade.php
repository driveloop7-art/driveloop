<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Pendiente - Mi Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .icon-pending { font-size: 5rem; color: #ffc107; }
    </style>
</head>
<body>

<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-5">
                <div class="icon-pending">⏳</div>
                <h1 class="mt-4">Pago en Proceso</h1>
                <p class="text-muted">Estamos esperando la confirmación de tu pago por parte de Mercado Pago.</p>
                
                <div class="alert alert-warning mt-3">
                    <strong>Estado:</strong> Pendiente de acreditación
                </div>

                @if(isset($payment_id))
                    <p class="mt-2">Referencia de operación: <strong>{{ $payment_id }}</strong></p>
                @endif

                <hr>

                <p class="small text-secondary">
                    Si pagaste en efectivo (como Efecty), el pago puede tardar hasta 24 horas en procesarse. 
                    Te enviaremos un correo cuando esté listo.
                </p>

                <a href="{{ url('/') }}" class="btn btn-primary mt-3 w-100">Volver a la tienda</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>