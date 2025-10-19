<x-guest-layout>


    {{-- Title --}}
    <x-slot name="title">Contact</x-slot>

    <main>
        <section>
            <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold text-center text-gray-800">Contact Us</h1>
                </div>
            </div>
        </section>
        {{-- Contact us form --}}
        <section class="bg-gray-100 py-10">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">

                    
                    <!-- Contact Information -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Get in Touch</h3>
                    
                        <p class="text-gray-600 mb-4">
                            You can send us a message using this form, or contact us by email or phone. We'd love to hear from you!
                        </p>
                        <div class="p-5">
                            <div class="text-sm uppercase text-bb font-bold">Contact us</div>
                            <p class="my-3 block" >Association Road, Infront of Private Stand, Benapole Bazar, Jashore.<br/> Bangladesh.</p>
                            <p class="my-3 block" ><i class="mdi mdi-phone mr-2"></i> 04228-75778, 76152, 76153</p>
                            <p class="my-3 block" ><i class="mdi mdi-email-outline mr-2"></i> info@cnfbpl.com</p>
                            <p class="my-3 block" ><i class="mdi mdi-email-outline mr-2"></i> associationbpl@cnfbpl.com</p>
                            <p class="my-3 block" ><i class="mdi mdi-email-outline mr-2"></i> associationbpl@gmail.com</p>

                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Send Us a Message</h3>
                        @if(session('success'))
                            <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form id="contactForm" class="grid grid-cols-1 gap-6">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <p class="text-red-500 text-xs mt-1 error-message" id="name-error"></p>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <p class="text-red-500 text-xs mt-1 error-message" id="email-error"></p>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                <textarea name="message" id="message" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                <p class="text-red-500 text-xs mt-1 error-message" id="message-error"></p>
                            </div>
                            <div>
                                <button type="submit" id="submitButton" class="block text-center px-4 py-2 bg-gradient-to-r from-violet-400 to-purple-300 rounded-md shadow-md hover:shadow-lg hover:scale-105 duration-150 transition-all font-bold text-lg text-white">
                                    Send Message
                                </button>
                            </div>
                        </form>
                        
                        <!-- Success Message Alert (Hidden by default) -->
                        <div id="successAlert" class="hidden mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            <span class="success-message"></span>
                        </div>
                    </div>
                </div>
                {{-- Google Map --}}
                <div class="rounded-md overflow-hidden shadow-md">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.4267809471976!2d88.89689597594261!3d23.044810015496765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39ff37d7fc8587bd%3A0xd04c6da8aa7688af!2z4Kas4KeH4Kao4Ka-4Kaq4KeL4KayIOCmuOCmvybgpo_gpqsg4KaP4Kac4KeH4Kao4KeN4Kaf4Ka4IOCmheCnjeCmr-CmvuCmuOCni-CmuOCmv-Cmr-CmvOCnh-CmtuCmqA!5e0!3m2!1sbn!2sbd!4v1744119932034!5m2!1sbn!2sbd" class="w-full" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>

    </main>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#contactForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    // Clear previous errors
                    $('.error-message').text('');
                    $('.form-input').removeClass('border-red-500');
                    
                    // Disable submit button
                    $('#submitButton').prop('disabled', true).addClass('opacity-75');
                    
                    // Get form data
                    let formData = {
                        _token: '{{ csrf_token() }}',
                        name: $('#name').val(),
                        email: $('#email').val(),
                        message: $('#message').val()
                    };
                    
                    // Send AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("contact.store") }}',
                        data: formData,
                        success: function(response) {
                            // Show success message
                            $('#successAlert').removeClass('hidden');
                            $('#successAlert .success-message').text(response.message);
                            
                            // Clear form
                            $('#contactForm')[0].reset();
                            
                            // Scroll to success message
                            $('#successAlert')[0].scrollIntoView({ behavior: 'smooth' });
                            
                            // Hide success message after 5 seconds
                            setTimeout(function() {
                                $('#successAlert').fadeOut('slow');
                            }, 5000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                // Display validation errors
                                for (let field in errors) {
                                    $(`#${field}-error`).text(errors[field][0]);
                                    $(`#${field}`).addClass('border-red-500');
                                }
                            } else {
                                // Show general error message
                                $('#successAlert').removeClass('hidden')
                                    .removeClass('text-green-700 bg-green-100')
                                    .addClass('text-red-700 bg-red-100');
                                $('#successAlert .success-message').text('An error occurred. Please try again later.');
                            }
                        },
                        complete: function() {
                            // Re-enable submit button
                            $('#submitButton').prop('disabled', false).removeClass('opacity-75');
                        }
                    });
                });
                
                // Clear error message when user starts typing
                $('#contactForm input, #contactForm textarea').on('input', function() {
                    let field = $(this).attr('name');
                    $(`#${field}-error`).text('');
                    $(this).removeClass('border-red-500');
                });
            });
        </script>
    </x-slot>


</x-guest-layout>
