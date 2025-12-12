<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VogueThreads | Premium Fashion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS Reset and Variables */
        :root {
            --primary: #000;
            --secondary: #fff;
            --accent: #e60012;
            --light-gray: #f8f8f8;
            --medium-gray: #e5e5e5;
            --dark-gray: #333;
            --text: #fff; /* White text for transparent navbar */
            --text-light: rgba(255, 255, 255, 0.8);
            --font-main: 'Helvetica Neue', Arial, sans-serif;
            --font-heading: 'Helvetica Neue', Arial, sans-serif;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden; /* Prevent scrolling */
        }

        body {
            font-family: var(--font-main);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        button {
            cursor: pointer;
            border: none;
            font-family: inherit;
            background: transparent;
        }

        img {
            max-width: 100%;
            display: block;
        }

        /* Container for responsive design */
        .container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* FULLY TRANSPARENT Header - Fixed at top */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: transparent;
            transition: var(--transition);
            padding: 20px 0;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        /* Logo styling */
        .logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--secondary);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            letter-spacing: 1px;
            flex-shrink: 0;
        }

        .logo span {
            color: var(--accent);
        }

        /* Main Navigation - Center aligned */
        .main-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
        }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--secondary);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            padding: 8px 0;
            position: relative;
            transition: var(--transition);
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--accent);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--accent);
            transition: var(--transition);
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        /* Header actions - right side */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 25px;
            flex-shrink: 0;
        }

        .header-actions a {
            color: var(--secondary);
            font-size: 18px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            transition: var(--transition);
        }

        .header-actions a:hover {
            color: var(--accent);
            transform: scale(1.1);
        }

        .search-bar {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-bar input {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: var(--secondary);
            padding: 8px 40px 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            width: 200px;
            transition: var(--transition);
            backdrop-filter: blur(5px);
        }

        .search-bar input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-bar input:focus {
            outline: none;
            width: 250px;
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .search-bar button {
            position: absolute;
            right: 10px;
            color: var(--secondary);
            font-size: 16px;
        }

        /* Mobile menu button - hidden by default */
        .mobile-menu-btn {
            display: none;
            color: var(--secondary);
            font-size: 24px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            padding: 5px;
        }

        /* Full Screen Slideshow - No scrolling */
        .fullpage-slideshow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
            background-color: #000;
        }

        .slide.active {
            opacity: 1;
            z-index: 2;
        }

        .slide-content {
            text-align: center;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        .slide-content h2 {
            font-size: 48px;
            font-weight: 300;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
            color: var(--secondary);
        }

        .slide-content p {
            font-size: 20px;
            margin-bottom: 30px;
            color: var(--secondary);
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
        }

        .slide-btn {
            display: inline-block;
            padding: 15px 40px;
            background-color: var(--accent);
            color: var(--secondary);
            font-size: 16px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-radius: 2px;
            transition: var(--transition);
        }

        .slide-btn:hover {
            background-color: #ff2a3a;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        /* Removed video-slide specific styles since we're using images only */

        /* Slide navigation dots - vertical on right */
        .slide-navigation {
            position: fixed;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1001;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .slide-nav-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .slide-nav-dot.active {
            background-color: var(--accent);
            transform: scale(1.4);
            border-color: white;
            box-shadow: 0 0 10px rgba(230, 0, 18, 0.5);
        }

        /* Slide progress indicator */
        .slide-progress {
            position: fixed;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1001;
            color: var(--secondary);
            font-size: 16px;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 25px;
            border-radius: 25px;
            backdrop-filter: blur(10px);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Mobile navigation overlay */
        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1002;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-nav-overlay.active {
            display: block;
            opacity: 1;
        }

        .mobile-nav {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1003;
            width: 90%;
            max-width: 500px;
            text-align: center;
            display: none;
        }

        .mobile-nav.active {
            display: block;
        }

        .mobile-nav-links {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .mobile-nav-links a {
            font-size: 24px;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }

        .mobile-nav-links a:hover,
        .mobile-nav-links a.active {
            color: var(--accent);
            transform: translateX(10px);
        }

        .mobile-close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: var(--secondary);
            font-size: 30px;
            z-index: 1004;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 1200px) {
            .nav-links {
                gap: 30px;
            }
            
            .slide-content h2 {
                font-size: 42px;
            }
            
            .slide-content p {
                font-size: 18px;
            }
        }

        @media (max-width: 992px) {
            .nav-links {
                gap: 20px;
            }
            
            .nav-links a {
                font-size: 13px;
            }
            
            .search-bar input {
                width: 180px;
            }
            
            .search-bar input:focus {
                width: 220px;
            }
            
            .slide-content h2 {
                font-size: 36px;
            }
            
            .slide-content p {
                font-size: 16px;
            }
        }

        @media (max-width: 768px) {
            /* Hide desktop navigation */
            .main-nav {
                display: none;
            }
            
            /* Show mobile menu button */
            .mobile-menu-btn {
                display: block;
            }
            
            /* Adjust header layout for mobile */
            .header-content {
                justify-content: space-between;
            }
            
            .logo {
                font-size: 24px;
            }
            
            .search-bar {
                display: none;
            }
            
            .header-actions {
                gap: 20px;
            }
            
            /* Adjust slides for mobile */
            .slide-content {
                padding: 20px;
            }
            
            .slide-content h2 {
                font-size: 32px;
            }
            
            .slide-content p {
                font-size: 16px;
                margin-bottom: 25px;
            }
            
            .slide-btn {
                padding: 12px 30px;
                font-size: 14px;
            }
            
            .slide-navigation {
                right: 20px;
            }
            
            .slide-progress {
                bottom: 30px;
                font-size: 14px;
                padding: 8px 20px;
            }
        }

        @media (max-width: 576px) {
            header {
                padding: 15px 0;
            }
            
            .logo {
                font-size: 20px;
            }
            
            .header-actions {
                gap: 15px;
            }
            
            .header-actions a {
                font-size: 16px;
            }
            
            .slide-content h2 {
                font-size: 28px;
            }
            
            .slide-content p {
                font-size: 15px;
            }
            
            .slide-btn {
                padding: 10px 25px;
                font-size: 13px;
            }
            
            .slide-navigation {
                right: 15px;
                gap: 15px;
            }
            
            .slide-nav-dot {
                width: 12px;
                height: 12px;
            }
            
            .mobile-nav-links a {
                font-size: 20px;
                padding: 12px 0;
            }
        }

        @media (max-width: 400px) {
            .logo {
                font-size: 18px;
            }
            
            .slide-content h2 {
                font-size: 24px;
            }
            
            .slide-content p {
                font-size: 14px;
            }
            
            .slide-progress {
                bottom: 25px;
                font-size: 12px;
                padding: 6px 15px;
            }
        }

        /* Landscape mode adjustments */
        @media (max-height: 600px) and (orientation: landscape) {
            header {
                padding: 10px 0;
            }
            
            .logo {
                font-size: 20px;
            }
            
            .slide-content {
                padding: 15px;
            }
            
            .slide-content h2 {
                font-size: 28px;
                margin-bottom: 10px;
            }
            
            .slide-content p {
                font-size: 14px;
                margin-bottom: 15px;
            }
            
            .slide-btn {
                padding: 10px 20px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <!-- Transparent Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <a href="#" class="logo">VOGUE<span>THREADS</span></a>
                
                <!-- Desktop Navigation -->
                <nav class="main-nav">
                    <ul class="nav-links">
                        <li><a href="./index.php" class="active">Home</a></li>
                        <!-- <li><a href="#">New Arrivals</a></li> -->
                        <li><a href="../FashionHub/allpages/men.html">Men</a></li>
                        <li><a href="../FashionHub/allpages/women.html">Women</a></li>
                        <li><a href="../FashionHub/allpages/kids.html">Kids</a></li>
                        <li><a href="../FashionHub/allpages/baby.html">Baby</a></li>
                        <!-- <li><a href="#">Collections</a></li> -->
                    </ul>
                </nav>
                
                <!-- Header Actions -->
                <div class="header-actions">
                    <!-- Search Bar -->
                    <div class="search-bar">
                        <input type="text" placeholder="Search...">
                        <button><i class="fas fa-search"></i></button>
                    </div>
                    
                    <!-- Action Icons -->
                    <a href="#"><i class="far fa-user"></i></a>
                    <a href="#"><i class="far fa-heart"></i></a>
                    <a href="#"><i class="fas fa-shopping-bag"></i></a>
                    
                    <!-- Mobile Menu Button -->
                    <button class="mobile-menu-btn">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay"></div>
    
    <!-- Mobile Navigation -->
    <div class="mobile-nav">
        <button class="mobile-close-btn">
            <i class="fas fa-times"></i>
        </button>
        <nav class="mobile-nav-links">
            <a href="#" class="active">Home</a>
            <!-- <a href="#">New Arrivals</a> -->
            <a href="./allpages/men.html">Men</a>
            <a href="./allpages/women.html">Women</a>
            <a href="./allpages/kids.html">Kids</a>
            <!-- <a href="../FashionHub/allpages/">Sale</a> -->
            <!-- <a href="#">Collections</a> -->
        </nav>
    </div>

    <!-- Full Page Slideshow -->
    <div class="fullpage-slideshow">
        <!-- Slide 1: Hero Image (Replaced Video) -->
        <div class="slide active" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('../FashionHub/index/Summer\ Collection\ 2023.jpg')">
            <div class="slide-content">
                <h2>Summer Collection 2023</h2>
                <p>Experience premium fashion that combines style, comfort, and quality in every piece.</p>
                <a href="../FashionHub/allpages/men.html" class="slide-btn">Shop Now</a>
            </div>
        </div>
        
        <!-- Slide 2: Brand Story -->
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('./index/Founded\ with\ a\ vision\ to\ create\ timeless\ fashion\ that\ transcends\ trends\ and\ seasons..jpg')">
            <div class="slide-content">
                <h2>Our Story</h2>
                <p>Founded with a vision to create timeless fashion that transcends trends and seasons.</p>
                <a href="../FashionHub/allpages/women.html" class="slide-btn">Discover More</a>
            </div>
        </div>
        
        <!-- Slide 3: Men's Collection (Replaced Video) -->
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('../FashionHub/index/Men\'s\ Collection.png')">
            <div class="slide-content">
                <h2>Men's Collection</h2>
                <p>Sophisticated styles for the modern man. From casual wear to formal attire.</p>
                <a href="../FashionHub/allpages/men.html" class="slide-btn">Shop Men's</a>
            </div>
        </div>
        
        <!-- Slide 4: Women's Collection -->
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('../FashionHub/index/Women\'s\ Collection.avif')">
            <div class="slide-content">
                <h2>Women's Collection</h2>
                <p>Elegant and contemporary fashion for every occasion and style preference.</p>
                <a href="../FashionHub/allpages/women.html" class="slide-btn">Shop Women's</a>
            </div>
        </div>
        
        <!-- Slide 5: Kids Collection (Replaced Video) -->
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('../FashionHub/index/Kids\ Collection.webp')">
            <div class="slide-content">
                <h2>Kids Collection</h2>
                <p>Comfortable, durable, and stylish clothing for the little ones.</p>
                <a href="../FashionHub/allpages/kids.html" class="slide-btn">Shop Kids</a>
            </div>
        </div>
        
        <!-- Slide 6: Sale -->
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80')">
            <div class="slide-content">
                <h2>Seasonal Sale</h2>
                <p>Up to 50% off on selected items. Limited time offer.</p>
                <a href="../FashionHub/allpages/baby.html" class="slide-btn">Shop Sale</a>
            </div>
        </div>  
        
        <!-- Slide Navigation Dots -->
        <div class="slide-navigation">
            <div class="slide-nav-dot active" data-slide="0"></div>
            <div class="slide-nav-dot" data-slide="1"></div>
            <div class="slide-nav-dot" data-slide="2"></div>
            <div class="slide-nav-dot" data-slide="3"></div>
            <div class="slide-nav-dot" data-slide="4"></div>
            <div class="slide-nav-dot" data-slide="5"></div>
        </div>
        
        <!-- Slide Progress -->
        <div class="slide-progress">
            <span class="current-slide">1</span> / <span class="total-slides">6</span>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileCloseBtn = document.querySelector('.mobile-close-btn');
        const mobileNavOverlay = document.querySelector('.mobile-nav-overlay');
        const mobileNav = document.querySelector('.mobile-nav');
        
        // Toggle mobile menu
        mobileMenuBtn.addEventListener('click', () => {
            mobileNavOverlay.classList.add('active');
            mobileNav.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        // Close mobile menu
        mobileCloseBtn.addEventListener('click', () => {
            mobileNavOverlay.classList.remove('active');
            mobileNav.classList.remove('active');
            document.body.style.overflow = 'hidden';
        });
        
        // Close mobile menu when clicking overlay
        mobileNavOverlay.addEventListener('click', () => {
            mobileNavOverlay.classList.remove('active');
            mobileNav.classList.remove('active');
            document.body.style.overflow = 'hidden';
        });
        
        // Close mobile menu when clicking a link
        document.querySelectorAll('.mobile-nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                mobileNavOverlay.classList.remove('active');
                mobileNav.classList.remove('active');
                document.body.style.overflow = 'hidden';
            });
        });
        
        // Full Page Slideshow
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slide-nav-dot');
        const currentSlideElement = document.querySelector('.current-slide');
        const totalSlidesElement = document.querySelector('.total-slides');
        let currentSlide = 0;
        let isScrolling = false;
        
        // Set total slides count
        totalSlidesElement.textContent = slides.length;
        
        function showSlide(n) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            currentSlide = (n + slides.length) % slides.length;
            
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
            currentSlideElement.textContent = currentSlide + 1;
        }
        
        // Dot navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
            });
        });
        
        // Mouse wheel navigation
        document.addEventListener('wheel', (e) => {
            if (!isScrolling) {
                isScrolling = true;
                
                if (e.deltaY > 0) {
                    // Scrolling down - go to next slide
                    showSlide(currentSlide + 1);
                } else {
                    // Scrolling up - go to previous slide
                    showSlide(currentSlide - 1);
                }
                
                setTimeout(() => {
                    isScrolling = false;
                }, 800);
            }
        });
        
        // Touch swipe navigation for mobile
        let touchStartY = 0;
        let touchEndY = 0;
        
        document.addEventListener('touchstart', (e) => {
            touchStartY = e.changedTouches[0].screenY;
        });
        
        document.addEventListener('touchend', (e) => {
            touchEndY = e.changedTouches[0].screenY;
            handleSwipe();
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            
            if (touchEndY < touchStartY - swipeThreshold) {
                // Swipe up - go to next slide
                showSlide(currentSlide + 1);
            } else if (touchEndY > touchStartY + swipeThreshold) {
                // Swipe down - go to previous slide
                showSlide(currentSlide - 1);
            }
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown' || e.key === 'PageDown') {
                e.preventDefault();
                showSlide(currentSlide + 1);
            } else if (e.key === 'ArrowUp' || e.key === 'PageUp') {
                e.preventDefault();
                showSlide(currentSlide - 1);
            }
        });
        
        // Auto advance slides
        let slideInterval;
        
        function startAutoSlide() {
            slideInterval = setInterval(() => {
                showSlide(currentSlide + 1);
            }, 6000); // 6 seconds per slide
        }
        
        function stopAutoSlide() {
            clearInterval(slideInterval);
        }
        
        // Start auto slide
        startAutoSlide();
        
        // Pause auto slide on user interaction
        document.addEventListener('wheel', stopAutoSlide);
        document.addEventListener('touchstart', stopAutoSlide);
        document.addEventListener('keydown', stopAutoSlide);
        dots.forEach(dot => {
            dot.addEventListener('click', stopAutoSlide);
        });
        
        // Restart auto slide after 8 seconds of inactivity
        function restartAutoSlide() {
            stopAutoSlide();
            setTimeout(startAutoSlide, 8000);
        }
        
        // Listen for user interaction
        document.addEventListener('wheel', restartAutoSlide);
        document.addEventListener('touchstart', restartAutoSlide);
        document.addEventListener('keydown', restartAutoSlide);
        dots.forEach(dot => {
            dot.addEventListener('click', restartAutoSlide);
        });
        
        // Removed video handling code since we're using images only
        
        // Search functionality
        const searchInput = document.querySelector('.search-bar input');
        const searchButton = document.querySelector('.search-bar button');
        
        searchButton.addEventListener('click', () => {
            if (searchInput.value.trim() !== '') {
                alert(`Searching for: ${searchInput.value}`);
                searchInput.value = '';
                searchInput.blur();
            }
        });
        
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                if (searchInput.value.trim() !== '') {
                    alert(`Searching for: ${searchInput.value}`);
                    searchInput.value = '';
                    searchInput.blur();
                }
            }
        });
        
        // Active navigation state
        // document.querySelectorAll('.nav-links a, .mobile-nav-links a').forEach(link => {
        //     link.addEventListener('click', (e) => {
        //         e.preventDefault();
        //         document.querySelectorAll('.nav-links a, .mobile-nav-links a').forEach(l => {
        //             l.classList.remove('active');
        //         });
        //         link.classList.add('active');
        //     });
        // });
        
        // Prevent right-click context menu on images
        document.addEventListener('contextmenu', (e) => {
            if (e.target.tagName === 'IMG') {
                e.preventDefault();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', () => {
            // Reset any transitions or animations if needed
        });
    </script>
</body>
</html>