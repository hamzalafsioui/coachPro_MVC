<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Profile - CoachPro</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/coach_profile.css">
    <!-- Global Tailwind Config -->
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

                <a href="<?= BASE_URL ?>/coach/profile" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
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
        <div class="p-8 max-w-5xl mx-auto space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-outfit font-bold text-white mb-2">My Profile</h1>
                    <p class="text-gray-400">Manage your account information and preferences.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div class="glass-panel p-6 rounded-2xl text-center">
                        <div class="relative w-32 h-32 mx-auto mb-4 group">
                            <div class="w-full h-full rounded-full border-4 border-gray-700 shadow-xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-4xl font-bold text-white uppercase">
                                <?= strtoupper(substr($coachObj->getFirstname(), 0, 1) . substr($coachObj->getLastname(), 0, 1)); ?>
                            </div>
                        </div>
                        <h2 class="text-xl font-bold text-white font-outfit"><?= htmlspecialchars($coachObj->getFirstname() . ' ' . $coachObj->getLastname()); ?></h2>
                        <p class="text-blue-400 text-sm mb-4">Professional Coach</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Personal Information -->
                    <div class="glass-panel p-8 rounded-2xl">
                        <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center">
                            <i class="fas fa-user-circle mr-3 text-blue-500"></i>
                            Personal Information
                        </h3>

                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-400 text-sm font-medium mb-2">First Name</label>
                                    <input type="text" value="<?= htmlspecialchars($coachObj->getFirstname()); ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-sm font-medium mb-2">Last Name</label>
                                    <input type="text" value="<?= htmlspecialchars($coachObj->getLastname()); ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-sm font-medium mb-2">Email Address</label>
                                    <input type="email" value="<?= htmlspecialchars($coachObj->getEmail()); ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-sm font-medium mb-2">Phone Number</label>
                                    <input type="tel" value="<?= htmlspecialchars($coachObj->getPhone() ?? 'Not provided'); ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-sm font-medium mb-2">Experience (Years)</label>
                                    <input type="number" value="<?= $coachObj->getExperienceYears() ?? 0; ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-sm font-medium mb-2">Hourly Rate ($)</label>
                                    <input type="text" value="<?= $coachObj->getHourlyRate() ?? 0; ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-400 text-sm font-medium mb-2">Bio</label>
                                <textarea rows="4" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled><?= htmlspecialchars($coachObj->getBio() ?? 'No bio available.'); ?></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="<?= BASE_URL ?>/public/assets/js/coach_profile.js"></script>
</body>

</html>