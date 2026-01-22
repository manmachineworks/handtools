@component('mail::message')
# New Enquiry (Apply Form)

**Name:** {{ $record->name }}  
**Email:** {{ $record->email }}  
**Phone:** {{ $record->mobile }}  
**Product:** {{ $record->product_type }}  
**City:** {{ $record->city }}  
**State:** {{ $record->state }}

@component('mail::panel')
IP: {{ $record->ip }}  
UA: {{ $record->user_agent }}
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
