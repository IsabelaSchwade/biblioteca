<?php
echo "<link rel='stylesheet' type='text/css' href='style.css'>";

$db = new mysqli("localhost", "root", "", "biblioteca");

// Verifique se a conexão com o banco de dados foi bem-sucedida
if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}

// Consulta para listar todos os livros disponíveis
$queryLivros = "SELECT id, nome_livro FROM livro";
$resultadoLivros = $db->query($queryLivros);

// Verifique se a consulta retornou resultados
if (!$resultadoLivros) {
    die("Erro na consulta: " . $db->error);
}

echo "<h1>Cadastrar Empréstimo</h1>";

echo <<<HTML
<form method="post" action="addEmprestimo.php">
    <label for="nome_pessoa">Nome da Pessoa:</label>
    <input type="text" id="nome_pessoa" name="nome_pessoa" required><br><br>
    
    <label for="email_pessoa">E-mail:</label>
    <input type="email" id="email_pessoa" name="email_pessoa" required><br><br>
    
    <label for="livro">Selecione o Livro:</label>
    <select name="livro" id="livro" required>
HTML;

if ($resultadoLivros->num_rows > 0) {
    while ($livro = $resultadoLivros->fetch_assoc()) {
        echo "<option value='{$livro['id']}'>{$livro['nome_livro']}</option>";
    }
} else {
    echo "<option value=''>Nenhum livro disponível</option>";
}

echo <<<HTML
    </select><br><br>
    
    <label for="data_emprestimo">Data do Empréstimo:</label>
    <input type="date" id="data_emprestimo" name="data_emprestimo" required><br><br>
    
    <input type="submit" value="Cadastrar Empréstimo">
</form>
HTML;

$db->close();
?>
