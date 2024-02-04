function BuscaData(){

    let data_relatorio = document.getElementById("data").value;
    let placa_carro = document.getElementById("carro").value;


    if(data_relatorio == null){

        alert("Escolha uma data!");
        
    }else{

        $.post("php/processa.php", {act: "relatorio_mensal",data_relatorio: data_relatorio,placa_carro:placa_carro}, function(result)
        {
       
        });

    }

    
}