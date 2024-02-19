<?php
session_start();
require_once("../models/db_connection.php");
$conn = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o usuário está logado
    if (!isset($_SESSION['nome_usuario'])) {
        echo "Usuário não logado.";
        exit;
    }

    // Verifica se o setor foi enviado pelo formulário
    if (!isset($_POST['setor'])) {
        echo "Setor não selecionado.";
        exit;
    }

    // Obtém o nome do usuário logado na sessão
    $nomeUsuario = $_SESSION['nome_usuario'];

    // Obtém o setor selecionado pelo usuário
    $setor = $_POST['setor']; 
    
    // Recebe as respostas do formulário
    $respostas = array(
        $_POST['resposta1'],
        $_POST['resposta2'],
        $_POST['resposta3'],
        $_POST['resposta4'],
        $_POST['resposta5'],
        $_POST['resposta6'],
        $_POST['resposta7'],
        $_POST['resposta8']
    );

    // Calcula a quantidade de "Sim" e "Não" para cada resposta
    $sim = 0;
    $nao = 0;

    foreach ($respostas as $resposta) {
        if ($resposta === 'Sim') {
            $sim++;
        } elseif ($resposta === 'Não') {
            $nao++;
        }
    }

    // Insere as respostas, o setor e o nome do usuário na tabela respostas
    $sql_respostas = "INSERT INTO respostas (setor, nome_usuario, resps, respn) VALUES ('$setor', '$nomeUsuario', '$sim', '$nao')";

    if ($conn->query($sql_respostas) === TRUE) {
        echo "Respostas salvas no banco de dados com sucesso!";
    } else {
        echo "Erro ao salvar as respostas no banco de dados: " . $conn->error;
    }

    // Insere as respostas individuais juntamente com as perguntas na tabela perguntas_respostas
    $sql_perguntas_respostas = "INSERT INTO perguntas_respostas (setor, nome_usuario, pergunta, resposta) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_perguntas_respostas);

    $perguntas = array(
        "Os computadores do seu setor impedem o uso de dispositivos de mídia via USB?",
        "O acesso aos navegadores possui alguma restrição de acesso a sites?",
        "Os computadores possuem algum sistema de antivírus eficiente? (Não considere sistemas gratuitos como: Avast, Baidu, Avira entre outros).",
        "Os colaboradores do seu setor já receberam treinamentos de conscientização sobre segurança da informação?",
        "A fim de proteger os dados do seu setor, são realizados backups a fim de preservar a operação em caso de qualquer perda de informação?",
        "Caso alguma empresa terceira precise fazer um serviço nas dependências da empresa, é feito o controle interno e acompanhamento deste terceiro?",
        "O seu setor possui um mapeamento claro com a finalidade do processamento dos dados?",
        "O seu setor tem o cuidado de deixar os papéis virados para baixo a fim de não expor as informações do mesmo?"
    );

    for ($i = 0; $i < count($respostas); $i++) {
        $pergunta = $perguntas[$i];
        $resposta = $respostas[$i];

        $stmt->bind_param("ssss", $setor, $nomeUsuario, $pergunta, $resposta);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "O formulário não foi enviado.";
}
?>
