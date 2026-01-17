<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Coaches - CoachPro</title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/sportif_coaches.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/sportif_profile.css">

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

                <a href="<?= BASE_URL ?>/sportif/dashboard" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-th-large w-6 text-center group-hover:text-blue-400 transition-colors"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="<?= BASE_URL ?>/sportif/coaches" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-search w-6 text-center group-hover:text-cyan-400 transition-colors"></i>
                    <span class="font-medium">Find Coaches</span>
                </a>

                <a href="<?= BASE_URL ?>/sportif/seances" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-clipboard-list w-6 text-center group-hover:text-indigo-400 transition-colors"></i>
                    <span class="font-medium">My Bookings</span>
                </a>

                <div class="pt-6 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Settings</p>
                </div>

                <a href="<?= BASE_URL ?>/sportif/profile" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
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
                    <h1 class="text-3xl font-outfit font-bold text-white mb-2">Find a Coach</h1>
                    <p class="text-gray-400">Discover top-rated coaches tailored to your goals.</p>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-6 py-4 rounded-2xl flex items-center gap-3">
                    <i class="fas fa-check-circle"></i>
                    <p class="text-sm font-medium"><?= $_SESSION['success'];
                                                    unset($_SESSION['success']); ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-6 py-4 rounded-2xl flex items-center gap-3">
                    <i class="fas fa-exclamation-circle"></i>
                    <p class="text-sm font-medium"><?= $_SESSION['error'];
                                                    unset($_SESSION['error']); ?></p>
                </div>
            <?php endif; ?>

            <!-- Filters -->
            <div class="glass-panel p-4 rounded-2xl flex flex-col md:flex-row gap-4 items-center">
                <div class="search-input-wrapper flex-1 w-full relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <input type="text" id="coachSearch" placeholder="Search by name..." class="w-full bg-gray-800 border-none rounded-xl py-3 pl-12 pr-4 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="w-full md:w-auto">
                    <select id="specialtyFilter" class="w-full bg-gray-800 text-white border-none rounded-xl py-3 px-6 focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                        <option value="all">All Specialties</option>
                        <?php if (isset($sports)): ?>
                            <?php foreach ($sports as $sport): ?>
                                <option value="<?= htmlspecialchars(strtolower($sport['name'])); ?>">
                                    <?= htmlspecialchars($sport['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- Coaches Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (isset($coaches)): ?>
                    <?php foreach ($coaches as $coach): ?>
                        <div class="glass-panel rounded-2xl p-6 coach-card group relative" data-name="<?= htmlspecialchars($coach['name']); ?>" data-specialties="<?= isset($coach['specialties']) ? strtolower(implode(' ', $coach['specialties'])) : ''; ?>" data-id="<?= $coach['id']; ?>">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-16 h-16 rounded-xl bg-gray-800 flex items-center justify-center text-3xl text-gray-400 coach-img-wrapper">
                                    <i class="<?= $coach['image'] ?? 'fas fa-user'; ?> coach-img"></i>
                                </div>
                                <div class="flex items-center gap-1 bg-yellow-500/10 px-2 py-1 rounded-lg border border-yellow-500/20">
                                    <i class="fas fa-star text-yellow-500 text-sm"></i>
                                    <span class="font-bold text-yellow-500 text-sm"><?= $coach['rating'] ?? 'N/A'; ?></span>
                                    <span class="text-gray-500 text-xs">(<?= $coach['reviews'] ?? 0; ?>)</span>
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-white mb-1"><?= htmlspecialchars($coach['name']); ?></h3>

                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php if (isset($coach['specialties'])): ?>
                                    <?php foreach ($coach['specialties'] as $skill): ?>
                                        <span class="text-xs px-2 py-1 rounded-md specialty-tag" style="background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2);">
                                            <?= htmlspecialchars($skill); ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <p class="text-gray-400 text-sm mb-6 line-clamp-2">
                                <?= htmlspecialchars($coach['bio'] ?? 'No bio available.'); ?>
                            </p>

                            <button onclick="handleBooking(<?= $coach['id']; ?>)" class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold transition-all shadow-lg shadow-blue-600/20 book-btn">
                                Book Session
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="col-span-full text-center text-gray-500 py-12">No coaches found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Specific JS -->
    <script src="<?= BASE_URL ?>/public/assets/js/sportif_coaches.js"></script>

</body>

</html>