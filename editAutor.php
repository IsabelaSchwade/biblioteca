<?php
if (isset($_POST)) {
    
    $db = new mysqli("localhost", "root", "", "biblioteca");

    
    $nome_autor = ($_POST['nome_autor']);
    $id_autor = ($_POST['id_autor']);
     
    
    $query = "UPDATE autor SET nome_autor = '$nome_autor' WHERE id_autor = $id_autor";

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
