@php
// Obtener los datos de tributos una sola vez
$tributos = $this->getTributos();
@endphp

<x-filament::page>
    <div>
        <!-- Contenedor del mapa -->
        <div id="tributo-map" class="rounded-xl border border-gray-300 shadow-sm mb-4" style="height: 600px;"></div>
        
        <!-- Información de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="fi-card rounded-xl shadow-sm p-4">
                <h3 class="text-lg font-medium">Total de tributos en mapa</h3>
                <p class="text-3xl font-bold text-primary-600 dark:text-primary-500">{{ count($tributos) }}</p>
            </div>
            
            <div class="fi-card rounded-xl shadow-sm p-4">
                <h3 class="text-lg font-medium">Países representados</h3>
                <p class="text-3xl font-bold text-primary-600 dark:text-primary-500">{{ count(collect($tributos)->pluck('pais')->filter()->unique()) }}</p>
            </div>
            
            <div class="fi-card rounded-xl shadow-sm p-4">
                <h3 class="text-lg font-medium">Ciudades representadas</h3>
                <p class="text-3xl font-bold text-primary-600 dark:text-primary-500">{{ count(collect($tributos)->pluck('ciudad')->filter()->unique()) }}</p>
            </div>
        </div>
        
        <!-- Mensaje si no hay tributos -->
        @if(count($tributos) === 0)
            <div class="p-4 bg-orange-50 dark:bg-gray-800 rounded-lg border border-orange-200 dark:border-gray-700">
                <p class="text-orange-700 dark:text-gray-300">No hay tributos disponibles para mostrar en el mapa. Los tributos deben estar aprobados, tener coordenadas de ubicación y estar marcados para mostrarse en el mapa.</p>
            </div>
        @endif
    </div>
    
    <!-- Leaflet CSS -->
    @pushOnce('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <style>
            /* Estilos base para ambos temas */
            #tributo-map {
                transition: border-color 0.3s ease;
            }
            
            /* Estilos personalizados para tema claro/oscuro que se aplicarán con JS */
            .leaflet-popup-content h3 {
                font-weight: bold;
            }

            .leaflet-popup-content p {
                line-height: 1.4;
            }
            
            .leaflet-popup-content img {
                object-fit: cover;
            }
            
            /* Clases de tema que se aplicarán mediante JavaScript */
            .popup-light {
                background-color: #ffffff;
                color: #111827;
            }
            
            .popup-dark {
                background-color: #1f2937;
                color: #e5e7eb;
            }
            
            .popup-light h3 {
                color: #a16207;
            }
            
            .popup-dark h3 {
                color: #f59e0b;
            }
        </style>
    @endPushOnce
    
    <!-- Script para inicializar el mapa con Leaflet -->
    @pushOnce('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            // Inicializar con los datos
            document.addEventListener('DOMContentLoaded', function() {
                let map;
                let lightTileLayer;
                let darkTileLayer;
                let currentMarkers = [];
                const tributos = @json($tributos);
                
                // Función para inicializar el mapa
                function initMap() {
                    // Inicializar el mapa de Leaflet
                    map = L.map('tributo-map', {
                        attributionControl: true,
                        zoomControl: true
                    }).setView([0, 0], 2);
                    
                    // Definir ambas capas (clara y oscura)
                    lightTileLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="https://carto.com/attributions">CARTO</a>',
                        subdomains: 'abcd',
                        maxZoom: 19
                    });
                    
                    darkTileLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="https://carto.com/attributions">CARTO</a>',
                        subdomains: 'abcd',
                        maxZoom: 19
                    });
                    
                    // Determinar si está en modo oscuro
                    if (document.documentElement.classList.contains('dark')) {
                        darkTileLayer.addTo(map);
                        applyDarkStyles();
                    } else {
                        lightTileLayer.addTo(map);
                        applyLightStyles();
                    }
                    
                    addMarkers();
                }
                
                // Función para agregar los marcadores
                function addMarkers() {
                    if (!map || tributos.length === 0) return;
                    
                    // Remover marcadores existentes
                    currentMarkers.forEach(marker => map.removeLayer(marker));
                    currentMarkers = [];
                    
                    // Determinar el icono basado en el tema
                    const isDark = document.documentElement.classList.contains('dark');
                    const iconUrl = isDark 
                        ? 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png' 
                        : 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png';
                    
                    const customIcon = L.icon({
                        iconUrl: iconUrl,
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });
                    
                    // Crear marcadores para cada tributo
                    const markers = [];
                    tributos.forEach(tributo => {
                        const marker = L.marker([tributo.lat, tributo.lng], {icon: customIcon}).addTo(map);
                        
                        // Crear el contenido del popup
                        const popupContent = `
                            <div class="p-3 max-w-xs ${isDark ? 'popup-dark' : 'popup-light'}">
                                <div class="flex items-center mb-2">
                                    ${tributo.foto ? `<img src="${tributo.foto}" class="w-10 h-10 rounded-full mr-3">` : ''}
                                    <div>
                                        <h3 class="font-bold">${tributo.nombre}</h3>
                                        <p class="text-xs opacity-80">${tributo.relacion || 'Anónimo'}</p>
                                    </div>
                                </div>
                                <p class="text-sm">${tributo.mensaje}</p>
                                <div class="mt-2 text-xs opacity-70">
                                    ${tributo.ciudad ? `${tributo.ciudad}, ` : ''}${tributo.pais || ''}
                                </div>
                            </div>
                        `;
                        
                        // Añadir popup al marcador
                        marker.bindPopup(popupContent);
                        markers.push(marker);
                        currentMarkers.push(marker);
                    });
                    
                    // Crear un grupo de marcadores para ajustar el zoom
                    const group = new L.featureGroup(markers);
                    map.fitBounds(group.getBounds().pad(0.1)); // Añadir un poco de padding
                    
                    // Si hay demasiado zoom, limitarlo
                    if (map.getZoom() > 12) {
                        map.setZoom(12);
                    }
                }
                
                // Aplicar estilos de modo oscuro
                function applyDarkStyles() {
                    const mapContainer = document.getElementById('tributo-map');
                    
                    // Estilo para los popups
                    const styleSheet = document.createElement('style');
                    styleSheet.id = 'map-custom-styles';
                    styleSheet.textContent = `
                        .leaflet-popup-content-wrapper {
                            background-color: #1f2937 !important;
                            color: #e5e7eb !important;
                            border-radius: 0.5rem !important;
                        }
                        .leaflet-popup-tip {
                            background-color: #1f2937 !important;
                        }
                        .leaflet-control-zoom a {
                            background-color: #374151 !important;
                            color: #e5e7eb !important;
                            border-color: #4b5563 !important;
                        }
                        .leaflet-control-zoom a:hover {
                            background-color: #4b5563 !important;
                        }
                        .leaflet-control-attribution {
                            background-color: rgba(31, 41, 55, 0.8) !important;
                            color: #9ca3af !important;
                        }
                        .leaflet-control-attribution a {
                            color: #d1d5db !important;
                        }
                    `;
                    
                    const existingStyle = document.getElementById('map-custom-styles');
                    if (existingStyle) {
                        existingStyle.remove();
                    }
                    
                    document.head.appendChild(styleSheet);
                    mapContainer.className = mapContainer.className.replace('border-gray-300', 'border-gray-700');
                }
                
                // Aplicar estilos de modo claro
                function applyLightStyles() {
                    const mapContainer = document.getElementById('tributo-map');
                    
                    // Estilo para los popups
                    const styleSheet = document.createElement('style');
                    styleSheet.id = 'map-custom-styles';
                    styleSheet.textContent = `
                        .leaflet-popup-content-wrapper {
                            background-color: #ffffff !important;
                            color: #111827 !important;
                            border-radius: 0.5rem !important;
                        }
                        .leaflet-popup-tip {
                            background-color: #ffffff !important;
                        }
                        .leaflet-control-zoom a {
                            background-color: #ffffff !important;
                            color: #111827 !important;
                            border-color: #e5e7eb !important;
                        }
                        .leaflet-control-zoom a:hover {
                            background-color: #f3f4f6 !important;
                        }
                        .leaflet-control-attribution {
                            background-color: rgba(255, 255, 255, 0.8) !important;
                            color: #4b5563 !important;
                        }
                        .leaflet-control-attribution a {
                            color: #1f2937 !important;
                        }
                    `;
                    
                    const existingStyle = document.getElementById('map-custom-styles');
                    if (existingStyle) {
                        existingStyle.remove();
                    }
                    
                    document.head.appendChild(styleSheet);
                    mapContainer.className = mapContainer.className.replace('border-gray-700', 'border-gray-300');
                }
                
                // Inicializar el mapa
                initMap();
                
                // Detectar cambios en el tema
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === 'class' && 
                            mutation.target === document.documentElement) {
                            
                            const isDark = document.documentElement.classList.contains('dark');
                            
                            if (isDark) {
                                if (map) {
                                    map.removeLayer(lightTileLayer);
                                    darkTileLayer.addTo(map);
                                    applyDarkStyles();
                                }
                            } else {
                                if (map) {
                                    map.removeLayer(darkTileLayer);
                                    lightTileLayer.addTo(map);
                                    applyLightStyles();
                                }
                            }
                            
                            // Re-crear los marcadores para actualizar los popups
                            addMarkers();
                        }
                    });
                });
                
                observer.observe(document.documentElement, { attributes: true });
            });
        </script>
    @endPushOnce
</x-filament::page> 