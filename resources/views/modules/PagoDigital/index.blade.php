<x-page>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-14">

<div class="max-w-7xl mx-auto px-6">

<!-- TITULO -->
<div class="text-center mb-14">

<h1 class="text-4xl font-bold text-gray-900">
Confirmar reserva
</h1>

<p class="text-gray-500 mt-3">
Revisa los detalles antes de continuar con el pago
</p>

</div>


<div class="grid lg:grid-cols-2 gap-12 items-center">


<!-- IMAGEN DEL CARRO -->

<div class="relative">

<img
src="https://placehold.co/900x600/f87171/ffffff?text=Toyota+RAV4"
class="rounded-3xl shadow-2xl w-full object-cover"
/>

<div class="absolute bottom-6 left-6 bg-white/80 backdrop-blur-lg px-5 py-3 rounded-xl shadow">

<div class="text-sm font-semibold text-gray-800">
Toyota RAV4
</div>

<div class="text-xs text-gray-500">
Híbrida 2022
</div>

</div>

</div>


<!-- TARJETA DE RESUMEN -->

<div class="bg-white/80 backdrop-blur-xl border border-white/40 rounded-3xl shadow-2xl p-10">


<!-- VEHICULO -->

<div class="mb-6">

<h2 class="text-3xl font-bold text-gray-900">
Toyota RAV4
</h2>

<p class="text-gray-500">
Híbrida 2022
</p>

</div>


<!-- DETALLES -->

<div class="grid grid-cols-3 gap-4 text-sm text-gray-600 mb-8">

<div class="bg-gray-50 rounded-lg p-3 text-center">
📍
<div>Cali</div>
</div>

<div class="bg-gray-50 rounded-lg p-3 text-center">
👤
<div>5 Personas</div>
</div>

<div class="bg-gray-50 rounded-lg p-3 text-center">
⚡
<div>Híbrido</div>
</div>

</div>


<!-- FECHAS -->

<div class="bg-gray-50 rounded-xl p-5 mb-6">

<div class="flex justify-between">

<div>

<p class="text-xs text-gray-400 uppercase">
Recogida
</p>

<p class="font-semibold text-gray-800">
24 Dic 2025
</p>

<p class="text-sm text-gray-500">
6:00 pm
</p>

</div>

<div>

<p class="text-xs text-gray-400 uppercase">
Entrega
</p>

<p class="font-semibold text-gray-800">
27 Dic 2025
</p>

<p class="text-sm text-gray-500">
6:00 pm
</p>

</div>

</div>

</div>


<!-- DESGLOSE PRECIO -->

<div class="space-y-3 text-sm text-gray-600 mb-6">

<div class="flex justify-between">
<span>Precio por día</span>
<span>{{ $monto }} COP</span>
</div>

<div class="flex justify-between">
<span>Días</span>
<span>3</span>
</div>

<div class="flex justify-between">
<span>Seguro e impuestos</span>
<span>Incluido</span>
</div>

</div>


<div class="border-t border-gray-200 pt-4 flex justify-between items-center mb-8">

<span class="text-lg font-semibold text-gray-900">
Total
</span>

<span class="text-3xl font-bold text-gray-900">
{{ $monto * 3 }} COP
</span>

</div>


<!-- BOTON -->

<a
href="{{ route('checkout', ['monto' => $monto, 'reserva_id' => $reserva_id]) }}"
class="block w-full text-center bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300"
>

Continuar al pago

</a>


<p class="text-xs text-gray-400 text-center mt-4">
Pago seguro procesado con Mercado Pago
</p>

</div>

</div>

</div>

</div>

</x-page>