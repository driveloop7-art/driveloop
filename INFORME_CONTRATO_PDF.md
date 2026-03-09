# Informe Técnico: Generación y Envío de Contratos en PDF (DriveLoop)

Este documento detalla la implementación, dependencias y archivos involucrados en la generación automática de contratos en formato PDF y su envío por correo electrónico en el sistema DriveLoop.

## 1. Dependencias Utilizadas

Para lograr esta funcionalidad, el sistema depende principalmente de las siguientes librerías de terceros (instaladas vía Composer) y utilidades nativas de Laravel:

*   **`barryvdh/laravel-dompdf`**: Es el paquete principal que convierte vistas HTML (Blade) a archivos PDF. Se utiliza para tomar el diseño del contrato y renderizarlo en un documento exportable.
*   **Facade `Pdf` (`Barryvdh\DomPDF\Facade\Pdf`)**: Es el punto de acceso que proporciona el paquete anterior para cargar la vista (`Pdf::loadView()`) y descargar/previsualizar el archivo (`->stream()`, `->output()`).
*   **Gestor de Almacenamiento (Storage)**: El Facade `Illuminate\Support\Facades\Storage` de Laravel se usa para guardar físicamente una copia del PDF en el disco antes de enviarlo por correo. (Se guarda en `storage/app/public/contratos/`).
*   **Manejo de Correo (Mail)**: El Facade `Illuminate\Support\Facades\Mail` y la clase `Mailable` de Laravel se usan para attaching (adjuntar) el PDF resultante y enviarlo al usuario.

## 2. Archivos Clave en la Implementación

A continuación, se listan los archivos que hacen posible la generación del contrato y visualizar los botones en la interfaz gráfica:

### A. Controlador: `ContratoGarantiaController`
Ruta: `app/Modules/ContratoGarantia/Controllers/ContratoGarantiaController.php`

Maneja toda la lógica del negocio. Contiene dos métodos principales:
*   **`generarContrato($codReserva)`**: 
    1. Obtiene los datos de la reserva, usuario y vehículo.
    2. Valida si el contrato *ya existe* (para no duplicarlo). Si existe, simplemente retorna el archivo guardado.
    3. Si no existe, genera un código de verificación único, crea el registro en base de datos (`Contrato::create()`), renderiza el PDF, lo guarda en el Storage y lo envía al usuario por email.
    4. Finalmente hace un `->stream()` para mostrarlo en una nueva pestaña del navegador.
*   **`enviarContrato($codReserva)`**: Similar al anterior, pero diseñado para el botón "Enviar por Email". Asegura que el archivo se genere (si no existe), o simplemente toma el existente y dispara el correo notificando el éxito en pantalla.

### B. Rutas del Módulo: `routes.php`
Ruta: `app/Modules/ContratoGarantia/routes.php`

Define las rutas (URLs) protegidas de este módulo:
*   `GET /contrato-garantia/descargar/{codReserva}` -> Función `generarContrato` (alias: `contrato.descargar`).
*   `POST /contrato-garantia/enviar/{codReserva}` -> Función `enviarContrato` (alias: `contrato.enviar`).

### C. Vista Lista de Contratos: `index.blade.php`
Ruta: `resources/views/modules/ContratoGarantia/index.blade.php`

Es la interfaz donde el usuario/administrador ve el listado.
Se han implementado botones dinámicos basados en la relación `$reserva->contrato`:
1.  **Botón Visualizar/Generar PDF**: Un botón tipo `<a>` con `target="_blank"` que abre el PDF en otra pestaña. El texto cambia de *📄 Generar PDF* a *📄 Ver PDF* si ya fue generado.
2.  **Botón Enviar**: Un `<form>` con método `POST` (por seguridad y evitar que el navegador pre-cargue la URL enviando múltiples correos accidentales). El texto cambia de *✉️ Generar y Enviar* a *✉️ Reenviar Email*.

### D. Plantilla HTML del PDF: `contrato.blade.php`
Ruta: `resources/views/pdf/contrato.blade.php` (Aprox.)

Esta es la vista donde se diseña el formato del contrato (logos, firmas, cláusulas legales). Las variables como `$reserva` y el `$codigo` generado se inyectan directamente sobre este Blade, y luego el paquete DomPDF lo procesa para crear el archivo `.pdf`.

### E. Mailable: `ContratoAlquilerMail`
Ruta: `app/Mail/ContratoAlquilerMail.php`

Clase encargada de construir el correo electrónico, definir el "Asunto" (Subject), y llamar a un método `->attachData()` para adjuntar el contenido binario del PDF generado en memoria antes de mandarlo por SMTP.

---

## 3. Resumen del Flujo Lógico

1.  **Acción del Usuario**: El usuario da clic en "Generar PDF".
2.  **Solicitud HTTP**: Laravel recibe un GET a `/contrato-garantia/descargar/{id}`.
3.  **Lógica**: El sistema valida si el PDF está en la ruta guardada. Si lo está, cancela el resto del proceso y responde mostrando el PDF.
4.  **Generación Nueva en Memoria**: Si no existe, genera el HTML de la vista `pdf.contrato` usando `Pdf::loadView()`.
5.  **Persistencia**: Salva en BD en la tabla `contratos` (registro) y por el Storage Guarda `.pdf` en el HDD del servidor (archivo).
6.  **Despacho**: Llama a `Mail::to()` para enviar el adjunto al cliente de manera final.
7.  **Respuesta al Navegador**: `stream()` el PDF para que el usuario pueda visualizarlo al instante.
