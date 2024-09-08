<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli("localhost", "root", "", "biblioteca");

    // Verificar se a conexão foi bem-sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }

    // Verificar se todos os campos necessários estão definidos
    if (!isset($_POST['nome_pessoa'], $_POST['email_pessoa'], $_POST['id_livro'], $_POST['data_emprestimo'])) {
        die("Dados do formulário ausentes.");
    }

    $pessoa = $db->real_escape_string($_POST['nome_pessoa']);
    $email = $db->real_escape_string($_POST['email_pessoa']);
    $livro_emprestado = intval($_POST['id_livro']);
    $data_emprestimo = $db->real_escape_string($_POST['data_emprestimo']);

    // Verificar se o livro já está emprestado
    $query_verifica_livro = "SELECT status FROM livro WHERE id = $livro_emprestado";
    $resultado_verifica_livro = $db->query($query_verifica_livro);

    if ($resultado_verifica_livro->num_rows === 0) {
        die("O livro selecionado não existe.");
    }

    $livro = $resultado_verifica_livro->fetch_assoc();
    if ($livro['status'] === 'emprestado') {
        die("Este livro já está emprestado e não pode ser emprestado novamente até ser devolvido.");
    }

    // Inserir o novo empréstimo
    $query = "INSERT INTO emprestimo (nome_pessoa, email_pessoa, id_livro, data_emprestimo) 
              VALUES ('$pessoa', '$email', $livro_emprestado, '$data_emprestimo')";

    try {
        if ($db->query($query) === TRUE) {
            // Atualizar o status do livro para 'emprestado'
            $query_atualizar_status = "UPDATE livro SET status = 'emprestado' WHERE id = $livro_emprestado";
            $db->query($query_atualizar_status);

            header("Location: emprestimo.php");
            exit();
        } else {
            echo "Erro ao adicionar empréstimo: " . $db->error;
        }
    } catch (mysqli_sql_exception $e) {
        echo "Erro de SQL: " . $e->getMessage();
    }

    $db->close();
}

?>