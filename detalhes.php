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

// Obter o ID do veículo da URL
$vehicleId = isset($_GET['id']) ? $_GET['id'] : '';

$vehicle = null;
$images = [];

if ($vehicleId) {
    // Consulta para obter os dados do veículo
    $stmt = $conn->prepare("SELECT id, title, price, brand, year, km, fuel, transmission, description FROM vehicles WHERE id = ?");
    $stmt->bind_param("s", $vehicleId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $vehicle = $result->fetch_assoc();

        // Consulta para obter as imagens do veículo
        $stmtImages = $conn->prepare("SELECT image_url FROM vehicle_images WHERE vehicle_id = ?");
        $stmtImages->bind_param("s", $vehicleId);
        $stmtImages->execute();
        $resultImages = $stmtImages->get_result();
        while ($row = $resultImages->fetch_assoc()) {
            $images[] = $row['image_url'];
        }
        $stmtImages->close();
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detalhes do Veículo - Alencar Veículos</title>
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

    <!-- Vehicle Details -->
    <main class="pt-20">
        <section class="gallery-container py-8">
            <div class="container mx-auto px-4">
                <?php if ($vehicle): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Main Image -->
                    <div class="main-image-container">
                        <img id="main-image" src="<?php echo htmlspecialchars($images[0] ?? ''); ?>" alt="<?php echo htmlspecialchars($vehicle['title']); ?>" class="w-full h-[400px] object-cover rounded-lg shadow-lg" />
                        <!-- Thumbnails -->
                        <div class="grid grid-cols-4 gap-2 mt-4" id="thumbnails-container">
                            <?php foreach ($images as $index => $img): ?>
                                <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($vehicle['title'] . ' - Imagem ' . ($index + 1)); ?>" class="gallery-thumbnail w-full h-20 object-cover rounded cursor-pointer <?php echo $index === 0 ? 'active' : ''; ?>" />
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="vehicle-info">
                        <h1 id="vehicle-title" class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($vehicle['title']); ?></h1>
                        <div id="vehicle-price" class="text-3xl font-bold text-blue-600 mb-6"><?php echo htmlspecialchars($vehicle['price']); ?></div>

                        <!-- Specifications -->
                        <div id="vehicle-specs" class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-gray-50 p-4 rounded">
                                <span class="text-gray-600">Quilometragem</span>
                                <p class="font-semibold"><?php echo htmlspecialchars($vehicle['km']); ?></p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded">
                                <span class="text-gray-600">Ano</span>
                                <p class="font-semibold"><?php echo htmlspecialchars($vehicle['year']); ?></p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded">
                                <span class="text-gray-600">Combustível</span>
                                <p class="font-semibold"><?php echo htmlspecialchars($vehicle['fuel']); ?></p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded">
                                <span class="text-gray-600">Câmbio</span>
                                <p class="font-semibold"><?php echo htmlspecialchars($vehicle['transmission']); ?></p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div id="vehicle-description" class="bg-gray-50 p-6 rounded-lg">
                            <?php echo nl2br(htmlspecialchars($vehicle['description'])); ?>
                        </div>

                        <!-- Contact Buttons -->
                        <div class="space-y-4 mt-6">
                            <button id="whatsapp-button" class="w-full bg-green-500 hover:bg-green-600 text-white py-3 px-6 rounded-lg flex items-center justify-center transition" onclick="window.open('https://wa.me/5511999999999?text=Olá! Tenho interesse no <?php echo rawurlencode($vehicle['title']); ?>', '_blank')">
                                <i class="fab fa-whatsapp mr-2 text-xl"></i>
                                Contato via WhatsApp
                            </button>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                    <p class="text-center text-red-600">Veículo não encontrado.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script src="js/main5.js"></script>
</body>
</html>
