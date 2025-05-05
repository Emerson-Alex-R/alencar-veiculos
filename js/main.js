(function() {
    'use strict';

    const vehiclesContainer = document.getElementById('vehicles-container');
    const filterForm = document.getElementById('filter-form');
    let vehiclesData = [];

    // Fetch vehicle data from JSON and render cards
    async function fetchAndRenderVehicles() {
        try {
            const response = await fetch('/vehicles.json');
            vehiclesData = await response.json();
            renderVehicles(vehiclesData);
        } catch (error) {
            console.error('Error fetching vehicle data:', error);
            vehiclesContainer.innerHTML = '<p class="text-center text-red-600">Erro ao carregar os veículos.</p>';
        }
    }

    // Render vehicle cards dynamically
    function renderVehicles(vehicles) {
        if (!vehicles || vehicles.length === 0) {
            vehiclesContainer.innerHTML = '<p class="text-center text-gray-600">Nenhum veículo encontrado.</p>';
            return;
        }
        vehiclesContainer.innerHTML = vehicles.map(vehicle => `
            <a href="veiculos/${vehicle.id}.html" class="block">
                <div class="vehicle-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300" data-marca="${vehicle.brand}" data-ano="${vehicle.year}" data-preco="${parsePrice(vehicle.price)}">
                    <img src="${vehicle.images[0]}" alt="${vehicle.title}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">${vehicle.title}</h3>
                        <p class="text-gray-600 mb-4">${vehicle.transmission}, ${vehicle.fuel}, ${vehicle.km}</p>
                        <div class="text-2xl font-bold text-blue-600 mb-4">${vehicle.price}</div>
                        <div class="text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                            Ver Detalhes
                        </div>
                    </div>
                </div>
            </a>
        `).join('');
    }

    // Parse price string to number for filtering
    function parsePrice(priceStr) {
        return Number(priceStr.replace(/[^\d]/g, ''));
    }

    // Filter vehicles based on form inputs
    function filterVehicles() {
        const search = filterForm.search.value.toLowerCase();
        const marca = filterForm.marca.value;
        const ano = filterForm.ano.value;
        const preco = filterForm.preco.value;

        const filtered = vehiclesData.filter(vehicle => {
            const matchesSearch = vehicle.title.toLowerCase().includes(search) || vehicle.brand.toLowerCase().includes(search);
            const matchesMarca = !marca || vehicle.brand === marca;
            const matchesAno = !ano || vehicle.year === ano;
            const priceNum = parsePrice(vehicle.price);
            let matchesPreco = true;
            if (preco === 'ate-150') {
                matchesPreco = priceNum <= 150000;
            } else if (preco === 'acima-150') {
                matchesPreco = priceNum > 150000;
            }
            return matchesSearch && matchesMarca && matchesAno && matchesPreco;
        });

        renderVehicles(filtered);
    }

    // Event listener for filter form
    if (filterForm) {
        filterForm.addEventListener('input', () => {
            filterVehicles();
        });
    }

    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        fetchAndRenderVehicles();
    });
})();
