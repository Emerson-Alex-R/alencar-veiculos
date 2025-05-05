<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: admin.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simulação simples de autenticação
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['loggedin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = 'Usuário ou senha inválidos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Alencar Veículos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/main.css" />
</head>
<body class="bg-gray-100 font-[Inter] flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Área do Administrador</h1>
        <?php if ($error): ?>
            <p class="text-red-600 mb-4 text-center"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post" class="space-y-6">
            <div>
                <label for="username" class="block text-gray-700 mb-2">Usuário</label>
                <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required />
            </div>
            <div>
                <label for="password" class="block text-gray-700 mb-2">Senha</label>
                <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required />
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition">Entrar</button>
        </form>
    </div>
</body>
</html>
