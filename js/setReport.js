function BuscaData(){

    let data_relatorio = document.getElementById("data").value;
    $.post("php/processa.php", {act: "relatorio_mensal",data_relatorio: data_relatorio}, function(result)
    {
       
    });
}