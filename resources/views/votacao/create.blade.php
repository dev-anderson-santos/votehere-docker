@extends('adminlte::page')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-duallistbox.css') }}">
<link href="{{ asset('css/bootstrap-switch.css') }} " rel="stylesheet">
    <div class="content-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex justify-content-between align-items-center">
                    <h1>Nova Votação</h1>
                </div>
            </div>
            <div class="card-body">
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Selecione uma categoria:</label>            
                                <select name="tipo" id="" required class="form-control">
                                    <option value="">-- Selecione uma categoria --</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">   
                        <div class="col-md-4">                            
                            <div class="form-group">
                                <label>Data de início:</label>            
                                <input type="date" class="form-control" id="data_inicio" value="" name="data_inicio">
                            </div>
                        </div>
                        <div class="col-md-2">                            
                            <div class="form-group">
                                <label>Horário de início:</label>            
                                <input type="time" class="form-control" id="hora_inicio" value=""" name="hora_inicio">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Data de término:</label>            
                                <input type="date" class="form-control" id="data_fim" value="" name="data_fim">                                
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Horário de término:</label>            
                                <input type="time" class="form-control" id="hora_fim" value=""" name="hora_fim">                                
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Selecione os candidatos para votação:</label>
                                <select multiple="multiple" name="duallistbox_demo1[]" size="4" style="display: none;">
                                    @foreach ($candidatos as $user)
                                        @if ($user->roleUser()->first()->role_id == \App\Models\RoleModel::CANDIDATO)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Status da votação</label>
                                <input type="checkbox" name="status" class="form-control" 
                                    data-toggle="switch" data-on-color="primary" 
                                    data-on-text="Ativada" data-off-color="danger" 
                                    data-inverse="true"
                                    data-off-text="Desativada" checked>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Avisar eleitor?</label>
                                <input type="checkbox" name="avisar_encerramento" class="form-control" 
                                    data-toggle="switch" data-on-color="primary" 
                                    data-on-text="Sim" data-off-color="danger" 
                                    data-inverse="true"
                                    data-off-text="Não" checked>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col-md-12">
                            <a href="{{ route('votacao.categorias') }}" class="btn btn-default">Cancelar</a>
                            <button type="button" id="btn-salvar-votacao" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>             
                </form>  
            </div>
        </div>
    </div>
    
    
@endsection

