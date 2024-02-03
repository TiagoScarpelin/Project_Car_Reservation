function obterParametroDaURL(nome) {
    const urlSearchParams = new URLSearchParams(window.location.search);
    return urlSearchParams.get(nome);
}

function horario(){

    let dataAtual = new Date();
    let horas = dataAtual.getHours();
    let minutos = dataAtual.getMinutes();
    let segundos = dataAtual.getSeconds();

    // Formate a saída como uma string
    let horarioAtual = horas + ':' + minutos + ':' + segundos + " h";

    document.getElementById("hora_devolucao").value = horarioAtual;

}


function Devolver_carro(){


    let status = obterParametroDaURL('parametro1');
    let nome = obterParametroDaURL('parametro2');
    let nome_carro = obterParametroDaURL('parametro3');
    let placa = obterParametroDaURL('parametro4');
    let horario = document.getElementById("hora_devolucao").value;
    let km = document.getElementById("devolucao").value;
    let turno = obterParametroDaURL('parametro5');
    let destino = obterParametroDaURL('parametro6');

    let dataAtual = new Date();
    let ano = dataAtual.getFullYear();
    let mes = ('0' + (dataAtual.getMonth() + 1)).slice(-2); 
    let dia = ('0' + dataAtual.getDate()).slice(-2);

    let formatoDataHora = ano + '-' + mes + '-' + dia + ' ' + horario;

    let data = formatoDataHora;
    
    

    $.post("php/processa.php", { act: "devolver_carro", tipo:status, nome: nome,nome_carro:nome_carro,placa: placa,data: data,km:km,turno: turno,destino: destino}, function(result) {
        
        if(result == 1){
            alert("deu bom devolver_carro");
        }else if(result == 0){
            alert("deu ruim devolver_carro");
        }else if(result == 2){
            alert("Kilometragem menor do que o ultimo");
            document.getElementById("devolucao").value = "";
        }
        

    });

}




