<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Adicionar livro</title>
</head>
<body>

<h1>Adicionar Livro</h1>

<?php

$db = new mysqli("localhost", "root", "", "biblioteca");
$query_autores = "SELECT id_autor, nome_autor FROM autor";
$resultado_autores = $db->query($query_autores);
?>

<form action="addLivro.php" method="post" id="container">
    <label>Nome do livro:</label>
    <input type="text" id="nome_livro" required name="nome_livro">

    <label>Data de lançamento:</label>
    <input type="date" id="data_lancamento" required name="data_lancamento">

    <label>Autor:</label>
    <select id="id_autor" required name="id_autor">
        <option value="">Selecione o autor</option>
        <?php
        if ($resultado_autores->num_rows > 0) {
            while ($autor = $resultado_autores->fetch_assoc()) {
                echo "<option value='{$autor['id']}'>{$autor['nome_autor']}</option>";
            }
        } else {
            echo "<option value=''>Nenhum autor cadastrado</option>";
        }
        ?>
    </select>

    <label>Id:</label>
    <input type="number" id="id" required name="id">

    <label for="foto_capa">Foto da capa do livro:</label>
    <input type="file" id="foto_capa" name="foto_capa" accept="image/*">

    <input type="submit" name="botao" value="Adicionar">
</form>

<a>Não encontrou o autor que procurava?</a>
<a href='form_adiconarAutor.php'>Adicionar autor</a>
<a href='index.php'>Voltar para a página inicial</a>

</body>
</html>