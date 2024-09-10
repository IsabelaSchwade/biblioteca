<?php
if (isset($_GET['id_autor'])) {
    $db = new mysqli("localhost", "root", "", "biblioteca");

    $id_autor = ($_GET['id_autor']);


    $query_verificar_livros = "SELECT COUNT(*) AS num_livros_emprestados 
                               FROM livro 
                               WHERE autor_livro = $id_autor 
                               AND status = 'emprestado'";
    $resultado_verificar = $db->query($query_verificar_livros);
    $linha = $resultado_verificar->fetch_assoc();

    if ($linha['num_livros_emprestados'] > 0) {
      
        echo "Não é possível excluir o autor, pois existem livros emprestados associados a ele.";
        echo "<br><a href='index.php'>Voltar para a página inicial</a>";
    } else {
  
        $query_excluir_autor = "DELETE FROM autor WHERE id_autor = $id_autor";
        
        if ($db->query($query_excluir_autor) === TRUE) {
            echo "Autor excluído com sucesso!";
            echo "<br><a href='index.php'>Voltar para a página inicial</a>";
        } else {
            echo "Erro ao excluir o autor: " . $db->error;
        }
    }

    $query_excluir_livros = "DELETE FROM livro WHERE autor_livro = $id_autor";
    if ($db->query($query_excluir_livros) === FALSE) {
        echo "Erro ao excluir os livros: " . $db->error;
        $db->close();
        exit();
    }

    $query_excluir_autor = "DELETE FROM autor WHERE id_autor = $id_autor";
    if ($db->query($query_excluir_autor) === TRUE) {
        echo "Autor e seus livros excluídos com sucesso!";
        echo"<br><br>";
        echo "<br><a href='index.php'>Voltar para a página inicial</a>";
    } else {
        echo "Erro ao excluir o autor: " . $db->error;
    }

    $db->close();
} else {
    echo "ID do autor não fornecido!";
}
?>


