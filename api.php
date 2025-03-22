<?php
// Inclua a conexão com o banco de dados
include('config/db.php');

// Habilitar CORS para permitir requisições de qualquer origem
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// 🔥 Capturar método via _method (para permitir DELETE via POST)
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST' && isset($_POST['_method'])) {
    $method = $_POST['_method'];
}

// 👉 Buscar filmes
if (isset($_GET['tipo']) && $_GET['tipo'] === 'filme') {
    $query = "SELECT f.*, g.nome AS genero FROM filmes f
              LEFT JOIN generos g ON f.genero_id = g.id";
    $result = $db->query($query);

    $filmes = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Corrigir o caminho da imagem para garantir que esteja correto
        $row['capa'] = !empty($row['capa']) ? 'uploads/' . $row['capa'] : 'uploads/default.png';
        $filmes[] = $row;
    }

    echo json_encode($filmes);
    exit;
}

// 👉 Buscar gêneros
if (isset($_GET['tipo']) && $_GET['tipo'] === 'genero') {
    $query = "SELECT id, nome FROM generos";
    $result = $db->query($query);

    $generos = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $generos[] = $row;
    }

    echo json_encode($generos);
    exit;
}

// 👉 Salvar filme (método POST)
if ($method === 'POST') {
    try {
        $titulo = $_POST['titulo'] ?? '';
        $sinopse = $_POST['descricao'] ?? '';
        $genero_id = $_POST['genero_id'] ?? '';
        $link = $_POST['trailer'] ?? '';

        // Upload da imagem
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $nomeArquivo = uniqid() . "." . $extensao;
            $destino = 'uploads/' . $nomeArquivo;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $capa = $nomeArquivo;
            } else {
                throw new Exception('Erro ao salvar a imagem.');
            }
        } else {
            throw new Exception('Imagem é obrigatória.');
        }

        // Inserir filme no banco de dados
        $stmt = $db->prepare("INSERT INTO filmes (titulo, sinopse, capa, link, genero_id) 
                              VALUES (:titulo, :sinopse, :capa, :link, :genero_id)");
        $stmt->execute([
            ':titulo' => $titulo,
            ':sinopse' => $sinopse,
            ':capa' => $capa,
            ':link' => $link,
            ':genero_id' => $genero_id
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Filme salvo com sucesso!']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
}

// 👉 Excluir filme (método DELETE tratado via _method)
if ($method === 'DELETE' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Converte para número inteiro

    if ($id > 0) {
        // 🔥 Verifica se o filme existe e obtém a capa
        $stmt = $db->prepare("SELECT capa FROM filmes WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $filme = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($filme) {
            // Exclui a imagem, se existir
            if (!empty($filme['capa']) && file_exists('uploads/' . $filme['capa'])) {
                unlink('uploads/' . $filme['capa']);
            }

            // 🔥 Exclui o filme
            $stmt = $db->prepare("DELETE FROM filmes WHERE id = :id");
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Filme excluído com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o filme.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Filme não encontrado.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID inválido para exclusão.']);
    }

    exit;
}

// 👉 Se o método for desconhecido
echo json_encode(['status' => 'error', 'message' => 'Método não permitido.']);
exit;
