<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!! __('Exam &raquo; :examName &raquo; Posttest', ['examName' => $data->name]) !!}
        </h2>
    </x-slot>

    <x-slot name="script">

    </x-slot>
    <form action="{{ route('assessment.assessment_update') }}" method="POST">
        @csrf
        <input type="hidden" name="exam_code" value="{{$data->exam_code}}">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden sm:rounded-md">
                    @foreach ($questions as $question)
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="mb-4">
                            <h2 class="text-xl font-semibold">{{ $question->question }}</h2>
                            <input type="hidden" name="question_{{ $question->id }}" value="{{ $question->id }}">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($question->choices as $choice)
                            <label class="flex items-center">
                                <input type="radio" name="answer_{{ $question->id }}" value="{{ $choice->choice }}">
                                <span class="ml-2">{{ $choice->choice }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex items-right p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit Test</button>
                </div>
            </div>
        </div>
    </form>
    </div>
    </div>
</x-app-layout>
