<x-mail::message>
# Introduction

Dear, {{ $name }}! Reset your password. Your reset code: {{ $code }} .

<x-mail::button :url="''">
Reset password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
