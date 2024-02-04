function reserva(url,tipo){

    let urlDestino;
    let parametro1 = '';
    let parametro2 = '';
    let parametro3 = '';
    let parametro4 = '';
    let parametro5 = '';
    let parametro6 = '';


    if(tipo ==  0){
        parametro1 = "local";       //esse pode ser fixo(nao mexer)
        parametro2 = "QDF4C98";     //mudar para variavel ( no momento esta fixo)
        urlDestino = url + '?parametro1=' + encodeURIComponent(parametro1) + '&parametro2=' + encodeURIComponent(parametro2);
    }else if(tipo == 1){
        parametro1 = "viagem";      //esse pode ser fixo(nao mexer)
        parametro2 = "QDF4C98";     //mudar para variavel ( no momento esta fixo)
    
        urlDestino = url + '?parametro1=' + encodeURIComponent(parametro1) + '&parametro2=' + encodeURIComponent(parametro2);
    }else if (tipo ==  2){

        // pegar infos da pagina index, no momento esta fixo para teste, depois substituir pelas variaveis corretas.

        parametro1 = "local";           // status    
        parametro2 = "tiago";           // nome
        parametro3 = "Ranger";          // nome_carro
        parametro4 = "QDF4C98";         // placa
        parametro5 = "manha";           // turno
        parametro6 = "jundiai";         // destino           


        urlDestino = url + '?parametro1=' + encodeURIComponent(parametro1) + '&parametro2=' + encodeURIComponent(parametro2) + '&parametro3=' + encodeURIComponent(parametro3)+ '&parametro4=' + encodeURIComponent(parametro4)+ '&parametro5=' + encodeURIComponent(parametro5)+ '&parametro6=' + encodeURIComponent(parametro6);
    }

    
    window.location.href = urlDestino;
}

function monta_index(){
    $.post("php/processa.php", { act: "index" }, function(result) {
        
        let dados = JSON.parse(result);
        
        console.log(dados);

        // SEJA FELIZ AQUI IVO, SO COLOCAR ESSES DADOS NO INDEX AGORA, TMJ!!!!

    });
}

function mudaTela(){
    window.location.href = 'confirm.html';
}