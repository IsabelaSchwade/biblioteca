<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Adicionar livro</title>
</head>
<body>

<h1>Cadastrar empréstimo </h1>

<?php
$db = new mysqli("localhost", "root", "", "biblioteca");
$query_livros = "SELECT nome_livro FROM livro";
$resultado_livros = $db->query($query_livros);
?>

<form action="addLivro.php" method="post" enctype="multipart/form-data" id="container">
    <label>Nome da pessoa que emprestou:</label>
    <input type="text" id="nome_pessoa" required name="nome_pessoa">
    <br>
    <br>
    <label>E-mail::</label>
    <input type="email" id="email_pessoa" required name="email_pessoa">
    <br>
    <br>
    <label>Nome do livro:</label>
    <select id="id_autor" required name="id_autor">
        <option value="">Selecione o livro</option>
        <?php
        if ($resultado_livros->num_rows > 0) {
            while ($livro = $resultado_livros->fetch_assoc()) {
                echo "<option value='{$livro['nome_livro']}'>{$livro['id_livro']}</option>";
            }
        } else {
            echo "<option value=>Nenhum livro cadastrado</option>";
        }
       
        ?>
        
    </select>
    <br>
        <br>
    <label>Data do empréstimo: </label>
    <input type="date" id="data_emprestimo" required name="data_emprestimo">

   

    <input type="submit" name="botao" value="Adicionar">
    </form>
    <br>
    
    <a href='index.php'>Voltar para a página inicial</a>

    </body>
    </html>
