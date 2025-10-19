<x-app-layout>
    {{-- Title --}}
    <x-slot name="title">Send SMS</x-slot>

    {{-- Header Style --}}
    <x-slot name="headerstyle">
    </x-slot>

    {{-- Page Content --}}
    <div class="flex flex-col gap-6">
        <div class="card max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <div class="">
                <h2 class="text-2xl font-bold text-center mb-6">Send SMS</h2>

                <!-- Tabs for switching between SMS types -->
                <div class="flex justify-center space-x-4 mb-4">
                    <button class="tab-btn active bg-blue-500 text-white px-4 py-2 rounded-md" data-tab="single">Single SMS</button>
                    <button class="tab-btn bg-gray-300 px-4 py-2 rounded-md" data-tab="bulk">Bulk SMS</button>
                    {{-- <button class="tab-btn bg-gray-300 px-4 py-2 rounded-md" data-tab="dynamic">Dynamic SMS</button> --}}
                </div>

                <!-- Single SMS Form -->
                <form id="singleSmsForm" class="sms-form">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-semibold">Phone Number:</label>
                        <input type="text" name="phone" class="w-full border p-2 rounded mt-1" placeholder="01XXXXXXXXX" required pattern="01[0-9]{9}">
                        <p class="error-message text-red-500 text-sm mt-1 hidden"></p>
                        <p class="text-gray-500 text-sm mt-1">Format: 01XXXXXXXXX (11 digits)</p>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Message:</label>
                        <textarea name="message" class="w-full border p-2 rounded mt-1" placeholder="Enter your message..." required maxlength="480" rows="4"></textarea>
                        <p class="error-message text-red-500 text-sm mt-1 hidden"></p>
                        <p class="text-gray-500 text-sm mt-1"><span class="message-length">0</span>/480 characters</p>
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded mt-4 hover:bg-blue-600">Send SMS</button>
                </form>

                <!-- Bulk SMS Form -->
                <form id="bulkSmsForm" class="sms-form hidden">
                    @csrf
                    <div class="mb-4">
                        {{-- <label class="block font-semibold">Phone Numbers (comma-separated):</label>
                        <textarea name="phones" class="w-full border p-2 rounded mt-1" placeholder="01XXXXXXXXX, 01YYYYYYYYY" required rows="3"></textarea>
                        <p class="error-message text-red-500 text-sm mt-1 hidden"></p> --}}
                        <p class="text-gray-500 text-sm mt-1">This will be sent to all {{$agentCount}} agents.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Message:</label>
                        <textarea name="message" class="w-full border p-2 rounded mt-1" placeholder="Enter your message..." required maxlength="480" rows="4"></textarea>
                        <p class="error-message text-red-500 text-sm mt-1 hidden"></p>
                        <p class="text-gray-500 text-sm mt-1"><span class="message-length">0</span>/480 characters</p>
                    </div>

                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded mt-4 hover:bg-green-600">Send Bulk SMS</button>
                </form>

                <!-- Dynamic SMS Form -->
                <form id="dynamicSmsForm" class="sms-form hidden">
                    @csrf
                    <div id="dynamic-fields">
                        <div class="dynamic-entry mb-6">
                            <div class="mb-4">
                                <label class="block font-semibold">Phone Number:</label>
                                <input type="text" name="msisdn[]" class="w-full border p-2 rounded mt-1" placeholder="01XXXXXXXXX" required pattern="01[0-9]{9}">
                                <p class="error-message text-red-500 text-sm mt-1 hidden"></p>
                            </div>

                            <div class="mb-2">
                                <label class="block font-semibold">Message:</label>
                                <textarea name="text[]" class="w-full border p-2 rounded mt-1" placeholder="Enter your message..." required maxlength="480" rows="3"></textarea>
                                <p class="error-message text-red-500 text-sm mt-1 hidden"></p>
                                <p class="text-gray-500 text-sm mt-1"><span class="message-length">0</span>/480 characters</p>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="addDynamicField" class="w-full bg-yellow-500 text-white py-2 rounded mt-4 hover:bg-yellow-600">+ Add More</button>
                    <button type="submit" class="w-full bg-purple-500 text-white py-2 rounded mt-4 hover:bg-purple-600">Send Dynamic SMS</button>
                </form>

                <!-- Response Message -->
                <div id="responseMessage" class="mt-4 text-center"></div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // Tab switching
                $(".tab-btn").click(function () {
                    $(".tab-btn").removeClass("bg-blue-500 text-white").addClass("bg-gray-300");
                    $(this).removeClass("bg-gray-300").addClass("bg-blue-500 text-white");

                    $(".sms-form").addClass("hidden");
                    $("#" + $(this).data("tab") + "SmsForm").removeClass("hidden");
                });

                // Character counter for message textareas
                $('textarea[name="message"], textarea[name="text[]"]').on('input', function() {
                    $(this).closest('div').find('.message-length').text(this.value.length);
                });

                // Dynamic SMS: Add more fields
                $("#addDynamicField").click(function () {
                    const newEntry = `
                        <div class="dynamic-entry mb-6">
                            <div class="mb-4">
                                <label class="block font-semibold">Phone Number:</label>
                                <input type="text" name="msisdn[]" class="w-full border p-2 rounded mt-1" placeholder="01XXXXXXXXX" required pattern="01[0-9]{9}">
                                <p class="error-message text-red-500 text-sm mt-1 hidden"></p>
                            </div>

                            <div class="mb-2">
                                <label class="block font-semibold">Message:</label>
                                <textarea name="text[]" class="w-full border p-2 rounded mt-1" placeholder="Enter your message..." required maxlength="480" rows="3"></textarea>
                                <p class="error-message text-red-500 text-sm mt-1 hidden"></p>
                                <p class="text-gray-500 text-sm mt-1"><span class="message-length">0</span>/480 characters</p>
                            </div>

                            <button type="button" class="remove-entry text-red-500 text-sm hover:text-red-700">Remove</button>
                        </div>
                    `;
                    $("#dynamic-fields").append(newEntry);
                });

                // Remove dynamic entry
                $(document).on('click', '.remove-entry', function() {
                    $(this).closest('.dynamic-entry').remove();
                });

                // Form submission handlers
                $(".sms-form").submit(function (e) {
                    e.preventDefault();
                    const form = $(this);
                    let actionUrl = "";

                    // Reset error messages
                    form.find('.error-message').addClass('hidden').text('');

                    if (form.attr("id") === "singleSmsForm") {
                        actionUrl = "/sms/send-single";
                    } else if (form.attr("id") === "bulkSmsForm") {
                        actionUrl = "/sms/send-bulk";
                    } else if (form.attr("id") === "dynamicSmsForm") {
                        actionUrl = "/sms/send-dynamic";
                    }

                    // Add CSRF token to the request headers
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Disable submit button and show loading state
                    const submitBtn = form.find('button[type="submit"]');
                    const originalText = submitBtn.text();
                    submitBtn.prop('disabled', true).text('Sending...');

                    $.ajax({
                        url: actionUrl,
                        method: "POST",
                        data: form.serialize(),
                        success: function (response) {
                            if (response.success) {
                                $("#responseMessage").html(`
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                        <p class="font-semibold">✅ ${response.message}</p>
                                    </div>
                                `);
                                form.trigger('reset');
                            } else {
                                $("#responseMessage").html(`
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                        <p class="font-semibold">❌ ${response.message}</p>
                                    </div>
                                `);
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 422) {
                                // Validation errors
                                const errors = xhr.responseJSON.errors;
                                Object.keys(errors).forEach(field => {
                                    const errorMsg = errors[field][0];
                                    // Handle array fields (for dynamic form)
                                    if (field.includes('.')) {
                                        const [fieldName, index] = field.split('.');
                                        form.find(`[name="${fieldName}[]"]`).eq(index)
                                            .siblings('.error-message')
                                            .removeClass('hidden')
                                            .text(errorMsg);
                                    } else {
                                        form.find(`[name="${field}"]`)
                                            .siblings('.error-message')
                                            .removeClass('hidden')
                                            .text(errorMsg);
                                    }
                                });
                            } else {
                                $("#responseMessage").html(`
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                        <p class="font-semibold">❌ An error occurred while sending the SMS.</p>
                                    </div>
                                `);
                            }
                        },
                        complete: function() {
                            // Re-enable submit button
                            submitBtn.prop('disabled', false).text(originalText);
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>
