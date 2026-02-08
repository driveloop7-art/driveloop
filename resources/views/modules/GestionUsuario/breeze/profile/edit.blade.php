<x-page>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="grid grid-col-1 p-2 gap-6 md:grid-cols-2 md:p-8 ">
        <x-card class="p-4 sm:p-8 bg-white shadow xl:rounded-lg">
            @include('modules.GestionUsuario.breeze.profile.partials.update-profile-information-form')
        </x-card>
        <x-card class="p-4 sm:p-8 bg-white shadow xl:rounded-lg">
            @include('modules.GestionUsuario.breeze.profile.partials.update-password-form')
        </x-card>
        <x-card class="p-4 sm:p-8 bg-white shadow xl:rounded-lg">
            @include('modules.GestionUsuario.breeze.profile.partials.visualize-documents')
        </x-card>
        <x-card class="p-4 sm:p-8 bg-white shadow xl:rounded-lg">
            @include('modules.GestionUsuario.breeze.profile.partials.delete-user-form')
        </x-card>
    </div>

</x-page>