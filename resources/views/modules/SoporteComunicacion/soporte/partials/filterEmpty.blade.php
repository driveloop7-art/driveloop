<div class="text-center py-12 bg-white rounded-lg border-2 border-dashed border-gray-200">
    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron tickets</h3>
    <p class="mt-1 text-sm text-gray-500">No hay tickets que coincidan con los criterios de búsqueda
        seleccionados.</p>
    <div class="mt-6">
        <a href="{{ route('tickets.soporte.index') }}"
            class="bg-white hover:bg-dl hover:text-white border-2 border-dl text-dl inline-flex xl:rounded-md justify-center p-2 tracking-widest font-semibold text-xs uppercase transition ease-in-out duration-150 items-center">
            Ver todos los tickets
        </a>
    </div>
</div>