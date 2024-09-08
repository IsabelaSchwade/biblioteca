<?php
echo "<link rel='stylesheet' type='text/css' href='Style.css'>";
if (isset($_GET['id'])) {
    // Conexão com o banco de dados
    $db = new mysqli("localhost", "root", "", "biblioteca");

    // Escapar valor para evitar SQL Injection
    $idlivro = $_GET['id'];

    // Query de consulta para buscar detalhes do livro
    $query = "SELECT * FROM livro WHERE id = $idlivro";
    $resultado = $db->query($query);

    if ($resultado) {
        $livro = $resultado->fetch_assoc();
    } else {
        echo "Erro ao carregar livro.";
        exit();
    }

    // Query para buscar todos os autores
    $query_autores = "SELECT id_autor, nome_autor FROM autor";
    $resultado_autores = $db->query($query_autores);

    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar livro</title>
</head>
<body>
    <h1>Editar Livro</h1>
    <form method="post" action="editLivro.php" enctype="multipart/form-data" >
        <label for="nome_livro">Título</label>
        <input type="text" id="nome_livro" required name="nome_livro" value="<?php echo htmlspecialchars($livro['nome_livro']); ?>">
        <br>
        <label for="data_lancamento">Data de lançamento</label>
        <input type="date" id="data_lancamento" required name="data_lancamento" value="<?php echo htmlspecialchars($livro['data_lancamento']); ?>">
        <br>
        <label for="id_autor">Autor(a)</label>
        <select id="id_autor" required name="id_autor">
            <option value="">Selecione o autor</option>
            <?php
            // Preencher o dropdown com os autores
            if ($resultado_autores->num_rows > 0) {
                while ($autor = $resultado_autores->fetch_assoc()) {
                    $selected = ($autor['id_autor'] == $livro['autor_livro']) ? 'selected' : '';
                    echo "<option value='{$autor['id_autor']}' $selected>{$autor['nome_autor']}</option>";
                }
            } else {
                echo "<option value=''>Nenhum autor cadastrado</option>";
            }
            ?>
        </select>
        <br>
        <label for="foto_capa">Foto da capa do livro:</label>
        <input type="file" id="foto_capa" name="foto_capa" accept="image/*">
        <br>
        <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($livro['id']); ?>">
        <input type="submit" name="botao" value="Editar">
    </form>
    <div class='link-container'>; 
    <a href='index.php'>Voltar para a página inicial</a>
        </div>;
</body>
</html>
