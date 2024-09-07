<?php

if (isset($_POST)) {
    
    $db = new mysqli("localhost", "root", "", "biblioteca");
    
    $nome_autor = ($_POST['nome_autor']);

    $query = "INSERT INTO autor (nome_autor) VALUES ('$nome_autor')";

    if ($db->query($query) === TRUE) {
        header("Location: index.php"); 
        exit(); 
    } else {
        echo "Erro ao inserir dados: " . $db->error;
    }

    $db->close();
}
?>
