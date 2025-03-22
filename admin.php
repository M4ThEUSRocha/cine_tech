<?php include('views/header.php'); ?>

<h1 class="text-center mb-4">🎬 Área Administrativa</h1>

<div class="card shadow p-4">
    <form id="form-filme" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" required></textarea>
        </div>
        <div class="mb-3">
            <label for="genero" class="form-label">Gênero</label>
            <select class="form-control" id="genero" name="genero_id" required>
                <option value="">Selecione um gênero</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="imagem" class="form-label">Imagem</label>
            <input type="file" class="form-control" id="imagem" name="imagem" required accept=".jpg, .jpeg, .png">
            <small class="text-muted">Formatos permitidos: .jpg, .jpeg, .png</small>
        </div>
        <div class="mb-3">
            <label for="trailer" class="form-label">Link do Trailer</label>
            <input type="url" class="form-control" id="trailer" name="trailer" required placeholder="https://example.com/trailer">
        </div>
        <button type="submit" class="btn btn-success w-100" id="btn-submit">
            <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
            Salvar
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Carregar gêneros dinamicamente
        fetch('api.php?tipo=genero')
            .then(response => {
                if (!response.ok) throw new Error('Erro ao carregar gêneros');
                return response.json();
            })
            .then(data => {
                let options = '<option value="">Selecione um gênero</option>';
                data.forEach(genero => {
                    options += `<option value="${genero.id}">${genero.nome}</option>`;
                });
                document.getElementById('genero').innerHTML = options;
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao carregar os gêneros.');
            });

        // Validação de URL do trailer
        function validarURL(url) {
            const regex = /^(https?:\/\/)?(www\.)?([a-zA-Z0-9._-]+\.[a-zA-Z]{2,})(\/.*)?$/;
            return regex.test(url);
        }

        // Salvar filme
        document.getElementById('form-filme').addEventListener('submit', (e) => {
            e.preventDefault();

            const trailer = document.getElementById('trailer').value;
            if (!validarURL(trailer)) {
                alert('URL do trailer inválida!');
                return;
            }

            const imagem = document.getElementById('imagem').files[0];
            if (imagem) {
                const formatosPermitidos = ['image/jpeg', 'image/png'];
                if (!formatosPermitidos.includes(imagem.type)) {
                    alert('Formato de imagem inválido! Use .jpg ou .png.');
                    return;
                }
            }

            // Exibir spinner
            const spinner = document.getElementById('spinner');
            spinner.classList.remove('d-none');

            const formData = new FormData(e.target);

            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Erro ao salvar o filme');
                return response.json();
            })
            .then(data => {
                alert(data.message);

                // Redireciona para a lista após o sucesso
                window.location.href = 'index.php';
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao salvar o filme.');
            })
            .finally(() => {
                // Esconde o spinner após a conclusão
                spinner.classList.add('d-none');
            });
        });
    });
</script>

<?php include('views/footer.php'); ?>
