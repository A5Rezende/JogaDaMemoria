<?php
include_once('../banco/config.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ranking Global</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" media="screen" href="style_ranking.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style_login.css">
  <script src="main.js"></script>
</head>

<body>
  <main>
    <div class="container">
      <h1>Ranking Global</h1>
      <br><br>
      <table class="table table-bordered border-primary">
        <thead>
          <tr>
            <th scope="col">USUÁRIO </th>
            <th scope="col">DIMENSÃO </th>
            <th scope="col">MODALIDADE</th>
            <th scope="col">JOGADAS</th>
            <th scope="col">DATA</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $listagem = $conn->prepare("SELECT C.USERNAME, H.DIMENSAO, H.MODALIDADE, H.JOGADAS, H.DATA 
                                          FROM HISTORICO H
                                            INNER JOIN CADASTROS C ON C.ID = H.USUARIO 
                                          WHERE H.RESULTADO = 'Vitória'
                                          ORDER BY H.JOGADAS, H.DIMENSAO
                                          LIMIT 10");
              $listagem->execute();
              while ($lista = $listagem->fetch(PDO::FETCH_ASSOC))
              {
                echo "<tr>";
                echo "<td>" . $lista['USERNAME'] . "</td>";
                echo "<td>" . $lista['DIMENSAO'] . "</td>";
                echo "<td>" . $lista['MODALIDADE'] . "</td>";
                echo "<td>" . $lista['JOGADAS'] . "</td>";
                echo "<td>" . $lista['DATA'] . "</td>";
                echo "</tr>";
              }
            ?>
            </tbody>
      </table>
      <br><br>
      <form style="display: inline" action="../jogo/jogo.html" method="get"><button class="voltar_btn">Voltar</button>
      </form>
    </div>
  </main>
</body>

</html>