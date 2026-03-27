<x-page>
    <div class="mx-auto w-full max-w-6xl px-4 py-6">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @forelse ($vehiculos as $itemVeh)
                @php
                    $foto = $itemVeh->fotos->first();
                    $img = $foto ? asset('storage/' . $foto->ruta) : asset('AUTO.jpg');

                    $marca = $itemVeh->marca->des ?? '---';
                    $linea = $itemVeh->linea->des ?? '---';
                    $modelo = $itemVeh->mod ?? '---';
                    $color = $itemVeh->col ?? '---';
                @endphp

                <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <img src="{{ $img }}" alt="Foto vehículo" class="h-44 w-full object-cover" loading="lazy" />

                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm">
                            <div class="flex items-baseline gap-2">
                                <span class="font-bold text-gray-900">Marca:</span>
                                <span class="text-gray-700">{{ $marca }}</span>
                            </div>

                            <div class="flex items-baseline justify-end gap-2 text-right">
                                <span class="font-bold text-gray-900">Modelo:</span>
                                <span class="text-gray-700">{{ $modelo }}</span>
                            </div>

                            <div class="flex items-baseline gap-2">
                                <span class="font-bold text-gray-900">Línea:</span>
                                <span class="text-gray-700">{{ $linea }}</span>
                            </div>

                            <div class="flex items-baseline justify-end gap-2 text-right">
                                <span class="font-bold text-gray-900">Color:</span>
                                <span class="text-gray-700">{{ $color }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2">
                        <div
                            class="rounded-bl-2xl bg-slate-900 px-4 py-3 text-center text-sm font-extrabold text-white">
                            ${{ number_format((int) ($itemVeh->prerent ?? 0), 0, ',', '.') }} / DÍA
                        </div>

                        <a href="#"
                            class="rounded-br-2xl bg-rose-600 px-4 py-3 text-center text-sm font-extrabold text-white transition hover:bg-rose-700">
                            RENTAR
                        </a>
                    </div>
                </article>

            @empty
                <div
                    class="col-span-full rounded-xl border border-dashed border-gray-300 bg-white p-6 text-center text-gray-600">
                    No hay vehículos para los filtros seleccionados.
                </div>
            @endforelse

        </div>
    </div>
</x-page>
