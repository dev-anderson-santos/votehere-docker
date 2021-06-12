@extends('adminlte::page')

@section('content')
    <div class="conainer-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      @include('usuario.includes.alerts')
                      <div class="row d-flex justify-content-between align-items-center">
                            <h1>Categorias</h1>   
                            <div>
                                <button type=button onclick="novaCategoria()" id="btn_nova_aula" class="btn btn-primary nova_atividade" data-toggle="modal" data-target="#modalAdicionaCategoria" title="Criar nova categoria">Nova</button>
                            </div>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      @if ($tipos->isNotEmpty())
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Nome</th>
                              <th>Ações</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($tipos as $item)
                              <tr>
                                  <td>{{ $item->id }}</td>
                                  <td>{{ $item->nome }}</td>
                                  <td>                                  
                                      <button class="btn btn-secondary" data-toggle="modal" id="getCategoria" data-target="#modalEditarCategoria" title="Editar" data-url="{{ route('dynamicModal', $item->id) }}">
                                        <i class="fa fa-pencil-alt"></i>
                                      </button>
                                      <a href="{{ route('tipo.destroy', $item->id) }}" class="btn btn-danger" title="Excluir">
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
                          <p>Nenhuma categoria cadastrada</p>
                        </div>
                      </div>
                      @endif
                    </div>
                    <!-- /.card-body -->
                    @if ($tipos->isNotEmpty())
                      <div class="card-footer clearfix">
                          <p>{{ $tipos->links() }}</p>
                      </div>
                    @endif
                  </div>
            </div>
        </div>
    </div>

    {{-- @include('tipo.modal-novo-tipo') --}}
    @include('tipo.modal-edit-tipo')
@endsection

