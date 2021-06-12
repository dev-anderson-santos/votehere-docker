@extends('adminlte::page')

@section('content')

@php
    $isAdmin = !empty(\App\Models\RoleUserModel::whereRoleId(\App\Models\RoleModel::ADMINISTRADOR)->whereUserId(auth()->user()->id)->first()) 
              && \App\Models\RoleUserModel::whereRoleId(\App\Models\RoleModel::ADMINISTRADOR)->whereUserId(auth()->user()->id)->first()->exists() 
              ? true 
              : false;
@endphp

<link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.min.css') }}">
    <div class="conainer-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      <div class="row d-flex justify-content-between align-items-center">
                            <h1>Votações disponíveis</h1>                              
                            @if($isAdmin)
                              @if($tipo || $candidatos)
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                      É necessário criar uma categoria e os candidatos para criar uma votação.
                                    </div>
                                  </div>
                              </div>
                              @endif
                              <div>
                                  <a href="{{ route('votacao.create') }}" id="btnNova" class="btn btn-success float-sm-right {{ ($tipo || $candidatos) ? 'disabled' : '' }}">Nova</a>
                              </div>
                            @endif
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      @if($tipoVotacao->isNotEmpty())
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Nome</th>
                              @if ($isAdmin)
                                <th width="40%">Ações</th>                                
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($tipoVotacao as $item)
                              <tr>
                                  <td>{{ $item->votacao_id }}</td>
                                  <td>
                                      <a href="{{ route('votacao.votar', $item->votacao_id) }}">Votar para {{ $item->votacao($item->votacao_id)->first()->nome }}</a>
                                  </td>
                                  @if ($isAdmin)
                                  <td>
                                    <a href="{{ route('votacao.show', ['votacao_id' => $item->votacao_id]) }}" class="btn btn-primary fa fa-eye" title="Visualizar"></a>                                  
                                    {{-- <a href="#" class="btn btn-success" title="Pausar ou Iniciar Votação">
                                      <i class="fa fa-arrow-right"></i>
                                    </a> --}}
                                    <a href="{{ route('votacao.edit', $item->votacao_id) }}" class="btn btn-secondary" title="Editar">
                                      <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="excluirVotacao({{ $item->votacao_id }})" class="btn btn-danger" title="Excluir">
                                      <i class="fa fa-trash"></i>
                                    </a>
                                  </td>
                                @endif
                              </tr>                          
                          @endforeach
                          </tbody>
                        </table>
                      @else
                        <div class="row">
                          <div class="col-md-12">
                            <p>Nenhuma votação em andamento</p>
                          </div>
                        </div>
                      @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                      @if($tipoVotacao->isNotEmpty())
                        {{ $tipoVotacao->links() }}
                      @endif
                    </div>
                  </div>
            </div>
        </div>
    </div>    
@endsection
