<x-mail::message>
# New Job Application

**Position:** {{ $application->position }}
**Name:** {{ $application->full_name }}
**Email:** {{ $application->email }}
**Phone:** {{ $application->phone }}

@if($application->resume_path)
A resume file has been uploaded and is available in the admin panel.
@endif

<x-mail::button :url="url('/admin/job-applications')">
View Applications
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
