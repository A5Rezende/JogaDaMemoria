<?php
include_once('../banco/config.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cadastre-se</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"
      rel="stylesheet"
    >
    <link rel="stylesheet" href="style_cadastro2.css">
    <script src="main.js"></script>
  </head>
  <body>
    <main>
      <div>
        <h1>Cadastre-se</h1>

        <form action="cadastro.php" method="POST">
          
          <?php
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if (!empty($dados['submit'])) {
              $consulta_username_existente = $conn->query("SELECT * FROM cadastros WHERE USERNAME = '" . $dados['username'] . "' OR NOME = '" . $dados['nome_completo'] . "' LIMIT 1");
              if ($consulta_username_existente->rowCount() > 0) {
                echo '<script> alert("Usuario já cadastrado no banco de dados!") </script>';
              } else {
                $senha_cript = password_hash($dados['senha'], PASSWORD_DEFAULT);
                $query_cadastro = "INSERT INTO cadastros (NOME, DATANASC, CPF, TELEFONE, EMAIL, USERNAME, SENHA) 
                  VALUES ('" . $dados['nome_completo'] . "','" . $dados['dtnasc'] . "', '" . $dados['cpf'] . "', '" . $dados['telefone'] . "', '" . $dados['email'] . "',
                  '" . $dados['username'] . "', '" . $senha_cript . "')";
    
                $cadastro = $conn->prepare($query_cadastro);
    
                $cadastro->execute();
    
                if ($cadastro->rowCount()) {
                  echo '<script> alert("Usuário cadastrado com sucesso!") </script>';
                  header("Location: ../login/login.php");
                } else {
                  echo '<script> alert("Usuário não pôde ser cadastrado") </script>';
                }
              }
            }
          ?>

          <label>Nome Completo</label><br>
          <input type="text" name="nome_completo" id="nome_input" required minlength="5"><br><br>

          <label>Data de Nascimento</label><br>
          <input type="text" name="dtnasc" id="dt_nasc_input" placeholder="AAAAmmDD" required minlength="5"><br><br>

          <label>CPF</label><br>
          <input type="text" name="cpf" id="cpf_input" required minlength="5"><br><br>

          <label>Telefone</label><br>
          <input type="text" name="telefone" id="telefone_input" required minlength="5"><br><br>

          <label>E-mail</label><br>
          <input type="text" name="email" id="email_input" required minlength="5"><br><br>

          <label>Username</label><br>
          <input id="username_input" name="username" type="text" required minlength="5"><br><br>

          <label>Senha</label><br>
          <input id="senha_input" name="senha" type="password" required minlength="5"><br><br><br>
        
          <input class="cad_btn" type="submit" name="submit" id="submit" value="Cadastrar">
        </form>
      </div>
    </main>
  </body>
</html>
