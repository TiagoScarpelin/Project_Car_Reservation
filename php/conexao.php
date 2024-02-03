<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
define('HOST', '127.0.0.1');
define('USUARIO', 'admin');
define('SENHA', 'admin');
define('DB_SISTEMA_CARROS', 'sistema_carros');
ini_set('display_errors', 1); //TIRAR NA VERSAO FINAL
error_reporting(E_ALL); //TIRAR NA VERSAO FINAL

//insert into usuario(usuario, senha) values ('canalti',md5('senhadocanalti'));


function Get_Conn_sistema_carros()
{

    $conn = new mysqli(HOST, USUARIO, SENHA, DB_SISTEMA_CARROS) or die ('N�o foi poss�vel conectar');

    if(!$conn)
    {
        die("Falha na conex�o" . mysqli_connect_error());
    }else
    {
    //
    }
    return $conn;
}


function Get_Conn_NODB()
{

    $conn = new mysqli(HOST, USUARIO, SENHA) or die ('N�o foi poss�vel conectar');
    if(!$conn)
    {
        die("Falha na conex�o" . mysqli_connect_error());
    }
    else
    {
        //
    }
    return $conn;

}



?>