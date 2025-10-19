<x-guest-layout>


    {{-- Title --}}
    <x-slot name="title">General Members</x-slot>

    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable CSS --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    </x-slot>

    <main>
        {{-- <x-marquee></x-marguee> --}}
        {{-- General Member --}}
        <section class=" ">
            <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold text-center text-gray-800">General Members</h1>
                </div>
            </div>
            <div class="max-w-7xl mx-auto py-10">
                {{-- General member datatable --}}

                <div class="container mx-auto px-4 py-8">
                    <table class="min-w-full divide-yshadow-md overflow-hidden " id="agenttable">
                        <thead class="bg-gradient-to-r from-violet-400 to-purple-300 text-white">
                            <tr>
                                <th class="text-left text-sm font-semibold uppercase tracking-wider px-6 py-4">Serial No</th>
                                <th class="text-left text-sm font-semibold uppercase tracking-wider px-6 py-4">Photo</th>
                                <th class="text-left text-sm font-semibold uppercase tracking-wider px-6 py-4">Name</th>
                                <th class="text-left text-sm font-semibold uppercase tracking-wider px-6 py-4">Name (Bangla)</th>
                                <th class="text-left text-sm font-semibold uppercase tracking-wider px-6 py-4">Details</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($agents as $member)
                                <tr class="hover:bg-gray-100 transition-colors duration-200 @if($loop->odd) bg-gray-50 @endif">
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="whitespace-nowrap text-sm text-gray-900 px-6 py-4">
                                        <div class="flex items-center justify-center">
                                            @if ($member->owner_photo)
                                                <img src="{{ asset($member->owner_photo) }}" class="h-12 w-12 rounded-full shadow-md" alt="logo">
                                            @elseif ($member->agency_logo)
                                                <img src="{{ asset($member->agency_logo) }}" class="h-12 w-12 rounded-full shadow-md" alt="logo">
                                            @else
                                                <img src="{{ asset('images/placeholder.png') }}" class="h-12 w-12 rounded-full shadow-md" alt="logo">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap text-sm text-gray-900 px-6 py-4 font-medium">{{ $member->name }}</td>
                                    <td class="whitespace-nowrap text-sm text-gray-900 px-6 py-4 font-medium">{{ $member->bangla_name }}</td>
                                    <td class="text-sm text-gray-900 px-6 py-4">
                                        <p>
                                            <span class="font-semibold">Owner:</span> {{ $member->owners_name }} <br/>
                                            <span class="font-semibold">Owner's Designation:</span> {{ $member->owners_designation }} <br/>
                                            <span class="font-semibold">Address:</span> {{ $member->office_address }} <br/>
                                            <span class="font-semibold">Mobile:</span> {{ $member->phone }} <br/>
                                            <span class="font-semibold">Email:</span> {{ $member->email }}
                                        </p>
                                        @if ($member->other_owner)
                                            <p class="mt-2">
                                                <span class="font-semibold">Other Owner:</span> {{ $member->other_owner }} <br/>
                                                <span class="font-semibold">Mobile:</span> {{ $member->owners_mobile }}
                                            </p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <x-slot name="script">
        <!-- Datatable Script -->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="//cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

        <script>
            // Define Bengali font
            pdfMake.fonts = {
                Roboto: {
                    normal: 'https://cdn.jsdelivr.net/npm/@fontsource/noto-sans-bengali@4.5.12/files/noto-sans-bengali-all-400-normal.woff',
                    bold: 'https://cdn.jsdelivr.net/npm/@fontsource/noto-sans-bengali@4.5.12/files/noto-sans-bengali-all-700-normal.woff',
                },
            };

            $(document).ready(function () {
                var datatablelist = $('#agenttable').DataTable({
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]], // Page length options
                    "pageLength": 10, // Default page length
                    "responsive": true,
                    "dom": 'Blfrtip', // Include 'l' for the lengthMenu dropdown
                    "buttons": [
                        {
                            extend: 'copyHtml5',
                            text: 'Copy',
                            className: 'text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-110 duration-150 transition-all  font-bold text-lg text-white'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            className: 'text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-110 duration-150 transition-all  font-bold text-lg text-white',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            customize: function(doc) {
                                doc.defaultStyle = {
                                    font: 'Roboto'  // Use our Bengali-supported font
                                };
                            }
                        }
                    ]
                });
            });
        </script>
    </x-slot>

</x-guest-layout>
