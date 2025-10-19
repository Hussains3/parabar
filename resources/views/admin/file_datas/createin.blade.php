<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Receive File Inhouse</x-slot>


    {{-- Header Style --}}
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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">

        {{-- Form --}}
        <div class="card flex-grow max-w-2xl mx-auto">
            <div class="p-6">

                <div class="flex justify-between items-center mb-4">

                    <h2 class="text-xl">Receive Inhouse File</h2>
                    <div class="">
                        <a href="{{route('file_datas.create')}}">
                            <button class="font-mont px-2 py-2 bg-red-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110" id="">Out</button>
                        </a>
                        <a href="{{route('dashboard')}}">
                            <button class="font-mont px-2 py-2 bg-green-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110" id="">Dashboard</button>
                        </a>

                        <a href="{{route('ie_datas.index')}}">
                            <button class="font-mont px-2 py-2 bg-indigo-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110" id="">+ New Imp/Exp</button>
                        </a>
                    </div>
                </div>

                <form class="" id="fileReciveForm" enctype="multipart/form-data" action="{{route('file_datas.store')}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="">

                        {{-- Section One --}}
                        <div class="grid grid-cols-4 gap-4 mb-4 bg-center bg-no-repeat bg-contain bg-opacity-10 backdrop-blur-2xl" style="background-image: url('{{asset('bcnft.png')}}');">

                            <div>
                                <label for="lodgement_no" class="block mb-2">Lodgement No</label>
                                <div class="flex items-center justify-between">
                                    <span style="padding-top: 5px;padding-right: 10px">{{date('Y').'-'}}</span>
                                    <input type="text" class="form-input" id="lodgement_no" name="lodgement_no"  value="{{$next_lodgement_no}}" @role('extra') required @endrole>
                                </div>
                            </div> <!-- end -->

                            <div class="">
                            </div><!-- end -->

                            <div class="">
                                <label for="lodgement_date" class="block mb-2">Lodgement Date</label>
                                <input type="text" class="form-input skipme" id="lodgement_date" name="lodgement_date" placeholder="Lodgement Date" required value="{{ date('d/m/Y') }}">
                            </div> <!-- end -->

                            <div class="col-span-2">
                                <label for="agentain" class="block mb-2">Agent Name</label>
                                <input type="text" class="form-input" id="agentain" name="agentain" required @role('extra') autofocus @endrole value="{{$lastagent ?? ''}}">
                            </div> <!-- end -->


                            {{-- <div class="col-span-2">
                                <label for="agentain" class="block mb-2">Agent Name</label>
                                <select class="form-select agentain" id="agentain" name="agentain" required>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->name }}" @if ($lastagent == $agent->name) selected @endif>{{ $agent->name.' ('.$agent->ain_no.')'  }}</option>
                                    @endforeach
                                </select>
                            </div> <!-- end --> --}}

                            <div class="">
                                <label for="manifest_no" class="block mb-2">Manifest No</label>
                                <input type="text" class="form-input" id="manifest_no" name="manifest_no" placeholder="Manifest No" required>

                            </div> <!-- end -->

                            <div class="">
                                <label for="manifest_date" class="block mb-2">Manifest Date</label>
                                <input type="text" class="form-input" id="manifest_date" name="manifest_date" placeholder="Manifest Date" required >
                                {{-- skipme --}}

                            </div> <!-- end -->

                            <div class="col-span-2 hidden">
                                <label for="impexp" class="block mb-2">Importer/Exporter</label>
                                <input type="text" class="form-input" id="impexp" name="impexp" placeholder="Importer/Exporter" @role('operator') autofocus @endrole>

                            </div> <!-- end -->


                            <div class="hidden">
                                <label for="be_number" class="block mb-2">B/E Number</label>
                                <input type="text" class="form-input" id="be_number" name="be_number" placeholder="B/E Number" >
                            </div> <!-- end -->

                            <div class="hidden">
                                <label for="be_date" class="block mb-2 dateText">B/E Date</label>
                                <input type="text" class="form-input" id="be_date" name="be_date" placeholder="B/E Date"  @role('extra') value="{{ date('d/m/Y') }}" required @endrole>
                                {{-- value="{{ date('d/m/Y') }}" --}}
                            </div> <!-- end -->


                            <div class=" @role('extra') hidden @endrole">
                                <label for="page" class="block mb-2">Item</label>
                                <input type="text" class="form-input w-20" id="page" name="page" placeholder="00" max="999" >
                            </div> <!-- end -->
                            <div class=""><input type="hidden" name="printable" id="printable"></div><!-- end -->
                            <div class=""></div>

                            <div class="self-end col-span-2 flex justify-end">
                                <input type="submit" value="Submit" class="font-mont px-10 py-4 bg-cyan-600 text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:scale-110"
                                id="baccountSaveBtn">
                            </div><!-- end -->


                        </div>



                    </div>
                </form>
            </div>
        </div>
    </div>


    <x-slot name="script">
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {

                let enterCount = 0; // Track Enter key presses
                let enterTimer;

                $('#printable').val('');

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

                // Focus and select the input field
                $('#agentain').focus().select();
                $('.agentain').select2();

                // BE Date input formatting
                $('#be_date').on('input', function(e) {
                    let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
                    let formattedValue = '';

                    if (value.length > 0) {
                        // Handle day (first 2 digits)
                        let day = value.substring(0, 2);
                        if (parseInt(day) > 31) {
                            day = '31';
                        }
                        formattedValue = day;

                        if (value.length > 2) {
                            // Handle month (next 2 digits)
                            let month = value.substring(2, 4);
                            if (parseInt(month) > 12) {
                                month = '12';
                            }
                            formattedValue = day + '/' + month;

                            if (value.length > 4) {
                                // Handle year (last 4 digits)
                                let year = value.substring(4, 8);
                                formattedValue = day + '/' + month + '/' + year;
                            }
                        }
                    }

                    $(this).val(formattedValue);
                });

                // Prevent non-numeric input except backspace and delete
                $('#be_date').on('keydown', function(e) {
                    // Allow: backspace, delete, tab, escape, enter
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                        // Allow: Ctrl+A, Ctrl+C, Ctrl+V
                        (e.keyCode === 65 && e.ctrlKey === true) ||
                        (e.keyCode === 67 && e.ctrlKey === true) ||
                        (e.keyCode === 86 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
                        (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

                // Manifest Date input formatting
                $('#manifest_date').on('input', function(e) {
                    let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
                    let formattedValue = '';

                    if (value.length > 0) {
                        // Handle day (first 2 digits)
                        let day = value.substring(0, 2);
                        if (parseInt(day) > 31) {
                            day = '31';
                        }
                        formattedValue = day;

                        if (value.length > 2) {
                            // Handle month (next 2 digits)
                            let month = value.substring(2, 4);
                            if (parseInt(month) > 12) {
                                month = '12';
                            }
                            formattedValue = day + '/' + month;

                            if (value.length > 4) {
                                // Handle year (last 4 digits)
                                let year = value.substring(4, 8);
                                formattedValue = day + '/' + month + '/' + year;
                            }
                        }
                    }

                    $(this).val(formattedValue);
                });

                // Prevent non-numeric input for manifest_date
                $('#manifest_date').on('keydown', function(e) {
                    // Allow: backspace, delete, tab, escape, enter
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                        // Allow: Ctrl+A, Ctrl+C, Ctrl+V
                        (e.keyCode === 65 && e.ctrlKey === true) ||
                        (e.keyCode === 67 && e.ctrlKey === true) ||
                        (e.keyCode === 86 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
                        (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

                // Lodgement Date input formatting
                $('#lodgement_date').on('input', function(e) {
                    let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
                    let formattedValue = '';

                    if (value.length > 0) {
                        // Handle day (first 2 digits)
                        let day = value.substring(0, 2);
                        if (parseInt(day) > 31) {
                            day = '31';
                        }
                        formattedValue = day;

                        if (value.length > 2) {
                            // Handle month (next 2 digits)
                            let month = value.substring(2, 4);
                            if (parseInt(month) > 12) {
                                month = '12';
                            }
                            formattedValue = day + '/' + month;

                            if (value.length > 4) {
                                // Handle year (last 4 digits)
                                let year = value.substring(4, 8);
                                formattedValue = day + '/' + month + '/' + year;
                            }
                        }
                    }

                    $(this).val(formattedValue);
                });

                // Prevent non-numeric input for lodgement_date
                $('#lodgement_date').on('keydown', function(e) {
                    // Allow: backspace, delete, tab, escape, enter
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                        // Allow: Ctrl+A, Ctrl+C, Ctrl+V
                        (e.keyCode === 65 && e.ctrlKey === true) ||
                        (e.keyCode === 67 && e.ctrlKey === true) ||
                        (e.keyCode === 86 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
                        (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

                $("#fileReciveForm").on("keydown", function (e) {
                    if (e.key === "Enter") {
                        e.preventDefault(); // Prevent default form submission
                        enterCount++;

                        // Check if Enter was pressed twice within 300ms
                        clearTimeout(enterTimer);
                        enterTimer = setTimeout(function () {
                            if (enterCount === 1) {
                                // Single Enter press: Click the Submit button
                                $("#baccountSaveBtn").click();
                            } else if (enterCount === 2) {
                                let beval = $('#be_number').val();
                                if(beval != ''){
                                    $('#printable').val('1');
                                    $('#fileReciveForm').submit();
                                }else{
                                    $('#fileReciveForm').submit();
                                }
                            }
                            enterCount = 0; // Reset counter
                        }, 500);
                    }
                });

            });

            function submitAndPrint() {
                $('#printable').val('1');
                $('#fileReciveForm').submit();
            }

        </script>
    </x-slot>

</x-app-layout>
