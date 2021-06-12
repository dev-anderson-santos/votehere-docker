@component('mail::message')
# Introduction

Olá {{ $user->name }}, a votação encerrou!

@component('mail::button', ['url' => 'http://localhost/votacoes/votacao/1'])
Ver resultado.
@endcomponent

Obrigado, <br>
{{ config('app.name') }}
@endcomponent
