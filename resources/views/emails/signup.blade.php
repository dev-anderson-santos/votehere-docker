Olá {{$email_data['name']}}
<br><br>
Seja bem-vindo(a) ao {{env('APP_NAME')}}!
<br>
Por favor, clique no link abaixo para verificar o seu e-mail e ativar a sua conta!
<br><br>
<a href="{{ env('APP_URL') }}.'/verify?code='.{{$email_data['verification_code']}}">Verificar e-mail!</a>

<br><br>
Obrigado!
<br>
{{ env('APP_NAME') }}