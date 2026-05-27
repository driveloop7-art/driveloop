<div x-data="{ 
tabs: [], 
    activeTab: new URLSearchParams(window.location.search).get('tab') || null
}" class="flex flex-col lg:flex-row gap-2 align-top">
    <!-- Sidebar -->
    <div class="w-full lg:w-64 flex-shrink-0">
        <div class="w-full lg:w-64 flex-shrink-0">
            <ul class="space-y-1">
                <template x-for="tab in tabs" :key="tab.name">
                    <li>
                        <button @click="activeTab = tab.name"
                            class="block w-full text-left pr-6 pl-6 py-3 text-base font-medium transition-colors duration-200"
                            :class="activeTab === tab.name ? 'text-white bg-dl' : 'text-gray-600 hover:text-white hover:bg-dl bg-transparent'">
                            <span x-text="tab.label"></span>
                        </button>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 min-w-0">
        {{ $slot }}
    </div>
</div>