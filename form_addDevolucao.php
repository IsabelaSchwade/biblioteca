<?php

echo "<link rel='stylesheet' type='text/css' href='Style.css'>";

if (isset($_GET)) {
    
    $db = new mysqli("localhost", "root", "", "biblioteca");

    $idEmprestimo = $_GET['id_emprestimo'];


    $query = "SELECT * FROM emprestimo WHERE id_emprestimo = $idEmprestimo";
    $resultado = $db->query($query);

    if ($resultado) {
        $emprestimo = $resultado->fetch_assoc();
    } else {
        echo "Erro ao carregar empréstimo.";
        exit();
    }
  
    $query_livros = "SELECT id, nome_livro FROM livro";
    $resultado_livros = $db->query($query_livros);

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
        function validarDatas(event) {
            
            var dataEmprestimo = document.getElementById('data_emprestimo').value;
            var dataDevolucao = document.getElementById('data_devolucao').value;

            var emprestimoDate = new Date(dataEmprestimo);
            var devolucaoDate = new Date(dataDevolucao);

            if (devolucaoDate < emprestimoDate) {
                alert("A data de devolução não pode ser anterior à data de empréstimo.");
                event.preventDefault(); 
            }
        }
    </script>
</head>
<body>
    <h1>Registrar Devolução</h1>
    <form method="post" action="addDevolucao.php" onsubmit="validarDatas(event)">
        
        <label for="nome_pessoa">Nome da Pessoa:</label>
        <input type="text" id="nome_pessoa" required name="nome_pessoa" value="<?php echo htmlspecialchars($emprestimo['nome_pessoa']); ?>">
        <br>

        <label for="email_pessoa">E-mail:</label>
        <input type="email" id="email_pessoa" required name="email_pessoa" value="<?php echo htmlspecialchars($emprestimo['email_pessoa']); ?>">
        <br>

        <label for="id_livro">Livro Emprestado:</label>
        <select id="id_livro" required name="id_livro">
            <option value="">Selecione o livro</option>
            <?php
            
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

        <label for="data_emprestimo">Data do Empréstimo:</label>
        <input type="date" id="data_emprestimo" required name="data_emprestimo" value="<?php echo htmlspecialchars($emprestimo['data_emprestimo']); ?>">
        <br>

        <label for="data_devolucao">Data da Devolução:</label>
        <input type="date" id="data_devolucao" name="data_devolucao" required>
        <br>

        <input type="hidden" name="id_emprestimo" value="<?php echo htmlspecialchars($emprestimo['id_emprestimo']); ?>">
        
        <input type="submit" name="botao" value="Marcar devolução">
    </form>

    
    <div class='link-container'>
    <a href='index.php'>Voltar para a página inicial</a>
        </div>
</body>
</html> 