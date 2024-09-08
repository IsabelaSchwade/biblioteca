<?php
if (isset($_GET['id'])) {
    $livroId = intval($_GET['id']);
    $db = new mysqli("localhost", "root", "", "biblioteca");

    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }

    // Verificar se o livro está emprestado
    $queryVerificaEmprestimo = "SELECT * FROM emprestimo WHERE id_livro = $livroId";
    $resultadoVerificaEmprestimo = $db->query($queryVerificaEmprestimo);

    if ($resultadoVerificaEmprestimo->num_rows > 0) {
        // Livro está emprestado, não pode ser excluído
        echo "Não é possível excluir o livro porque ele está emprestado.";
    } else {
        // Livro não está emprestado, pode ser excluído
        $queryExcluir = "DELETE FROM livro WHERE id = $livroId";
        if ($db->query($queryExcluir) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao excluir o livro: " . $db->error;
        }
    }

    $db->close();
} else {
    echo "ID do livro não fornecido.";
}
?>
