<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include('conexao.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['act'] == "login") {
        $login = $_POST['login_user'];
        $senha = $_POST['senha_user'];
        Login($login, $senha);
    }

    if($_POST['act'] == "cadastra_carros"){
        $nome_carro = $_POST['nome_carro'];
        $placa = $_POST['placa_carro'];
        Cadastra_carros($nome_carro,$placa);
    }

    if($_POST['act'] == "relatorio_mensal"){

        $data_relatorio = $_POST['data_relatorio'];

        Relatorio_mensal($data_relatorio);

    }

    if($_POST['act'] == "kilometragem"){

        $placa = $_POST['placa_carro'];

        kilometragem($placa);

    }

    if($_POST['act'] == "imediata"){

        $status = $_POST['tipo'];
        $nome = $_POST['nome'];
        $nome_carro = $_POST['nome_carro'];
        $destino = $_POST['destino'];
        $placa = $_POST['placa'];
        $horario_saida = $_POST['horario_saida']; 
        $km_saida = $_POST['km_saida'];
        $turno = $_POST['turno'];

        Imediata($status,$nome,$nome_carro,$destino,$placa,$horario_saida,$km_saida,$turno);

    }

    if($_POST['act'] == "agendado"){

        $status = $_POST['tipo'];
        $nome = $_POST['nome'];
        $nome_carro = $_POST['nome_carro'];
        $destino = $_POST['destino'];
        $placa = $_POST['placa'];
        $horario_saida = $_POST['horario_saida']; 
        $turno = $_POST['turno'];

        Agendado($status,$nome,$nome_carro,$destino,$placa,$horario_saida,$turno);

    }

    if($_POST['act'] == "index"){

        index_reservas();
        index();
    }

    if($_POST['act'] == "devolver_carro"){

        $status = $_POST['tipo'];
        $nome = $_POST['nome'];
        $nome_carro = $_POST['nome_carro'];
        $placa = $_POST['placa'];
        $data = $_POST['data'];
        $km = $_POST['km'];
        $turno = $_POST['turno'];
        $destino = $_POST['destino'];
        

        devolver_carro($status,$nome,$nome_carro,$placa,$data,$km,$turno,$destino);
    }

    if($_POST['act'] == "dados_agendamento"){

        $data = $_POST['data_relatorio'];
        $nome_colaborador = $_POST['nome_colaborador'];

        dados_agendamento($data,$nome_colaborador);

    }

    if($_POST['act'] == "Confirma_Agendamento"){

        $data = $_POST['data_relatorio'];
        $nome_colaborador = $_POST['nome_colaborador'];

        Confirma_Agendamento($data,$nome_colaborador);

    }

    if($_POST['act'] == "dataAgendamento"){

        
        dataAgendamento();

    }

}

function dataAgendamento(){

    $conn = Get_Conn_sistema_carros();

    $sql = "SELECT data_reserva FROM reservas";
    $Retorno_consulta = array();
    $result = mysqli_query($conn,$sql); 

    while($row = mysqli_fetch_array($result,MYSQLI_NUM))
    {
        $Retorno_consulta[] = $row;
    }

    $retorno = json_encode($Retorno_consulta);
    mysqli_close($conn);
    echo $retorno;

}

function Confirma_Agendamento($data,$nome_colaborador){

    $conn = Get_Conn_sistema_carros();
    $condicao = 'retirado';

    $sql = "call agendamento('$data','$nome_colaborador','$condicao')";

    if($conn->query($sql) === TRUE){
        $conn->close();
        echo 1;
    }else{
        $conn->close();
        echo 0;
    }
}

function dados_agendamento($data,$nome_colaborador){

    $conn = Get_Conn_sistema_carros();

    $sql = "SELECT status,nome,nome_carro,placa,data_reserva,turno,destino FROM reservas WHERE nome = '$nome_colaborador' AND data_reserva = '$data'";
    $Retorno_consulta = array();
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result,MYSQLI_NUM))
    {
        $Retorno_consulta[] = $row;
    }

    mysqli_close($conn);

    if(empty($Retorno_consulta)){
        echo 0;
    }else{
        $retorno = json_encode($Retorno_consulta);
        echo $retorno;
    }

    
   

}

function index_reservas(){

    $conn = Get_Conn_sistema_carros();
    $sql = "CALL AtualizarSituacaoCarros()";

    if($conn->query($sql) === TRUE){

        $conn->close();
        return;
    
    }else{
        $conn->close();
        echo 0;
        
    }
    
}

function Delete_Reserva($conn,$placa){
    
    $sql = "DELETE FROM reservas WHERE placa = '$placa'";

    if($conn->query($sql) === TRUE){
        $conn->close();
    }else{
        $conn->close();
        exit(0);
        
    }

}

function Delete_Registro($conn,$placa){

    $sql = "DELETE FROM registros WHERE placa = '$placa'";

    if($conn->query($sql) === TRUE){
        $conn->close();
    }else{
        $conn->close();
        exit(0);
    }

}

function Delete_Registro_Reserva($conn,$placa){

    $sql = "SELECT placa FROM registros WHERE placa = '$placa'";     

    $result = mysqli_query($conn,$sql);
    $Retorno_consulta = array();

    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
        $Retorno_consulta = $row; 
    }

    if (empty($Retorno_consulta)) {
        
        Delete_Reserva($conn,$placa);

    }else{

        Delete_Registro($conn,$placa);

    }

}


function devolver_carro($status,$nome,$nome_carro,$placa,$data,$km,$turno,$destino){
    
    
    /*
    $conn = Get_Conn_sistema_carros();
    $sql = "UPDATE carros SET situacao = 'livre', kilometragem = '$km' WHERE placa = '$placa'";
    $condicao = 'devolvido';

    if ($conn->query($sql) === TRUE) {
        Delete_Registro($conn, $placa);
        Insert_Relatorio($condicao, $status, $nome, $nome_carro, $destino, $placa, $data, $km, $turno);
    } else {
        $conn->close();
        echo 0;
    }
    */

    // DEVOLVER CARROS (IMEDIATA)

    $conn = Get_Conn_sistema_carros();
    $condicao = 'devolvido';
    
    $sql = "SELECT kilometragem FROM carros WHERE placa = '$placa'";
    $Retorno_consulta;
    
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        
        $conn->close();
        echo 0;
        exit;
    }
    
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
        $Retorno_consulta = $row[0]; 
    }
     
    
    if ($Retorno_consulta !== null && $Retorno_consulta < $km) {
        $sql = "UPDATE carros SET situacao = 'livre', kilometragem = '$km' WHERE placa = '$placa'";
    
        if($conn->query($sql) === TRUE) {
            Delete_Registro_Reserva($conn, $placa);
            Insert_Relatorio($condicao, $status, $nome, $nome_carro, $destino, $placa, $data, $km, $turno);
        } else {
            $conn->close();
            echo 0;
        }
    } else {
        $conn->close();
        echo 2;
    }
    
}

function compararLinhas($linha1, $linha2) {
    return $linha1 == $linha2;
}


function index(){

    $conn = Get_Conn_sistema_carros();

    $sql = "SELECT c.situacao, c.nome, c.placa, r.data_saida, r.turno, r.destino FROM carros c LEFT JOIN registros r ON c.placa = r.placa";
    $Retorno_consulta = array();
    $result = mysqli_query($conn,$sql); 

    while($row = mysqli_fetch_array($result,MYSQLI_NUM))
    {
        $Retorno_consulta[] = $row;
    }

    $sql2 = "SELECT c.situacao,c.nome,c.placa, re.data_reserva, re.turno, re.destino FROM carros c LEFT JOIN reservas re ON c.placa = re.placa";
    $result2 = mysqli_query($conn,$sql2); 

    while($row2 = mysqli_fetch_array($result2,MYSQLI_NUM))
    {
        $Retorno_consulta[] = $row2;
    }

    
    $gruposPlaca = array();

    foreach ($Retorno_consulta as $linha) {
        $placa = $linha[2]; // Índice 2 corresponde à coluna da placa

        if (!isset($gruposPlaca[$placa])) {
            $gruposPlaca[$placa] = array();
        }

        $gruposPlaca[$placa][] = $linha;
    }

    // Seleciona a linha que não possui null após a coluna da placa para cada grupo
    $submatrizSemDuplicatas = array();

    foreach ($gruposPlaca as $grupo) {
        $linhaEscolhida = null;

        foreach ($grupo as $linha) {
            if ($linha[3] !== null) { // Verifica se a coluna após a placa não é null
                $linhaEscolhida = $linha;
                break;
            }
        }

        // Se não houver linha sem null, escolhe a primeira linha do grupo
        if ($linhaEscolhida === null && !empty($grupo)) {
            $linhaEscolhida = $grupo[0];
        }

        $submatrizSemDuplicatas[] = $linhaEscolhida;
    }

    $retorno = json_encode($submatrizSemDuplicatas);

    echo $retorno;

}


function Agendado($status,$nome,$nome_carro,$destino,$placa,$horario_saida,$turno){

    $conn = Get_Conn_sistema_carros();

    $sql = "INSERT INTO reservas (status,nome,nome_carro,placa,data_reserva,turno,destino) VALUES ('$status','$nome','$nome_carro','$placa','$horario_saida','$turno','$destino')";

    if($conn->query($sql) === TRUE){
        $conn->close();
        echo 1;
    }else{
        $conn->close();
        echo 0;
    }
}

function Imediata($status,$nome,$nome_carro,$destino,$placa,$horario_saida,$km_saida,$turno){

    $conn = Get_Conn_sistema_carros();
    $condicao = 'retirado';

    $sql = "INSERT INTO registros (status,nome,nome_carro,placa,data_saida,turno,destino) VALUES ('$status','$nome','$nome_carro','$placa','$horario_saida','$turno','$destino')";

    if($conn->query($sql) === TRUE){
        Insert_Relatorio($condicao,$status,$nome,$nome_carro,$destino,$placa,$horario_saida,$km_saida,$turno);
    }else{
        $conn->close();
        echo 0;
    }
}

function Insert_Relatorio($condicao,$status,$nome,$nome_carro,$destino,$placa,$horario_saida,$km_saida,$turno){

    $conn = Get_Conn_sistema_carros();

    $sql = "INSERT INTO relatorio (condicao,status,nome,nome_carro,placa,data,kilometragem,turno,destino) VALUES ('$condicao','$status','$nome','$nome_carro','$placa','$horario_saida','$km_saida','$turno','$destino')";

    if($conn->query($sql) === TRUE){
        $conn->close();
        echo 1;
    }else{
        $conn->close();
        echo 0;
    }

}

function kilometragem($placa){

    $conn = Get_Conn_sistema_carros();

    $sql = "SELECT nome,kilometragem FROM carros WHERE placa = '$placa'";
    $Retorno_consulta = array();
    $result = mysqli_query($conn,$sql); 

    while($row = mysqli_fetch_array($result,MYSQLI_NUM))
    {
        $Retorno_consulta[] = $row;
    }

    $retorno = json_encode($Retorno_consulta);
    mysqli_close($conn);
    echo $retorno;
}

function Login($login,$senha){

    $connection = Get_Conn_sistema_carros();
    
    // Consulta no banco de dados para verificar as credenciais
    $query = "SELECT nome,senha FROM login WHERE nome = '$login' AND senha = '$senha'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);

    
    // Verifica se a consulta foi bem-sucedida
    if ($result) {
        // Verifica se as credenciais são válidas
        if (mysqli_num_rows($result) > 0) {
            http_response_code(200); // Autenticação bem-sucedida
    
        } else {
            http_response_code(401); // Credenciais inválidas
        }
    } else {
        http_response_code(500); // Erro na consulta
    }
    
    
    // Fecha a conexão com o banco de dados
    mysqli_close($connection);

}


function Cadastra_carros($nome_carro,$placa){


    $conn = Get_Conn_sistema_carros();

    $sql = "INSERT INTO carros (placa,nome) VALUES ('$placa','$nome_carro')";

    if($conn->query($sql) === TRUE){
        $conn->close();
        echo 1;
    }else{
        $conn->close();
        echo 0;
    }
}

function Relatorio_mensal($data_relatorio){

    $conn = Get_Conn_sistema_carros();

    $datetimemes = new DateTime($data_relatorio);
    $mes = $datetimemes->format("m");

    $datetimeano = new DateTime($data_relatorio);
    $ano = $datetimeano->format('Y');

    $sql = "SELECT condicao,status, nome, nome_carro, placa, data,kilometragem,turno,destino FROM relatorio WHERE MONTH(data) = $mes AND YEAR(data) = $ano";
    $Retorno_consulta = array();
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result,MYSQLI_NUM))
    {
        $Retorno_consulta[] = $row;
    }

    $retorno = json_encode($Retorno_consulta);
    mysqli_close($conn);

    echo $retorno;

}



?>