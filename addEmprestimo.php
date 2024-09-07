<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $db = new mysqli("localhost", "root", "", "biblioteca");

    // Verificar se a conexão foi bem-sucedida
    if ($db->connect_error) {
        die("Falha na conexão: " . $db->connect_error);
    }

    // Depuração: Verificar o conteúdo do $_POST
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    exit();

    // Verificar se os campos esperados estão definidos
    if (!isset($_POST['nome_pessoa'], $_POST['email_pessoa'], $_POST['livro'], $_POST['data_emprestimo'])) {
        die("Dados do formulário ausentes.");
    }

    $pessoa = $db->real_escape_string($_POST['nome_pessoa']);
    $email = $db->real_escape_string($_POST['email_pessoa']);
    $livro_emprestado = intval($_POST['livro']); // Use intval para garantir que é um número
    $data_emprestimo = $db->real_escape_string($_POST['data_emprestimo']);

    // Verificar se o livro existe
    $query_verifica_livro = "SELECT id_livro FROM livro WHERE id_livro = $livro_emprestado";
    $resultado_verifica_livro = $db->query($query_verifica_livro);

    if ($resultado_verifica_livro->num_rows === 0) {
        die("O livro selecionado não existe.");
    }

    // Inserir o novo empréstimo
    $query = "INSERT INTO emprestimo (nome_pessoa, email_pessoa, id_livro, data_emprestimo) 
              VALUES ('$pessoa', '$email', $livro_emprestado, '$data_emprestimo')";

    try {
        if ($db->query($query) === TRUE) {
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
