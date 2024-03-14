<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exams') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            // AJAX DataTable
            var datatable = $('#crudTable').DataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                , }
                , columns: [{
                        data: 'id'
                        , name: 'id'
                        , width: '5%'
                    }
                    , {
                        data: 'exam_code'
                        , name: 'exam_code'
                    }
                    , {
                        data: 'exam_name'
                        , name: 'exam_name'
                    }
                    , {
                        data: 'participant'
                        , name: 'participant'
                    }
                    , {
                        data: 'score'
                        , name: 'score'
                    }
                    , {
                        data: 'duration'
                        , name: 'duration'
                    }
                    , {
                        data: 'attempt_time'
                        , name: 'attempt_time'
                    }
                    , {
                        data: 'action'
                        , name: 'action'
                        , orderable: false
                        , searchable: false
                        , width: '25%'
                    }
                , ]
            , });

        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Exam Code</th>
                                <th>Exam</th>
                                <th>Participant</th>
                                <th>Score</th>
                                <th>Duration</th>
                                <th>Time Attempt</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
