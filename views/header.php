<?php
// header.php
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineTech - Filmes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Ícones Bootstrap -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">🎬 CineTech</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Botão moderno com dropdown -->
                <li class="nav-item dropdown">
                    <button class="btn btn-primary dropdown-toggle px-4 py-2 d-flex align-items-center" type="button" id="navbarDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-list me-2"></i> Opções
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php"><i class="bi bi-film me-2"></i> Filmes</a></li>
                        <li><a class="dropdown-item" href="admin.php"><i class="bi bi-gear me-2"></i> Área Administrativa</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container flex-grow-1 mt-4">
