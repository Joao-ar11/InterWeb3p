<?php 
    session_start();
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'dono') {
        header('LOCATION: ../index.php');
    }
    include('../php/conn.php');
    if (isset($_POST["taxaAdm"]) && isset($_POST["lucro"]) && isset($_POST["seguro-civil"]) && isset($_POST["imposto"]) && isset($_POST["seguro-garantia"])) {
        $query = 'INSERT INTO tarifa (taxa_administrativa, seguro_respon_civil, seguro_garantia, lucro, imposto) VALUES ("' . $_POST['taxaAdm'] . '", "' . $_POST['seguro-civil'] . '", "' . $_POST['seguro-garantia'] . '", "' . $_POST['lucro'] . '", "' . $_POST['imposto'] . '")';
        $conn->query($query);
        $_SESSION['confirmar'] = 'confirmado';
    }
    header('../pages/tarifas.php');
?>