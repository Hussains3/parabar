@component('mail::message')
# Thank You for Contacting Us

Dear {{ $name }},

Thank you for reaching out to us. We have received your message and will get back to you as soon as possible.

Best regards,<br>
{{ config('app.name') }}
@endcomponent