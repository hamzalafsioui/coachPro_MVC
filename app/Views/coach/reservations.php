<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations - CoachPro</title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/coach_reservations.css">

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

                <a href="<?= BASE_URL ?>/coach/reservations" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-clipboard-list w-6 text-center group-hover:text-indigo-400 transition-colors"></i>
                    <span class="font-medium">Reservations</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/clients" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
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
                    <h1 class="text-3xl font-outfit font-bold text-white mb-2">Reservations</h1>
                    <p class="text-gray-400">Manage all your booking requests and history.</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-2">
                <button class="filter-btn active bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium" data-filter="all">All</button>
                <button class="filter-btn bg-gray-800 text-gray-400 px-5 py-2 rounded-lg text-sm font-medium hover:text-white" data-filter="pending">Pending</button>
                <button class="filter-btn bg-gray-800 text-gray-400 px-5 py-2 rounded-lg text-sm font-medium hover:text-white" data-filter="confirmed">Upcoming</button>
                <button class="filter-btn bg-gray-800 text-gray-400 px-5 py-2 rounded-lg text-sm font-medium hover:text-white" data-filter="completed">Completed</button>
                <button class="filter-btn bg-gray-800 text-gray-400 px-5 py-2 rounded-lg text-sm font-medium hover:text-white" data-filter="cancelled">Cancelled</button>
            </div>

            <!-- Reservations List -->
            <div class="grid grid-cols-1 gap-4">
                <?php if (isset($reservations)): ?>
                    <?php foreach ($reservations as $res): ?>
                        <div class="glass-panel p-6 rounded-2xl reservation-card" data-status="<?= $res['status']; ?>" data-id="<?= $res['id']; ?>">
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                                <!-- Client Info -->
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center text-lg font-bold text-white border border-gray-600 shadow-md">
                                        <?= $res['avatar'] ?? '?'; ?>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg"><?= htmlspecialchars($res['client']); ?></h3>
                                        <div class="flex items-center gap-2 text-sm text-gray-400">
                                            <span><?= htmlspecialchars($res['type']); ?></span>
                                            <span>&bull;</span>
                                            <span><?= $res['price'] ?? 'N/A'; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date & Time -->
                                <div class="flex items-center gap-6">
                                    <div class="text-right md:text-left">
                                        <div class="flex items-center gap-2 text-gray-300">
                                            <i class="fas fa-calendar text-blue-400"></i>
                                            <span><?= date('M d, Y', strtotime($res['date'])); ?></span>
                                        </div>
                                        <div class="flex items-center gap-2 text-gray-400 text-sm mt-1">
                                            <i class="fas fa-clock text-blue-400"></i>
                                            <span><?= htmlspecialchars($res['time']); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div>
                                    <span class="status-badge status-<?= $res['status']; ?>">
                                        <?= ucfirst($res['status']); ?>
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-2 w-full md:w-auto mt-4 md:mt-0">
                                    <?php if ($res['status'] === 'pending'): ?>
                                        <button onclick="handleAction('accept', <?= $res['id']; ?>)" class="flex-1 md:flex-none px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded-lg text-sm font-medium transition-colors">
                                            <i class="fas fa-check mr-1"></i> Accept
                                        </button>
                                        <button onclick="handleAction('decline', <?= $res['id']; ?>)" class="flex-1 md:flex-none px-4 py-2 bg-red-600/20 hover:bg-red-600/40 text-red-500 rounded-lg text-sm font-medium transition-colors border border-red-600/30">
                                            <i class="fas fa-times mr-1"></i> Decline
                                        </button>
                                    <?php elseif ($res['status'] === 'confirmed'): ?>
                                        <button onclick="handleAction('cancel', <?= $res['id']; ?>)" class="flex-1 md:flex-none px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-300 rounded-lg text-sm font-medium transition-colors">
                                            Cancel
                                        </button>
                                    <?php else: ?>
                                        <button class="flex-1 md:flex-none px-4 py-2 bg-gray-800 text-gray-500 rounded-lg text-sm font-medium cursor-not-allowed">
                                            Archived
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-500 py-12">No reservations found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- JS -->
    <script src="<?= BASE_URL ?>/public/assets/js/coach_reservations.js"></script>
</body>

</html>