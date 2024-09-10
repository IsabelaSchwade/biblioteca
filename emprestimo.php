<?php
echo "<link rel='stylesheet' type='text/css' href='Style.css'>";

$db = new mysqli("localhost", "root", "", "biblioteca");



$queryEmprestimo = "SELECT emprestimo.*, livro.nome_livro 
    FROM emprestimo
    JOIN livro ON livro.id = emprestimo.id_livro";

$resultadoEmprestimo = $db->query($queryEmprestimo);

echo "<h1>Meus empréstimos</h1>";

echo "<br><br>";
echo "<table>";
echo "<tr>
        <td>Pessoa que emprestou: </td>
        <td>E-mail:</td>
        <td>Nome do livro: </td>
        <td>Data do empréstimo: </td>
        <td>Selecione</td>
    </tr>";

if ($resultadoEmprestimo->num_rows == 0) {
    echo "<tr><td>Você não emprestou nenhum livro!</td></tr>";

}else {
    while ($linha = $resultadoEmprestimo->fetch_assoc()) {
        echo "<tr>";
            echo "<td>{$linha['nome_pessoa']}</td>";
            echo "<td>{$linha['email_pessoa']}</td>";
            echo "<td>{$linha['nome_livro']}</td>";
            echo "<td>{$linha['data_emprestimo']}</td>";
            echo "<td><a href='form_addDevolucao.php?id_emprestimo={$linha['id_emprestimo']}'>Marcar devolução</a> 
                     
                 </td>";
        echo "</tr>";
    }
}

echo "</table>";

// Feche a conexão com o banco de dados
$db->close();
echo"<br>";
echo"<br>";
echo" <div class='link-container'>";
echo "<a href='form_addEmprestimo.php'>Adicionar novo empréstimo</a><br>";
echo"<br>";

echo "<a href='index.php'>Voltar para página inicial</a><br>";
echo"</div>"
?>
