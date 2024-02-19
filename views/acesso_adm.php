<?php
require_once("../controllers/calculos.php");
require_once("verificar_login.php"); // Inclui o arquivo de verificação de login
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Acesso ADM</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/acesso_adm.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> <!-- Materialize CSS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!-- Adiciona o script do Google Charts-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    <div class="background"></div>
    <nav style="background-color: #007bff; font-family: fantasy;">
        <div class="nav-wrapper">
            <a href="#" data-target="menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="logout.php" style="color: white; font-size:1.5rem;">LOGOUT</a></li>
            </ul>
        </div>
    </nav>
    <div id="menu" class="sidenav sidenav-fixed">
        <ul>
            <li><a href="acesso_adm.php">INÍCIO</a></li>
            <li><a href="setores.php">SETORES</a></li>
            <li><a href="respostas.php">RESPOSTAS</a></li>
        </ul>
    </div>
    <div id="conteudo" style="margin-top: 40px; margin-left: 250px; padding: 20px;">
        <div id="calculosResultados">
            <?php
            $cor_faixa = '';
            $etiqueta = '';
            if ($mediaIFNC > 0.8) {
                $cor_faixa = 'red';
                $etiqueta = 'Muito Alto';
            } elseif ($mediaIFNC >= 0.6) {
                $cor_faixa = 'orange';
                $etiqueta = 'Alto';
            } elseif ($mediaIFNC >= 0.4) {
                $cor_faixa = 'yellow';
                $etiqueta = 'Moderado';
            } elseif ($mediaIFNC >= 0.2) {
                $cor_faixa = 'lightgreen';
                $etiqueta = 'Baixo';
            } else {
                $cor_faixa = 'darkgreen';
                $etiqueta = 'Muito Baixo';
            }
            ?>
            <div id="faixa_colorida" style="background-color: <?php echo $cor_faixa; ?>; margin-top: 60px; height: 52px;">
                <?php echo $etiqueta; ?>
            </div>

            <div style="margin-top: 10px;">
                <label>
                    <input type="checkbox" id="porEmpresaCheckbox" />
                    <span>Por Empresa</span>
                </label>
                <label style="margin-left: 20px;">
                    <input type="checkbox" id="todosSetoresCheckbox" />
                    <span>Todos os Setores</span>
                </label>
            </div>

            <div id="porEmpresaContent" style="display: none;">
                <h2>ÍNDICE EMPRESA</h2>
                <div class="card">
                    <p>ISE Médio: <?php echo number_format($mediaISE, 1); ?></p>
                    <p>IFNC Médio: <?php echo number_format($mediaIFNC, 1); ?></p>
                </div>
            </div>

            <div id="todosSetoresContent" style="display: none;">
                <h2>RESULTADOS</h2>
                <?php
                foreach ($calculosResultados as $setorNome => $resultados) {
                    $ise = number_format($resultados['ise'], 1);
                    $ifnc = number_format($resultados['ifnc'], 1);
                ?>
                    <div class="card">
                        <p>Setor: <?php echo $setorNome; ?></p>
                        <p>ISE: <?php echo $ise; ?></p>
                        <p>IFNC: <?php echo $ifnc; ?></p>
                    </div>
                <?php
                }
                ?>
                <h2>INDÍCE FINAL DE NÃO CONFORMIDADE POR SETOR</h2>
                
                <!-- Modal Trigger -->
                <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Legenda</a>
                <!-- Modal Structure -->
                <div id="modal1" class="modal">
                    <div class="modal-content">
                    
                    <h1> Classificação </h1>
                        <ol>
                            <ul>
                           <li> Índice de Segurança da Empresa (ISE) </li>
                           <li>  Índice Final de NÃO Conformidade (IFNC)</li>
                           <br>
                           <li>   - De 0 até 0,2 = Muito Baixo</li>
                           <li> - Acima de 0,2 até 0,4 = Baixo</li>
                           <li> - Acima de 0,4 até 0,6 = Moderado</li>
                           <li>  - Acima de 0,6 até 0,8 = Alto</li>
                           <li>  - Acima de 0,8 = Muito Alto</li>
                            </ul>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok</a>
                    </div>
                </div>
                <canvas id="ifncChart" width="200" height="45"></canvas>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var porEmpresaCheckbox = document.getElementById('porEmpresaCheckbox');
                        var todosSetoresCheckbox = document.getElementById('todosSetoresCheckbox');
                        var porEmpresaContent = document.getElementById('porEmpresaContent');
                        var todosSetoresContent = document.getElementById('todosSetoresContent');

                        porEmpresaCheckbox.addEventListener('change', function() {
                            if (porEmpresaCheckbox.checked) {
                                porEmpresaContent.style.display = 'block';
                                todosSetoresContent.style.display = 'none';
                                todosSetoresCheckbox.checked = false;
                            } else {
                                porEmpresaContent.style.display = 'none';
                            }
                        });

                        todosSetoresCheckbox.addEventListener('change', function() {
                            if (todosSetoresCheckbox.checked) {
                                todosSetoresContent.style.display = 'block';
                                porEmpresaContent.style.display = 'none';
                                porEmpresaCheckbox.checked = false;
                            } else {
                                todosSetoresContent.style.display = 'none';
                            }
                        });
                    });
                </script>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var elems = document.querySelectorAll('.modal');
                        var instances = M.Modal.init(elems);
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var elems = document.querySelectorAll('.sidenav');
                        var instances = M.Sidenav.init(elems);
                    });
                </script>
                <script>
                    // Inicializar o menu lateral
                    document.addEventListener('DOMContentLoaded', function() {
                        var elems = document.querySelectorAll('.sidenav');
                        var instances = M.Sidenav.init(elems);
                    });
                </script>

                <script>
                    var ctx = document.getElementById('ifncChart').getContext('2d');

                    var setorNomes = [
                        <?php
                        foreach ($calculosResultados as $setorNome => $resultados) {
                            echo "'" . $setorNome . "', ";
                        }
                        ?>
                    ];

                    var ifncValores = [
                        <?php
                        foreach ($calculosResultados as $setorNome => $resultados) {
                            $ifnc = number_format($resultados['ifnc'], 1); // Formata com 1 casa decimal
                            echo $ifnc . ', ';
                        }
                        ?>
                    ];

                    var iseValores = [
                        <?php
                        foreach ($calculosResultados as $setorNome => $resultados) {
                            $ise = number_format($resultados['ise'], 1); // Formata com 1 casa decimal
                            echo $ise . ', ';
                        }
                        ?>
                    ];

                    var ifncChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: setorNomes,
                            datasets: [{
                                    label: 'IFNC',
                                    data: ifncValores,
                                    backgroundColor: 'rgba(75, 192, 192, 0.6)', // Cor das barras para IFNC
                                    borderWidth: 1
                                },
                                {
                                    label: 'ISE',
                                    data: iseValores,
                                    backgroundColor: 'rgba(255, 99, 132, 0.6)', // Cor das barras para ISE
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    min: 0, // Valor mínimo do eixo vertical
                                    max: 1 // Valor máximo do eixo vertical
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
</body>

</html>