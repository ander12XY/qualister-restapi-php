<?php

session_start();

require 'lib/Slim/Slim.php';
require 'lib/Slim/Middleware/HttpBasicAuth.php';

$app = new Slim();
$app->add(new HttpBasicAuth('qualister', '123'));

$app->get('/', 'home');

function home(){
    include "home.php";
}

$app->get('/login', 'dologin');

function dologin(){
    global $app;

    $usuariologin = $app->request()->get("usuariologin");
    $usuariosenha = $app->request()->get("usuariosenha");

    $token = md5(date("%Y%m%d"));

    if ($usuariologin == "aluno" && $usuariosenha == "qualister"){
        $usuario = array(
            "usuarioid" => 1,
            "usuariologin" => "aluno",
            "usuariosenha" => "qualister",
            "usuarionome" => "Aluno Qualister",
            "datacadastro" => date("Y-m-d"),
            "token" => $token
        );
        $status = "sucesso";
        $mensagem = "sucesso ao fazer login";
    } else {
        $usuario = array();
        $status = "erro";
        $mensagem = "erro ao fazer login";
    }


    $_SESSION['token'] = $token;

    header("Content-Type: application/json");
    echo json_encode(array(
        "status" => $status,
        "mensagem" => $mensagem,
        "dados" => $usuario
    ));
    exit();
}

$app->post('/addproduto', 'addproduto');

function addproduto(){
    global $app;

    $produtonome  = $app->request()->post("produtonome");
    $produtovalor = $app->request()->post("produtovalor");
    $produtoestoque = $app->request()->post("produtoestoque");
    $token = $app->request()->post("token");

    if ($_SESSION['token'] == $token){
        $produto = array(
            "produtoid" => 1,
            "produtonome" => $usuariologin,
            "produtovalor" => $usuariosenha,
            "produtoestoque" => "Aluno Qualister"
        );
        $status = "sucesso";
        $mensagem = "sucesso ao adicionar o produto";
    } else {
        $produto = array();
        $status = "erro";
        $mensagem = "erro, token inválido";
    }

    $_SESSION['produto'] = $produto;

    header("Content-Type: application/json");
    echo json_encode(array(
        "status" => $status,
        "mensagem" => $mensagem,
        "dados" => $produto
    ));
    exit();
}

$app->get('/ultimoproduto', 'ultimoproduto');

function ultimoproduto(){
    $token = $app->request()->get("token");
    
    if ($_SESSION['token'] == $token){
        $produto = $_SESSION['produto'];

        if (count($produto) > 0){
            $status = "sucesso";
            $mensagem = "sucesso ao adicionar o produto";
        } else {
            $status = "erro";
            $mensagem = "nenhum produto cadastrado";
        }
    } else {
        $produto = array();
        $status = "erro";
        $mensagem = "erro, token inválido";
    }

    header("Content-Type: application/json");
    echo json_encode(array(
        "status" => $status,
        "mensagem" => $mensagem,
        "dados" => $produto
    ));
    exit();
}

$app->run();