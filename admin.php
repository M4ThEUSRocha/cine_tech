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
        
        <!-- Dropdown de Gênero -->
        <div class="mb-3">
            <label for="genero" class="form-label">Gênero</label>
            <div class="dropdown w-100">
                <button class="btn dropdown-toggle w-100 text-start border form-control" type="button" id="dropdownGenero" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: white; color: black;">
                    Selecione um gênero
                </button>
                <ul class="dropdown-menu w-100" id="filtro-genero">
                    <li><a class="dropdown-item" href="#" data-value="" onclick="selecionarGenero(this)">Selecione um gênero</a></li>
                </ul>
            </div>
            <input type="hidden" id="genero" name="genero_id" required>
        </div>

        <div class="mb-3">
            <label for="data_lancamento" class="form-label">Data de Lançamento</label>
            <input type="date" class="form-control" id="data_lancamento" name="data_lancamento" required>
        </div>
        <div class="mb-3">
            <label for="duracao" class="form-label">Duração (HH:MM)</label>
            <input type="time" class="form-control" id="duracao" name="duracao" required step="60">
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
        fetch('api.php?tipo=genero')
            .then(response => response.json())
            .then(data => {
                const filtroGenero = document.getElementById('filtro-genero');

                data.forEach(genero => {
                    const li = document.createElement('li');
                    li.innerHTML = `<a class="dropdown-item" href="#" data-value="${genero.id}" onclick="selecionarGenero(this)">${genero.nome}</a>`;
                    filtroGenero.appendChild(li);
                });
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao carregar os gêneros.');
            });

        function validarURL(url) {
            const regex = /^(https?:\/\/)?(www\.)?([a-zA-Z0-9._-]+\.[a-zA-Z]{2,})(\/.*)?$/;
            return regex.test(url);
        }

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

            document.getElementById('spinner').classList.remove('d-none');

            const formData = new FormData(e.target);

            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                window.location.href = 'index.php';
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao salvar o filme.');
            })
            .finally(() => {
                document.getElementById('spinner').classList.add('d-none');
            });
        });
    });

    function selecionarGenero(elemento) {
        const botao = document.getElementById('dropdownGenero');
        const inputHidden = document.getElementById('genero');

        botao.innerText = elemento.innerText; // Atualiza o texto do botão
        inputHidden.value = elemento.getAttribute('data-value'); // Salva o ID do gênero no input hidden
    }
</script>

<?php include('views/footer.php'); ?>
