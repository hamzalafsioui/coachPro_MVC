    <!-- Hero Section -->
    <section id="home" class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white space-y-8">
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-outfit font-bold leading-tight">
                        Transform Your
                        <span class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                            Fitness Journey
                        </span>
                    </h1>
                    <p class="text-xl text-gray-300 leading-relaxed">
                        Connect with certified professional coaches, book personalized training sessions, and achieve your fitness goals faster with CoachPro's innovative platform.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?= BASE_URL ?>/register" class="gradient-blue px-8 py-4 rounded-lg text-white font-semibold text-lg hover-scale smooth-transition shadow-2xl flex items-center justify-center space-x-2">
                            <span>Start Your Journey</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#how-it-works" class="glass px-8 py-4 rounded-lg text-white font-semibold text-lg hover-scale smooth-transition border border-white/20 flex items-center justify-center space-x-2">
                            <i class="fas fa-play-circle"></i>
                            <span>Watch Demo</span>
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-cyan-400 count-up">500+</div>
                            <div class="text-gray-400 text-sm mt-1">Pro Coaches</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-blue-400 count-up">10K+</div>
                            <div class="text-gray-400 text-sm mt-1">Active Users</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-purple-400 count-up">50K+</div>
                            <div class="text-gray-400 text-sm mt-1">Sessions Booked</div>
                        </div>
                    </div>
                </div>

                <!-- Right Image/Illustration -->
                <div class="relative float-animation">
                    <div class="glass rounded-3xl p-8 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=600&h=600&fit=crop" alt="Fitness Training" class="rounded-2xl shadow-lg w-full">
                    </div>
                    <!-- Floating Elements -->
                    <div class="absolute -top-6 -right-6 glass-dark rounded-2xl p-6 shadow-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 gradient-cyan rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-white"></i>
                            </div>
                            <div class="text-white">
                                <div class="text-2xl font-bold">4.9</div>
                                <div class="text-xs text-gray-400">Rating</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-outfit font-bold text-white mb-4">
                    Why Choose <span class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">CoachPro</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Everything you need to succeed in your fitness journey, all in one platform
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="glass-dark rounded-2xl p-8 hover-lift smooth-transition reveal">
                    <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-user-tie text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Certified Coaches</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Access a network of verified, professional coaches specialized in various sports and training methodologies.
                    </p>
                </div>

                <!-- Feature Card 2 -->
                <div class="glass-dark rounded-2xl p-8 hover-lift smooth-transition reveal">
                    <div class="w-16 h-16 gradient-cyan rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Easy Booking</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Book and manage training sessions with just a few clicks. Real-time availability and instant confirmations.
                    </p>
                </div>

                <!-- Feature Card 3 -->
                <div class="glass-dark rounded-2xl p-8 hover-lift smooth-transition reveal">
                    <div class="w-16 h-16 gradient-purple rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Track Progress</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Monitor your fitness journey with detailed analytics, session history, and personalized recommendations.
                    </p>
                </div>

                <!-- Feature Card 4 -->
                <div class="glass-dark rounded-2xl p-8 hover-lift smooth-transition reveal">
                    <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-star text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Reviews & Ratings</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Make informed decisions with authentic reviews and ratings from the CoachPro community.
                    </p>
                </div>

                <!-- Feature Card 5 -->
                <div class="glass-dark rounded-2xl p-8 hover-lift smooth-transition reveal">
                    <div class="w-16 h-16 gradient-cyan rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Smart Notifications</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Stay updated with email and push notifications for bookings, reminders, and important updates.
                    </p>
                </div>

                <!-- Feature Card 6 -->
                <div class="glass-dark rounded-2xl p-8 hover-lift smooth-transition reveal">
                    <div class="w-16 h-16 gradient-purple rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Secure & Private</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Your data is protected with industry-standard security measures and privacy controls.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-outfit font-bold text-white mb-4">
                    Get Started in <span class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">3 Easy Steps</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Your fitness transformation is just minutes away
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 md:gap-12">
                <!-- Step 1 -->
                <div class="text-center reveal">
                    <div class="relative mb-8">
                        <div class="w-32 h-32 gradient-blue rounded-full flex items-center justify-center mx-auto pulse-glow">
                            <i class="fas fa-user-plus text-white text-4xl"></i>
                        </div>
                        <div class="absolute -top-4 -right-4 w-16 h-16 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                            1
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Create Account</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Sign up in seconds and tell us about your fitness goals and preferences.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center reveal">
                    <div class="relative mb-8">
                        <div class="w-32 h-32 gradient-cyan rounded-full flex items-center justify-center mx-auto pulse-glow">
                            <i class="fas fa-search text-white text-4xl"></i>
                        </div>
                        <div class="absolute -top-4 -right-4 w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                            2
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Find Your Coach</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Browse certified coaches, check reviews, and choose the perfect match for you.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center reveal">
                    <div class="relative mb-8">
                        <div class="w-32 h-32 gradient-purple rounded-full flex items-center justify-center mx-auto pulse-glow">
                            <i class="fas fa-rocket text-white text-4xl"></i>
                        </div>
                        <div class="absolute -top-4 -right-4 w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                            3
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Start Training</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Book sessions, track progress, and achieve your fitness goals with expert guidance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="glass-dark rounded-3xl p-12 text-center reveal shadow-2xl">
                <h2 class="text-4xl md:text-5xl font-outfit font-bold text-white mb-6">
                    Ready to Transform Your Life?
                </h2>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Join thousands of athletes and fitness enthusiasts who have already taken the first step towards their goals.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= BASE_URL ?>/register" class="gradient-blue px-10 py-4 rounded-lg text-white font-bold text-lg hover-scale smooth-transition shadow-2xl">
                        Start Free Trial
                    </a>
                    <a href="#coaches" class="glass border border-white/20 px-10 py-4 rounded-lg text-white font-bold text-lg hover-scale smooth-transition">
                        Browse Coaches
                    </a>
                </div>
            </div>
        </div>
    </section>