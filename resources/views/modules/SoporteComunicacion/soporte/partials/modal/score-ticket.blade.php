@php
    $questions = \App\Modules\SoporteComunicacion\Models\Question::where('is_active', true)->get();
@endphp
<x-modal class="xl:max-w-2xl" name="mdl-score-ticket" title="Encuesta" :show="$errors->isNotEmpty()" focusable>
    <x-card class="p-6">
        <form action="{{ route('tickets.score.results') }}" method="POST">
            @csrf
            <input name="codtic" type="hidden" :value="params.codtic" />
            <div class="grid grid-cols-1 gap-6 mt-4">
                @foreach($questions as $question)
                    <div class="mb-4">
                        <label class="text-sm">{{ $question->id . '. ' . $question->question }}</label>
                        <div class="flex items-center space-x-10 mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="inline-flex items-center">
                                    <input type="radio" name="questions[{{ $question->id }}]" value="{{ $i }}"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 mt-2"
                                        required>
                                    <div class="ml-2 mt-2 flex">
                                        @for($j = 0; $j < $i; $j++)
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </label>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
    </x-card>

    <div class="mt-6 flex justify-end">
        <x-button class="text-xs">{{ __('Submit') }}</x-button>
    </div>
    </form>
</x-modal>