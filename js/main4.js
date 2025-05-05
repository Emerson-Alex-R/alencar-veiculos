(function() {
    'use strict';

    const vehiclesContainer = document.getElementById('vehicles-container');
    const filterForm = document.getElementById('filter-form');
    const featuredVehiclesContainer = document.getElementById('featured-vehicles-container');
    let vehiclesData = [];

    // Fetch vehicle data from JSON and render cards
    async function fetchAndRenderVehicles() {
        try {
            const response = await fetch('/vehicles.json');
            vehiclesData = await response.json();
            renderVehicles(vehiclesData);
            renderFeaturedVehicles(vehiclesData);
        } catch (error) {
            console.error('Error fetching vehicle data:', error);
            if (vehiclesContainer) {
                vehiclesContainer.innerHTML = '<p class="text-center text-red-600">Erro ao carregar os veículos.</p>';
            }
            if (featuredVehiclesContainer) {
                featuredVehiclesContainer.innerHTML = '<p class="text-center text-red-600">Erro ao carregar os veículos em destaque.</p>';
            }
        }
    }

    // Render vehicle cards dynamically with main characteristics
    function renderVehicles(vehicles) {
        if (!vehicles || vehicles.length === 0) {
            if (vehiclesContainer) {
                vehiclesContainer.innerHTML = '<p class="text-center text-gray-600">Nenhum veículo encontrado.</p>';
            }
            return;
        }
        if (vehiclesContainer) {
            vehiclesContainer.innerHTML = vehicles.map(vehicle => `
                <a href="detalhes.html?id=${vehicle.id}" class="block">
                    <div class="vehicle-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300" data-marca="${vehicle.brand}" data-ano="${vehicle.year}" data-preco="${parsePrice(vehicle.price)}">
                        <img src="${vehicle.images[0]}" alt="${vehicle.title}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">${vehicle.title}</h3>
                            <p class="text-gray-600 mb-4">${vehicle.transmission}, ${vehicle.fuel}, ${vehicle.km}</p>
                            <div class="grid grid-cols-2 gap-2 mb-4 text-sm text-gray-700">
                                <div><strong>Quilometragem:</strong> ${vehicle.km}</div>
                                <div><strong>Ano:</strong> ${vehicle.year}</div>
                                <div><strong>Combustível:</strong> ${vehicle.fuel}</div>
                                <div><strong>Câmbio:</strong> ${vehicle.transmission}</div>
                            </div>
                            <div class="text-2xl font-bold text-blue-600 mb-4">${vehicle.price}</div>
                            <div class="text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                                Ver Detalhes
                            </div>
                        </div>
                    </div>
                </a>
            `).join('');
        }
    }

    // Render the first 3 vehicles as featured on index.html
    function renderFeaturedVehicles(vehicles) {
        if (!vehicles || vehicles.length === 0) {
            if (featuredVehiclesContainer) {
                featuredVehiclesContainer.innerHTML = '<p class="text-center text-gray-600">Nenhum veículo em destaque.</p>';
            }
            return;
        }
        const featured = vehicles.slice(0, 3);
        if (featuredVehiclesContainer) {
            featuredVehiclesContainer.innerHTML = featured.map(vehicle => `
                <a href="detalhes.html?id=${vehicle.id}" class="block">
                    <div class="vehicle-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
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
    }

    // Parse price string to number for filtering
    function parsePrice(priceStr) {
        return Number(priceStr.replace(/[^\d]/g, ''));
    }

    // Filter vehicles based on form inputs
    function filterVehicles() {
        if (!filterForm) return;
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

    // Contact form submission handling on detalhes.html
    function setupContactForm() {
        const contactForm = document.getElementById('contact-form');
        if (!contactForm) return;

        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Simple validation
            const name = contactForm.name.value.trim();
            const email = contactForm.email.value.trim();
            const phone = contactForm.phone.value.trim();
            const message = contactForm.message.value.trim();

            if (!name || !email || !phone || !message) {
                alert('Por favor, preencha todos os campos do formulário.');
                return;
            }

            // Simulate form submission
            alert('Mensagem enviada com sucesso! Entraremos em contato em breve.');

            // Reset form
            contactForm.reset();

            // Close modal
            const modal = document.getElementById('contact-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        });
    }

    // Setup gallery for vehicle details page
    function setupGallery() {
        const mainImage = document.getElementById('main-image');
        const thumbnailsContainer = document.getElementById('thumbnails-container');

        if (!mainImage || !thumbnailsContainer) return;

        thumbnailsContainer.addEventListener('click', (e) => {
            if (e.target && e.target.classList.contains('gallery-thumbnail')) {
                mainImage.src = e.target.src;
                mainImage.alt = e.target.alt;

                const thumbnails = thumbnailsContainer.querySelectorAll('.gallery-thumbnail');
                thumbnails.forEach(t => t.classList.remove('active'));
                e.target.classList.add('active');
            }
        });
    }

    // Render vehicle details on detalhes.html
    async function renderVehicleDetails() {
        const params = new URLSearchParams(window.location.search);
        const vehicleId = params.get('id');
        if (!vehicleId) return;

        try {
            const response = await fetch('/vehicles.json');
            const vehicles = await response.json();
            const vehicle = vehicles.find(v => v.id === vehicleId);
            if (!vehicle) return;

            // Set title, price, description
            const titleEl = document.getElementById('vehicle-title');
            const priceEl = document.getElementById('vehicle-price');
            const descEl = document.getElementById('vehicle-description');
            const specsEl = document.getElementById('vehicle-specs');
            const whatsappBtn = document.getElementById('whatsapp-button');

            if (titleEl) titleEl.textContent = vehicle.title;
            if (priceEl) priceEl.textContent = vehicle.price;
            if (descEl) descEl.textContent = vehicle.description;

            // Render specs
            if (specsEl) {
                specsEl.innerHTML = `
                    <div class="bg-gray-50 p-4 rounded">
                        <span class="text-gray-600">Quilometragem</span>
                        <p class="font-semibold">${vehicle.km}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <span class="text-gray-600">Ano</span>
                        <p class="font-semibold">${vehicle.year}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <span class="text-gray-600">Combustível</span>
                        <p class="font-semibold">${vehicle.fuel}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <span class="text-gray-600">Câmbio</span>
                        <p class="font-semibold">${vehicle.transmission}</p>
                    </div>
                `;
            }

            // Set main image and thumbnails
            const mainImage = document.getElementById('main-image');
            const thumbnailsContainer = document.getElementById('thumbnails-container');
            if (mainImage && thumbnailsContainer) {
                mainImage.src = vehicle.images[0];
                mainImage.alt = vehicle.title;
                thumbnailsContainer.innerHTML = vehicle.images.map((img, idx) => `
                    <img src="${img}" alt="${vehicle.title} - Imagem ${idx + 1}" class="gallery-thumbnail w-full h-20 object-cover rounded cursor-pointer ${idx === 0 ? 'active' : ''}" />
                `).join('');
            }

            // Setup WhatsApp contact link
            if (whatsappBtn) {
                const message = encodeURIComponent(`Olá! Tenho interesse no ${vehicle.title}`);
                whatsappBtn.onclick = () => {
                    window.open(`https://wa.me/5511999999999?text=${message}`, '_blank');
                };
            }

            setupGallery();

            setupContactForm();

        } catch (error) {
            console.error('Error loading vehicle details:', error);
        }
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
        if (vehiclesContainer) {
            fetchAndRenderVehicles();
            if (filterForm) {
                filterForm.addEventListener('input', () => {
                    filterVehicles();
                });
            }
        }
        if (document.getElementById('vehicle-title')) {
            renderVehicleDetails();
        }
    });
})();
