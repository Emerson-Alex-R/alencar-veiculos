<?php
// Conexão com o banco de dados MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alencar_veiculos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sobre Nós - Alencar Veículos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/main.css" />
</head>
<body class="font-[Inter]">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="index.php" title="Alencar Veículos" class="inline-block">
                    <img src="https://images.pexels.com/photos/235986/pexels-photo-235986.jpeg" alt="Alencar Veículos Logo" class="h-12 w-auto" />
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="index.php" class="text-gray-800 hover:text-blue-600 transition">Início</a>
                    <a href="estoque.php" class="text-gray-800 hover:text-blue-600 transition">Estoque</a>
                    <a href="sobre-nos.php" class="text-gray-800 hover:text-blue-600 transition">Sobre Nós</a>
                </div>
                <button class="md:hidden text-gray-800" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="py-4 space-y-4">
                    <a href="index.php" class="block text-gray-800 hover:text-blue-600 transition">Início</a>
                    <a href="estoque.php" class="block text-gray-800 hover:text-blue-600 transition">Estoque</a>
                    <a href="sobre-nos.php" class="block text-gray-800 hover:text-blue-600 transition">Sobre Nós</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="bg-gray-800 text-white pt-24 pb-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4">Sobre Nós</h1>
            <p class="text-gray-300">Conheça nossa história e compromisso com a qualidade</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-12">
        <div class="container mx-auto px-4">
            <!-- Company Story -->
            <section class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h2 class="text-3xl font-bold mb-6">Nossa História</h2>
                    <p class="text-gray-700 mb-4">
                        Há mais de 15 anos no mercado, a Alencar Veículos se destaca pela excelência no comércio de veículos seminovos e usados. Nossa história começou com um sonho de oferecer carros de qualidade com o melhor custo-benefício para nossos clientes.
                    </p>
                    <p class="text-gray-700">
                        Ao longo dos anos, construímos uma reputação sólida baseada na transparência, honestidade e compromisso com a satisfação total de nossos clientes. Cada veículo em nosso estoque passa por rigorosas avaliações técnicas para garantir a máxima qualidade.
                    </p>
                </div>
                <div>
                    <img src="https://images.pexels.com/photos/4489734/pexels-photo-4489734.jpeg" alt="Equipe Alencar Veículos" class="w-full h-[400px] object-cover rounded-lg shadow-lg">
                </div>
            </section>

            <!-- Our Values -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold mb-8 text-center">Nossos Valores</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <i class="fas fa-handshake text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-bold mb-3">Transparência</h3>
                        <p class="text-gray-700">
                            Prezamos pela honestidade em todas as negociações, fornecendo informações claras e precisas sobre nossos veículos.
                        </p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <i class="fas fa-award text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-bold mb-3">Qualidade</h3>
                        <p class="text-gray-700">
                            Todos os nossos veículos passam por rigorosas inspeções técnicas para garantir a máxima qualidade e segurança.
                        </p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <i class="fas fa-heart text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-bold mb-3">Compromisso</h3>
                        <p class="text-gray-700">
                            Nosso compromisso é com a satisfação total dos nossos clientes, oferecendo o melhor atendimento e pós-venda.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Our Team -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold mb-8 text-center">Nossa Equipe</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <img src="https://images.pexels.com/photos/3184338/pexels-photo-3184338.jpeg" alt="Consultor de Vendas" class="w-full h-64 object-cover rounded-lg shadow-lg mb-4">
                        <h3 class="text-xl font-bold mb-2">Departamento de Vendas</h3>
                        <p class="text-gray-700">
                            Profissionais experientes prontos para encontrar o veículo ideal para você.
                        </p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.pexels.com/photos/3184339/pexels-photo-3184339.jpeg" alt="Equipe Técnica" class="w-full h-64 object-cover rounded-lg shadow-lg mb-4">
                        <h3 class="text-xl font-bold mb-2">Equipe Técnica</h3>
                        <p class="text-gray-700">
                            Mecânicos especializados que garantem a qualidade de nossos veículos.
                        </p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg" alt="Suporte ao Cliente" class="w-full h-64 object-cover rounded-lg shadow-lg mb-4">
                        <h3 class="text-xl font-bold mb-2">Atendimento ao Cliente</h3>
                        <p class="text-gray-700">
                            Suporte dedicado para melhor atender suas necessidades.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="bg-gray-50 rounded-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-6">Entre em Contato</h2>
                        <p class="text-gray-700 mb-6">
                            Estamos sempre prontos para atender você da melhor forma possível. Entre em contato conosco para tirar suas dúvidas ou agendar uma visita.
                        </p>
                        <div class="space-y-4">
                            <p class="flex items-center text-gray-700">
                                <i class="fas fa-phone mr-3 text-blue-600"></i>
                                (86) 98877-7808
                            </p>
                            <p class="flex items-center text-gray-700">
                                <i class="fas fa-envelope mr-3 text-blue-600"></i>
                                contato@alencarveiculos.com
                            </p>
                            <p class="flex items-center text-gray-700">
                                <i class="fas fa-map-marker-alt mr-3 text-blue-600"></i>
                                Av. Barão de Gurguéia, 1814 - Vermelha, Teresina - PI, 64018-290
                            </p>
                        </div>
                    </div>
                    <div>
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3975.095095927927!2d-42.81409168521244!3d-5.091927956011091!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7b2a4a3a0a0a0a0a%3A0x123456789abcdef!2sAv.%20Bar%C3%A3o%20de%20Gurgu%C3%A9ia%2C%201814%20-%20Vermelha%2C%20Teresina%20-%20PI%2C%2064018-290!5e0!3m2!1spt-BR!2sbr!4v1683300000000!5m2!1spt-BR!2sbr" 
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            class="rounded-lg shadow-lg">
                        </iframe>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <a href="index.php" title="Alencar Veículos" class="inline-block mb-4">
                        <img src="https://images.pexels.com/photos/235986/pexels-photo-235986.jpeg" alt="Alencar Veículos Logo" class="h-12 w-auto">
                    </a>
                    <p class="text-gray-400">Seu carro novo está aqui</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contato</h3>
                    <p class="text-gray-400 mb-2">
                        <i class="fas fa-phone mr-2"></i> (86) 98877-7808
                    </p>
                    <p class="text-gray-400 mb-2">
                        <i class="fas fa-envelope mr-2"></i> contato@alencarveiculos.com
                    </p>
                    <p class="text-gray-400">
                        <i class="fas fa-map-marker-alt mr-2"></i> Av. Barão de Gurguéia, 1814 - Vermelha, Teresina - PI, 64018-290
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Horário de Funcionamento</h3>
                    <p class="text-gray-400 mb-2">Segunda-feira: 08:00–18:00</p>
                    <p class="text-gray-400 mb-2">Terça-feira: 08:00–18:00</p>
                    <p class="text-gray-400 mb-2">Quarta-feira: 08:00–18:00</p>
                    <p class="text-gray-400 mb-2">Quinta-feira: 08:00–18:00</p>
                    <p class="text-gray-400 mb-2">Sexta-feira: 08:00–18:00</p>
                    <p class="text-gray-400 mb-2">Sábado: 08:00–12:00</p>
                    <p class="text-gray-400">Domingo: Fechado</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Alencar Veículos. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="js/main5.js"></script>
</body>
</html>
