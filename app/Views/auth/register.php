<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CoachPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="<?= BASE_URL ?>/public/assets/js/tailwind.config.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="<?= BASE_URL ?>/" class="inline-flex items-center space-x-3 mb-6">
                <span class="text-white text-3xl font-outfit font-bold">CoachPro</span>
            </a>
            <h1 class="text-4xl font-outfit font-bold text-white mb-2">Create Account</h1>
        </div>

        <div class="glass-dark rounded-2xl p-8 shadow-2xl">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="mb-6 p-4 rounded-lg bg-red-500/20 border border-red-500/50 text-red-200">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form id="registerForm" action="<?= BASE_URL ?>/register" method="POST" class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="firstname" class="form-input w-full p-2 rounded bg-gray-700 text-white" placeholder="First Name" required>
                    <input type="text" name="lastname" class="form-input w-full p-2 rounded bg-gray-700 text-white" placeholder="Last Name" required>
                </div>
                <input type="email" name="email" class="form-input w-full p-2 rounded bg-gray-700 text-white" placeholder="Email" required>
                <input type="tel" name="phone" class="form-input w-full p-2 rounded bg-gray-700 text-white" placeholder="Phone">
                <input type="password" name="password" class="form-input w-full p-2 rounded bg-gray-700 text-white" placeholder="Password" required>
                <input type="password" name="confirm_password" class="form-input w-full p-2 rounded bg-gray-700 text-white" placeholder="Confirm Password" required>

                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="sportif" class="peer sr-only" checked>
                        <div class="p-4 border border-gray-600 rounded peer-checked:bg-blue-600 text-center text-white">Athlete</div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="coach" class="peer sr-only">
                        <div class="p-4 border border-gray-600 rounded peer-checked:bg-cyan-600 text-center text-white">Coach</div>
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 py-3 rounded-lg text-white font-semibold hover:bg-blue-500 transition">Create Account</button>
            </form>
            <div class="text-center pt-4 border-t border-gray-700">
                <p class="text-gray-400">
                    Already have an account?
                    <a href="<?= BASE_URL ?>/login" class="text-blue-400 hover:text-blue-300 font-semibold smooth-transition">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>