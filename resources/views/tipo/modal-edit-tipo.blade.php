<div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarCategoriaLabel">Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-editar-categoria">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nome da categoria</label>
                        
                        <input type="text" class="form-control" style="display: none" name="nome" required placeholder="Nome do tipo de votação">
                        
                    </div>

                    <div id="modal-loader" 
                        style="display: none; text-align: center;">
                    <img src="{{ asset('img/ajax-loader.gif') }}">
                   </div>
                    <div id="dynamic-content"></div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-editar-tipo" class="btn btn-primary">Salvar</button>
                </div>                    
            </form>
        </div>
    </div>
</div>

