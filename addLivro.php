<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = new mysqli("localhost", "root", "", "biblioteca");

    if ($db->connect_error) {
        die("Conexão falhou: " . $db->connect_error);
    }

    $diretorioDestino = "uploads/"; // Definindo o diretório onde as imagens serão salvas

    // Verifica se houve algum erro no upload
    if (isset($_FILES['foto_capa']) && $_FILES['foto_capa']['error'] == 0) {
        // Extrai a extensão do arquivo
        $extensao = strtolower(pathinfo($_FILES['foto_capa']['name'], PATHINFO_EXTENSION));

        // Define o caminho completo do arquivo no diretório de destino
        $destinoArquivo = $diretorioDestino . basename($_FILES['foto_capa']['name']);

        // Verifica se o arquivo é uma imagem
        $checagem_imagem = getimagesize($_FILES['foto_capa']['tmp_name']);
        if ($checagem_imagem !== false) {
            // Move o arquivo para o diretório de destino
            if (move_uploaded_file($_FILES['foto_capa']['tmp_name'], $destinoArquivo)) {
                $fotoCapaURL = $db->real_escape_string($destinoArquivo);
            } else {
                echo "Erro ao fazer upload da imagem.";
                exit();
            }
        } else {
            echo "O arquivo enviado não é uma imagem.";
            exit();
        }
    } else {
        echo "Por favor, envie uma imagem da capa do livro.";
        exit();
    }

    $nome_livro = $db->real_escape_string($_POST['nome_livro']);
    $data_lancamento = $db->real_escape_string($_POST['data_lancamento']);
    $id_autor = intval($_POST['id_autor']);

    // Verificar se o autor existe
    $query_autor = "SELECT id_autor FROM autor WHERE id_autor = $id_autor";
    $resultado_autor = $db->query($query_autor);

    if ($resultado_autor->num_rows > 0) {
        // Inserir no banco de dados
        $query = "INSERT INTO livro (nome_livro, data_lancamento, autor_livro, foto_capa) 
                  VALUES ('$nome_livro', '$data_lancamento', $id_autor, '$fotoCapaURL')";

        if ($db->query($query) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao adicionar o livro: " . $db->error;
        }
    } else {
        echo "Autor não encontrado!";
    }

    // Fecha a conexão com o banco de dados
    $db->close();
}
?>
