@component('mail::message')
# Site Feedback Sent!

From: **{{$feedback->email}}**

@component('mail::panel')
{{$feedback->message}}
@endcomponent

{{$feedback->reply_me ? "I'm waiting for a reply!"  : "That's all, don't reply!"}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
