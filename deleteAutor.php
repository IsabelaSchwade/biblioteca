<?php
    if (isset($_GET['id_autor'])) { 
        
        $db = new mysqli("localhost", "root", "", "biblioteca");

    
        $query = "DELETE FROM autor WHERE id_autor = {$_GET['id_autor']}"; 

        $resultado = $db->query($query);

        header("Location: index.php");
        exit(); 
    }
?>
