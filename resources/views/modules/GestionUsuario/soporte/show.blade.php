<x-page>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Revisión de Documentos') }}: {{ $user->nom }} {{ $user->ape }}
                </h2>
                <a href="{{ route('soporte.docs.index') }}">
                    <x-button type="tertiary" class="!px-4 !py-2 !text-xs">
                        &larr; Volver al listado
                    </x-button>
                </a>
            </div>

            <!-- Información del Usuario -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Información del Usuario</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-gray-500 block text-sm">Nombre Completo</span>
                            <span class="font-semibold">{{ $user->nom }} {{ $user->ape }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-sm">Email</span>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-sm">Teléfono</span>
                            <span>{{ $user->tel ?? 'N/A' }}</span>
                        </div>
                         <div>
                            <span class="text-gray-500 block text-sm">Fecha Registro</span>
                            <span>{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Documento de Identidad -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                             <h3 class="text-lg font-bold text-gray-900">
                                @if($docIdentidad && $docIdentidad->idtipdocusu == 3) Pasaporte @else Cédula de Ciudadanía @endif
                            </h3>
                            @if($docIdentidad)
                                @php
                                    $identidadClass = match($docIdentidad->estado) {
                                        'APROBADO' => 'bg-green-100 text-green-800',
                                        'RECHAZADO' => 'bg-red-100 text-red-800',
                                        default => 'bg-yellow-100 text-yellow-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $identidadClass }}">
                                    {{ $docIdentidad->estado }}
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">NO SUBIDO</span>
                            @endif
                        </div>

                        @if($docIdentidad)
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-xs text-center font-bold text-gray-500 uppercase tracking-wide mb-1">Anverso</div> 
                                    <div class="text-xs text-center font-bold text-gray-500 uppercase tracking-wide mb-1">Reverso</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Anverso -->
                                    <div class="border rounded p-2 text-center">
                                        @if($docIdentidad->url_anverso)
                                            <a href="{{ asset('storage/'.$docIdentidad->url_anverso) }}" target="_blank">
                                                @if(str_ends_with(strtolower($docIdentidad->url_anverso), '.pdf'))
                                                    <div class="flex items-center justify-center h-32 bg-gray-50">
                                                        <span class="text-red-500 font-bold">PDF</span>
                                                    </div>
                                                @else
                                                    <img src="{{ asset('storage/'.$docIdentidad->url_anverso) }}" class="max-h-32 mx-auto object-cover" alt="Anverso">
                                                @endif
                                            </a>
                                            <a href="{{ asset('storage/'.$docIdentidad->url_anverso) }}" target="_blank" class="text-xs text-blue-500 mt-1 block">Ver en grande</a>
                                        @else
                                            <span class="text-gray-400 italic">No disponible</span>
                                        @endif
                                    </div>
                                    <!-- Reverso -->
                                     <div class="border rounded p-2 text-center">
                                        @if($docIdentidad->url_reverso)
                                            <a href="{{ asset('storage/'.$docIdentidad->url_reverso) }}" target="_blank">
                                                 @if(str_ends_with(strtolower($docIdentidad->url_reverso), '.pdf'))
                                                    <div class="flex items-center justify-center h-32 bg-gray-50">
                                                        <span class="text-red-500 font-bold">PDF</span>
                                                    </div>
                                                @else
                                                    <img src="{{ asset('storage/'.$docIdentidad->url_reverso) }}" class="max-h-32 mx-auto object-cover" alt="Reverso">
                                                @endif
                                            </a>
                                            <a href="{{ asset('storage/'.$docIdentidad->url_reverso) }}" target="_blank" class="text-xs text-blue-500 mt-1 block">Ver en grande</a>
                                        @else
                                            <span class="text-gray-400 italic">No disponible (Opcional en Pasaporte)</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mt-2 text-sm">
                                    <strong>Número:</strong> {{ $docIdentidad->num }}
                                </div>

                                @if($docIdentidad->estado == 'PENDIENTE')
                                    <div class="mt-6 border-t pt-4">
                                        <!-- Formularios ocultos o contenedores de lógica -->
                                        <form id="form-approve-identidad" action="{{ route('soporte.docs.approve', $docIdentidad->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                        <form id="form-reject-identidad" action="{{ route('soporte.docs.reject', $docIdentidad->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>

                                        <div class="flex flex-col md:flex-row gap-4 items-start">
                                            <!-- Columna Izquierda: Input de Rechazo -->
                                            <div class="flex-1 w-full">
                                                <textarea name="mensaje_rechazo" form="form-reject-identidad" required placeholder="Motivo del rechazo (Solo si rechaza)" rows="3" class="w-full h-full min-h-[5rem] rounded-md border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 text-sm resize-none"></textarea>
                                            </div>

                                            <!-- Columna Derecha: Botones -->
                                            <div class="flex flex-col gap-3 shrink-0">
                                                <x-button type="tertiary" form="form-approve-identidad" class="!px-6 !py-2 !text-xs uppercase font-bold tracking-wider">
                                                    Aprobar
                                                </x-button>
                                                
                                                <x-button type="primary" form="form-reject-identidad" class="!bg-red-600 hover:!bg-red-700 !border-red-600 !px-6 !py-2 !text-xs uppercase font-bold tracking-wider">
                                                    Rechazar
                                                </x-button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($docIdentidad->estado == 'RECHAZADO')
                                    <div class="mt-4 p-3 bg-red-50 text-red-700 text-sm rounded">
                                        <strong>Motivo rechazo:</strong> {{ $docIdentidad->mensaje_rechazo }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">El usuario no ha subido este documento.</p>
                        @endif
                    </div>
                </div>

                <!-- Licencia de Conducción -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold text-gray-900">Licencia de Conducción</h3>
                             @if($docLicencia)
                                @php
                                    $licenciaClass = match($docLicencia->estado) {
                                        'APROBADO' => 'bg-green-100 text-green-800',
                                        'RECHAZADO' => 'bg-red-100 text-red-800',
                                        default => 'bg-yellow-100 text-yellow-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $licenciaClass }}">
                                    {{ $docLicencia->estado }}
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">NO SUBIDO</span>
                            @endif
                        </div>

                        @if($docLicencia)
                           <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-xs text-center font-bold text-gray-500 uppercase tracking-wide mb-1">Anverso</div> 
                                    <div class="text-xs text-center font-bold text-gray-500 uppercase tracking-wide mb-1">Reverso</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Anverso -->
                                    <div class="border rounded p-2 text-center">
                                        @if($docLicencia->url_anverso)
                                            <a href="{{ asset('storage/'.$docLicencia->url_anverso) }}" target="_blank">
                                                @if(str_ends_with(strtolower($docLicencia->url_anverso), '.pdf'))
                                                    <div class="flex items-center justify-center h-32 bg-gray-50">
                                                        <span class="text-red-500 font-bold">PDF</span>
                                                    </div>
                                                @else
                                                    <img src="{{ asset('storage/'.$docLicencia->url_anverso) }}" class="max-h-32 mx-auto object-cover" alt="Anverso">
                                                @endif
                                            </a>
                                            <a href="{{ asset('storage/'.$docLicencia->url_anverso) }}" target="_blank" class="text-xs text-blue-500 mt-1 block">Ver en grande</a>
                                        @else
                                            <span class="text-gray-400 italic">No disponible</span>
                                        @endif
                                    </div>
                                    <!-- Reverso -->
                                     <div class="border rounded p-2 text-center">
                                        @if($docLicencia->url_reverso)
                                            <a href="{{ asset('storage/'.$docLicencia->url_reverso) }}" target="_blank">
                                                 @if(str_ends_with(strtolower($docLicencia->url_reverso), '.pdf'))
                                                    <div class="flex items-center justify-center h-32 bg-gray-50">
                                                        <span class="text-red-500 font-bold">PDF</span>
                                                    </div>
                                                @else
                                                    <img src="{{ asset('storage/'.$docLicencia->url_reverso) }}" class="max-h-32 mx-auto object-cover" alt="Reverso">
                                                @endif
                                            </a>
                                            <a href="{{ asset('storage/'.$docLicencia->url_reverso) }}" target="_blank" class="text-xs text-blue-500 mt-1 block">Ver en grande</a>
                                        @else
                                            <span class="text-gray-400 italic">No disponible</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mt-2 text-sm">
                                    <strong>Número:</strong> {{ $docLicencia->num }}
                                </div>

                                @if($docLicencia->estado == 'PENDIENTE')
                                     <div class="mt-6 border-t pt-4">
                                        <!-- Formularios ocultos -->
                                        <form id="form-approve-licencia" action="{{ route('soporte.docs.approve', $docLicencia->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                        <form id="form-reject-licencia" action="{{ route('soporte.docs.reject', $docLicencia->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>

                                        <div class="flex flex-col md:flex-row gap-4 items-start">
                                            <!-- Columna Izquierda: Input de Rechazo (Ahora Textarea) -->
                                            <div class="flex-1 w-full">
                                                <textarea name="mensaje_rechazo" form="form-reject-licencia" required placeholder="Motivo del rechazo (Solo si rechaza)" rows="3" class="w-full h-full min-h-[5rem] rounded-md border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 text-sm resize-none"></textarea>
                                            </div>

                                            <!-- Columna Derecha: Botones (Apilados) -->
                                            <div class="flex flex-col gap-3 shrink-0">
                                                <x-button type="tertiary" form="form-approve-licencia" class="!px-6 !py-2 !text-xs uppercase font-bold tracking-wider">
                                                    Aprobar
                                                </x-button>
                                                
                                                <x-button type="primary" form="form-reject-licencia" class="!bg-red-600 hover:!bg-red-700 !border-red-600 !px-6 !py-2 !text-xs uppercase font-bold tracking-wider">
                                                    Rechazar
                                                </x-button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($docLicencia->estado == 'RECHAZADO')
                                    <div class="mt-4 p-3 bg-red-50 text-red-700 text-sm rounded">
                                        <strong>Motivo rechazo:</strong> {{ $docLicencia->mensaje_rechazo }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">El usuario no ha subido este documento.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-page>
