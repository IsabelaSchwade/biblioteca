<?php
if (isset($_GET['id'])) {

    $livroId = ($_GET['id']);

    $db = new mysqli("localhost", "root", "", "biblioteca");

    $queryVerificaEmprestimo = "SELECT * FROM emprestimo WHERE id_livro = $livroId";
    $resultadoVerificaEmprestimo = $db->query($queryVerificaEmprestimo);

    if ($resultadoVerificaEmprestimo->num_rows > 0) {
        
        echo "Não é possível excluir o livro porque ele está emprestado.";
    } else {
       
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
