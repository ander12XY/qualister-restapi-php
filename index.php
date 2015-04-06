<?php

require 'lib/Slim/Slim.php';
require 'lib/Slim/Middleware/HttpBasicAuth.php';
require 'lib/meekrodb.php';

$app = new Slim();
$app->add(new HttpBasicAuth('qualister', '123'));
$db = new MeekroDB("localhost", "root", "root", "api", "3306", "utf8");

$app->get('/', 'home');

function home(){
    include "home.php";
}

$app->get('/login', 'dologin');

function dologin(){
    global $app;
    global $db;

    $usuariologin = $app->request()->get("usuariologin");
    $usuariosenha = $app->request()->get("usuariosenha");
    
    $usuario = $db->queryFirstRow("SELECT usuariodatacadastro, usuarioid, usuariologin FROM usuario WHERE usuariologin = %s AND usuariosenha = %s LIMIT 1", $usuariologin, md5($usuariosenha));

    if ($db->count() > 0){
        $usuario["token"] = md5(date("YmdHis"));

        $datahora = new DateTime(date("Y-m-d H:i:s"));
        $datahora->modify('+20 minutes');

        $db->insert("token", array(
          "usuariologin" => $usuariologin,
          "tokenstring" => $usuario["token"],
          "tokendatalimite" => $datahora->format('Y-m-d H:i:s')
        ));

        $status = "sucesso";
        $mensagem = "sucesso ao fazer login";
    } else {
        $usuario = array();
        $status = "erro";
        $mensagem = "erro ao fazer login";
    }

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
    global $db;

    $produtonome  = $app->request()->post("produtonome");
    $produtovalor = $app->request()->post("produtovalor");
    $produtoestoque = $app->request()->post("produtoestoque");
    $token = $app->request()->post("token");

    $tokenbanco = $db->queryFirstRow("SELECT * FROM token WHERE tokenstring = %s AND tokendatalimite >= %s LIMIT 1", $token, date("Y-m-d H:i:s"));
    
    if ($db->count() == 1){
        $novoproduto = array(
            "produtonome" => $produtonome,
            "produtovalor" => $produtovalor,
            "produtoestoque" => $produtoestoque,
            "usuariologin" => $tokenbanco["usuariologin"]
        );

        $db->insert("produto", $novoproduto);

        $produto = $db->queryFirstRow("SELECT * FROM produto WHERE produtonome = %s AND produtovalor = %s AND produtoestoque = %s AND usuariologin = %s ORDER BY produtoid DESC LIMIT 1", $novoproduto["produtonome"], $novoproduto["produtovalor"], $novoproduto["produtoestoque"], $novoproduto["usuariologin"]);    

        $status = "sucesso";
        $mensagem = "sucesso ao adicionar o produto";
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