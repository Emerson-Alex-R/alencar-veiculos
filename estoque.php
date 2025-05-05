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

// Consulta para obter todos os veículos
$sql = "SELECT v.id, v.title, v.price, v.brand, v.year, v.km, v.fuel, v.transmission, vi.image_url
        FROM vehicles v
        LEFT JOIN vehicle_images vi ON v.id = vi.vehicle_id
        GROUP BY v.id
        ORDER BY v.id ASC";
$result = $conn->query($sql);
$vehicles = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Estoque - Alencar Veículos</title>
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
            <h1 class="text-4xl font-bold mb-4">Nosso Estoque</h1>
            <p class="text-gray-300">Encontre o veículo perfeito para você</p>
        </div>
    </header>

    <!-- Filters Section -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <form id="filter-form" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" id="search" name="search" placeholder="Buscar por modelo, marca..." class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" />
                <select id="marca" name="marca" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas as Marcas</option>
                    <option value="bmw">BMW</option>
                    <option value="range-rover">Range Rover</option>
                    <option value="toyota">Toyota</option>
                </select>
                <select id="ano" name="ano" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos os Anos</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>
                <select id="preco" name="preco" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas as Faixas de Preço</option>
                    <option value="ate-150">Até R$ 150.000</option>
                    <option value="acima-150">Acima de R$ 150.000</option>
                </select>
            </form>
        </div>
    </section>

    <!-- Vehicles Grid -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div id="vehicles-container" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php if (count($vehicles) === 0): ?>
                    <p class="text-center text-gray-600">Nenhum veículo encontrado.</p>
                <?php else: ?>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <a href="detalhes.php?id=<?php echo urlencode($vehicle['id']); ?>" class="block">
                            <div class="vehicle-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300" data-marca="<?php echo htmlspecialchars($vehicle['brand']); ?>" data-ano="<?php echo htmlspecialchars($vehicle['year']); ?>" data-preco="<?php echo htmlspecialchars(preg_replace('/\D/', '', $vehicle['price'])); ?>">
                                <img src="<?php echo htmlspecialchars($vehicle['image_url']); ?>" alt="<?php echo htmlspecialchars($vehicle['title']); ?>" loading="lazy" class="w-full h-48 object-cover" />
                                <div class="p-6">
                                    <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($vehicle['title']); ?></h3>
                                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($vehicle['transmission'] . ', ' . $vehicle['fuel'] . ', ' . $vehicle['km']); ?></p>
                                    <div class="grid grid-cols-2 gap-2 mb-4 text-sm text-gray-700">
                                        <div><strong>Quilometragem:</strong> <?php echo htmlspecialchars($vehicle['km']); ?></div>
                                        <div><strong>Ano:</strong> <?php echo htmlspecialchars($vehicle['year']); ?></div>
                                        <div><strong>Combustível:</strong> <?php echo htmlspecialchars($vehicle['fuel']); ?></div>
                                        <div><strong>Câmbio:</strong> <?php echo htmlspecialchars($vehicle['transmission']); ?></div>
                                    </div>
                                    <div class="text-2xl font-bold text-blue-600 mb-4"><?php echo htmlspecialchars($vehicle['price']); ?></div>
                                    <div class="text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                                        Ver Detalhes
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <a href="index.php" title="Alencar Veículos" class="inline-block mb-4">
                        <img src="https://images.pexels.com/photos/235986/pexels-photo-235986.jpeg" alt="Alencar Veículos Logo" class="h-12 w-auto" />
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
