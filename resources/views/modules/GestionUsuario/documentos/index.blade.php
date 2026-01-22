<x-page class="py-4">
    @if(session('success'))
        <div class="p-4 mb-6 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 mb-6 text-red-700 bg-red-100 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

        <!-- Tarjeta Documento de Identidad -->
        <x-card class="p-4 bg-white flex flex-col h-full">
            <div class="border-b border-gray-100 pb-4 mb-4">
                <h5 class="text-xl font-semibold text-dl">Documento de Identidad</h5>
                <p class="text-sm text-gray-500 mt-1 h-10 flex items-center">Sube foto de AMBAS caras de tu Cédula o
                    Pasaporte.</p>
            </div>

            <div class="flex-grow flex flex-col justify-between">
                {{-- Contenido cuando YA se subió el documento --}}
                @if($docIdentidad)
                    {{-- Si está Pendiente o Aprobado, mostramos estado centrado --}}
                    @if($docIdentidad->estado != 'RECHAZADO')
                        <div class="flex-grow flex flex-col items-center justify-start text-center p-4">
                            {{-- Icono según estado --}}
                            <div class="mb-2 h-24 flex items-center justify-center">
                                @if($docIdentidad->estado == 'APROBADO')
                                    <img src="{{ asset('images/icono-aprobado.png') }}" alt="Aprobado" class="w-24 h-24">
                                @else
                                    <img src="{{ asset('images/icono-pendiente.png') }}" alt="Pendiente" class="w-24 h-24">
                                @endif
                            </div>

                            <h3
                                class="text-xl font-bold {{ $docIdentidad->estado == 'APROBADO' ? 'text-green-600' : 'text-blue-600' }}">
                                Documento {{ ucfirst(strtolower($docIdentidad->estado)) }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-2 max-w-xs mx-auto h-10 flex items-center justify-center">
                                @if($docIdentidad->estado == 'APROBADO')
                                    Tu documento ha sido verificado correctamente.
                                @else
                                    Estamos validando tu documento de identificación.
                                @endif
                            </p>

                            <div class="mt-2 flex xl:flex-row lg:flex-col md:flex-row flex-col gap-3 text-xs justify-center items-center">
                                @if($docIdentidad->url_anverso)
                                    <a href="{{ asset('storage/' . $docIdentidad->url_anverso) }}" target="_blank">
                                        <x-button class="text-xs w-30" x-data="" type="tertiary">
                                            Ver Anverso
                                        </x-button>
                                    </a>
                                @endif
                                @if($docIdentidad->url_reverso)
                                    <a href="{{ asset('storage/' . $docIdentidad->url_reverso) }}" target="_blank">
                                        <x-button class="text-xs w-30" x-data="" type="tertiary">
                                            Ver Reverso
                                        </x-button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        {{-- Si está RECHAZADO, mostramos alerta roja arriba --}}
                        <div class="mb-4 p-4 rounded-md bg-red-50 text-red-700">
                            <div class="font-bold">Estado: RECHAZADO</div>
                            <p class="text-sm mt-1">{{ $docIdentidad->mensaje_rechazo }}</p>
                        </div>
                    @endif
                @else
                    {{-- Si no ha subido nada --}}
                    <div class="mb-6 p-3 bg-yellow-50 text-yellow-700 rounded-md text-sm">
                        ⚠️ No has subido este documento.
                    </div>
                @endif

                {{-- Formulario: Solo aparece si NO hay documento o si está RECHAZADO --}}
                @if(!$docIdentidad || $docIdentidad->estado == 'RECHAZADO')
                    <form action="{{ route('usuario.documentos.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4 flex flex-col flex-grow">
                        @csrf
                        <div class="flex-grow">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative mb-4">
                                    <div
                                        class="absolute left-2 top-[15px] -translate-y-1/2 text-xs w-[96%] h-7 pointer-events-none">
                                        <label
                                            class="absolute left-2 top-[6px] text-xs font-medium text-gray-400 tracking-wider whitespace-nowrap">
                                            Tipo de Documento
                                        </label>
                                    </div>
                                    <select name="documento_tipo"
                                        class="w-full px-4 pt-4 pb-2 text-sm border border-dl xl:rounded-md bg-white appearance-none cursor-pointer focus:outline-none focus:ring-1 focus:ring-dl"
                                        required>
                                        <option value="">Seleccione...</option>
                                        @foreach ($documentosTipo as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input type="text" name="num" label="Número de Documento" placeholder="Ej: 123456789"
                                    required />
                                <x-input type="file" name="archivo_anverso" label="Anverso" required />
                                <x-input type="file" name="archivo_reverso" label="Reverso *" />
                            </div>
                            <p class="text-xs text-gray-400 -mt-2 mb-2">* Reverso opcional para pasaporte</p>
                        </div>
                        <div class="pt-4 mt-auto">
                            <x-button type="primary" class="w-full">
                                Subir Identidad
                            </x-button>
                        </div>
                    </form>
                @endif
            </div>
        </x-card>

        <!-- Tarjeta Licencia de Conducción -->
        <x-card class="p-4 bg-white flex flex-col h-full">
            <div class="border-b border-gray-100 pb-4 mb-4">
                <h5 class="text-xl font-semibold text-dl">Licencia de Conducción</h5>
                <p class="text-sm text-gray-500 mt-1 h-10 flex items-center">Sube fotos de AMBAS caras de tu licencia.
                </p>
            </div>

            <div class="flex-grow flex flex-col justify-between">
                @if($docLicencia)
                    @if($docLicencia->estado != 'RECHAZADO')
                        <div class="flex-grow flex flex-col items-center justify-start text-center p-4">
                            <div class="mb-2 h-24 flex items-center justify-center">
                                @if($docLicencia->estado == 'APROBADO')
                                    <img src="{{ asset('images/icono-aprobado.png') }}" alt="Aprobado" class="w-24 h-24">
                                @else
                                    <img src="{{ asset('images/icono-pendiente.png') }}" alt="Pendiente" class="w-24 h-24">
                                @endif
                            </div>
                            <h3
                                class="text-xl font-bold {{ $docLicencia->estado == 'APROBADO' ? 'text-green-600' : 'text-blue-600' }}">
                                Documento {{ ucfirst(strtolower($docLicencia->estado)) }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-2 max-w-xs mx-auto h-10 flex items-center justify-center">
                                @if($docLicencia->estado == 'APROBADO')
                                    Tu licencia ha sido verificada correctamente.
                                @else
                                    Estamos validando tu licencia.
                                @endif
                            </p>

                            <div class="mt-2 flex xl:flex-row lg:flex-col md:flex-row flex-col gap-3 text-xs justify-center items-center">
                                @if($docLicencia->url_anverso)
                                    <a href="{{ asset('storage/' . $docLicencia->url_anverso) }}" target="_blank">
                                        <x-button class="text-xs w-30" x-data="" type="tertiary">
                                            Ver Anverso
                                        </x-button>
                                    </a>
                                @endif
                                @if($docLicencia->url_reverso)
                                    <a href="{{ asset('storage/' . $docLicencia->url_reverso) }}" target="_blank">
                                        <x-button class="text-xs w-30" x-data="" type="tertiary">
                                            Ver Reverso
                                        </x-button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mb-4 p-4 rounded-md bg-red-50 text-red-700">
                            <div class="font-bold">Estado: RECHAZADO</div>
                            <p class="text-sm mt-1">{{ $docLicencia->mensaje_rechazo }}</p>
                        </div>
                    @endif
                @else
                    <div class="mb-4 p-3 bg-yellow-50 text-yellow-700 rounded-md text-sm">
                        ⚠️ No has subido este documento.
                    </div>
                @endif

                @if(!$docLicencia || $docLicencia->estado == 'RECHAZADO')
                    <form action="{{ route('usuario.documentos.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4 flex flex-col flex-grow">
                        @csrf
                        <input type="hidden" name="documento_tipo" value="2">
                        <div class="flex-grow">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-input type="text" name="num" label="Número de Licencia" placeholder="Ej: LIC-987654"
                                    required class="md:col-span-2" />
                                <x-input type="file" name="archivo_anverso" label="Anverso" required />
                                <x-input type="file" name="archivo_reverso" label="Reverso" required />
                            </div>
                        </div>
                        <div class="pt-4 mt-auto">
                            <x-button type="primary" class="w-full">
                                Subir Licencia
                            </x-button>
                        </div>
                    </form>
                @endif
            </div>
        </x-card>
    </div>
</x-page>
