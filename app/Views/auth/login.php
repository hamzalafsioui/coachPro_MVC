<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CoachPro</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="<?= BASE_URL ?>/public/assets/js/tailwind.config.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="<?= BASE_URL ?>/home" class="inline-flex items-center space-x-3 mb-6">
                <span class="text-white text-3xl font-outfit font-bold">CoachPro</span>
            </a>
            <h1 class="text-4xl font-outfit font-bold text-white mb-2">Welcome Back</h1>
        </div>

        <div class="glass-dark rounded-2xl p-8 shadow-2xl">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="mb-6 p-4 rounded-lg bg-red-500/20 border border-red-500/50 text-red-200">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="mb-6 p-4 rounded-lg bg-green-500/20 border border-green-500/50 text-green-200">' . htmlspecialchars($_SESSION['success']) . '</div>';
                unset($_SESSION['success']);
            }
            ?>

            <form id="loginForm" action="<?= BASE_URL ?>/login" method="POST" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input w-full p-2 rounded bg-gray-700 text-white" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input type="password" id="password" name="password" class="form-input w-full p-2 rounded bg-gray-700 text-white" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 py-3 rounded-lg text-white font-semibold hover:bg-blue-500 transition">Sign In</button>
            </form>
            <div class="text-center pt-4 border-t border-gray-700">
                <p class="text-gray-400">
                    Don't have an account?
                    <a href="<?= BASE_URL ?>/register" class="text-blue-400 hover:text-blue-300 font-semibold smooth-transition">Create Account</a>
                </p>
            </div>
        </div>
    </div>
    <script src="<?= BASE_URL ?>/public/assets/js/main.js"></script>
</body>


</html>