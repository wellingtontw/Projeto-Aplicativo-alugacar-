<?php
session_start();

if (isset($_POST['submit'])) {

    $CPF = isset($_POST['CPF']) ? trim($_POST['CPF']) : '';
    $Senha = isset($_POST['Senha']) ? trim($_POST['Senha']) : '';

    if (!empty($CPF) && !empty($Senha)) {

        include_once('config.php');

        $sql = "SELECT * FROM cliente WHERE cpf = ? AND senha = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $CPF, $Senha);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows < 1) {
            unset($_SESSION['CPF']);
            unset($_SESSION['Senha']);
            header('Location: PaginaUsuario.php');
            exit;
        } else {
            $usuario = $result->fetch_assoc();

            $_SESSION['idcliente'] = $usuario['idcliente'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['CPF'] = $usuario['cpf'];
            $_SESSION['Senha'] = $usuario['senha'];

            header('Location: PaginaUsuario.php');
            exit;
        }

    } else {
        header('Location: PaginaUsuario.php');
        exit;
    }

} else {
    header('Location: PaginaUsuario.php');
    exit;
}
?>