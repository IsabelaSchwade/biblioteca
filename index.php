<?php
echo "<link rel='stylesheet' type='text/css' href='style.css'>"; 

$db = new mysqli("localhost", "root", "", "biblioteca"); 

$queryLivros = "SELECT livro.*, autor.nome_autor 
                FROM livro 
                JOIN autor ON livro.autor_livro = autor.id_autor";
$resultadoLivros = $db->query($queryLivros); 


$queryAutores = "SELECT * FROM autor";
$resultadoAutores = $db->query($queryAutores); 


echo "<h1>Biblioteca</h1>"; // título da página
echo "<br>";
echo "<h2>Livros</h2>";

?>