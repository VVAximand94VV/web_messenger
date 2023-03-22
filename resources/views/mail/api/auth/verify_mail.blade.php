<x-mail::message>
# Introduction

Hello, {{ $name }}! Click the button for verified your email address.

Id: {{ $id }}
Hash: {{ $hash }}
<x-mail::button url="{{ $url }}" color="success">
Verify Email
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
