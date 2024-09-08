<?php
// Inclui o arquivo CSS
echo "<link rel='stylesheet' type='text/css' href='Style.css'>";

// Verifica se o ID do empréstimo foi passado
if (isset($_GET['id_emprestimo'])) {
    // Conexão com o banco de dados
    $db = new mysqli("localhost", "root", "", "biblioteca");

    // Verifica se a conexão foi bem-sucedida
    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }

    // Escapa o valor do ID do empréstimo para evitar SQL Injection
    $idEmprestimo = $_GET['id_emprestimo'];

    // Consulta os detalhes do empréstimo atual
    $query = "SELECT * FROM emprestimo WHERE id_emprestimo = $idEmprestimo";
    $resultado = $db->query($query);

    if ($resultado) {
        $emprestimo = $resultado->fetch_assoc();
    } else {
        echo "Erro ao carregar empréstimo.";
        exit();
    }

    // Consulta para listar todos os livros disponíveis
    $query_livros = "SELECT id, nome_livro FROM livro";
    $resultado_livros = $db->query($query_livros);

    // Fecha a conexão
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Devolução</title>
    <script>
        // Função para validar a data de devolução
        function validarDatas(event) {
            // Obtém os valores das datas
            var dataEmprestimo = document.getElementById('data_emprestimo').value;
            var dataDevolucao = document.getElementById('data_devolucao').value;

            // Converte as datas para o formato Date
            var emprestimoDate = new Date(dataEmprestimo);
            var devolucaoDate = new Date(dataDevolucao);

            // Verifica se a data de devolução é anterior à data de empréstimo
            if (devolucaoDate < emprestimoDate) {
                alert("A data de devolução não pode ser anterior à data de empréstimo.");
                event.preventDefault(); // Impede o envio do formulário
            }
        }
    </script>
</head>
<body>
    <h1>Registrar Devolução</h1>
    <form method="post" action="addDevolucao.php" onsubmit="validarDatas(event)">
        <!-- Nome da pessoa que emprestou -->
        <label for="nome_pessoa">Nome da Pessoa:</label>
        <input type="text" id="nome_pessoa" required name="nome_pessoa" value="<?php echo htmlspecialchars($emprestimo['nome_pessoa']); ?>">
        <br>

        <!-- E-mail da pessoa que emprestou -->
        <label for="email_pessoa">E-mail:</label>
        <input type="email" id="email_pessoa" required name="email_pessoa" value="<?php echo htmlspecialchars($emprestimo['email_pessoa']); ?>">
        <br>

        <!-- Livro emprestado -->
        <label for="id_livro">Livro Emprestado:</label>
        <select id="id_livro" required name="id_livro">
            <option value="">Selecione o livro</option>
            <?php
            // Preenche o dropdown com os livros disponíveis
            if ($resultado_livros->num_rows > 0) {
                while ($livro = $resultado_livros->fetch_assoc()) {
                    $selected = ($livro['id'] == $emprestimo['id_livro']) ? 'selected' : '';
                    echo "<option value='{$livro['id']}' $selected>{$livro['nome_livro']}</option>";
                }
            } else {
                echo "<option value=''>Nenhum livro cadastrado</option>";
            }
            ?>
        </select>
        <br>

        <!-- Data do empréstimo -->
        <label for="data_emprestimo">Data do Empréstimo:</label>
        <input type="date" id="data_emprestimo" required name="data_emprestimo" value="<?php echo htmlspecialchars($emprestimo['data_emprestimo']); ?>">
        <br>

        <!-- Data da devolução -->
        <label for="data_devolucao">Data da Devolução:</label>
        <input type="date" id="data_devolucao" name="data_devolucao" required>
        <br>

        <!-- ID oculto para enviar o ID do empréstimo -->
        <input type="hidden" name="id_emprestimo" value="<?php echo htmlspecialchars($emprestimo['id_emprestimo']); ?>">
        <!-- Botão de submissão -->
        <input type="submit" name="botao" value="Marcar devolução">
    </form>

    <!-- Link para voltar à página inicial -->
    <div class='link-container'>
    <a href='index.php'>Voltar para a página inicial</a>
        </div>
</body>
</html>