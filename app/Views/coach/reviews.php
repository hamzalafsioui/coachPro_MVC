<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - CoachPro</title>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/coach_reviews.css">

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

                <a href="<?= BASE_URL ?>/coach/clients" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
                    <i class="fas fa-users w-6 text-center group-hover:text-purple-400 transition-colors"></i>
                    <span class="font-medium">Clients</span>
                </a>

                <a href="<?= BASE_URL ?>/coach/reviews" class="sidebar-link active flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 hover:text-white group text-gray-400">
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
                    <h1 class="text-3xl font-outfit font-bold text-white mb-2">Client Reviews</h1>
                    <p class="text-gray-400">Detailed feedback from your coaching sessions.</p>
                </div>
            </div>

            <!-- Rating Overview -->
            <div class="glass-panel p-8 rounded-2xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                    <!-- Average Rating -->
                    <div class="text-center md:text-left md:border-r border-gray-700 pr-0 md:pr-8">
                        <div class="text-6xl font-bold text-white mb-2 font-outfit"><?= $overall_rating ?? '0.0'; ?></div>
                        <div class="flex justify-center md:justify-start gap-1 text-yellow-500 text-xl mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="text-gray-400">Based on <?= $total_reviews ?? 0; ?> reviews</p>
                    </div>

                    <!-- Rating Breakdown -->
                    <div class="col-span-2 space-y-3">
                        <?php if (isset($rating_breakdown)): ?>
                            <?php foreach ($rating_breakdown as $stars => $count):
                                $percentage = $total_reviews > 0 ? ($count / $total_reviews) * 100 : 0;
                            ?>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 text-sm text-gray-400 flex items-center gap-1">
                                        <span><?= $stars; ?></span> <i class="fas fa-star text-xs"></i>
                                    </div>
                                    <div class="flex-1 h-2 bg-gray-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-yellow-500 rounded-full" style="width: <?= $percentage; ?>%"></div>
                                    </div>
                                    <div class="w-12 text-sm text-gray-400 text-right"><?= $count; ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="space-y-6">
                <?php if (isset($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="glass-panel p-6 rounded-2xl review-card" id="review-card-<?= $review['id']; ?>">
                            <div class="flex flex-col md:flex-row gap-6">
                                <!-- Client Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center text-lg font-bold text-white border border-gray-600">
                                        <?= $review['avatar'] ?? '?'; ?>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1">
                                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-2">
                                        <div>
                                            <h3 class="font-bold text-white text-lg"><?= htmlspecialchars($review['client']); ?></h3>
                                            <p class="text-sm text-gray-400"><?= htmlspecialchars($review['session_type'] ?? 'Session'); ?></p>
                                        </div>
                                        <span class="text-xs text-gray-500 mt-1 md:mt-0"><?= htmlspecialchars(new DateTime($review['created_at'])->format('d M Y')); ?></span>
                                    </div>

                                    <div class="flex gap-1 text-yellow-500 text-sm mb-3">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <?php if ($i < ($review['rating'] ?? 0)): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star text-gray-600"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>

                                    <p class="text-gray-300 leading-relaxed mb-4">
                                        "<?= htmlspecialchars($review['comment'] ?? 'No comment.'); ?>"
                                    </p>

                                    <!-- Existing Reply -->
                                    <?php if (!empty($review['reply'])): ?>
                                        <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4 mb-4">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-white font-medium text-sm">You</span>
                                                        <span class="text-gray-500 text-xs"><?= htmlspecialchars($review['reply']['date'] ?? ''); ?></span>
                                                    </div>
                                                    <p class="text-gray-300 text-sm"><?= htmlspecialchars($review['reply']['text'] ?? ''); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-500 py-12">No reviews found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- JS -->
    <script src="<?= BASE_URL ?>/public/assets/js/coach_reviews.js"></script>
</body>

</html>