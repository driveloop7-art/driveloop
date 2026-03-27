<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Mercado Pago</title>
    <style>
        body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; margin: 0; background-color: #f7f7f7; }
        #wallet_container { width: 300px; }
    </style>
</head>
<body>
    

    <h1>Finalizar Compra</h1>

    <div id="wallet_container"></div>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    
    <script>
        // Inicializamos con tu TEST Public Key
        const mp = new MercadoPago("APP_USR-4a5bd65d-8ae1-44b8-9ecb-fc8748998bf5", {
        locale: 'es-CO'
       
    });

        const bricksBuilder = mp.bricks();

        const renderComponent = async (bricksBuilder) => {
            // Esto evita que el botón se duplique
            if (window.walletBrickController) window.walletBrickController.unmount();
            
            window.walletBrickController = await bricksBuilder.create("wallet", "wallet_container", {
                initialization: {
                    preferenceId: "{{ $preference->id }}",
                },
                customization: {
                    texts: {
                        valueProp: 'smart_option',
                    },
                },
            });
        };

        renderComponent(bricksBuilder);
    </script>
</body>
</html> 

