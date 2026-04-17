<x-mail::message>
# New Service Request

**Service:** {{ ucfirst($serviceRequest->service_type) }}
**Name:** {{ $serviceRequest->name }}
**Email:** {{ $serviceRequest->email }}
@if($serviceRequest->phone)
**Phone:** {{ $serviceRequest->phone }}
@endif
@if($serviceRequest->company)
**Company:** {{ $serviceRequest->company }}
@endif

---

@if($serviceRequest->message)
{{ $serviceRequest->message }}
@else
_No additional message provided._
@endif

<x-mail::button :url="url('/admin/service-requests')">
View in Admin
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
