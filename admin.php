<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login2.php");
    exit;
}

// Conexão com o banco de dados MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alencar_veiculos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para obter todos os veículos
function getVehicles($conn) {
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
    return $vehicles;
}

$vehicles = getVehicles($conn);
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel Administrativo - Alencar Veículos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/main.css" />
</head>
<body class="bg-gray-100 font-[Inter]">
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="index.php" title="Alencar Veículos" class="inline-block">
                    <img src="https://images.pexels.com/photos/235986/pexels-photo-235986.jpeg" alt="Alencar Veículos Logo" class="h-12 w-auto" />
                </a>
                <form method="post" action="logout.php">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Sair</button>
                </form>
                <a href="login2.html" class="hidden"></a>
            </div>
        </div>
    </nav>

    <main class="pt-20 container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6">Painel Administrativo - Gerenciar Veículos</h1>

        <button id="add-vehicle-button" class="mb-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded">Adicionar Veículo</button>

        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-3 px-6 bg-gray-200 font-bold text-left">Título</th>
                    <th class="py-3 px-6 bg-gray-200 font-bold text-left">Marca</th>
                    <th class="py-3 px-6 bg-gray-200 font-bold text-left">Ano</th>
                    <th class="py-3 px-6 bg-gray-200 font-bold text-left">Preço</th>
                    <th class="py-3 px-6 bg-gray-200 font-bold text-left">Ações</th>
                </tr>
            </thead>
            <tbody id="vehicles-table-body">
                <?php if (count($vehicles) === 0): ?>
                    <tr><td colspan="5" class="text-center">Nenhum veículo cadastrado.</td></tr>
                <?php else: ?>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicle['title']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicle['brand']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicle['year']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicle['price']); ?></td>
                            <td class="border px-4 py-2 space-x-2">
                                <button class="edit-button bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded" data-id="<?php echo htmlspecialchars($vehicle['id']); ?>">Editar</button>
                                <button class="delete-button bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" data-id="<?php echo htmlspecialchars($vehicle['id']); ?>">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal para adicionar/editar veículo -->
        <div id="vehicle-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
            <div class="bg-white rounded-lg p-8 max-w-lg w-full mx-4">
                <h2 id="modal-title" class="text-2xl font-bold mb-6">Adicionar Veículo</h2>
                <form id="vehicle-form" class="space-y-4">
                    <input type="hidden" id="vehicle-id" name="id" />
                    <div>
                        <label for="title" class="block text-gray-700 mb-2">Título</label>
                        <input type="text" id="title" name="title" class="w-full p-3 border border-gray-300 rounded-lg" required />
                    </div>
                    <div>
                        <label for="brand" class="block text-gray-700 mb-2">Marca</label>
                        <input type="text" id="brand" name="brand" class="w-full p-3 border border-gray-300 rounded-lg" required />
                    </div>
                    <div>
                        <label for="year" class="block text-gray-700 mb-2">Ano</label>
                        <input type="number" id="year" name="year" class="w-full p-3 border border-gray-300 rounded-lg" required />
                    </div>
                    <div>
                        <label for="price" class="block text-gray-700 mb-2">Preço</label>
                        <input type="text" id="price" name="price" class="w-full p-3 border border-gray-300 rounded-lg" required />
                    </div>
                    <div>
                        <label for="km" class="block text-gray-700 mb-2">Quilometragem</label>
                        <input type="text" id="km" name="km" class="w-full p-3 border border-gray-300 rounded-lg" required />
                    </div>
                    <div>
                        <label for="fuel" class="block text-gray-700 mb-2">Combustível</label>
                        <input type="text" id="fuel" name="fuel" class="w-full p-3 border border-gray-300 rounded-lg" required />
                    </div>
                    <div>
                        <label for="transmission" class="block text-gray-700 mb-2">Câmbio</label>
                        <input type="text" id="transmission" name="transmission" class="w-full p-3 border border-gray-300 rounded-lg" required />
                    </div>
                    <div>
                        <label for="images" class="block text-gray-700 mb-2">URLs das Imagens (separadas por vírgula)</label>
                        <textarea id="images" name="images" class="w-full p-3 border border-gray-300 rounded-lg" rows="3" required></textarea>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" id="cancel-button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded">Cancelar</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="js/admin.js"></script>
</body>
</html>
