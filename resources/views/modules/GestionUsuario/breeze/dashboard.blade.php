<x-page>
    @if(session()->has('message'))
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif

    <section>
        @include('modules.SoporteComunicacion.partials.tickets.section')
    </section>


</x-page>