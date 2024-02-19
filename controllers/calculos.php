<?php
require_once("../models/db_connection.php");
$conn = conectar();

// Função para calcular ISE
function calcularISE($respostasCount) {
    return $respostasCount / 8;
}

// Função para calcular VCS
function calcularVCS($gin, $gci) {
    $vcsGin = $gin / 3;
    $vcsGci = $gci / 3;
    return $vcsGin * $vcsGci;
}

// Função para calcular IFNC
function calcularIFNC($vcs, $ipnc) {
    return $vcs * $ipnc;
}

// Consultar setores no banco de dados
$sql = "SELECT * FROM setores";
$result = $conn->query($sql);

// Array para armazenar os resultados dos cálculos por setor
$calculosResultados = array();
$totalISE = 0; // Variável para armazenar a soma de todos os ISE
$totalIFNC = 0; // Variável para armazenar a soma de todos os IFNC

// Realizar cálculos para cada setor e armazenar os resultados
while ($row = $result->fetch_assoc()) {
    $setorNome = $row["nome"];
    
    // Buscar a quantidade de respostas para este setor na tabela "respostas"
    $sql_respostas = "SELECT SUM(resps) AS resps_count, SUM(respn) AS respn_count FROM respostas WHERE setor = '" . $setorNome . "'";
    $result_respostas = $conn->query($sql_respostas);
    $respostasData = $result_respostas->fetch_assoc();

    $gin = $row["GIN"];
    $gci = $row["GCI"];
    $respsCount = intval($respostasData["resps_count"]);
    $respnCount = intval($respostasData["respn_count"]);

    $ise = calcularISE($respsCount);
    $vcs = calcularVCS($gin, $gci);
    $ipnc = $respnCount / 8;
    $ifnc = calcularIFNC($vcs, $ipnc);

    // Armazenar os resultados no array
    $calculosResultados[$setorNome] = array(
        'ise' => $ise,
        'ifnc' => $ifnc
    );

    // Adicionar o ISE e o IFNC ao total
    $totalISE += $ise;
    $totalIFNC += $ifnc;
}

// Calcular a média geral de ISE e IFNC
$mediaISE = count($calculosResultados) > 0 ? $totalISE / count($calculosResultados) : 0;
$mediaIFNC = count($calculosResultados) > 0 ? $totalIFNC / count($calculosResultados) : 0;

$conn->close();
