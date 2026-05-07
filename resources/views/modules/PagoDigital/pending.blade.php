<x-page>
    <div class="min-h-screen flex items-center justify-center bg-[#fafafa] px-6 py-12">
        <div class="w-full max-w-xl rounded-3xl bg-white shadow-xl border border-[#ececec] p-8 text-center">
            <div class="text-6xl mb-4">⏳</div>

            <h1 class="text-3xl font-bold text-[#111111]">
                Pago pendiente
            </h1>

            <p class="mt-3 text-[#555] leading-6">
                Tu transacción quedó registrada, pero aún está pendiente de confirmación.
            </p>

            @if(session('success'))
                <div class="mt-5 rounded-xl bg-yellow-50 border border-yellow-200 px-4 py-3 text-sm text-yellow-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-8">
                <a href="{{ url('/') }}"
                   class="inline-block rounded-xl bg-[#C91843] px-6 py-3 text-white font-bold hover:bg-[#981B39] transition">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</x-page>