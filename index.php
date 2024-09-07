<?php
echo "<link rel='stylesheet' type='text/css' href='style.css'>";

$db = new mysqli("localhost", "root", "", "biblioteca");

if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}

// Consulta e exibição dos livros
$queryLivros = "SELECT livro.*, autor.nome_autor 
                FROM livro 
                JOIN autor ON livro.autor_livro = autor.id_autor";
$resultadoLivros = $db->query($queryLivros);

// Consulta e exibição dos autores
$queryAutores = "SELECT * FROM autor";
$resultadoAutores = $db->query($queryAutores);

echo "<h1>Biblioteca</h1>";
echo "<h2>Livros</h2>";

echo <<<HTML
<form method="get" action="">
    <label for="ordenar_por">Ordenar livro por:</label>
    <select name="ordenar_por" id="ordenar_por">
        <option selected disabled value="">Selecione</option>
        <option value="nome_livro">Nome do Livro</option>
        <option value="autor_livro">Autor do livro</option>
        <option value="data_lancamento">Data de lançamento do livro</option>
    </select>
    <input type="submit" value="Ordenar">
</form>
HTML;

echo "<br><br>";
echo "<table>";
echo "<tr>
        <td>Nome do livro</td>
        <td>Data de lançamento</td>
        <td>Autor(a) do livro</td>
        <td>Id</td>
        <td>Capa do livro</td>
        <td>Selecione</td>
    </tr>";

if ($resultadoLivros->num_rows == 0) {
    echo "<tr><td colspan='6'>Você ainda não cadastrou livros na sua biblioteca</td></tr>";
} else {
    while ($linha = $resultadoLivros->fetch_assoc()) {
        echo "<tr>";
            echo "<td>{$linha['nome_livro']}</td>";
            echo "<td>{$linha['data_lancamento']}</td>";
            echo "<td>{$linha['nome_autor']}</td>";
            echo "<td>{$linha['id']}</td>";
            echo "<td><img src='{$linha['foto_capa']}' alt='Capa do livro' style='width:200px; height:auto;'></td>";
            echo "<td><a href='deleteLivro.php?id={$linha['id']}'>Excluir livro</a> |
                      <a href='form_editarLivro.php?id={$linha['id']}' class='separador'>Editar livro</a>
                 </td>";
        echo "</tr>";
    }
}
echo "</table>";
echo"<br>";
echo "<a href='form_adicionarLivro.php'>Adicionar novo livro</a><br>";
echo "<h2>Autores</h2>";

echo <<<HTML
<form method="get" action="">
    <label for="ordenarAutor_por">Ordenar autor por:</label>
    <select name="ordenarAutor_por" id="ordenarAutor_por">
        <option selected disabled value="">Selecione</option>
        <option value="nome_autor">Nome do autor</option>
    </select>
    <input type="submit" value="Ordenar">
</form>
HTML;

echo "<br><br>";
echo "<table>"; 
echo "<tr>
        <td>Nome do autor</td>
        <td>Id do autor</td>
        <td>Selecione</td>
    </tr>";

if ($resultadoAutores->num_rows == 0) {
    echo "<tr><td colspan='3'>Você ainda não cadastrou autores na sua biblioteca</td></tr>";
} else {
    while ($linha = $resultadoAutores->fetch_assoc()) {
        echo "<tr>";
            echo "<td>{$linha['nome_autor']}</td>";
            echo "<td>{$linha['id_autor']}</td>";
            echo "<td><a href='deleteAutor.php?id_autor={$linha['id_autor']}'>Excluir autor</a> |
                    <a href='form_editar_autor.php?id_autor={$linha['id_autor']}' class='separador'>Editar autor</a>
                </td>";
        echo "</tr>";
    }
}
echo "</table>";
echo "<br>";
echo "<div class='link-container'>"; 
echo "<a href='form_adicionarLivro.php'>Adicionar novo autor</a><br>";
echo "</div>";

$db->close();
?>
