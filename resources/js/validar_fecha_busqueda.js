document.getElementById('search-car-form').addEventListener('submit', function (e) {
    // 1. Obtener valores
    const pickupDateStr = this.querySelector('[name="pickup_date"]').value;
    const returnDateStr = this.querySelector('[name="return_date"]').value;

    // 2. Convertir a objetos Date (reseteando horas para comparar solo fechas)
    // Nota: Crear fecha desde string 'YYYY-MM-DD' asume UTC o local depende del navegador,
    // mejor usar new Date(str + 'T00:00:00') para asegurar consistencia local o comparar strings directamente.

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    // Validar que se hayan seleccionado fechas
    if (!pickupDateStr || !returnDateStr) {
        e.preventDefault();
        alert("Por favor seleccione ambas fechas.");
        return;
    }
    const pickupDate = new Date(pickupDateStr + 'T00:00:00');
    const returnDate = new Date(returnDateStr + 'T00:00:00');
    // 3. Validaciones
    let errors = [];
    // Validar fecha pasada (Pickup < Hoy)
    if (pickupDate < today) {
        errors.push("La fecha de recogida no puede ser en el pasado.");
    }
    // Validar coherencia (Return <= Pickup)
    if (returnDate <= pickupDate) {
        errors.push("La fecha de entrega debe ser posterior a la fecha de recogida.");
    }
    // 4. Resultado
    if (errors.length > 0) {
        e.preventDefault(); // DETIENE EL ENVÍO/REDIRECCIÓN
        alert(errors.join('\n'));
    }
    // Si no hay errores, el formulario se envía y carga la página de resultados.
});