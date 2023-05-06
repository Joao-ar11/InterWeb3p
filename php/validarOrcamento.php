<?php
    include './conn.php';
    session_start();
    $id_cliente = $conn->query('SELECT id_cliente FROM orcamento_id WHERE id =' . $_GET["id"] . ';');
    if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] !== 'cliente' || $_SESSION['id'] !== $id_cliente) {
        header('LOCATION: ../index.php');
    }
    if (isset($_GET['id']) && isset($_GET['validacao'])) {
        $validacao = "em validacao";
        if($_GET['validacao'] === 'confirmado') {
            $validacao = "confirmado";
        } elseif ($_GET['validacao'] === 'negado') {
            $validacao = 'negado';
        }
        $conn->query('UPDATE orcamento_id SET validacao = "' . $validacao . '" WHERE id =' . $_GET["id"] . ';');
    }
    header('LOCATION: ../pages/validarOrcamento-cliente.php');
?>