<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!! __('Exam &raquo; :dataName', ['dataName' => $data->name]) !!}
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
                                    <input type="hidden" name="participant" value="{{ auth()->user()->name }}">
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Code</th>
                                    <td class="border px-6 py-4"><mark>{{ $data->exam_code }}</mark></td>
                                    <input type="hidden" name="exam_code" value="{{ $data->exam_code }}">
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Name</th>
                                    <td class="border px-6 py-4">{{ $data->name }}</td>
                                    <input type="hidden" name="exam_name" value="{{ $data->name }}">
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Duration</th>
                                    <td class="border px-6 py-4 text-red-500">{{ $data->duration }} Menit</td>
                                    <input type="hidden" name="duration" value="{{ $data->duration }}">
                                </tr>
                                <tr>
                                    <th class="border px-6 py-4 text-left">Status</th>
                                    <td class="border px-6 py-4">{{ $data->is_active ? 'Active' : 'In-Active' }}</td>
                                    <input type="hidden" name="is_active" value="{{ $data->is_active }}">
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="flex items-right p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Do Test</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
