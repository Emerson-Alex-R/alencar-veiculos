// Admin panel JavaScript for managing vehicle inventory

(function() {
    'use strict';

    const vehiclesTableBody = document.getElementById('vehicles-table-body');
    const vehicleForm = document.getElementById('vehicle-form');
    const vehicleModal = document.getElementById('vehicle-modal');
    const modalTitle = document.getElementById('modal-title');
    const addVehicleButton = document.getElementById('add-vehicle-button');
    const cancelButton = document.getElementById('cancel-button');

    let vehiclesData = [];
    let editingVehicleId = null;

    // Load vehicles from vehicles.json or localStorage
    async function loadVehicles() {
        try {
            const storedVehicles = localStorage.getItem('vehiclesData');
            if (storedVehicles) {
                vehiclesData = JSON.parse(storedVehicles);
            } else {
                const response = await fetch('/vehicles.json');
                vehiclesData = await response.json();
                saveVehicles();
            }
            renderVehiclesTable();
        } catch (error) {
            console.error('Erro ao carregar veículos:', error);
            vehiclesTableBody.innerHTML = '<tr><td colspan="5" class="text-center text-red-600">Erro ao carregar veículos.</td></tr>';
        }
    }

    // Save vehicles to localStorage
    function saveVehicles() {
        localStorage.setItem('vehiclesData', JSON.stringify(vehiclesData));
    }

    // Render vehicles in the table
    function renderVehiclesTable() {
        if (!vehiclesData.length) {
            vehiclesTableBody.innerHTML = '<tr><td colspan="5" class="text-center">Nenhum veículo cadastrado.</td></tr>';
            return;
        }
        vehiclesTableBody.innerHTML = vehiclesData.map(vehicle => `
            <tr>
                <td class="border px-4 py-2">${vehicle.title}</td>
                <td class="border px-4 py-2">${vehicle.brand}</td>
                <td class="border px-4 py-2">${vehicle.year}</td>
                <td class="border px-4 py-2">${vehicle.price}</td>
                <td class="border px-4 py-2 space-x-2">
                    <button class="edit-button bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded" data-id="${vehicle.id}">Editar</button>
                    <button class="delete-button bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" data-id="${vehicle.id}">Excluir</button>
                </td>
            </tr>
        `).join('');
        attachTableEventListeners();
    }

    // Attach event listeners to edit and delete buttons
    function attachTableEventListeners() {
        const editButtons = document.querySelectorAll('.edit-button');
        const deleteButtons = document.querySelectorAll('.delete-button');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                openEditModal(id);
            });
        });

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                if (confirm('Tem certeza que deseja excluir este veículo?')) {
                    deleteVehicle(id);
                }
            });
        });
    }

    // Open modal to add new vehicle
    addVehicleButton.addEventListener('click', () => {
        editingVehicleId = null;
        modalTitle.textContent = 'Adicionar Veículo';
        vehicleForm.reset();
        openModal();
    });

    // Open modal to edit vehicle
    function openEditModal(id) {
        const vehicle = vehiclesData.find(v => v.id === id);
        if (!vehicle) return;
        editingVehicleId = id;
        modalTitle.textContent = 'Editar Veículo';
        vehicleForm.id.value = vehicle.id;
        vehicleForm.title.value = vehicle.title;
        vehicleForm.brand.value = vehicle.brand;
        vehicleForm.year.value = vehicle.year;
        vehicleForm.price.value = vehicle.price;
        vehicleForm.km.value = vehicle.km;
        vehicleForm.fuel.value = vehicle.fuel;
        vehicleForm.transmission.value = vehicle.transmission;
        vehicleForm.images.value = vehicle.images.join(', ');
        vehicleForm.description.value = vehicle.description;
        openModal();
    }

    // Delete vehicle
    function deleteVehicle(id) {
        vehiclesData = vehiclesData.filter(v => v.id !== id);
        saveVehicles();
        renderVehiclesTable();
    }

    // Open modal
    function openModal() {
        vehicleModal.classList.remove('hidden');
    }

    // Close modal
    function closeModal() {
        vehicleModal.classList.add('hidden');
    }

    // Cancel button closes modal
    cancelButton.addEventListener('click', () => {
        closeModal();
    });

    // Handle form submission for add/edit
    vehicleForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(vehicleForm);
        const vehicleData = {
            id: formData.get('id') || generateId(),
            title: formData.get('title').trim(),
            brand: formData.get('brand').trim(),
            year: formData.get('year').trim(),
            price: formData.get('price').trim(),
            km: formData.get('km').trim(),
            fuel: formData.get('fuel').trim(),
            transmission: formData.get('transmission').trim(),
            images: formData.get('images').split(',').map(s => s.trim()),
            description: formData.get('description').trim()
        };

        if (editingVehicleId) {
            // Edit existing
            const index = vehiclesData.findIndex(v => v.id === editingVehicleId);
            if (index !== -1) {
                vehiclesData[index] = vehicleData;
            }
        } else {
            // Add new
            vehiclesData.push(vehicleData);
        }

        saveVehicles();
        renderVehiclesTable();
        closeModal();
    });

    // Generate unique ID for new vehicle
    function generateId() {
        return 'vehicle-' + Date.now();
    }

    // Check if admin is logged in
    function checkLogin() {
        const isLoggedIn = localStorage.getItem('isAdminLoggedIn');
        if (!isLoggedIn) {
            window.location.href = 'login.html';
        }
    }

    // Logout button
    const logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', () => {
            localStorage.removeItem('isAdminLoggedIn');
            window.location.href = 'login.html';
        });
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        checkLogin();
        loadVehicles();
    });
})();
