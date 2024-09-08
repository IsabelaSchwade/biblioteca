<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Conectar ao banco de dados
    $db = new mysqli("localhost", "root", "", "biblioteca");

    // Verificar se a conexão foi bem-sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }

    // Verificar se todos os campos necessários estão definidos
    if (!isset($_POST['nome_pessoa'], $_POST['email_pessoa'], $_POST['id_livro'], $_POST['data_emprestimo'], $_POST['data_devolucao'], $_POST['id_emprestimo'])) {
        die("Dados do formulário ausentes.");
    }

    // Obter os dados do formulário
    $pessoa = $_POST['nome_pessoa'];
    $email = $_POST['email_pessoa'];
    $livro_emprestado = intval($_POST['id_livro']); // Garantir que é um número
    $data_emprestimo = $_POST['data_emprestimo'];
    $data_devolucao = $_POST['data_devolucao'];
    $id_emprestimo = intval($_POST['id_emprestimo']); // Garantir que o id_emprestimo seja um número

    // Verificar se o livro existe
    $query_verifica_livro = "SELECT id FROM livro WHERE id = $livro_emprestado";
    $resultado_verifica_livro = $db->query($query_verifica_livro);

    if ($resultado_verifica_livro->num_rows === 0) {
        die("O livro selecionado não existe.");
    }

    // Inserir os dados no histórico de devoluções
    $query_inserir = "INSERT INTO historicoemprestimos (nome_pessoa, email_pessoa, id_livro, data_emprestimo, data_devolucao) 
                      VALUES ('$pessoa', '$email', $livro_emprestado, '$data_emprestimo', '$data_devolucao')";

    try {
        // Executar a inserção
        if ($db->query($query_inserir) === TRUE) {
            // Depois de inserir no histórico, excluir o empréstimo original
            $queryExcluir = "DELETE FROM emprestimo WHERE id_emprestimo = $id_emprestimo";
            if ($db->query($queryExcluir) === TRUE) {
                // Redirecionar após a exclusão
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

    // Fechar a conexão
    $db->close();
}
?>
