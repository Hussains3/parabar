<x-app-layout>
    <x-slot name="title">Operate File</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Custom File') }}
        </h2>
    </x-slot>

    <x-slot name="headerstyle">
        <style>
            .ui-autocomplete {
                background-color: #fff;
                border: 1px solid #ccc;
                max-height: 200px;
                overflow-y: auto;
                z-index: 1000;
            }

            .ui-menu-item {
                padding: 5px 10px;
                cursor: pointer;
            }
        </style>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('customfiles.update', $customFile->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                        <input id="name" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="name" value="{{ old('name', $customFile->name) }}" required autofocus />
                    </div>

                    <!-- BE Number -->
                    <div>
                        <label for="be_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('BE Number') }}</label>
                        <input id="be_number" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="be_number" value="{{ old('be_number', $customFile->be_number) }}" required />
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Type') }}</label>
                        <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="IM" {{ old('type', $customFile->type) === 'IM' ? 'selected' : '' }}>Import</option>
                            <option value="EX" {{ old('type', $customFile->type) === 'EX' ? 'selected' : '' }}>Export</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
                        <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="Unpaid" {{ old('status', $customFile->status) === 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="Paid" {{ old('status', $customFile->status) === 'Paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <!-- Fees -->
                    <div>
                        <label for="fees" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Fees') }}</label>
                        <input id="fees" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="number" name="fees" value="{{ old('fees', $customFile->fees) }}" required />

                    </div>

                    <!-- Agent -->
                    <div>
                        <label for="agent_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Agent') }}</label>
                        <select id="agent_id" name="agent_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Select Agent</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id', $customFile->agent_id) == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
            $(document).ready(function() {

                // Autocomplete for Agent
                $('#agentain').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: '/ainautocomplete',
                            data: { query: request.term },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2, // Start searching after 2 characters
                    autoFocus: true, // Highlight the first suggestion
                });

                // Autocomplete for Importer/Exporter
                $('#impexp').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: '/ieautocomplete',
                            data: { query: request.term },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2, // Start searching after 2 characters
                    autoFocus: true, // Highlight the first suggestion
                });


                // Attach a keydown event listener to all input fields
                $('input').on('keydown', function(e) {
                    // Check if the Tab key is pressed (keyCode 9)
                    if (e.keyCode === 9) {
                    // Prevent the default tab behavior
                    e.preventDefault();

                    // Get all input fields in the form
                    let inputs = $('form').find('input');
                    let currentIndex = inputs.index(this); // Get the index of the current input
                    let nextIndex = currentIndex + 1;

                    // Loop through the remaining fields to find the next input without the class 'skipme'
                    while (nextIndex < inputs.length) {
                        let nextInput = inputs[nextIndex];
                        if (!$(nextInput).hasClass('skipme')) {
                        nextInput.focus(); // Focus on the next input without the class 'skipme'
                        break;
                        }
                        nextIndex++;
                    }
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
