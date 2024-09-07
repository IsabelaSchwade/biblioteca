<?php
echo "<link rel='stylesheet' type='text/css' href='style.css'>"; 

$db = new mysqli("localhost", "root", "", "biblioteca"); 

$queryLivros = "SELECT livro.*, autor.nome_autor 
                FROM livro 
                JOIN autor ON livro.autor_livro = autor.id_autor";
$resultadoLivros = $db->query($queryLivros); 


$queryAutores = "SELECT * FROM autor";
$resultadoAutores = $db->query($queryAutores); 

echo "<h1>Biblioteca</h1>";
echo "<h2>Livros</h2>";

echo <<<HTML
<form method="get" action="">
<label for="ordenar_por">Ordenar livro por:</label>
<select name="ordenar_por" id="ordenar_por">
    <option selected disabled value="">Selecione</option>
    <option value="nome_livro">Nome do Livro</option>
    <option value="autor_livro">Autor do livro </option>
    <option value="data_lancamento">Data de lançamento do livro</option>
</select>
<input type="submit" value="Ordenar">
HTML;
?>