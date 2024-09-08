<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='Style.css'>
    <title>Adicionar Empréstimo</title>
</head>
<body>

<h1>Cadastrar Empréstimo</h1>

<?php
$db = new mysqli("localhost", "root", "", "biblioteca");
$query_livros = "SELECT id, nome_livro FROM livro WHERE status = 'disponivel'";
$resultado_livros = $db->query($query_livros);
?>

<form action="addEmprestimo.php" method="post" id="container">
    <label>Nome da pessoa que emprestou:</label>
    <input type="text" id="nome_pessoa" required name="nome_pessoa">
    <br><br>
    <label>E-mail:</label>
    <input type="email" id="email_pessoa" required name="email_pessoa">
    <br><br>
    <label>Nome do livro:</label>
    <select id="id_livro" required name="id_livro">
        <option value="">Selecione o livro</option>
        <?php
        if ($resultado_livros->num_rows > 0) {
            while ($livro = $resultado_livros->fetch_assoc()) {
                echo "<option value='{$livro['id']}'>{$livro['nome_livro']}</option>";
            }
        } else {
            echo "<option value=''>Nenhum livro cadastrado</option>";
        }
        ?>
    </select>
    <br><br>
    <label>Data do empréstimo:</label>
    <input type="date" id="data_emprestimo" required name="data_emprestimo">
    <br><br>
    <input type="submit" value="Adicionar">
</form>
<br>
<div class='link-container'>; 
<a href='index.php'>Voltar para a página inicial</a>
    </div>
</body>
</html>
