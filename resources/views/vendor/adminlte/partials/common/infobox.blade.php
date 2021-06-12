<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $votacoes->count() }}</h3>

                <p>Votações</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('votacao.categorias') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $candidatos->count() }}</h3>

                <p>Candidatos</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('usuario.index') }}" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $eleitores->count() }}</h3>

                <p>Eleitores</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $votos }}</h3>

                <p>Votos</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>