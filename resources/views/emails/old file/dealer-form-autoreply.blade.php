@component('mail::message')
Hi {{ $record->name }},

Thanks for your interest in becoming a dealer. We’ve received your request and will respond soon.

**Summary**
- State: {{ $record->state }}
- Phone: {{ $record->phone }}

Thanks,  
{{ config('app.name') }}
@endcomponent
