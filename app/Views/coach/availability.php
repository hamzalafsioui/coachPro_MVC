<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Availability - CoachPro</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="<?= BASE_URL ?>/public/assets/js/tailwind.config.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/coach_availability.css">
</head>

<body class="text-gray-300 font-inter antialiased min-h-screen flex">

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay"
        class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden glass-panel"
        onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed lg:sticky top-0 h-screen w-72 glass-panel border-r border-gray-800 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto">
        <div class="p-6">
            <!-- Logo -->
            <div class="flex items-center space-x-3 mb-10">
                <div class="w-10 h-10 bg-gradient-to-tr from-blue-500 to-cyan-400 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <i class="fas fa-dumbbell text-white text-xl"></i>
                </div>
                <span class="text-white text-xl font-outfit font-bold tracking-tight">CoachPro</span>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Menu</p>

                <a href="<?= BASE_URL ?>/coach/dashboard" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white text-gray-400">
                    <i class="fas fa-th-large w-6 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/seances" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white text-gray-400">
                    <i class="fas fa-calendar-alt w-6 text-center"></i>
                    <span>My Schedule</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/availability" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white text-gray-400">
                    <i class="fas fa-clock w-6 text-center"></i>
                    <span>Availability</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/reservations" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white text-gray-400">
                    <i class="fas fa-clipboard-list w-6 text-center"></i>
                    <span>Reservations</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/clients" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white text-gray-400">
                    <i class="fas fa-users w-6 text-center"></i>
                    <span>Clients</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/reviews" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white text-gray-400">
                    <i class="fas fa-star w-6 text-center"></i>
                    <span>Reviews</span>
                </a>

                <div class="pt-6">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Settings</p>
                </div>

                <a href="<?= BASE_URL ?>/coach/profile" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white text-gray-400">
                    <i class="fas fa-user-cog w-6 text-center"></i>
                    <span>Profile</span>
                </a>

                <a href="<?= BASE_URL ?>/logout" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all hover:bg-red-500/10 hover:text-red-400 text-gray-400">
                    <i class="fas fa-sign-out-alt w-6 text-center"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 w-full overflow-y-auto h-screen scroll-smooth">

        <!-- Top Header (matches second file) -->
        <header class="h-16 border-b border-gray-800 flex items-center px-8 glass-panel">
            <button class="lg:hidden mr-4" onclick="toggleSidebar()">
                <i class="fas fa-bars text-gray-300"></i>
            </button>
            <h2 class="text-white font-outfit font-semibold text-lg">
                Manage Availability
            </h2>
        </header>

        <div class="p-8 max-w-6xl mx-auto space-y-8">

            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-outfit font-bold text-white mb-2">Availability Settings</h1>
                    <p class="text-gray-400">Set your weekly recurring schedule.</p>
                </div>
                <button onclick="saveAvailability()"
                    class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white px-8 py-3 rounded-xl font-medium shadow-lg shadow-blue-500/25 transition-all transform hover:scale-105 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Save Changes</span>
                </button>
            </div>

            <!-- Weekly Schedule -->
            <div class="space-y-6">
                <?php foreach ($availability as $day => $data): ?>
                    <div class="glass-panel p-6 rounded-2xl day-card" id="<?= $day ?>-card">
                        <div class="flex flex-col md:flex-row gap-6">

                            <!-- Day Toggle -->
                            <div class="w-full md:w-48 flex items-center justify-between gap-4">
                                <h3 class="capitalize font-bold text-lg text-white w-24"><?= $day ?></h3>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox"
                                        id="<?= $day ?>-toggle"
                                        class="sr-only peer"
                                        <?= $data['active'] ? 'checked' : '' ?>>
                                    <div class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:bg-blue-600
                                                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                                after:bg-white after:rounded-full after:h-5 after:w-5
                                                after:transition-all peer-checked:after:translate-x-full"></div>
                                </label>
                            </div>

                            <!-- Time Slots -->
                            <div class="flex-1 <?= $data['active'] ? '' : 'opacity-50 pointer-events-none' ?>"
                                id="<?= $day ?>-slots">

                                <div id="<?= $day ?>-slots-container">
                                    <?php foreach ($data['slots'] as $slot): ?>
                                        <div class="flex items-center gap-2 mb-2 time-slot">
                                            <input type="time" name="<?= $day ?>_start[]" value="<?= $slot[0] ?>"
                                                class="time-input bg-gray-800 border-gray-700 rounded-lg px-3 py-2 text-sm text-white w-32">
                                            <span class="text-gray-500">-</span>
                                            <input type="time" name="<?= $day ?>_end[]" value="<?= $slot[1] ?>"
                                                class="time-input bg-gray-800 border-gray-700 rounded-lg px-3 py-2 text-sm text-white w-32">
                                            <button type="button"
                                                onclick="this.parentElement.remove()"
                                                class="text-red-400 hover:text-red-300 p-2">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <button type="button"
                                    id="<?= $day ?>-add-btn"
                                    class="mt-2 text-sm text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Add Interval</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- JS -->
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
        console.log('BASE_URL:', BASE_URL);
    </script>
    <script src="<?= BASE_URL ?>/public/assets/js/coach_availability.js?v=<?= time() ?>"></script>

</body>

</html>