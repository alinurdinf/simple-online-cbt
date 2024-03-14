<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!! __('Exam &raquo; Show') !!}

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
                        data: 'question'
                        , name: 'question'
                    }
                    , {
                        data: 'correct_answer'
                        , name: 'correct_answer'
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

        <script>
            const addChoiceButton = document.getElementById('addChoice');
            const choicesContainer = document.getElementById('choices');
            const correctAnswerSelect = document.getElementById('correct_answer');

            addChoiceButton.addEventListener('click', () => {
                const choiceInput = document.createElement('div');
                choiceInput.classList.add('flex', 'space-x-2', 'mt-2');

                const choiceText = document.createElement('input');
                choiceText.setAttribute('type', 'text');
                choiceText.setAttribute('name', 'choices[]');
                choiceText.classList.add('w-2/3', 'bg-gray-200', 'text-gray-700', 'border', 'border-gray-200', 'rounded', 'py-2', 'px-3', 'focus:outline-none', 'focus:bg-white', 'focus:border-gray-500');
                choiceText.setAttribute('placeholder', 'Choice ' + (choicesContainer.childElementCount + 1));

                const removeChoiceButton = document.createElement('button');
                removeChoiceButton.setAttribute('type', 'button');
                removeChoiceButton.classList.add('bg-red-500', 'hover:bg-red-600', 'text-white', 'font-semibold', 'rounded', 'py-2', 'px-3');
                removeChoiceButton.textContent = 'Kurang';
                removeChoiceButton.addEventListener('click', () => {
                    choicesContainer.removeChild(choiceInput);
                    updateCorrectAnswerOptions(); // Update the correct answer options when a choice is removed
                });

                choiceInput.appendChild(choiceText);
                choiceInput.appendChild(removeChoiceButton);
                choicesContainer.appendChild(choiceInput);
                updateCorrectAnswerOptions(); // Update the correct answer options when a choice is added
            });

            function updateCorrectAnswerOptions() {
                correctAnswerSelect.innerHTML = '<option value="">Select Correct Answer</option>';
                const choices = document.querySelectorAll('[name="choices[]"]');
                choices.forEach((choice, index) => {
                    const choiceText = choice.value;
                    const option = document.createElement('option');
                    option.value = choiceText;
                    option.textContent = 'Choice ' + (index + 1);
                    correctAnswerSelect.appendChild(option);
                });
            }

        </script>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-10">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <th class="border px-6 py-4 text-left">Code</th>
                                <td class="border px-6 py-4">{{ $exam->exam_code }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-left">Name</th>
                                <td class="border px-6 py-4">{{ $exam->name }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-left">Duration</th>
                                <td class="border px-6 py-4">{{ $exam->duration }} Menit</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-left">Status</th>
                                <td class="border px-6 py-4">{{ $exam->is_active ? 'Active' : 'In-Active' }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="mb-10">
                        <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg" type="button">
                            Add Question </button>
                        <!-- Main modal -->
                        <div id="default-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Add New Question
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-6 space-y-6">
                                        <!-- Form inside the modal -->
                                        <form action="{{ route('question.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="exam_id" value="{{$exam->id}}">
                                            <div class="mb-4">
                                                <label for="question" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Question</label>
                                                <input type="text" name="question" id="question" class="w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 focus:outline-none focus:bg-white focus:border-gray-500">
                                            </div>
                                            <!-- Choices section -->
                                            <div class="mb-4" id="choices">
                                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choices</label>
                                                <div class="flex space-x-2">
                                                    <div class="w-2/3">
                                                        <input type="text" name="choices[]" class="w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-3 focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Choice 1">
                                                    </div>
                                                    <div class="w-1/6">
                                                        <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded py-2 px-3" id="addChoice">Tambah</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="correct_answer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correct Answer</label>
                                                <select name="correct_answer" id="correct_answer" class="w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 focus:outline-none focus:bg-white focus:border-gray-500">
                                                    <option value="">Select Correct Answer</option>
                                                    <!-- Options will be dynamically generated -->
                                                </select>
                                            </div>

                                    </div>
                                    <!-- Modal footer -->
                                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                        <button data-modal-hide="default-modal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Question</button>
                                        <button data-modal-hide="default-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Correct Answer</th>
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
