<x-mail::message>
# New Contact Message

**From:** {{ $senderName }}
**Email:** {{ $senderEmail }}
@if($senderPhone)
**Phone:** {{ $senderPhone }}
@endif

---

{{ $senderMessage }}

<x-mail::button :url="url('/admin/contact-messages')">
View in Admin
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
