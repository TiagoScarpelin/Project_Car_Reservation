
function monta_tela(){
    // Obter os valores dos parâmetros
    let placa = obterParametroDaURL('parametro2');

    $.post("php/processa.php", { act: "kilometragem", placa_carro: placa }, function(result) {
        // Decodificar o JSON retornado
        let dados = JSON.parse(result);
        console.log(dados);
        document.getElementById("km").value = dados[0][1] + " KM";
        document.getElementById("placa").value = placa;

        let dataAtual = new Date();
        let horas = dataAtual.getHours();
        let minutos = dataAtual.getMinutes();
        let segundos = dataAtual.getSeconds();

        // Formate a saída como uma string
        let horarioAtual = horas + ':' + minutos + ':' + segundos + " h";

        document.getElementById("horario_saida").value = horarioAtual;
        document.getElementById("nome_carro").value = dados[0][0];

    });


}


function obterParametroDaURL(nome) {
    const urlSearchParams = new URLSearchParams(window.location.search);
    return urlSearchParams.get(nome);
}


function reserva(){

    let tipo = obterParametroDaURL('parametro1');
    let nome = document.getElementById("nome").value;
    let destino = document.getElementById("destino").value;
    let placa = document.getElementById("placa").value;
    let horario_saida = document.getElementById("horario_saida").value;
    let km_saida = document.getElementById("km").value;
    let reserva_imediata = document.getElementById("imediataCheckbox");
    let reserva_agendada = document.getElementById("agendamentoCheckbox");
    let turno_manha = document.getElementById("manhaCheckbox");
    let turno_tarde = document.getElementById("tardeCheckbox");
    let turno_integral = document.getElementById("integralCheckbox");
    let nome_carro = document.getElementById("nome_carro").value;
    let data_agendamento = document.getElementById("data_agendamento").value;

    let dataAtual = new Date();
    // Obtenha as informações de ano, mês, dia, hora, minutos e segundos
    let ano = dataAtual.getFullYear();
    let mes = ('0' + (dataAtual.getMonth() + 1)).slice(-2); // Os meses são baseados em zero
    let dia = ('0' + dataAtual.getDate()).slice(-2);

    // Formate a saída no formato desejado
    let formatoDataHora = ano + '-' + mes + '-' + dia + ' ' + horario_saida;

    if(reserva_imediata.checked){

        if(turno_manha.checked){

            $.post("php/processa.php", { act: "imediata", tipo:tipo, nome: nome,nome_carro:nome_carro,placa: placa,horario_saida: formatoDataHora,turno: "manha",destino: destino,km_saida: km_saida }, function(result) {

                if(result == 1){
                    alert("deu bom manha");
                }else if (result == 0){
                    alert("deu ruim manha");
                }

            });

        }else if (turno_tarde.checked){
            $.post("php/processa.php", { act: "imediata", tipo:tipo, nome: nome,nome_carro:nome_carro,placa: placa,horario_saida: formatoDataHora,turno: "tarde",destino: destino,km_saida: km_saida }, function(result) {
                
                if(result == 1){
                    alert("deu bom tarde");
                }else if (result == 0){
                    alert("deu ruim tarde");
                }

        
            });

        }else if(turno_integral.checked){

            $.post("php/processa.php", { act: "imediata", tipo:tipo, nome: nome,nome_carro:nome_carro,placa: placa,horario_saida: formatoDataHora,turno: "integral",destino: destino,km_saida: km_saida }, function(result) {

                if(result == 1){
                    alert("deu bom Integral");
                }else if (result == 0){
                    alert("deu ruim Integral");
                }
        
            });

        }
        console.log("imediata");

    }else if(reserva_agendada.checked){

        if(turno_manha.checked){

            $.post("php/processa.php", { act: "agendado", tipo:tipo, nome: nome,nome_carro:nome_carro,placa: placa,horario_saida: data_agendamento,turno: "manha",destino: destino}, function(result) {

                if(result == 1){
                    alert("deu bom agendado manha");
                }else if (result == 0){
                    alert("deu ruim agendado manha");
                }
        
            });

        }else if (turno_tarde.checked){

            $.post("php/processa.php", { act: "agendado", tipo:tipo, nome: nome,nome_carro:nome_carro,placa: placa,horario_saida: data_agendamento,turno: "tarde",destino: destino}, function(result) {

                if(result == 1){
                    alert("deu bom agendado tarde");
                }else if (result == 0){
                    alert("deu ruim agendado tarde");
                }
        
            });


        }else if(turno_integral.checked){

            $.post("php/processa.php", { act: "agendado", tipo:tipo, nome: nome,nome_carro:nome_carro,placa: placa,horario_saida: data_agendamento,turno: "integral",destino: destino}, function(result) {

                if(result == 1){
                    alert("deu bom agendado integral");
                }else if (result == 0){
                    alert("deu ruim agendado integral");
                }
        
            });

        }
        console.log("agendada");
    }
}

/* Checkbox Escolha */

function desmarcarAgendamento() {
    document.getElementById("agendamentoCheckbox").checked = false;
}

function desmarcarImediata() {
    document.getElementById("imediataCheckbox").checked = false;
}

function desmarcarManhaETarde() {
    document.getElementById("manhaCheckbox").checked = false;
    document.getElementById("tardeCheckbox").checked = false;
}

function desmarcarIntegralETarde() {
    document.getElementById("integralCheckbox").checked = false;
    document.getElementById("tardeCheckbox").checked = false;
}

function desmarcarIntegralEManha() {
    document.getElementById("integralCheckbox").checked = false;
    document.getElementById("manhaCheckbox").checked = false;
}

function dataAgendamento(){

    $.post("php/processa.php", {act: "dataAgendamento"}, function(result) {

        let dados = JSON.parse(result);



    });

}