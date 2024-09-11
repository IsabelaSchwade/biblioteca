<?php

if (isset($_POST)) {
    $db = new mysqli("localhost", "root", "", "biblioteca");

    $pessoa = ($_POST['nome_pessoa']);
    $email = ($_POST['email_pessoa']);
    $livro_emprestado = ($_POST['id_livro']);
    $data_emprestimo = ($_POST['data_emprestimo']);


    $query_verifica_livro = "SELECT status FROM livro WHERE id = $livro_emprestado";
    $resultado_verifica_livro = $db->query($query_verifica_livro);
 
  

    $livro = $resultado_verifica_livro->fetch_assoc();
    if ($livro['status'] === 'emprestado') {
        die("Este livro já está emprestado e não pode ser emprestado novamente até ser devolvido.");
    }

    $query = "INSERT INTO emprestimo (nome_pessoa, email_pessoa, id_livro, data_emprestimo) 
              VALUES ('$pessoa', '$email', $livro_emprestado, '$data_emprestimo')";

        if ($db->query($query) === TRUE) {
            
            $query_atualizar_status = "UPDATE livro SET status = 'emprestado' WHERE id = $livro_emprestado";
            $db->query($query_atualizar_status);

            header("Location: emprestimo.php");
            exit();
        } else {
            echo "Erro ao adicionar empréstimo: " . $db->error;
        }
    

    $db->close();
}

?>