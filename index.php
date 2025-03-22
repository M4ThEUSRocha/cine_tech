<?php include('views/header.php'); ?>

<h1 class="text-center mb-4">🎬 Lista de Filmes</h1>

<div class="d-flex justify-content-between mb-4">
    <!-- Campo de pesquisa -->
    <input type="text" id="pesquisa" class="form-control me-2" placeholder="🔎 Buscar filme..." oninput="filtrarFilmes()">
    
    <!-- Filtro por gênero -->
    <select id="filtro-genero" class="form-select me-2" onchange="filtrarFilmes()">
        <option value="">Todos os Gêneros</option>
    </select>
</div>

<!-- Adicionar CSS para garantir a responsividade da imagem -->
<style>
    /* Ajustes para a responsividade da imagem */
    .card-img-top {
        width: 100%; /* A imagem ocupa toda a largura do card */
        height: auto; /* A altura será ajustada automaticamente para manter a proporção */
        object-fit: cover; /* Mantém a imagem coberta sem distorção */
        max-height: 250px; /* Limita a altura máxima para não exagerar em telas grandes */
    }
</style>

<div class="row" id="lista-filmes">
    <!-- Os filmes serão carregados dinamicamente aqui -->
</div>

<!-- Modal para detalhes do filme -->
<div class="modal fade" id="detalhesFilmeModal" tabindex="-1" aria-labelledby="detalhesFilmeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalhesFilmeModalLabel">Detalhes do Filme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <img id="detalhesCapa" src="" class="img-fluid mb-3" alt="Imagem do Filme">
                <h5 id="detalhesTitulo"></h5>
                <p id="detalhesSinopse"></p>
                <a id="detalhesTrailer" href="#" target="_blank" class="btn btn-primary w-100">Assistir Trailer</a>
            </div>
        </div>
    </div>
</div>

<script>
    let filmes = []; // Array para armazenar os filmes carregados

    document.addEventListener('DOMContentLoaded', () => {
        carregarFilmes();
        carregarGeneros();
    });

    // Carregar lista de filmes
    function carregarFilmes() {
        fetch('api.php?tipo=filme')
            .then(response => response.json())
            .then(data => {
                filmes = data;
                renderizarFilmes(filmes);

                // Ativa o botão de busca após o carregamento dos filmes
                document.getElementById('btn-buscar').disabled = false;
            })
            .catch(error => console.error('Erro ao carregar filmes:', error));
    }

    // Renderizar filmes na tela
    function renderizarFilmes(lista) {
        let html = '';
        lista.forEach(filme => {
            html += `
                <div class="col-md-4 mb-4" data-id="${filme.id}">
                    <div class="card h-100 shadow-sm">
                        <img src="${filme.capa}" class="card-img-top" alt="${filme.titulo}">
                        <div class="card-body">
                            <h5 class="card-title">${filme.titulo}</h5>
                            <p class="card-text">${filme.sinopse}</p>
                            <a href="${filme.link}" target="_blank" class="btn btn-primary w-100">Assistir Trailer</a>
                            <button class="btn btn-info w-100 mt-2" onclick="verDetalhes('${filme.titulo}', '${filme.sinopse}', '${filme.capa}', '${filme.link}')">Ver Detalhes</button>
                            <button class="btn btn-danger w-100 mt-2" onclick="excluirFilme(${filme.id})">Excluir</button>
                        </div>
                    </div>
                </div>
            `;
        });
        document.getElementById('lista-filmes').innerHTML = html;
    }

    // Excluir filme
    function excluirFilme(id) {
        if (!confirm('Tem certeza que deseja excluir este filme?')) return;

        fetch(`api.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.querySelector(`div[data-id="${id}"]`).remove(); // Remove o filme da lista
                alert(data.message);
            } else {
                alert(`Erro ao excluir filme: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Erro ao excluir filme:', error);
            alert('Erro ao excluir o filme.');
        });
    }

    // Carregar lista de gêneros
    function carregarGeneros() {
        fetch('api.php?tipo=genero')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('filtro-genero');
                data.forEach(genero => {
                    const option = document.createElement('option');
                    option.value = genero.nome.toLowerCase();
                    option.innerText = genero.nome;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Erro ao carregar gêneros:', error));
    }

    // Filtrar filmes por nome e gênero
    function filtrarFilmes() {
        if (filmes.length === 0) {
            console.warn('Nenhum filme carregado ainda.');
            return;
        }

        const termoPesquisa = document.getElementById('pesquisa').value.toLowerCase();
        const generoSelecionado = document.getElementById('filtro-genero').value;

        const filmesFiltrados = filmes.filter(filme => {
            const correspondeNome = filme.titulo.toLowerCase().includes(termoPesquisa);
            const correspondeGenero = !generoSelecionado || filme.genero.toLowerCase() === generoSelecionado;
            return correspondeNome && correspondeGenero;
        });

        renderizarFilmes(filmesFiltrados);
    }

    // Exibir detalhes no modal
    function verDetalhes(titulo, sinopse, capa, trailer) {
        document.getElementById('detalhesTitulo').innerText = titulo;
        document.getElementById('detalhesSinopse').innerText = sinopse;
        document.getElementById('detalhesCapa').src = capa;
        document.getElementById('detalhesTrailer').href = trailer;

        const modal = new bootstrap.Modal(document.getElementById('detalhesFilmeModal'));
        modal.show();
    }
</script>

<?php include('views/footer.php'); ?>
