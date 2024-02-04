function reqLog() {
    let nome = document.getElementById("nome").value;
    let placa = document.getElementById("placa").value;

    $.post("php/processa.php", {act: "cadastra_carros",nome_carro: nome,placa_carro: placa}, function(result)
    {

        alert("CARRO CADASTRADOOOOOOOOOOOO");

    });
}