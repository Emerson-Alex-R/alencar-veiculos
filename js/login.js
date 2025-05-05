// JavaScript para gerenciar o login do administrador

(function() {
    'use strict';

    const loginForm = document.getElementById('login-form');
    const loginError = document.getElementById('login-error');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = loginForm.username.value.trim();
            const password = loginForm.password.value.trim();

            // Simulação simples de autenticação
            if (username === 'admin' && password === 'admin123') {
                // Armazenar estado de login no localStorage
                localStorage.setItem('isAdminLoggedIn', 'true');
                // Redirecionar para o painel administrativo
                window.location.href = 'admin.html';
            } else {
                if (loginError) {
                    loginError.textContent = 'Usuário ou senha inválidos.';
                    loginError.classList.remove('hidden');
                }
            }
        });
    }
})();
