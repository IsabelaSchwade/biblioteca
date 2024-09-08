<?php
echo "<link rel='stylesheet' type='text/css' href='Style.css'>";

$db = new mysqli("localhost", "root", "", "biblioteca");

if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}

// Capturar a ordenação escolhida para livros
$ordenarLivroPor = isset($_GET['ordenar_por']) ? $_GET['ordenar_por'] : '';

// Consulta base para livros
$queryLivros = "SELECT livro.*, autor.nome_autor 
                FROM livro 
                JOIN autor ON livro.autor_livro = autor.id_autor";

// Adicionar a cláusula de ordenação conforme a opção selecionada
if ($ordenarLivroPor === 'nome_livro') {
    $queryLivros .= " ORDER BY livro.nome_livro ASC"; // Ordena por título do livro
} elseif ($ordenarLivroPor === 'autor_livro') {
    $queryLivros .= " ORDER BY autor.nome_autor ASC"; // Ordena por nome do autor
} elseif ($ordenarLivroPor === 'data_lancamento') {
    $queryLivros .= " ORDER BY livro.data_lancamento ASC"; // Ordena por data de lançamento, do mais recente ao mais antigo
}

$resultadoLivros = $db->query($queryLivros);

// Capturar a ordenação escolhida para autores
$ordenarAutorPor = isset($_GET['ordenarAutor_por']) ? $_GET['ordenarAutor_por'] : '';

// Definir a consulta para autores com ou sem ordenação
$queryAutores = "SELECT * FROM autor";

if ($ordenarAutorPor === 'nome_autor') {
    $queryAutores .= " ORDER BY nome_autor ASC"; // Ordena pelo nome do autor em ordem alfabética
}

$resultadoAutores = $db->query($queryAutores);

echo "<h1>Biblioteca</h1>";
echo "<h2>Livros</h2>";

// Formulário de ordenação de livros
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
echo "<br>";
echo "<div class='link-container'>"; 
echo "<a href='form_adicionarLivro.php'>Adicionar novo livro</a><br>";
echo "</div>";

echo "<h2>Autores</h2>";

// Formulário de ordenação de autores
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
                    <a href='form_editarAutor.php?id_autor={$linha['id_autor']}' class='separador'>Editar autor</a>
                </td>";
        echo "</tr>";
    }
}
echo "</table>";
echo "<br>";
echo "<div class='link-container'>"; 
echo "<a href='form_adicionarAutor.php'>Adicionar novo autor</a>";
echo"<br>";
echo"<a href='emprestimo.php'> Meus empréstimos</a>";
echo"<br>";
echo"<a href='devolvido.php'> Livros devolvidos</a>";
echo "</div>";

$db->close();

?>