@extends('adminlte::page')

@section('content')
<link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
<div class="content-fluid">
  @include('usuario.includes.alerts')
  <div class="card-body box-profile widget-user" style="border: solid 1px #ccc">
    <form action="{{ route('usuario.update', $candidato->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="widget-user-header" style="background-color: #{{ rand(100, 999999) }}">
        <h3 class="widget-user-username" style="color: white">{{ $candidato->name }}</h3>
        <h5 class="widget-user-desc" style="color: white">Candidato</h5>
      </div>
      <div class="text-center" style="position: relative">
          <img alt="Avatar" class="table-avatar user-image img-circle" style="position:absolute; border: solid 5px #575757; top: -45px; margin-left:-45px; left: 50%;" width="90px" src="{{ 
              (file_exists('storage/'.$candidato->avatar) && !is_null($candidato->avatar)) 
              ? asset('storage/'.$candidato->avatar)
              : asset('img/users/user-default-image.jpg') 
          }}">
          <input type="file" name="avatar" class="form-control fileButton" style="display: none" id="" accept=".jpg, .jpeg">
          <button type="button" class="labelUploadd" onclick="selecionarArquivo()" style="margin-bottom: 45px; height:30px; width: 30px; border-radius: 50px; border-color: white; transform: translate(100%, 45%); background-color: black">
            <i class="fas fa-camera" style="margin-left:-2px; font-size: 15px; color: white;"></i>
          </button>
      </div>
      
      <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" value="{{ $candidato->name }}" name="name" id="inputName" placeholder="Nome do candidato">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" value="{{ $candidato->email }}" name="email" id="inputEmail" placeholder="Email">
        </div>
      </div>
      
      <div class="form-group row">
        <div class="col-md-12 text-right">
          <a href="{{ route('usuario.index') }}" class="btn btn-default">Cancelar</a>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>              
    </form>
  </div>        
</div>
@endsection


