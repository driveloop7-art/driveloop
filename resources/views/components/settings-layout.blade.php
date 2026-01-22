<div x-data="{ tabs: [], activeTab: null }" class="flex flex-col md:flex-row gap-12 align-top">
    <!-- Sidebar -->
    <div class="w-10 md:w-64 flex-shrink-0">
        <div class="w-16 md:w-64 flex-shrink-0">
            <ul class="space-y-6">
                <template x-for="tab in tabs" :key="tab.name">
                    <li>
                        <button 
                            @click="activeTab = tab.name"
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
    <div class="flex-1 space-y-8">
        {{ $slot }}
    </div>
</div>
