<div class="modal fade" id="modalAdicionaCategoria" tabindex="-1" aria-labelledby="modalAdicionaCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAdicionaCategoriaLabel">Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tipo.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nome da categoria</label>
                        <input type="text" class="form-control" name="nome" required placeholder="Nome do tipo de votação">
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn-criar-tipo" class="btn btn-primary">Salvar</button>
                </div>                    
            </form>
        </div>
    </div>
</div>

