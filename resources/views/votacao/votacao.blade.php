@extends('adminlte::page')

@section('content')
    <div class="content-fluid">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row d-flex justify-content-between align-items-center">
                    <input type="hidden" value="{{ $votacao->votos()->get()->max('qtd_votos') }}" id="maior-voto">
                    <input type="hidden" value="{{ $votacao->id }}" id="votacao_id">
                    <h1>Resultado da votação</h1>
                    <div>
                        <a href="{{ route('votacao.categorias') }}" class="btn btn-secondary float-sm-right">Voltar</a>
                    </div>
                </div>
            </div>
        </section>
      
        <table class="table table-striped" id="tabela-resultado">
            <thead>
                <th>#</th>
                <th>Candidato</th>
                <th>Votos computados</th>
            </thead>
            <tbody>
                @php 
                    $maiorVoto = $votacao->votos()->get()->max('qtd_votos');
                @endphp
                @forelse ($votacao->votos as $item)
                <tr>
                    <td>
                        @if($item->qtd_votos == $maiorVoto)
                        <img src="{{ asset('img/trofeu.jpg') }}" class="img-fluid img-circle" height="40px" width="40px" alt="Vencedor">
                        @endif
                    </td>
                    <td>
                        <img src="{{ asset('storage/'.$item->user()->first()->avatar) }}" style="border: solid 2px #575757;" class="img-circle" height="40px" width="40px" alt="Vencedor">
                        {{ $item->user()->first()->name }}
                    </td>
                    <td>{{ $item->qtd_votos }}</td>
                </tr>
                @empty
                <tr>
                    <td>Sem informações</td>
                </tr>                
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        
        var pusher = new Pusher('9cd96e2f5edc3ca05233', {
            cluster: 'us2'
        });
        
        var channel = pusher.subscribe('voto-novo');
        channel.bind('App\\Events\\NewVote', function(data) {            
            
            if(data) {
                var maiorVoto = $('#maior-voto').val()
                $.ajax({
                    url: `/votar/get-votos/${data.voto.votacao_id}`,
                    type: 'get',                                    
                    success: function(dados) {
                        if($('#votacao_id').val() == dados.votos[0].votacao_id) {
                            $('#tabela-resultado tbody').html('');
                            
                            var rows = '';
                            $.each(dados.votos, function(i, obj) {
                                
                                rows += "<tr>";
                                rows += `<td>
                                    ${obj.qtd_votos == dados.maiorVoto 
                                    ? '<img src="{{ asset("img/trofeu.jpg") }}" class="img-fluid img-circle" height="40px" width="40px" alt="Vencedor">'
                                    : ''}
                                    </td>`;
                                rows += `<td>
                                    <img src="/storage/${obj.user.avatar}" class="img-circle" style="border: solid 2px #575757;" height="40px" width="40px" alt="Vencedor">
                                    ${obj.user.name}
                                </td>`;
                                rows += "<td>" + obj.qtd_votos + "</td>";
                                rows += "</tr>";
                            });
                            
                            $('#tabela-resultado tbody').html(rows);
                        }
                    }
                });
            }

        });
    </script>
@endsection