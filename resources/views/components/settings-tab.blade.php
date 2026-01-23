@props(['name', 'label'])

<div x-data 
     x-init="tabs.push({ name: '{{ $name }}', label: '{{ $label }}' }); if (!activeTab) activeTab = '{{ $name }}';"
     x-show="activeTab === '{{ $name }}'"
     class="space-y-6"
     style="display: none;">
    {{ $slot }}
</div>
