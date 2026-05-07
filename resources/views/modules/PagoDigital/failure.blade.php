<x-page>
    <div class="min-h-screen flex items-center justify-center bg-[#fafafa] px-6 py-12">
        <div class="w-full max-w-xl rounded-3xl bg-white shadow-xl border border-[#ececec] p-8 text-center">
            <div class="text-6xl mb-4">❌</div>

            <h1 class="text-3xl font-bold text-[#111111]">
                Error en el pago
            </h1>

            <p class="mt-3 text-[#555] leading-6">
                No fue posible procesar la reserva.
            </p>

            @if(session('error'))
                <div class="mt-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                <a href="{{ url()->previous() }}"
                   class="rounded-xl border border-[#981B39] px-6 py-3 text-[#981B39] font-bold hover:bg-[#fdf1f4] transition">
                    Intentar nuevamente
                </a>

                <a href="{{ url('/') }}"
                   class="rounded-xl bg-[#C91843] px-6 py-3 text-white font-bold hover:bg-[#981B39] transition">
                    Ir al inicio
                </a>
            </div>
        </div>
    </div>
</x-page>