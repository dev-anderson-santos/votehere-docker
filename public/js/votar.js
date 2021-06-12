$(document).ready(function() {

    window.setInterval(ut, 1000);

    var hora_fim_votacao = $('#hora_fim_votacao').val();
    var arr_hora_fim = hora_fim_votacao.split(':');

    var hora =  (new Date().toLocaleTimeString()).split(':');    
    var hora_montada = hora[0] + ':' + hora[1]
    console.log((hora[0] + hora[1]) - (arr_hora_fim[0] + arr_hora_fim[1]));    

});

function ut() {
    var dateTime = new Date();
    document.getElementById("datetime").innerHTML = `Data e hora local: ${dateTime.toLocaleDateString()} - ${dateTime.toLocaleTimeString()}`;

    
}

function votar(voto_id, user_id) {

    var form = $('#form_votar');
    var dados = {
        _token: $('[name="_token"]').val(), 
        voto_id: voto_id,
        eleitor_id: user_id,
    };

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: dados,
        success: function(data) {

            if(data.status == 'success') {

                Sweetalert2.fire({
                    title: 'Voto computado!',
                    html: `Você receberá um e-mail assim que a apuração terminar. <br/>${data.mensagem} <b></b>`,
                    icon: 'success',
                    allowOutsideClick: false,
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                    
                        location.replace('/votacoes/categorias')
                    }
                })
            } else if(data.status == 'info') {

                Sweetalert2.fire({
                    title: data.mensagem,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    allowOutsideClick: false
                }).then((result) => {
                    
                    if (result.isConfirmed) {
                        Sweetalert2.fire({
                            title: 'Voto computado!',
                            html: `Você receberá um e-mail assim que a apuração terminar. <b></b>`,
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.replace('/votacoes/categorias')
                            }
                        })
                    } else {
                        Sweetalert2.fire({
                            title: 'Voto computado!',
                            html: `Obrigado por votar! <b></b>`,
                            icon: 'success',
                            timer: 3000,
                            allowOutsideClick: false,
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
                    }
                })
            }
        }
    });
}