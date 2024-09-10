<?php
if (isset($_POST)) {
    /
    $db = new mysqli("localhost", "root", "", "biblioteca");

    
    $nome_livro = $_POST['nome_livro'];
    $data_lancamento = $_POST['data_lancamento'];
    $id_autor = $_POST['id_autor'];
    $idlivro = $_POST['id'];

    $query = "UPDATE livro SET nome_livro = '$nome_livro', data_lancamento = '$data_lancamento', autor_livro = $id_autor WHERE id = $idlivro";

    if ($db->query($query) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar o livro: " . $db->error;
    }

    $db->close();
} else {
    echo "Dados incompletos!";
}
?>
