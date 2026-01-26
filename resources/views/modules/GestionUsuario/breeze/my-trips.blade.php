<x-settings-layout active="Mis viajes">
    <div class="space-y-6">
        <!-- Card 1 -->
        <div class="bg-white border border-gray-400 rounded-lg shadow-sm p-4 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <!-- Car Image Placeholder -->
                <div class="w-32 h-20 bg-gray-100 flex items-center justify-center rounded">
                    <!-- Replace with actual car image -->
                    <span class="text-xs text-gray-400">Car Image</span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Toyota</h3>
                    <p class="text-gray-500 font-light">RAV4 Hibrida 2022</p>
                </div>
            </div>
            
            <div class="flex flex-col items-end gap-2 text-right w-full sm:w-auto">
                <span class="text-sm text-gray-600">Disponible</span>
                <button class="bg-dl text-white px-8 py-2 uppercase font-bold text-sm tracking-wider hover:bg-dl-two transition rounded shadow-sm w-full sm:w-auto">
                    RENTAR
                </button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white border border-gray-400 rounded-lg shadow-sm p-4 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                 <!-- Car Image Placeholder -->
                 <div class="w-32 h-20 bg-gray-100 flex items-center justify-center rounded">
                    <!-- Replace with actual car image -->
                    <span class="text-xs text-gray-400">Car Image</span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Toyota</h3>
                    <p class="text-gray-500 font-light">RAV4 Hibrida 2022</p>
                </div>
            </div>
            
            <div class="flex flex-col items-end gap-2 text-right w-full sm:w-auto">
                <span class="text-sm text-gray-600">No disponible</span>
                <button disabled class="bg-gray-300 text-gray-500 px-8 py-2 uppercase font-bold text-sm tracking-wider cursor-not-allowed rounded shadow-sm w-full sm:w-auto">
                    RENTAR
                </button>
            </div>
        </div>
    </div>
</x-settings-layout>
