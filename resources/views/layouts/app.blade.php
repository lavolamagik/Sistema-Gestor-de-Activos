<!DOCTYPE html>
<html lang="es">
    <head>
        <title>@yield('title')</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="vendor/adminlte/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="vendor/adminlte/dist/css/adminlte.min.css?v=3.2.0">
        <!-- Select2 -->
        <link rel="stylesheet" href="vendor/adminlte/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

        <!-- Leaflet CSS -->
        <link
            href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            rel="stylesheet"
        />

        <!-- Leaflet JavaScript -->
        <script
            src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            crossorigin="anonymous"
        ></script>

        @livewireStyles
        @livewireScripts

        <!-- Toastr -->
        <link rel="stylesheet" href="vendor/adminlte/plugins/toastr/toastr.min.css">

        <link rel="stylesheet" href="{{ asset('assets/colores.css') }}">
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"
                        onkeydown="if(event.key === 'Enter' || event.key === ' ') { this.click(); }">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="dashboard" class="nav-link">Inicio</a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Sección personalizada para el navbar -->
                @yield('navbar-custom')
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary">
            <!-- Brand Logo lleva al dashboard -->
            <a href="/dashboard" class="brand-link">
            <img src="pictures/Logo Empresas Iansa.png" alt="AdminLTE Logo"  width="200" height="auto"  style="opacity: .8">
            </a>
            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-2 pb-2 mb-2 d-flex align-items-center">
                <!-- Imagen de perfil -->
                <div class="image" style="width: 40px;">
                <img src="pictures/perfil.png" class="img-circle elevation-2" alt="Perfil de usuario">
                </div>

                <!-- Nombre de usuario -->
                <div class="info" style="flex: 1; margin: 0 10px;">
                <a href="#" class="d-block" style="text-decoration: none; font-size: 15px;">{{ $user->nombres }}</a>
                </div>

                <!-- Icono de cerrar sesión -->
                <div class="logout">
                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link p-0" style="color: #c2c7d0; font-size: 15px;"
                        onmouseover="this.style.color='red';"
                        onmouseout="this.style.color='#c2c7d0';"
                        onfocus="this.style.color='red';"
                        onblur="this.style.color='#c2c7d0';">
                    <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2" style="margin-right: 10px;">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false" style="font-size: 15px;">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Menú
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">Dashboard</a>
                    </li>
                    </ul>

                    @if($user->es_administrador)
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                            <a href="/register" class="nav-link">Registrar Usuario</a>
                            </li>
                        </ul>
                    @endif
                </li>

                <!-- Gestion de Activos -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-laptop"></i>
                    <p>
                        Gestión de Activos
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/tablaActivos" class="nav-link">
                            <p>Listado de Activos</p>
                            </a>
                        </li>
                        @if($user->es_administrador)
                            <li class="nav-item">
                            <a href="/registrarActivo" class="nav-link">
                                <p>
                                Dar un activo de alta
                                </p>
                            </a>
                            </li>
                            <li class="nav-item">
                                <a href="/tipos-activo" class="nav-link">
                                <p>
                                    Gestionar tipos de activos
                                </p>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
                <!-- Gestion de Personas -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Gestión de Personas
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/tablaPersonas" class="nav-link">
                        <p>Listado de Personas</p>
                        </a>
                    </li>
                    @if($user->es_administrador)
                        <li class="nav-item">
                        <a href="/registrarPersona" class="nav-link">
                            <p>Registrar nueva persona</p>
                        </a>
                        </li>
                    @endif
                    </ul>
                </li>

                <!-- Gestion de ubicaciones -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-map-marked-alt"></i>
                    <p>
                        Gestión de Ubicaciones
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <!-- registrar ubicacion-->
                    <li class="nav-item">
                        <a href="/ubicaciones" class="nav-link">
                        <p>
                            Listado de ubicaciones
                        </p>
                        </a>
                    </li>
                    <!-- modificar ubicacion-->
                    @if($user->es_administrador)
                        <li class="nav-item">
                        <a href="/registrarUbicacion" class="nav-link">
                            <p>
                            Registrar Ubicación
                            </p>
                        </a>
                        </li>
                    @endif
                    </ul>

                @if($user->es_administrador)
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-import"></i>
                        <p>
                        Importar Datos
                        <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="/importar" class="nav-link">
                            <p>Importar Asignación de Activos</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="/importarActivos" class="nav-link">
                            <p>Importar Activos</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="/importarPersonas" class="nav-link">
                            <p>Importar Personas</p>
                        </a>
                        </li>
                    </ul>
                    </li>
                @endif

                <!--Emportar Excell-->
                <li class="nav-item">
                    <a href="/exportar" class="nav-link">
                    <i class="nav-icon fas fa-file-export"></i>
                    <p>
                        Reportes
                    </p>
                    </a>
                </li>
                <!--Historial de Cambios-->
                <li class="nav-item">
                    <a href="/historial" class="nav-link">
                    <i class="nav-icon fas fa-history"></i>
                    <p>
                        Historial de Cambios
                    </p>
                    </a>
                </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
            </div>
        </aside>

        <!-- Aquí se mostrarán las vistas dinámicas -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Rosario Norte 615, Piso 23. Las Condes Santiago - Chile - Tel. 800 540 099 .</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="vendor/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="vendor/adminlte/dist/js/adminlte.js?v=3.2.0"></script>
    <!-- Select2 -->
    <script src="vendor/adminlte/plugins/select2/js/select2.full.min.js"></script>

    <!-- Toastr -->
    <script src="vendor/adminlte/plugins/toastr/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });
        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>

    @yield('scripts')


    <style>
        .required-asterisk {
            color: red;
        }

        .nav-item a.nav-link:hover {
            background-color: rgba(0, 0, 0, 0.1) !important; /* Oscurece ligeramente */
            transition: background-color 0s ease-in-out; /* Suaviza el cambio */
        }

        .nav-link {
            display: flex;
            align-items: center; /* Alinea verticalmente el icono con el texto */
            white-space: normal; /* Permite el salto de línea */
        }

        .nav-link i {
            flex-shrink: 0; /* Evita que el icono se reduzca de tamaño */
            width: 24px; /* Asegura un tamaño uniforme del icono */
            text-align: center;
        }

        .nav-link p {
            flex-grow: 1; /* Permite que el texto use el espacio disponible */
            margin: 0; /* Evita márgenes innecesarios */
            word-wrap: break-word; /* Rompe palabras largas si es necesario */
        }

        .user-panel {
            display: flex;
            align-items: center; /* Alinea verticalmente los elementos */
            width: 100%;
            padding: 0 10px; /* Añade un poco de padding para evitar que los elementos estén pegados a los bordes */
        }

        .image {
            width: 40px; /* Ancho fijo para la imagen */
            margin-left: -10px; /* Mueve la imagen un poco a la izquierda */
        }

        .info {
            flex: 1; /* Ocupa el espacio restante */
            margin: 0 10px; /* Añade un margen a los lados para separar el nombre del usuario de los otros elementos */
            white-space: nowrap; /* Evita que el nombre de usuario se divida en varias líneas */
            overflow: hidden; /* Oculta el texto que se desborda */
            text-overflow: ellipsis; /* Añade puntos suspensivos si el texto es demasiado largo */
        }

        .logout {
            width: 40px; /* Ancho fijo para el botón de cerrar sesión */
            text-align: right; /* Alinea el icono a la derecha */
            margin-right: -11px; /* Mueve el botón un poco a la derecha */
        }
    </style>
    </body>
</html>
