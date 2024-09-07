<?php
if (isset($_POST['nome_autor']) && isset($_POST['id_autor'])) {
    // Conexão com o banco de dados
    $db = new mysqli("localhost", "root", "", "biblioteca");

    // Escapar dados para segurança
    $nome_autor = $db->real_escape_string($_POST['nome_autor']);
    $id_autor = intval($_POST['id_autor']);
    
    // Query de atualização
    $query = "UPDATE autor SET nome_autor = '$nome_autor' WHERE id_autor = $id_autor";

    // Executa a consulta e verifica se foi bem-sucedida
    if ($db->query($query) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar o autor: " . $db->error;
    }

    $db->close();
} else {
    echo "Dados incompletos!";
}
?>
