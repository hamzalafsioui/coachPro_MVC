<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients - CoachPro</title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/coach_clients.css">

    <!-- Global Tailwind Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="<?= BASE_URL ?>/public/assets/js/tailwind.config.js"></script>

</head>

<body class="text-gray-300 font-inter antialiased min-h-screen flex">

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden glass-panel" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed lg:sticky top-0 h-screen w-72 glass-panel border-r border-gray-800 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto">
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

                <a href="<?= BASE_URL ?>/coach/dashboard" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-th-large w-6 text-center group-hover:text-blue-400 transition-colors"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/seances" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-calendar-alt w-6 text-center group-hover:text-cyan-400 transition-colors"></i>
                    <span class="font-medium">My Schedule</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/availability" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-clock w-6 text-center group-hover:text-green-400 transition-colors"></i>
                    <span class="font-medium">Availability</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/reservations" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-clipboard-list w-6 text-center group-hover:text-indigo-400 transition-colors"></i>
                    <span class="font-medium">Reservations</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/clients" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-users w-6 text-center group-hover:text-purple-400 transition-colors"></i>
                    <span class="font-medium">Clients</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/reviews" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-star w-6 text-center group-hover:text-yellow-400 transition-colors"></i>
                    <span class="font-medium">Reviews</span>
                </a>

                <div class="pt-6 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Settings</p>
                </div>

                <a href="<?= BASE_URL ?>/coach/profile" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-user-cog w-6 text-center group-hover:text-blue-400 transition-colors"></i>
                    <span class="font-medium">Profile</span>
                </a>

                <a href="<?= BASE_URL ?>/logout" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-red-500/10 hover:text-red-400 group text-gray-400">
                    <i class="fas fa-sign-out-alt w-6 text-center transition-colors"></i>
                    <span class="font-medium">Logout</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 w-full overflow-y-auto h-screen scroll-smooth">
        <div class="p-8 max-w-7xl mx-auto space-y-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-outfit font-bold text-white mb-2">My Clients</h1>
                    <p class="text-gray-400">Manage your athlete portfolio and track progress.</p>
                </div>

                <!-- Search -->
                <div class="relative w-full md:w-64">
                    <input type="text" id="clientSearch" placeholder="Search clients..." class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-2.5 pl-10 text-white focus:outline-none focus:border-blue-500 transition-colors">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <?php if (empty($clients)): ?>
                <div class="glass-panel p-12 rounded-2xl text-center">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-3xl text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Clients Yet</h3>
                    <p class="text-gray-400 max-w-md mx-auto">Clients will appear here once they book a session with you. Share your profile to get started!</p>
                </div>
            <?php else: ?>
                <!-- Clients Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($clients as $client): ?>
                        <div class="glass-panel p-6 rounded-2xl client-card flex flex-col h-full" data-name="<?= htmlspecialchars($client['name']); ?>" data-plan="<?= htmlspecialchars($client['plan'] ?? 'No plan'); ?>">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-xl font-bold text-white shadow-lg">
                                        <?= $client['avatar'] ?? '?'; ?>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg"><?= htmlspecialchars($client['name']); ?></h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="status-badge status-<?= $client['status'] ?? 'pending'; ?> text-xs" style="padding: 0.2rem 0.6rem; border-radius: 9999px; background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2);">
                                                <?= ucfirst($client['status'] ?? 'pending'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 flex-1">
                                <div>
                                    <p class="text-gray-500 text-xs uppercase font-semibold mb-1">Current Plan</p>
                                    <p class="text-gray-300"><?= htmlspecialchars($client['plan'] ?? 'N/A'); ?></p>
                                </div>

                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-500 font-semibold uppercase">Progress</span>
                                        <span class="text-blue-400"><?= $client['progress'] ?? 0; ?>%</span>
                                    </div>
                                    <div class="w-full bg-gray-700 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-blue-500 h-full transition-all duration-500" style="width: <?= $client['progress'] ?? 0; ?>%"></div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 pt-2">
                                    <div>
                                        <p class="text-gray-500 text-xs uppercase font-semibold mb-1">Joined</p>
                                        <p class="text-gray-300 text-sm"><?= $client['join_date'] ?? 'N/A'; ?></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-xs uppercase font-semibold mb-1">Last Session</p>
                                        <p class="text-gray-300 text-sm"><?= $client['last_session'] ?? 'N/A'; ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <button class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                                    <i class="fas fa-comment-alt"></i> Message
                                </button>
                                <button class="flex-1 bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 py-2 rounded-lg text-sm font-medium transition-colors border border-blue-500/30">
                                    Details
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- JS -->
    <script src="<?= BASE_URL ?>/public/assets/js/coach_clients.js"></script>
</body>

</html>