<?php

if (isset($_POST)) {
    $db = new mysqli("localhost", "root", "", "biblioteca");

    $pessoa = ($_POST['nome_pessoa']);
    $email = ($_POST['email_pessoa']);
    $livro_emprestado = ($_POST['id_livro']);
    $data_emprestimo = ($_POST['data_emprestimo']);
    $data_devolucao = ($_POST['data_devolucao']);
    $id_emprestimo = ($_POST['id_emprestimo']);

    $query_inserir = "INSERT INTO historicoemprestimos (nome_pessoa, email_pessoa, id_livro, data_emprestimo, data_devolucao) 
                      VALUES ('$pessoa', '$email', $livro_emprestado, '$data_emprestimo', '$data_devolucao')";

    
        if ($db->query($query_inserir) === TRUE) {

            $queryExcluir = "DELETE FROM emprestimo WHERE id_emprestimo = $id_emprestimo";
            if ($db->query($queryExcluir) === TRUE) {
            
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
    } 

    $db->close();


?> 