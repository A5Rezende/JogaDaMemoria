<?php
session_start();
ob_start();
include_once('../banco/config.php');

if(!isset($_SESSION['username']))
  header("Location: ../login/login.php");
  $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Necessário realizar login.</p>";
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jogo</title>
    <script>
      function preventBack(){window.history.forward()};
      setTimeout("preventBack()",0);
        window.onunload=function(){null;}
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      type="text/css"
      media="screen"
      href="style_ranking.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"
      rel="stylesheet">
    <link rel="stylesheet" href="style_jogo.css">
    <script defer src="jogo.js"></script>
  </head>
  <body>
    <main>
      <div class="menu">
        <div class="div_time">
          <h1 class="time_lbl">TEMPO DA PARTIDA</h1>
          <h1 class="timer">00:00</h1>
          <h2 class="pontos">Jogadas: 0</h2>
        </div>
        <div class="div_buttons">
          <h1 class="lbl_dim_e_modal">Dimensões de Tabuleiro:</h1>
          <button onclick="loadGame(2)">2x2</button><br>
          <button onclick="loadGame(8)">4x4</button><br>
          <button onclick="loadGame(18)">6x6</button><br>
          <button onclick="loadGame(32)">8x8</button>
          <h1 class="lbl_dim_e_modal">Modalidade Partida:</h1>
          <input type="radio" name="modo" value="Classico" checked="checked">
          Clássico <br>
          <input type="radio" name="modo" value="CaontraOTempo"> Contra Tempo
          <br>
          <button class="trapaca_btn" onclick="modoTrapaca()">
            Ativar Modo Trapaça</button><br>
          <form style="display: inline" action="../historico/historico.php" method="get">
            <button class="trapaca_and_histoty_btn">
              Histórico de Partidas
            </button>
          </form>
        </div>
        <div class="bottom_menu_div">
          <form style="display: inline" action="../ranking/ranking.php" method="get">
            <button class="bottom_btn">
              <img src="images/ranking.png" alt="">
            </button>
          </form>
          <form style="display: inline" action="../atualiza_cadastro/atualizar_cad.php" method="get">
            <button class="bottom_btn">
              <img src="images/settings.png" alt="">
            </button>
          </form>
          <form style="display: inline" action="sair.php" method="get">
            <button class="bottom_btn">
              <img src="images/logout.png" alt="">
            </button>
          </form>
        </div>
      </div>
      <div class="grid" id="grid"></div>
      <button class="reload_btn" onclick="reloadGame()">Reiniciar</button><br>
    </main>
  </body>
</html>