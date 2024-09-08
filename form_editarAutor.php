<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='Style.css'>;
    <title>Editar Autor</title>
</head>
<body>
    <h1>Editar Autor</h1>
    <?php
    // Conectar ao banco de dados e pegar o ID do autor
    $db = new mysqli("localhost", "root", "", "biblioteca");
    $id_autor = $_GET['id_autor'];
    $result = $db->query("SELECT nome_autor FROM autor WHERE id_autor = $id_autor");
    $autor = $result->fetch_assoc();
    ?>
    <form action="editAutor.php" method="post" id="container">
        <input type="hidden" name="id_autor" value="<?php echo $id_autor; ?>">
        <label>Nome do autor:</label>
        <input type="text" id="nome_autor" required name="nome_autor" value="<?php echo htmlspecialchars($autor['nome_autor']); ?>">
        <br>
        <br>
        <input type="submit" name="botao" value="Atualizar">
        <br>
    </form>
    <br>
    <br>
    <div class='link-container'>; 
    <a href='index.php'>Voltar para a página inicial</a>
        </div>;
    <br>
    <br>
    
</body>
</html>
