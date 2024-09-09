<?php

if (isset($_POST)) {

    $db = new mysqli("localhost", "root", "", "biblioteca");
    $diretorioDestino = "uploads/";

    
    if (isset($_FILES['foto_capa']) && $_FILES['foto_capa']['error'] == 0) {
        $destinoArquivo = $diretorioDestino . basename($_FILES['foto_capa']['name']);

        
        $checagem_imagem = getimagesize($_FILES['foto_capa']['tmp_name']);
        if ($checagem_imagem !== false) {
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

    $nome_livro = $_POST['nome_livro'];
    $data_lancamento = $_POST['data_lancamento'];
    $id_autor = $_POST['id_autor'];

    
    $query_autor = "SELECT id_autor FROM autor WHERE id_autor = $id_autor";
    $resultado_autor = $db->query($query_autor);

    if ($resultado_autor->num_rows > 0) {
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

    $db->close();
}
?>
