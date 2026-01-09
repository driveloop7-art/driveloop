<x-page>
    <section class="flex justify-center">
        <div class="mx-auto px-8">
            <h1 class="text-2xl md:text-4xl font-extrabold text-center mb-10">
                ¿NECESITAS AYUDA?<br>
                ESTAMOS AQUÍ PARA TI
            </h1>
            <p class="mt-4 text-lg max-w-xl">
                Encuentra soluciones, guías paso a paso o dejanos tu solicitud y uno de nuestros agentes se encargará de
                resolverla.
            </p>
        </div>
    </section>

    <section class="max-w-5xl mx-auto py-16 flex flex-col xl:flex-row gap-10">

        <x-card class="text-center p-8 max-w-sm">
            <h3 class="text-xl font-bold mb-3">Preguntas Frecuentes</h3>
            <p class="mb-6">Encuentra respuestas rápidas sobre reservas, pagos, cuentas y más.</p><br>
            <x-button width="full" x-data="" x-on:click.prevent="$dispatch('open-modal', 'mdl-fqa')">ver fqa</x-button>
        </x-card>

        <x-card class="text-center p-8 max-w-sm">
            <h3 class="text-xl font-bold mb-3">Centro de Ayuda</h3>
            <p class="mb-6">Tutoriales e instructivos detallados para resolver tus dudas.</p>
            <x-button width="full" x-data="" x-on:click.prevent="$dispatch('open-modal', 'mdl-atention')">ir a
                ayuda</x-button>
        </x-card>

        @auth
            <x-card class="text-center p-8 max-w-sm">
                <h3 class="text-xl font-bold mb-3">Contacto Directo</h3>
                <p class="mb-6">¿Necesitas atención personalizada? Nuestro equipo te ayudará.</p>
                <x-button width="full" x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'mdl-pqr')">contactar</x-button>
            </x-card>
            @include('modules.SoporteComunicacion.partials.modals.pqr')
        @endauth

        @include('modules.SoporteComunicacion.partials.modals.fqa')
        @include('modules.SoporteComunicacion.partials.modals.atention')
    </section>
</x-page>