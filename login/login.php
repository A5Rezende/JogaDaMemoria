<?php
session_start();
ob_start();
include_once('../banco/config.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Memory Cards - The Game</title>
    <script>
      function preventBack(){window.history.forward()};
      setTimeout("preventBack()",0);
        window.onunload=function(){null;}
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style_login.css">
    <script src="main.js"></script>
  </head>
  <body>
    <main>
      <div>
        <h1>Memory Cards - The Game</h1>
        <br><br>
        <!--<form style="display: inline" action="http://127.0.0.1:5500/cadastro/cadastro.html" method="get"><button class="cad_btn">Cadastre-se</button></form><br><br>-->
        <a href="../cadastro/cadastro.php" id="retrieve">Cadastre-se</a> <br> <br>

        <h2><span>or</span></h2><br>

        <?php
          $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
          //var_dump($dados); para testar recebimento dos inputs
          if(!empty($dados['submit'])){
            var_dump($dados);
            $query_usuario = "SELECT username, senha FROM cadastros WHERE username =:username LIMIT 1";
            $result_usuario = $conn->prepare($query_usuario);
            $result_usuario->bindParam(':username', $dados['username']);
            $result_usuario->execute();
            
            if(($result_usuario) AND ($result_usuario->rowCount() !=0)){
              $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
              var_dump($row_usuario);
              if(password_verify($dados['senha'], $row_usuario['senha'])){
                //$_SESSION['id'] = $row_usuario['id'];
                $_SESSION['username'] = $row_usuario['username'];
                header("Location: ../jogo/jogo.php");
              }else{
                $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Usuário ou senha inválida!</p>";
              }
            }else{
              $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Usuário ou senha inválida!</p>";
            }
          }

          if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
          }

        ?>

        <form action="" method="POST">
          <label>Usuário*</label><br>
          <input name="username" type="text" required minlength="5"> <br> <br>
          <label>Senha*</label><br>
          <input name="senha" type="password" required minlength="5"> <br> <br> <br>
          <!--<form style="display: inline" action="../jogo/jogo.html" method="get"><button class="login_btn">Login</button></form>-->
          <input class="login_btn" type="submit" name="submit" id="submit" value="Login">
        </form>
      </div>
    </main>
  </body>
</html>