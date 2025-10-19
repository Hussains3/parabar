@component('mail::message')
# New Contact Form Submission

You have received a new contact form submission:

**Name:** {{ $name }}  
**Email:** {{ $contact->email }}

**Message:**  
{{ $contact->message }}

@component('mail::button', ['url' => route('contacts.show', $contact->id)])
View Message
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
