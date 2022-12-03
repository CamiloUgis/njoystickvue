<div class="sidebar" style="background-color: #2D3046">
            <nav class="sidebar-nav">
                <ul class="nav">
                <li class="nav-title">
                        NAVEGACIÓN
                    </li>
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="main.html"><i class="icon-home"></i>Inicio</a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                                <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i>Transacciones</a>
                    </li>
                    <li @click="menu=5" class="nav-item">
                                <a class="nav-link" href="i#"><i class="icon-ghost"></i>Productos</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-list"></i>Control de Inventario</a>
                        <ul class="nav-dropdown-items">
                            
                            <li @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-puzzle"></i>Tipos</a>
                            </li>
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-game-controller"></i>Marcas</a>
                            </li>
                            
                        </ul>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
            </div>