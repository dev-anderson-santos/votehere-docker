@extends('adminlte::page')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.min.css') }}">
    <div class="conainer-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      <div class="row d-flex justify-content-between align-items-center">
                            <h1>Votações</h1>   
                            {{-- <div>
                                <a href="{{ route('votacao.create') }}" class="btn btn-success float-sm-right">Nova</a>
                            </div> --}}
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      @if($votacoes->isNotEmpty())
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Nome</th>
                              <th>Status</th>
                              <th>Andamento</th>
                              <th>Ações</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($votacoes as $item)
                                <tr>
                                  <td>{{ $item->id }}</td>
                                  <td>
                                    <ul class="list-inline">
                                      @foreach ($item->votos()->get() as $voto)                                  
                                      <li class="list-inline-item">
                                        {{-- <img alt="Avatar" class="table-avatar" height="40" width="40" 
                                              style="border-radius: 50%" title="{{ $voto->user()->first()->name }}" 
                                              src="{{ asset($voto->user()->first()->avatar) }}"> --}}

                                        <img alt="Avatar" class="img-circle img-fluid" height="40" width="40" title="{{ $voto->user()->first()->name }}" 
                                              src="{{ (file_exists('storage/'.$voto->user()->first()->avatar) && !is_null($voto->user()->first()->avatar)) 
                                                      ? asset('storage/'.$voto->user()->first()->avatar)
                                                      : asset('img/users/user-default-image.jpg') 
                                                  }}">
                                      </li>
                                      @endforeach
                                    </ul>
                                  </td>
                                  <td>@if($item->status == 1)
                                        <span class="badge badge-success">Ativada</span>
                                      @else
                                        <span class="badge badge-danger">Desativada</span>
                                      @endif
                                  </td>
                                  <td>
                                    <span class="irs irs--flat js-irs-2">
                                      <span class="irs">
                                        <span class="irs-line" tabindex="0"></span>
                                        <span class="irs-min" style="visibility: visible;">{{ \Carbon\Carbon::parse($item->data_inicio)->format('H:i') }}</span>
                                        <span class="irs-max" style="visibility: visible;">{{ \Carbon\Carbon::parse($item->data_fim)->format('H:i') }}</span>
                                        <span class="irs-from" style="visibility: hidden;">0</span>
                                        <span class="irs-to" style="visibility: hidden;">0</span>
                                        <span class="irs-single" style="left: 75.5356%;">7.9 mm</span>
                                      </span>
                                      <span class="irs-grid"></span>
                                      <span class="irs-bar irs-bar--single" style="left: 0px; width: 78.3891%;"></span>
                                      <span class="irs-shadow shadow-single" style="display: none;"></span>
                                      <span class="irs-handle single" style="left: 77.3357%;"><i></i><i></i><i></i></span>
                                    </span>
                                    <input id="range_5" type="text" name="range_5" value="" class="irs-hidden-input" tabindex="-1" readonly="">
                                  </td>
                                  <td>
                                    <a href="{{ route('votacao.show', ['votacao_id' => $item->id]) }}" class="btn btn-primary fa fa-eye" title="Visualizar"></a>
                                    <a href="{{ route('votacao.votar', ['votacao_id' => $item->id]) }}" class="btn btn-warning" title="Visualizar"><i class="fas fa-link"></i></a>
                                    <a href="#" class="btn btn-success" title="Pausar ou Iniciar Votação">
                                      <i class="fa fa-arrow-right"></i>
                                    </a>
                                    <a href="#" class="btn btn-secondary" title="Editar">
                                      <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger" title="Excluir">
                                      <i class="fa fa-trash"></i>
                                    </a>
                                  </td>
                                </tr>                          
                                @endforeach
                          </tbody>
                        </table>
                        @else
                          <div class="row">
                            <div class="col-md-12">
                              <p>Nenhuma votação cadastrada</p>
                            </div>
                          </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    @if($votacoes->isNotEmpty())
                      <div class="card-footer clearfix">
                        {{ $votacoes->links() }}
                      </div>
                    @endif
                  </div>
            </div>
        </div>
    </div>    
@endsection
