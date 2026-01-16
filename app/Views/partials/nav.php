    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-dark backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 gradient-blue rounded-lg flex items-center justify-center pulse-glow">
                        <i class="fas fa-dumbbell text-white text-2xl"></i>
                    </div>
                    <span class="text-white text-2xl font-outfit font-bold">CoachPro</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-300 hover:text-white smooth-transition font-medium">Home</a>
                    <a href="#features" class="text-gray-300 hover:text-white smooth-transition font-medium">Features</a>
                    <a href="#how-it-works" class="text-gray-300 hover:text-white smooth-transition font-medium">How It Works</a>
                    <a href="#coaches" class="text-gray-300 hover:text-white smooth-transition font-medium">Find Coaches</a>
                    <a href="#pricing" class="text-gray-300 hover:text-white smooth-transition font-medium">Pricing</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="<?= BASE_URL ?>/login" class="text-white hover:text-gray-300 smooth-transition font-medium">Login</a>
                    <a href="<?= BASE_URL ?>/register" class="gradient-blue px-6 py-2.5 rounded-lg text-white font-semibold hover-scale smooth-transition shadow-lg">
                        Get Started
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden text-white">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden glass-dark">
            <div class="px-4 pt-2 pb-4 space-y-3">
                <a href="#home" class="block text-gray-300 hover:text-white smooth-transition py-2">Home</a>
                <a href="#features" class="block text-gray-300 hover:text-white smooth-transition py-2">Features</a>
                <a href="#how-it-works" class="block text-gray-300 hover:text-white smooth-transition py-2">How It Works</a>
                <a href="#coaches" class="block text-gray-300 hover:text-white smooth-transition py-2">Find Coaches</a>
                <a href="#pricing" class="block text-gray-300 hover:text-white smooth-transition py-2">Pricing</a>
                <div class="pt-4 space-y-3">
                    <a href="<?= BASE_URL ?>/login" class="block text-center text-white border border-white px-6 py-2.5 rounded-lg font-semibold">Login</a>
                    <a href="<?= BASE_URL ?>/register" class="block text-center gradient-blue px-6 py-2.5 rounded-lg text-white font-semibold">Get Started</a>
                </div>
            </div>
        </div>
    </nav>