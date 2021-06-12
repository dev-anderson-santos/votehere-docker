@extends('adminlte::page')

@section('content')
<div class="content-fluid">
    <!-- Content Header (Page header) -->
    {{-- <section class="content-header">
        <div class="container-fluid">
            <div class="row d-flex justify-content-between align-items-center">
                <h1>Candidatos</h1>   
                <div>
                    
                </div>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section> --}}
    
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                @include('usuario.includes.alerts')
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-md-6">
                        <h1>Candidatos</h1>   
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="javascript:void(0)" onclick="removerTodosOsCandidatos()" class="btn btn-danger">Excluir todos</a>
                        <a href="{{ route('usuario.create') }}" class="btn btn-success">Novo</a>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="row">
                    @if(count($rolesPerUser) == 0)
                        <div class="col-md-12">
                            <p>Não há candidato cadastrado</p>
                        </div>
                    @else
                        @forelse ($users as $user)
                            @if ($user->roleUser->role_id == \App\Models\RoleModel::CANDIDATO) 
                                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-header text-muted border-bottom-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Candidato #{{ $user->id }}
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <a href="javascript:void(0)" onclick="removerCandidato({{ $user->id }})" class="btn btn-default remove_candidato"><i class="fas fa-trash" style="color: red"></i></a>
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="lead"><b>{{ $user->name }}</b></h2>
                                                    {{-- <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p> --}}
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> Email: {{ $user->email }}</li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                                                    </ul>
                                                </div>
                                                <div class="col-5 text-center">
                                                <img alt="Avatar" loading="eager" class="img-circle img-fluid" style="height: 150px; width:150px;" src="{{ (file_exists('storage/'.$user->avatar) && !is_null($user->avatar)) 
                                                                                                        ? asset('storage/'.$user->avatar)
                                                                                                        : asset('img/users/user-default-image.jpg') 
                                                                                                    }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <a href="#" class="btn btn-sm bg-teal">
                                                    <i class="fas fa-comments"></i>
                                                </a>
                                                <a href="{{ route('usuario.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-pencil-alt"></i> Editar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                        @endforelse 
                    @endif
                </div>
                @if (count($rolesPerUser) >= 10)
                    <div class="card-footer">
                        <nav aria-label="Contacts Page Navigation">
                            {{ $users->links() }}
                        </nav>
                    </div> <!-- /.card-footer -->                
                @endif
                
            </div>
        </div>
        
    </section>
    <!-- /.content -->
</div>    
@endsection