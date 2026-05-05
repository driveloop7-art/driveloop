import './bootstrap';
import Alpine from 'alpinejs';

//Importación de validaciones del register
import passwordMeter from './GestionUsuario/passwordMeter'; // Ajusta la ruta si es necesario

window.Alpine = Alpine;

//Registro el componente importado de register
Alpine.data('passwordMeter', passwordMeter);

// Ejecutar alpine
Alpine.start();
