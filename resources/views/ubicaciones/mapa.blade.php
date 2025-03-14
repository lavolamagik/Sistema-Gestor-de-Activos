<div class="card bg-gradient-primary">
    <div class="card-header border-0 ui-sortable-handle" style="cursor: move; background-color: #50ACB8;">
        <h3 class="card-title">
            <i class="fas fa-map-marker-alt mr-1"></i>
            Mapa de activos por ubicación
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" id="center-map-btn" class="btn btn-primary btn-sm" title="Centrar Mapa">
                <i class="fas fa-crosshairs"></i>
            </button>
        </div>
    </div>

    <div class="card-body" style="background-color: #50ACB8;">
        <div id="chile-map" style="height: 100%; width: 100%;"></div>
    </div>

</div>

<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/export-data.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/cl/cl-all.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Array generado dinámicamente desde PHP
        const ubicaciones = JSON.parse('{!! json_encode($ubicaciones) !!}');
        const cantidadPorUbicacion = JSON.parse('{!! json_encode($cantidadPorUbicacion) !!}');

        // Transformar datos para Highcharts
        const puntosUbicaciones = ubicaciones.map(ubicacion => ({
            id: ubicacion.id,
            name: ubicacion.sitio,
            lat: parseFloat(ubicacion.latitud),
            lon: parseFloat(ubicacion.longitud),
            activos: cantidadPorUbicacion[ubicacion.sitio] || 0,
            color: '#FF0000'
        }));

        // Calcular automáticamente el centro y zoom en función de las ubicaciones
        const latitudes = puntosUbicaciones.map(punto => punto.lat);
        const longitudes = puntosUbicaciones.map(punto => punto.lon);
        const minLat = Math.min(...latitudes);
        const maxLat = Math.max(...latitudes);
        const minLon = Math.min(...longitudes);
        const maxLon = Math.max(...longitudes);

        const centerLat = (minLat + maxLat) / 2;
        const centerLon = (minLon + maxLon) / 2;

        // Configuración del mapa
        const chart = Highcharts.mapChart('chile-map', {
            chart: {
                map: 'countries/cl/cl-all', // Mapa de Chile
                backgroundColor: '#50ACB8',
                panning: {
                    enabled: true
                },
                panKey: 'shift' // Habilitar arrastre con Shift
            },
            title: {
                text: 'Mapa de Chile',
                style: {
                    color: '#ffffff' // Opcional: Cambia el color del título si el fondo es oscuro
                }
            },
            mapNavigation: {
                enabled: true,
                enableMouseWheelZoom: true, // Permitir zoom con el scroll
                buttons: {
                    zoomIn: {
                        onclick: function () {
                            this.mapView.zoomBy(1); // Zoom in
                            console.log('Zoom In: Nivel actual de zoom:', this.mapView.zoom);
                        }
                    },
                    zoomOut: {
                        onclick: function () {
                            this.mapView.zoomBy(-1); // Zoom out
                            console.log('Zoom Out: Nivel actual de zoom:', this.mapView.zoom);
                        }
                    }
                }
            },
            mapView: {
                // Definir las coordenadas iniciales del centro del mapa y el zoom
                center: {
                    x: centerLon,
                    y: centerLat
                },
                zoom: -2.5
            },
            tooltip: {
                headerFormat: '<b>{point.key}</b><br>',
                pointFormat: 'Activos: {point.activos}' // Mostrar cantidad de activos en el tooltip
            },
            series: [
                {
                    name: 'Regiones',
                    color: '#E0E0E0',
                    enableMouseTracking: true
                },
                {
                    type: 'mappoint',
                    name: 'Ubicaciones',
                    data: puntosUbicaciones, // Usar los puntos generados
                    marker: {
                        symbol: 'circle',
                        radius: 8,
                        fillColor: '#0aa40d', // Rojo para destacar el punto
                        lineColor: '#000000',
                        lineWidth: 1
                    },
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}', // Mostrar solo el nombre del lugar en la etiqueta
                        color: '#FFFFFF',
                        style: {
                            textOutline: '1px contrast'
                        }
                    },
                    point: {
                        events: {
                            click: function () {
                                updateUbicacion(this.id); // Pasa el nombre de la ubicación a la función
                            }
                        }
                    }
                }
            ]
        });

        // Añadir evento al botón para centrar el mapa
        document.getElementById('center-map-btn').addEventListener('click', function () {
            // Convertir latitud y longitud a coordenadas X e Y de Highcharts
            const projectedCenter = chart.mapView.lonLatToProjectedUnits({ lon: centerLon, lat: centerLat });
            // Centrar el mapa usando las coordenadas proyectadas
            chart.mapView.setView([projectedCenter.x, projectedCenter.y], -2.5);
            console.log('Mapa centrado en:', projectedCenter);
        });


        console.log('Centro calculado:', { centerLat, centerLon });
    });
</script>
