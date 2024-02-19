<?php
require_once("verificar_login.php"); // Inclui o arquivo de verificação de login
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perguntas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="../css/quest_perg.css">
</head>

<body>
    <nav style="background-color: #007bff; font-family: fantasy;">
        <div class="nav-wrapper">
            <a href="#" class="brand-logo">PERGUNTAS</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="logout.php" style="color: white; font-size:1.5rem;">LOGOUT</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h3>RESPONDA O QUESTIONÁRIO</h3>
        <form id="formPerguntas" method="post" action="../controllers/salvar_respostas.php">
            <?php
            if (isset($_GET['setor'])) {
                $setorSelecionado = urldecode($_GET['setor']);
                $_SESSION['setor'] = $setorSelecionado;
            } else {
                header("Location: quest_setores.php");
                exit;
            }
            ?>
            <input type="hidden" name="setor" value="<?php echo $_SESSION['setor']; ?>">
            <input type="hidden" name="usuario" value="<?php echo $_SESSION['nome_usuario']; ?>">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Os computadores do seu setor impedem o uso de dispositivos de mídia via USB?</td>
                        <td>
                            <p>
                                <label>
                                    <input type="radio" name="resposta1" value="Sim" required />
                                    <span>Sim</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="resposta1" value="Não" />
                                    <span>Não</span>
                                </label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>O acesso aos navegadores possui alguma restrição de acesso a sites?</td>
                        <td>
                            <p>
                                <label>
                                    <input type="radio" name="resposta2" value="Sim" required />
                                    <span>Sim</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="resposta2" value="Não" />
                                    <span>Não</span>
                                </label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Os computadores possuem algum sistema de antivírus eficiente? (Não considere sistemas gratuitos como: Avast, Baidu, Avira entre outros).</td>
                        <td>
                            <p>
                                <label>
                                    <input type="radio" name="resposta3" value="Sim" required />
                                    <span>Sim</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="resposta3" value="Não" />
                                    <span>Não</span>
                                </label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Os colaboradores do seu setor já receberam treinamentos de conscientização sobre segurança da informação?</td>
                        <td>
                            <p>
                                <label>
                                    <input type="radio" name="resposta4" value="Sim" required />
                                    <span>Sim</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="resposta4" value="Não" />
                                    <span>Não</span>
                                </label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>A fim de proteger os dados do seu setor, são realizados backups a fim de preservar a operação em caso de qualquer perda de informação?</td>
                        <td>
                            <p>
                                <label>
                                    <input type="radio" name="resposta5" value="Sim" required />
                                    <span>Sim</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="resposta5" value="Não" />
                                    <span>Não</span>
                                </label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Caso alguma empresa terceira precise fazer um serviço nas dependências da empresa, é feito o controle interno e acompanhamento deste terceiro?</td>
                        <td>
                            <p>
                                <label>
                                    <input type="radio" name="resposta6" value="Sim" required />
                                    <span>Sim</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="resposta6" value="Não" />
                                    <span>Não</span>
                                </label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>O seu setor possui um mapeamento claro com a finalidade do processamento dos dados?</td>
                        <td>
                            <p>
                                <label>
                                    <input type="radio" name="resposta7" value="Sim" required />
                                    <span>Sim</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="resposta7" value="Não" />
                                    <span>Não</span>
                                </label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>O seu setor tem o cuidado de deixar os papéis virados para baixo a fim de não expor as informações do mesmo?</td>
                        <td>
                            <p>
                                <label>
                                    <input type="radio" name="resposta8" value="Sim" required />
                                    <span>Sim</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="resposta8" value="Não" />
                                    <span>Não</span>
                                </label>
                            </p>
                        </td>
                    </tr>

                </tbody>
            </table>

            <button type="button" class="btn waves-effect waves-light" style="margin-top: 20px;" onclick="showModal()">Salvar Respostas</button><br>
        </form>
    </div>

    <!-- estrutura do modal -->
    <div id="thanksModal" class="modal">
        <div class="modal-content">
            <h4>Obrigado!</h4>
            <p>Suas respostas foram salvas com sucesso.</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat" onclick="submitForm()">OK</a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            M.Modal.init(elems);
        });

        function showModal() {
            if ($("#formPerguntas")[0].checkValidity()) {
                var instance = M.Modal.getInstance(document.getElementById('thanksModal'));
                instance.open();
            } else {
                $("#formPerguntas").submit();
            }
        }

        function submitForm() {
            $("#formPerguntas").submit();
        }

        $("#formPerguntas").on("submit", function(event) {
            event.preventDefault();
            $.ajax({
                url: '../controllers/salvar_respostas.php',
                type: 'post',
                data: $("#formPerguntas").serialize(),
                success: function(response) {
                    window.location.href = "logout.php";
                },
                error: function() {
                    alert("Houve um erro ao salvar as respostas. Por favor, tente novamente.");
                }
            });
        });
    </script>
</body>

</html>