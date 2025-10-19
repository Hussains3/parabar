@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-4">
            <a href="{{ route('contacts.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to all messages</a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-2">From: {{ $contact->name }}</h2>
                <p class="text-gray-600">{{ $contact->email }}</p>
                <p class="text-sm text-gray-500">Received: {{ $contact->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div class="border-t pt-4">
                <h3 class="font-medium mb-2">Message:</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $contact->message }}</p>
            </div>

            <div class="mt-6 border-t pt-4 flex justify-between items-center">
                <span class="text-sm text-gray-500">
                    Status: 
                    @if($contact->is_read)
                        <span class="text-green-600">Read</span>
                    @else
                        <span class="text-yellow-600">Unread</span>
                    @endif
                </span>

                <form action="{{ route('contacts.destroy', $contact) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this message?')">
                        Delete Message
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection