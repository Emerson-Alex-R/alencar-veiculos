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

// Consulta para obter os 3 primeiros veículos
$sql = "SELECT v.id, v.title, v.price, v.brand, v.year, v.km, v.fuel, v.transmission, vi.image_url
        FROM vehicles v
        LEFT JOIN vehicle_images vi ON v.id = vi.vehicle_id
        GROUP BY v.id
        ORDER BY v.id ASC
        LIMIT 3";
$result = $conn->query($sql);
$featuredVehicles = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $featuredVehicles[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Alencar Veículos - Seu Carro Novo Está Aqui</title>
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

    <!-- Hero Section -->
    <header class="min-h-screen flex items-center justify-center relative bg-cover bg-center" style="background-image: url('https://images.pexels.com/photos/3802510/pexels-photo-3802510.jpeg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative text-center text-white px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Encontre o Carro dos Seus Sonhos</h1>
            <p class="text-xl md:text-2xl mb-8">Os melhores veículos com as melhores condições</p>
            <a href="estoque.php" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-semibold transition">
                Ver Nosso Estoque
            </a>
        </div>
    </header>

    <!-- Featured Vehicles -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Veículos em Destaque</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($featuredVehicles as $vehicle): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <img src="<?php echo htmlspecialchars($vehicle['image_url']); ?>" alt="<?php echo htmlspecialchars($vehicle['title']); ?>" class="w-full h-48 object-cover" />
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($vehicle['title']); ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($vehicle['transmission'] . ', ' . $vehicle['fuel'] . ', ' . $vehicle['km']); ?></p>
                        <div class="text-2xl font-bold text-blue-600 mb-4"><?php echo htmlspecialchars($vehicle['price']); ?></div>
                        <a href="detalhes.php?id=<?php echo urlencode($vehicle['id']); ?>" class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
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
