@component('mail::message')
Hi {{ $record->name }},

Thanks for contacting us! Your enquiry has been received. Our team will get back to you shortly.

**Summary**
- Product: {{ $record->product_type }}
- City/State: {{ $record->city }}, {{ $record->state }}

Thanks,  
{{ config('app.name') }}
@endcomponent
