<div class="sidebar" style="background-color: #2D3046">
            <nav class="sidebar-nav">
                <ul class="nav">
                <li class="nav-title">
                     NAVEGACIÓN
                    </li>
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="main.html"><i class="icon-home"></i>Inicio</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket-loaded"></i>Control de Transacciones</a>
                            <ul class="nav-dropdown-items">
                                <li @click="menu=3" class="nav-item">
                                    <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i>Transacciones</a>
                                </li>
                                <li @click="menu=9" class="nav-item">
                                    <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i>Ventas</a>
                                </li>
                                <li @click="menu=10" class="nav-item">
                                    <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i>Arriendo</a>
                                </li>
                                <li @click="menu=11" class="nav-item">
                                    <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i>Cambio</a>
                                </li>
                                <li @click="menu=12" class="nav-item">
                                    <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i>Reserva</a>
                                </li>
                            </ul>
                    </li>
                    
                    <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i>Listado de Socios</a>
                    </li>
                    <li @click="menu=5" class="nav-item">
                                <a class="nav-link" href="i#"><i class="icon-ghost"></i>Productos</a>
                    </li>
                    
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i>Control de Clientes</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i>Listado de Clientes</a>
                            </li>

                       <!--     <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i>Usuarios</a>
                            </li>-->
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-list"></i>Control de Inventario</a>
                        <ul class="nav-dropdown-items">
                            
                            <li @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-puzzle"></i>Géneros</a>
                            </li>
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-game-controller"></i>Plataformas</a>
                            </li>
                            
                        </ul>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
            </div>