
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" onclick="showSection('cartelera')" style="text-align: center;">
                <div>
                    <img src="img/C.png" alt="Logo" style="width: 60px; height: 60px; object-fit: cover; display: block; margin: 0 auto;">
                    <span style="display: block; color: white; font-size: 1.2rem; margin-top: 5px;">Cinepolito</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSection('cartelera')">Cartelera</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSection('alimentos')">Alimentos</a>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Películas
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="#" onclick="showSection('agregarPeliculas')">Agregar Películas</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showSection('verPeliculas')">Ver Películas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Clientes
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="#" onclick="showSection('agregarClientes')">Agregar Clientes</a></li>
                            <li><a class="dropdown-item" href="#" onclick="showSection('verClientes')">Ver Clientes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Consultas
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="#" onclick="showSection('verCompras')">Ver Compras</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex align-items-center ms-auto">
                    <a id="cart-icon" class="nav-link" href="javascript:void(0)" style="color: white; margin-right: 20px;">
                        <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                        <span id="cart-count" class="badge bg-danger">0</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

