<?php
echo "<link rel='stylesheet' type='text/css' href='Style.css'>";

$db = new mysqli("localhost", "root", "", "biblioteca");



$queryDevolucao = "SELECT historicoemprestimos.*, livro.nome_livro 
    FROM historicoemprestimos
    JOIN livro ON livro.id = historicoemprestimos.id_livro"; 

$resultadoDevolucao = $db->query($queryDevolucao);
 
echo "<h1>Histórico de devoluções</h1>";

echo "<br><br>";
echo "<table>";
echo "<tr>
        <td>Pessoa que devolveu: </td>
        <td>E-mail:</td>
        <td>Nome do livro: </td>
        <td>Data do empréstimo: </td>
        <td>Data da devolução: </td>
    </tr>";

if ($resultadoDevolucao->num_rows == 0) {
    echo "<tr><td>Ainda não houve devoluções!</td></tr>";
} else {
    while ($linha = $resultadoDevolucao->fetch_assoc()) {
        echo "<tr>";
            echo "<td>{$linha['nome_pessoa']}</td>";
            echo "<td>{$linha['email_pessoa']}</td>";
            echo "<td>{$linha['nome_livro']}</td>";
            echo "<td>{$linha['data_emprestimo']}</td>";
            echo "<td>{$linha['data_devolucao']}</td>";
        echo "</tr>";
    }
}

echo "</table>";

$db->close();

echo "<br><br>";

echo" <div class='link-container'>";
echo "<a href='index.php'>Voltar para página inicial</a><br>";
echo"</div>"

?>
