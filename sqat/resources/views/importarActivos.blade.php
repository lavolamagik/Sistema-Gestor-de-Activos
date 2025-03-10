@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header" style="background-color: #34848c; color: white;">
                            <h3 class="card-title mb-0">Importar Datos de Activos</h3>
                        </div>
                        <div class="card-body">
                            <!-- Success Message -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Error Message -->
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Excel Import Form -->
                            <form id="importForm" action="{{ route('importar.excel.activos') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="file" name="archivo_excel" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block" style="background-color: #36cc36;">
                                    <i class="fas fa-file-import"></i> Importar Datos
                                </button>
                            </form>

                            <!-- Tabs for Imported Data and Errors -->
                            @if ((isset($activos) && count($activos) > 0) || (isset($errores) && count($errores) > 0))
                                <hr class="my-4">
                                <ul class="nav nav-tabs" id="importTabs" role="tablist">
                                    @if (isset($activos) && count($activos) > 0)
                                        <li class="nav-item">
                                            <a class="nav-link active" id="success-tab" data-toggle="tab" href="#success" role="tab" aria-controls="success" aria-selected="true">
                                                <i class="fas fa-check-circle text-success"></i> Datos Importados ({{ count($activos) }})
                                            </a>
                                        </li>
                                    @endif
                                    @if (isset($errores) && count($errores) > 0)
                                        <li class="nav-item">
                                            <a class="nav-link" id="errors-tab" data-toggle="tab" href="#errors" role="tab" aria-controls="errors" aria-selected="false">
                                                <i class="fas fa-exclamation-circle text-danger"></i> Errores ({{ count($errores) }})
                                            </a>
                                        </li>
                                    @endif
                                </ul>

                                <div class="tab-content" id="importTabsContent">
                                    <!-- Success Tab -->
                                    @if (isset($activos) && count($activos) > 0)
                                        <div class="tab-pane fade show active" id="success" role="tabpanel" aria-labelledby="success-tab">
                                            <div class="table-responsive mt-3">
                                                <table id="tablaDatos" class="table table-bordered table-striped table-hover">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Nro Serie</th>
                                                            <th>Marca</th>
                                                            <th>Modelo</th>
                                                            <th>Tipo de Activo</th>
                                                            <th>Estado</th>
                                                            <th>Ubicación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($activos as $activo)
                                                            @if (!empty(array_filter($activo)))
                                                                <tr>
                                                                    <td>{{ $activo['nro_serie'] }}</td>
                                                                    <td>{{ $activo['marca'] }}</td>
                                                                    <td>{{ $activo['modelo'] }}</td>
                                                                    <td>{{ $activo['tipo_de_activo'] }}</td>
                                                                    <td>{{ $activo['estado'] }}</td>
                                                                    <td>{{ $activo['ubicacion'] }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Errors Tab -->
                                    @if (isset($errores) && count($errores) > 0)
                                        <div class="tab-pane fade" id="errors" role="tabpanel" aria-labelledby="errors-tab">
                                            <div class="table-responsive mt-3">
                                                <table id="tablaErrores" class="table table-bordered table-danger table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nro Serie</th>
                                                            <th>Marca</th>
                                                            <th>Modelo</th>
                                                            <th>Tipo de Activo</th>
                                                            <th>Ubicación</th>
                                                            <th>Motivo del Error</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($errores as $error)
                                                            @if (!empty(array_filter($error['fila'])))
                                                                <tr>
                                                                    @foreach ($error['fila'] as $cell)
                                                                        <td>{{ $cell ?? '-' }}</td>
                                                                    @endforeach
                                                                    <td>{{ $error['motivo'] }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Download Template Button -->
                            <div class="text-center mt-4">
                                <a href="{{ route('descargarActivos.excel') }}" class="btn btn-secondary">
                                    <i class="fas fa-file-excel mr-2"></i> Descargar Plantilla Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#tablaDatos, #tablaErrores').DataTable({
                responsive: false,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });

            // Custom file input
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });
        });
    </script>
@endsection