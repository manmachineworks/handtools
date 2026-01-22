@component('mail::message')
# New Dealer Request

**Name:** {{ $record->name }}  
**Email:** {{ $record->email }}  
**Phone:** {{ $record->phone }}  
**State:** {{ $record->state }}  
**Address:** {{ $record->address }}

**Message:**  
{{ $record->message }}

@component('mail::panel')
IP: {{ $record->ip }}  
UA: {{ $record->user_agent }}
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
