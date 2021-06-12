$(function() {
    
    $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox({
        nonSelectedListLabel: 'Candidatos disponíveis',
        selectedListLabel: 'Candidatos selecionados',
        filterTextClear: 'Limpar filtro',
        filterPlaceHolder: 'Pesquisar candidato',
        infoText: 'Candidatos: {0}',
        infoTextEmpty: 'Nenhum candidato'
    });

    var dualListContainer = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox('getContainer');
    dualListContainer.find('.moveall i').removeClass().addClass('fa fa-arrow-right');
    dualListContainer.find('.removeall i').removeClass().addClass('fa fa-arrow-left');
    dualListContainer.find('.move i').removeClass().addClass('fa fa-arrow-right');
    dualListContainer.find('.remove i').removeClass().addClass('fa fa-arrow-left');

    

    $('#btn-salvar-votacao').on('click', function() {
        criarVotacao();
    })

    $('#btn-editar-votacao').on('click', function() {
        editarVotacao();
    })

    $("[name='status']").bootstrapSwitch({state: false});
    $("[name='avisar_encerramento']").bootstrapSwitch();

    $('#range_5').ionRangeSlider({
        min     : 0,
        max     : 10,
        type    : 'single',
        step    : 0.1,
        postfix : ' mm',
        prettify: false,
        hasGrid : true
    })
    
    $(document).ready(function(){
      
        $(document).on('click', '#getCategoria', function(e){
    
            e.preventDefault();
    
            var url = $(this).data('url');
    
            $('#dynamic-content').html(''); // leave it blank before ajax call
            $('#modal-loader').show();      // load ajax loader
    
            $.ajax({
                url: url,
                type: 'GET',
                // dataType: 'html',
                success: function(data){
                    // console.log(data.result);  
                    // alert(data);  
                    $('#dynamic-content').html(`
                        <input type="hidden" name="tipo_id" value="${data.result.id}">
                        <input type="text" class="form-control" name="nome" value="${data.result.nome}" required placeholder="Nome do tipo de votação">
                    `);    
                    // $('[name="nome"]').val(data.nome); // load response 
                    $('#modal-loader').hide();        // hide ajax loader   
                }
            })
            
            .fail(function(){
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader').hide();
            });
    
        });

        $('#btn-editar-tipo').on('click', function() {
            var form = $('#form-editar-categoria');

            $.ajax({
                url: `tipos/${form.find('[name="tipo_id"]').val()}/update`,
                method: 'get',
                data: form.serialize(),
                success: function(data) {
                    if(data.status == 'success')
                        location.replace('tipos');
                    else
                        alert(data.mensagem);
                }
            })
        })
    });
    
});

function criarVotacao() {    

    var tipo = $('[name="tipo"]').val();
    var candidatos = $('[name="duallistbox_demo1[]"]').val();
    var data_inicio = $('#data_inicio').val();
    var data_fim = $('#data_fim').val();
    var hora_inicio = $('#hora_inicio').val();
    var hora_fim = $('#hora_fim').val();

    $.ajax({
        url: '/votacoes/salvar',
        method: 'POST',
        data: {
            _token: $('[name="_token"]').val(),
            tipo: tipo,
            candidatos: candidatos,
            data_inicio: data_inicio,
            data_fim: data_fim,
            hora_inicio: hora_inicio,
            hora_fim: hora_fim,
            status: $('[name="status"]').prop('checked'),
            avisar_encerramento: $('[name="avisar_encerramento"]').prop('checked'),
        },
        success: function(data) {
            if(data.status == 'success') {                
                Sweetalert2.fire({
                    title: 'Feito!',
                    html: `${data.mensagem} <b></b>`,
                    icon: 'success',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Sweetalert2.showLoading()
                        timerInterval = setInterval(() => {
                        
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    
                    if (result.dismiss === Sweetalert2.DismissReason.timer) {
                        location.replace('/votacoes/categorias')
                    }
                })
            } else if(data.status == 'warning') {
                Sweetalert2.fire({
                    icon: 'warning',
                    title: data.mensagem
                })
            } else {
                Sweetalert2.fire({
                    icon: 'error',
                    title: data.mensagem
                })
            }
        }
    });
}

function editarVotacao() {

    var votacao_id = $('[name="votacao_id"]').val();
    var tipo = $('[name="tipo"]').val();
    var candidatos = $('[name="duallistbox_demo1[]"]').val();
    var data_inicio = $('#data_inicio').val();
    var data_fim = $('#data_fim').val();
    var hora_inicio = $('#hora_inicio').val();
    var hora_fim = $('#hora_fim').val();

    $.ajax({
        url: `/votacoes/${votacao_id}/update/`,
        method: 'POST',
        data: {
            _token: $('[name="_token"]').val(),
            tipo: tipo,
            candidatos: candidatos,
            data_inicio: data_inicio,
            data_fim: data_fim,
            hora_inicio: hora_inicio,
            hora_fim: hora_fim,
            status: $('[name="status"]').prop('checked'),
            avisar_encerramento: $('[name="avisar_encerramento"]').prop('checked'),
        },
        success: function(data) {
            if(data.status == 'success') {                
                Sweetalert2.fire({
                    title: 'Feito!',
                    html: `${data.mensagem} <b></b>`,
                    icon: 'success',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Sweetalert2.showLoading()
                        timerInterval = setInterval(() => {
                        
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    
                    if (result.dismiss === Sweetalert2.DismissReason.timer) {
                        location.replace('/votacoes/categorias')
                    }
                })
            } else if(data.status == 'warning') {
                Sweetalert2.fire({
                    icon: 'warning',
                    title: data.mensagem
                })
            } else {
                Sweetalert2.fire({
                    icon: 'error',
                    title: data.mensagem
                })
            }
        }
    });
}

function excluirVotacao(votacao_id) {
    Sweetalert2.fire({
        title: 'Tem certeza que deseja remover esta votação?',
        text: "Esta ação não poderá ser desfeita.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(`${votacao_id}/delete`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .catch(error => {
                Sweetalert2.showValidationMessage(
                    `Request failed: ${error}`
                )
            })
        },
        allowOutsideClick: () => !Sweetalert2.isLoading()
    }).then((result) => {
        
        if (result.isConfirmed) {
            if(result.value.status == 'success') {
                Sweetalert2.fire({
                    title: 'Removido!',
                    html: `${result.value.mensagem} <b></b>`,
                    icon: 'success',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Sweetalert2.showLoading()
                        timerInterval = setInterval(() => {
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    
                    if (result.dismiss === Sweetalert2.DismissReason.timer) {
                        location.replace('/votacoes/categorias')
                    }
                })
            } else if(result.value.status == 'warning') {
                Sweetalert2.fire({
                    title: 'Atenção!',
                    html: `${result.value.mensagem}`,
                    icon: 'warning',
                })
            } else {
                Sweetalert2.fire({
                    title: 'Erro!',
                    html: `${result.value.mensagem}`,
                    icon: 'error',
                })
            }
        }
    })
}

function selecionarArquivo(){
	$(".fileButton").trigger('click');
	$(".fileButton").on('change', function(){
		readFile(this);
	});
}

function readFile(_this) {
	if (_this.files && _this.files[0]) {

		var FR = new FileReader();
		FR.onloadend = function(e) {
			$(".user-image").attr("src", e.target.result);
			
		};
		FR.readAsDataURL( _this.files[0] );
	}
}

function removerCandidato(candidato_id_) {
    
    Sweetalert2.fire({
        title: 'Tem certeza que deseja remover o candidato?',
        text: "Esta ação não poderá ser desfeita.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        showLoaderOnConfirm: true,
        preConfirm: (candidato_id) => {
            return fetch(`/candidatos/${candidato_id_}/delete`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .catch(error => {
                Sweetalert2.showValidationMessage(
                    `Request failed: ${error}`
                )
            })
        },
        allowOutsideClick: () => !Sweetalert2.isLoading()
    }).then((result) => {
        
        if (result.isConfirmed) {
            if(result.value.status == 'success') {
                Sweetalert2.fire({
                    title: 'Removido!',
                    html: `${result.value.mensagem} <b></b>`,
                    icon: 'success',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Sweetalert2.showLoading()
                        timerInterval = setInterval(() => {
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    
                    if (result.dismiss === Sweetalert2.DismissReason.timer) {
                        location.replace('/candidatos')
                    }
                })
            } else if(result.value.status == 'warning') {
                Sweetalert2.fire({
                    title: 'Atenção!',
                    html: `${result.value.mensagem}`,
                    icon: 'warning',
                })
            } else {
                Sweetalert2.fire({
                    title: 'Erro!',
                    html: `${result.value.mensagem}`,
                    icon: 'error',
                })
            }
        }
    })    
}

function removerTodosOsCandidatos() {
    
    Sweetalert2.fire({
        title: 'Tem certeza que deseja remover todos os candidatos?',
        text: "Esta ação não poderá ser desfeita.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(`/candidatos/killThemAll`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .catch(error => {
                Sweetalert2.showValidationMessage(
                    `Request failed: ${error}`
                )
            })
        },
        allowOutsideClick: () => !Sweetalert2.isLoading()
    }).then((result) => {
        
        if (result.isConfirmed) {
            if(result.value.status == 'success') {
                Sweetalert2.fire({
                    title: 'Removido!',
                    html: `${result.value.mensagem} <b></b>`,
                    icon: 'success',
                    timer: 5000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Sweetalert2.showLoading()
                        timerInterval = setInterval(() => {
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    
                    if (result.dismiss === Sweetalert2.DismissReason.timer) {
                        location.replace('/candidatos')
                    }
                })
            } else if(result.value.status == 'info') {
                Sweetalert2.fire({
                    title: 'Atenção!',
                    html: `${result.value.mensagem}`,
                    icon: 'info',
                })
            } else {
                Sweetalert2.fire({
                    title: 'Erro!',
                    html: `${result.value.mensagem}`,
                    icon: 'error',
                })
            }
        }
    })    
}

function criarCandidato() {
    var form = $('#form_novo_candidato');
    var dados = {
        _token: $('[name="_token"]').val(), 
        name: $('#name').val(),
        email: $('#email').val(),
        avatar: $('#avatar').val(),
    };

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: dados,
        success: function(data) {

            if(data.status == 'success') {                
                Sweetalert2.fire({
                    title: 'Feito!',
                    html: `${data.mensagem} <b></b>`,
                    icon: 'success',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Sweetalert2.showLoading()
                        timerInterval = setInterval(() => {
                        
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    
                    if (result.dismiss === Sweetalert2.DismissReason.timer) {
                        location.replace('/candidatos')
                    }
                })
            } else if(data.status == 'warning') {
                Sweetalert2.fire({
                    icon: 'warning',
                    title: data.mensagem
                })
            } else {
                Sweetalert2.fire({
                    icon: 'error',
                    title: data.mensagem
                })
            }
        }
    })
    
}

function novaCategoria() {
    const rota = 'tipos/store?nome=';

    Sweetalert2.fire({
        title: 'Nova categoria',
        input: 'text',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#ccc',
        confirmButtonText: 'Salvar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        inputValue: this,
        preConfirm: (nome) => {
            return fetch(rota+nome)
            .then(response => {
                
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .catch(error => {
                Sweetalert2.showValidationMessage(
                `Request failed: ${error}`
                )
            })
        },
        allowOutsideClick: () => !Sweetalert2.isLoading()
    }).then((result) => {
        console.log(result);
        if (result.isConfirmed) {
            if(result.value.status == 'success') {
                Sweetalert2.fire({
                    title: 'Feito!',
                    html: `${result.value.mensagem} <b></b>`,
                    icon: 'success',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Sweetalert2.showLoading()
                        timerInterval = setInterval(() => {
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    
                    if (result.dismiss === Sweetalert2.DismissReason.timer) {
                        location.replace('/tipos')
                    }
                })
            } else if(result.value.status == 'info') {
                Sweetalert2.fire({
                    title: 'Atenção!',
                    html: `${result.value.mensagem}`,
                    icon: 'info',
                })
            } else {
                Sweetalert2.fire({
                    title: 'Erro!',
                    html: `${result.value.mensagem}`,
                    icon: 'error',
                })
            }
        }
    })
}

