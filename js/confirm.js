function data(){

    let dataAtual = new Date();
    let dia = dataAtual.getDate();
    let mes = dataAtual.getMonth() + 1; // Os meses são indexados de 0 a 11, então somamos 1
    let ano = dataAtual.getFullYear();
    
    // Adiciona um zero à esquerda se o dia ou mês for menor que 10
    dia = dia < 10 ? '0' + dia : dia;
    mes = mes < 10 ? '0' + mes : mes;
    
    // Formate a saída como uma string
    let dataAtualFormatada = dia + '/' + mes + '/' + ano;

    document.getElementById("data").value = dataAtualFormatada;

}

function Dados_Agendamento(){

    let data_relatorio = document.getElementById("data").value;
    let nome_colaborador = document.getElementById("nome_colaborador").value;

    let partesData = data_relatorio.split("/");

    // Extraia dia, mês e ano
    let dia = partesData[0];
    let mes = partesData[1];
    let ano = partesData[2];
    
    
    // Formate a string da data como "AAAA-MM-DD"
    let dataFormatada = `${ano}-${mes}-${dia}`;

    $.post("php/processa.php", {act: "dados_agendamento", data_relatorio:dataFormatada,nome_colaborador:nome_colaborador}, function(result)
    {

        if(result != 0){
            openPopup();
        }else{
            alert("Sem dados");
        }
        
    });
}

function openPopup() {
    document.getElementById("overlay").style.display = "flex";
}

function closePopup() {
    document.getElementById("overlay").style.display = "none";
}

function Confirma_Agendamento(){

    let data_relatorio = document.getElementById("data").value;
    let nome_colaborador = document.getElementById("nome_colaborador").value;

    let partesData = data_relatorio.split("/");

    // Extraia dia, mês e ano
    let dia = partesData[0];
    let mes = partesData[1];
    let ano = partesData[2];
    
    
    // Formate a string da data como "AAAA-MM-DD"
    let dataFormatada = `${ano}-${mes}-${dia}`;

    $.post("php/processa.php", {act: "Confirma_Agendamento", data_relatorio:dataFormatada,nome_colaborador:nome_colaborador}, function(result)
    {

        if(result != 0){
            closePopup();
           document.getElementById("data").value = "";
           document.getElementById("nome_colaborador").value = "";
        }else{
            alert("deu ruim");
        }
        
    });

}