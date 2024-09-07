<?php
    if (isset($_GET['id'])) { 
        $db = new mysqli("localhost", "root", "", "biblioteca");

        $query = "DELETE FROM livro WHERE id = {$_GET['id']}"; 
        $resultado = $db->query($query);
        header("Location: index.php");
        
    }
?>