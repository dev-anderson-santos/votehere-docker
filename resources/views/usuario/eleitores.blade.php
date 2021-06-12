@extends('adminlte::page')

@section('content')
<div class="content-fluid">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row d-flex justify-content-between align-items-center">
                <h1>Eleitores</h1>   
                {{-- <div>
                    <a href="{{ route('usuario.create') }}" class="btn btn-success float-sm-right">Novo</a>
                </div> --}}
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('usuario.includes.alerts')
    <!-- Main content -->
    
    <section class="content">                
        <table class="table tablestriped">
            <tr>
                <thead>
                    <td>#</td>
                    <td>Nome</td>
                    <td>E-mail</td>
                </thead>
            </tr>
            <tr>
                <tbody>
                    @forelse ($eleitores as $item)
                        <tr>
                            <td>{{ $item->user->id }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td>Nenhum eleitor encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </tr>
        </table>
        <nav aria-label="Contacts Page Navigation">
            {{ $eleitores->links() }}
        </nav>
    </section>
    <!-- /.content -->
</div>    
@endsection