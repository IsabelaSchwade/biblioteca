<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli("localhost", "root", "", "biblioteca");

    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }

    if (!isset($_POST['nome_pessoa'], $_POST['email_pessoa'], $_POST['id_livro'], $_POST['data_emprestimo'], $_POST['data_devolucao'], $_POST['id_emprestimo'])) {
        die("Dados do formulário ausentes.");
    }

    $pessoa = $db->real_escape_string($_POST['nome_pessoa']);
    $email = $db->real_escape_string($_POST['email_pessoa']);
    $livro_emprestado = intval($_POST['id_livro']);
    $data_emprestimo = $db->real_escape_string($_POST['data_emprestimo']);
    $data_devolucao = $db->real_escape_string($_POST['data_devolucao']);
    $id_emprestimo = intval($_POST['id_emprestimo']);

    $query_inserir = "INSERT INTO historicoemprestimos (nome_pessoa, email_pessoa, id_livro, data_emprestimo, data_devolucao) 
                      VALUES ('$pessoa', '$email', $livro_emprestado, '$data_emprestimo', '$data_devolucao')";

    try {
        if ($db->query($query_inserir) === TRUE) {
            // Excluir o empréstimo original
            $queryExcluir = "DELETE FROM emprestimo WHERE id_emprestimo = $id_emprestimo";
            if ($db->query($queryExcluir) === TRUE) {
                // Atualizar o status do livro para 'disponivel'
                $query_atualizar_status = "UPDATE livro SET status = 'disponivel' WHERE id = $livro_emprestado";
                $db->query($query_atualizar_status);

                header("Location: devolvido.php");
                exit();
            } else {
                echo "Erro ao excluir o empréstimo: " . $db->error;
            }
        } else {
            echo "Erro ao registrar devolução: " . $db->error;
        }
    } catch (mysqli_sql_exception $e) {
        echo "Erro de SQL: " . $e->getMessage();
    }

    $db->close();
}

?>