<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!! __('Exam &raquo; :resultName &raquo; Result' , ['resultName' => $data->name]) !!}
        </h2>
    </x-slot>

    <x-slot name="script">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                    <div class="mb-5" role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            There's something wrong!
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>
                    @endif
                    <form action="{{ route('assessment.assessment_store') }}" method="POST">
                        @csrf
                        <table class="table-auto w-full">
                            <tbody>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Participant</th>
                                    <td class="border px-6 py-4">{{ auth()->user()->name }}</td>
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Code</th>
                                    <td class="border px-6 py-4"><mark>{{ $result->exam_code }}</mark></td>
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Name</th>
                                    <td class="border px-6 py-4">{{ $result->participant }}</td>
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Duartion</th>
                                    <td class="border px-6 py-4 text-red-500">{{ $result->duration }}</td>
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Time Attempt</th>
                                    <td class="border px-6 py-4 ">{{ $result->attempt_time }}</td>
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Score</th>
                                    <td class="border px-6 py-4 flex items-center">
                                        <span class="mr-2">{{ $result->score }}</span>
                                        @if ($result->score >= 70)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="green" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                        </svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="w-6 h-6 ml-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="flex items-right p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">
                            <a href="{{route('assessment.assessment_finish')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Finish Test</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
