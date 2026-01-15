<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - CoachPro</title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
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

                <a href="<?= BASE_URL ?>/sportif/coaches" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
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

                <a href="<?= BASE_URL ?>/sportif/profile" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
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
            <!-- Profile Header -->
            <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-blue-600 to-cyan-500 opacity-20"></div>
                <div class="relative flex flex-col md:flex-row items-center md:items-end gap-6 pt-10">
                    <div class="profile-avatar-container">
                        <div class="w-32 h-32 rounded-full border-4 border-slate-900 bg-slate-800 flex items-center justify-center text-4xl font-bold text-white shadow-xl">
                            <?= strtoupper(substr($sportifObj->getFirstname(), 0, 1) . substr($sportifObj->getLastname(), 0, 1)); ?>
                        </div>
                    </div>
                    <div class="text-center md:text-left mb-2 flex-1">
                        <h1 class="text-3xl font-outfit font-bold text-white"><?= htmlspecialchars($sportifObj->getFirstname() . ' ' . $sportifObj->getLastname()); ?></h1>
                        <p class="text-blue-400 font-medium">Sportif User</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Personal Info -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="glass-panel p-8 rounded-2xl">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-xl font-bold text-white flex items-center gap-3">
                                <i class="fas fa-user-circle text-blue-500"></i>
                                Personal Information
                            </h2>
                        </div>

                        <form id="profileForm" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">First Name</label>
                                    <input type="text" value="<?= htmlspecialchars($sportifObj->getFirstname()); ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Last Name</label>
                                    <input type="text" value="<?= htmlspecialchars($sportifObj->getLastname()); ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Email Address</label>
                                    <input type="email" value="<?= htmlspecialchars($sportifObj->getEmail()); ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Phone Number</label>
                                    <input type="tel" value="<?= htmlspecialchars($sportifObj->getPhone() ?? 'Not provided'); ?>" class="w-full bg-gray-800 border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Side Panel -->
                <div class="space-y-6">
                    <!-- Membership Status -->
                    <div class="glass-panel p-6 rounded-2xl">
                        <h3 class="text-lg font-bold text-white mb-4">Membership</h3>
                        <div class="bg-gradient-to-br from-blue-600 to-cyan-600 p-6 rounded-xl shadow-lg shadow-blue-500/20 mb-4 relative overflow-hidden group">
                            <div class="relative">
                                <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-md font-medium backdrop-blur-sm">PRO PLAN</span>
                                <h4 class="text-2xl font-bold text-white mt-3">Premium Member</h4>
                                <p class="text-blue-100 text-sm mt-1">Valid until Dec 2026</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- JS -->
    <script src="<?= BASE_URL ?>/public/assets/js/sportif_profile.js"></script>
</body>

</html>