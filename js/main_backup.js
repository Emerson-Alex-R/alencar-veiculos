// Wrap everything in an IIFE to avoid global scope pollution
(function() {
    'use strict';

    // Mobile menu functionality
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Vehicle filtering functionality
    const setupFilters = () => {
        const filterForm = document.getElementById('filter-form');
        const vehiclesContainer = document.getElementById('vehicles-container');

        if (filterForm && vehiclesContainer) {
            filterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                
                try {
                    const marca = document.getElementById('marca').value;
                    const ano = document.getElementById('ano').value;
                    const preco = document.getElementById('preco').value;

                    // Get all vehicle cards
                    const vehicles = vehiclesContainer.querySelectorAll('.vehicle-card');

                    vehicles.forEach(vehicle => {
                        const shouldShow = filterVehicle(vehicle, marca, ano, preco);
                        vehicle.style.display = shouldShow ? 'block' : 'none';
                    });

                    // Show message if no results
                    const visibleVehicles = vehiclesContainer.querySelectorAll('.vehicle-card[style="display: block"]');
                    const noResultsMessage = document.getElementById('no-results');
                    
                    if (visibleVehicles.length === 0) {
                        if (!noResultsMessage) {
                            const message = document.createElement('p');
                            message.id = 'no-results';
                            message.className = 'text-center text-gray-600 py-8';
                            message.textContent = 'Nenhum veículo encontrado com os filtros selecionados.';
                            vehiclesContainer.appendChild(message);
                        }
                    } else if (noResultsMessage) {
                        noResultsMessage.remove();
                    }
                } catch (error) {
                    console.error('Error filtering vehicles:', error);
                    showErrorMessage('Ocorreu um erro ao filtrar os veículos. Por favor, tente novamente.');
                }
            });
        }
    };

    // Vehicle filtering helper function
    const filterVehicle = (vehicleCard, marca, ano, preco) => {
        if (!marca && !ano && !preco) return true;

        const vehicleMarca = vehicleCard.dataset.marca;
        const vehicleAno = vehicleCard.dataset.ano;
        const vehiclePreco = parseInt(vehicleCard.dataset.preco);

        const matchMarca = !marca || vehicleMarca === marca;
        const matchAno = !ano || vehicleAno === ano;
        const matchPreco = !preco || checkPrecoRange(vehiclePreco, preco);

        return matchMarca && matchAno && matchPreco;
    };

    // Price range checker
    const checkPrecoRange = (preco, range) => {
        const ranges = {
            'ate-50': preco <= 50000,
            '50-100': preco > 50000 && preco <= 100000,
            '100-150': preco > 100000 && preco <= 150000,
            'acima-150': preco > 150000
        };
        return ranges[range];
    };

    // Vehicle gallery functionality
    const setupGallery = () => {
        const mainImage = document.getElementById('main-image');
        const thumbnails = document.querySelectorAll('.gallery-thumbnail');

        if (mainImage && thumbnails.length > 0) {
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', () => {
                    try {
                        // Update main image
                        mainImage.src = thumbnail.src;
                        mainImage.alt = thumbnail.alt;

                        // Update active state
                        thumbnails.forEach(t => t.classList.remove('active'));
                        thumbnail.classList.add('active');
                    } catch (error) {
                        console.error('Error updating gallery image:', error);
                        showErrorMessage('Erro ao carregar a imagem. Por favor, tente novamente.');
                    }
                });
            });
        }
    };

    // Contact form modal functionality
    const setupModal = () => {
        const contactButtons = document.querySelectorAll('[data-modal-target]');
        const closeButtons = document.querySelectorAll('[data-close-modal]');
        const modals = document.querySelectorAll('.modal');

        contactButtons.forEach(button => {
            button.addEventListener('click', () => {
                try {
                    const modal = document.querySelector(button.dataset.modalTarget);
                    openModal(modal);
                } catch (error) {
                    console.error('Error opening modal:', error);
                }
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                try {
                    const modal = button.closest('.modal');
                    closeModal(modal);
                } catch (error) {
                    console.error('Error closing modal:', error);
                }
            });
        });

        // Close modal on outside click
        modals.forEach(modal => {
            modal.addEventListener('click', e => {
                if (e.target === modal) {
                    closeModal(modal);
                }
            });
        });

        // Close modal on Escape key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                modals.forEach(modal => {
                    if (modal.classList.contains('active')) {
                        closeModal(modal);
                    }
                });
            }
        });
    };

    const openModal = (modal) => {
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };

    const closeModal = (modal) => {
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    // Contact form validation and submission
    const setupContactForm = () => {
        const contactForm = document.getElementById('contact-form');

        if (contactForm) {
            contactForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                try {
                    const formData = new FormData(contactForm);
                    const data = Object.fromEntries(formData.entries());

                    // Validate form data
                    const errors = validateContactForm(data);
                    if (Object.keys(errors).length > 0) {
                        showFormErrors(errors);
                        return;
                    }

                    // Show loading state
                    const submitButton = contactForm.querySelector('button[type="submit"]');
                    const originalButtonText = submitButton.textContent;
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<div class="spinner mr-2"></div> Enviando...';

                    // Simulate form submission (replace with actual API call)
                    await new Promise(resolve => setTimeout(resolve, 1500));

                    // Show success message
                    showSuccessMessage('Mensagem enviada com sucesso! Entraremos em contato em breve.');
                    contactForm.reset();

                    // Close modal after delay
                    setTimeout(() => {
                        const modal = contactForm.closest('.modal');
                        if (modal) closeModal(modal);
                    }, 2000);

                } catch (error) {
                    console.error('Error submitting form:', error);
                    showErrorMessage('Erro ao enviar mensagem. Por favor, tente novamente.');
                } finally {
                    // Reset button state
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                }
            });
        }
    };

    // Form validation helper
    const validateContactForm = (data) => {
        const errors = {};

        if (!data.name?.trim()) {
            errors.name = 'Nome é obrigatório';
        }

        if (!data.email?.trim()) {
            errors.email = 'Email é obrigatório';
        } else if (!isValidEmail(data.email)) {
            errors.email = 'Email inválido';
        }

        if (!data.message?.trim()) {
            errors.message = 'Mensagem é obrigatória';
        }

        return errors;
    };

    // Email validation helper
    const isValidEmail = (email) => {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    };

    // Error display helpers
    const showFormErrors = (errors) => {
        // Clear existing error messages
        document.querySelectorAll('.error-message').forEach(el => el.remove());

        // Show new error messages
        Object.entries(errors).forEach(([field, message]) => {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = message;
                input.parentNode.appendChild(errorDiv);
            }
        });
    };

    const showErrorMessage = (message) => {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative';
        errorDiv.role = 'alert';
        errorDiv.textContent = message;

        document.body.appendChild(errorDiv);
        setTimeout(() => errorDiv.remove(), 5000);
    };

    const showSuccessMessage = (message) => {
        const successDiv = document.createElement('div');
        successDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative';
        successDiv.role = 'alert';
        successDiv.textContent = message;

        document.body.appendChild(successDiv);
        setTimeout(() => successDiv.remove(), 5000);
    };

    // Initialize all functionality when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        setupFilters();
        setupGallery();
        setupModal();
        setupContactForm();
    });
})();
