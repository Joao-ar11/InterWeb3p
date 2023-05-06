<?php 
session_start();


// Conecta ao banco de dados
//$servidor = "localhost"; // nome do servidor MySQL
//$usuario_bd = "root"; // nome do usuário do banco de dados
//$senha_bd = "root"; // senha do banco de dados
//$nome_bd = "interbd"; // nome do banco de dados
//$conexao = mysqli_connect($servidor, $usuario_bd, $senha_bd, $nome_bd);

//Banco remoto
$DB_HOST = $_ENV["DB_HOST"];
$DB_USER = $_ENV["DB_USER"];
$DB_PASSWORD = $_ENV["DB_PASSWORD"];
$DB_NAME = $_ENV["DB_NAME"];
$DB_PORT = $_ENV["DB_PORT"];

$conexao = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $DB_PORT);

$mensagem_erro = "";
// Verifica se houve erro na conexão
if (!$conexao) {
    die("Erro de conexão: " . mysqli_connect_error());
}

if (isset($_POST["username"]) && isset($_POST["password"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
}


// Verifica se o usuário já está logado
if (isset($_SESSION["username"])) {
    // Redireciona o usuário para a página protegida
    header("Location: home-dono.php");
}

// Verifica se o formulário de login foi submetido
if (isset($_POST["username"]) && isset($_POST["password"])) {

// Define a consulta SQL para buscar as informações do usuário
$consulta = "SELECT id, senha, funcao FROM cadastro WHERE email = '$username'";


// Executa a consulta SQL
$resultado = $conexao->query($consulta);
// Verifica se a consulta retornou um resultado
while ($senha_crip = $resultado->fetch_assoc()){
    if (password_verify($password, $senha_crip['senha'])) {
    // Define o nome do usuário na sessão
    $_SESSION["id"] = $senha_crip["id"];
    $_SESSION['funcao'] = $senha_crip['funcao'];
        
        if($_SESSION['funcao'] == 'cliente') {
            // Redireciona o usuário para a página protegida
            header("Location: ./pages/home-cliente.php");
        }

        if($_SESSION['funcao'] == 'funcionario') {
            // Redireciona o usuário para a página protegida
            header("Location: ./pages/home-funcionario.php");
        }

        if($_SESSION['funcao'] == 'dono') {
            // Redireciona o usuário para a página protegida
            header("Location: ./pages/home-dono.php");
        }
} else {
    // Exibe uma mensagem de erro
    $mensagem_erro = "Usuário ou senha incorretos";
}
}
}
?>
<?php

if ($_POST){



$curl = curl_init();

 curl_setopt_array($curl,[
    CURLOPT_URL =>"https://www.google.com/recaptcha/api/siteverify",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>[
        'secret' =>'6LcnCmclAAAAAMnyHWtt2Bl1Ucb6iTCbA2hIUPlj',
        'response' => $_POST['g-recaptcha-response'] ?? ''

    ]
    ]);

    $response = curl_exec($curl);
    
    curl_close($curl);

    

    $responseArray = json_decode($response,true);

    $sucesso = $responseArray['success'] ?? false;
    exit;

}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        .erro {
            color: red;
        }
    </style>
    
</head>
<body>
    <section class="fundo-login"> 
        <img  class="logo-login" src="images/logo.png" alt="Logo da empresa">
		<div class="form">
			<h2 class="texto-login">Login</h2>
			<form action="./index.php" method="post" onsubmit="return valida()">
				<input type="email" name="username" placeholder="Usuário" required>
				<input type="password" name="password" placeholder="Senha" required minlength="8" maxlength="16">
                
                <p class='erro'><?php echo $mensagem_erro?></p>
                 
                
				<button type="submit">Entrar</button>
                
            
                <a href="#">Esqueceu sua senha?</a>
                <div class="g-recaptcha" data-sitekey="6LcnCmclAAAAAIfsoESyWb6brsld_grmS2BavXQ6"></div>
                
                
			</form>
            
		</div>
	</section>
    <script type="text/javascript">
        function valida(){
            if(grecaptcha.getResponse() ==''){
                alert('VOCE PRECISA MARCAR A VALIDACAO');
                return false;
            }
        }
       </script>
</body>
</html>