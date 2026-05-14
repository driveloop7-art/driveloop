
    <x-page>
    <section class="max-w-6xl mx-auto px-6 py-12">

        {{-- TÍTULO --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-black mb-4">
                Servicios
            </h1>
            <p class="text-black text-gray-600 text-lg max-w-3xl mx-auto">
                DriveLoop integra múltiples funcionalidades para garantizar una experiencia completa
                en el alquiler y gestión de vehículos.
            </p>
        </div>

        {{-- SERVICIOS --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-white border-dl p-6 rounded-2xl shadow-sm border">
                <h3 class="font-bold text-lg mb-2 text-dl">Alquiler de vehículos</h3>
                <p class="text-gray-600 text-sm">
                    Búsqueda y reserva de vehículos disponibles según fechas y ubicación.
                </p>
            </div>

            <div class="bg-white border-dl p-6 rounded-2xl shadow-sm border">
                <h3 class="font-bold text-lg mb-2 text-dl">Publicación de vehículos</h3>
                <p class="text-gray-600 text-sm">
                    Registro y administración de vehículos por parte de propietarios.
                </p>
            </div>

            <div class="bg-white border-dl p-6 rounded-2xl shadow-sm border">
                <h3 class="font-bold text-lg mb-2 text-dl">Gestión de reservas</h3>
                <p class="text-gray-600 text-sm">
                    Control de fechas, estados y seguimiento de cada alquiler.
                </p>
            </div>

            <div class="bg-white border-dl p-6 rounded-2xl shadow-sm border">
                <h3 class="font-bold text-lg mb-2 text-dl">Pagos digitales</h3>
                <p class="text-gray-600 text-sm">
                    Integración con pasarelas para procesar pagos de forma segura.
                </p>
            </div>

            <div class="bg-white border-dl p-6 rounded-2xl shadow-sm border">
                <h3 class="font-bold text-lg mb-2 text-dl">Validación documental</h3>
                <p class="text-gray-600 text-sm">
                    Revisión de documentos de usuarios y vehículos para garantizar seguridad.
                </p>
            </div>

            <div class="bg-white border-dl p-6 rounded-2xl shadow-sm border">
                <h3 class="font-bold text-lg mb-2 text-dl">Soporte al usuario</h3>
                <p class="text-gray-600 text-sm">
                    Gestión de tickets y atención a incidencias durante el uso de la plataforma.
                </p>
            </div>

        </div>

        {{-- CTA --}}
        <div class="text-center mt-12">
            <a href="{{ route('publicacion.vehiculo') }}"
                class="px-6 py-3 bg-dl text-white rounded-full font-semibold hover:bg-dl-two transition">
                Publicar mi vehículo
            </a>
        </div>

    </section>
    </x-page>
