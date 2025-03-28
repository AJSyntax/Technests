// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Intersection Observer for fade-in animations
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe all sections
document.querySelectorAll('section').forEach(section => {
    observer.observe(section);
});

// Dark mode toggle
const darkModeToggle = document.createElement('button');
darkModeToggle.className = 'fixed bottom-4 right-4 p-3 rounded-full bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 shadow-lg z-50';
darkModeToggle.innerHTML = `
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path class="sun-icon hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        <path class="moon-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
    </svg>
`;

document.body.appendChild(darkModeToggle);

// Check for saved dark mode preference
const darkMode = localStorage.getItem('darkMode') === 'true';
if (darkMode) {
    document.documentElement.classList.add('dark');
    darkModeToggle.querySelector('.sun-icon').classList.remove('hidden');
    darkModeToggle.querySelector('.moon-icon').classList.add('hidden');
}

darkModeToggle.addEventListener('click', () => {
    document.documentElement.classList.toggle('dark');
    const isDark = document.documentElement.classList.contains('dark');
    localStorage.setItem('darkMode', isDark);
    
    // Toggle icons
    darkModeToggle.querySelector('.sun-icon').classList.toggle('hidden');
    darkModeToggle.querySelector('.moon-icon').classList.toggle('hidden');
});

// Mobile navigation toggle
const createMobileNav = () => {
    const nav = document.querySelector('nav');
    const mobileNavButton = document.createElement('button');
    mobileNavButton.className = 'md:hidden p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none';
    mobileNavButton.innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    `;

    const mobileNav = document.createElement('div');
    mobileNav.className = 'hidden md:hidden fixed inset-0 bg-white dark:bg-gray-800 z-40';
    mobileNav.innerHTML = `
        <div class="flex flex-col h-full">
            <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                <span class="text-xl font-bold text-gray-900 dark:text-white">Menu</span>
                <button class="close-mobile-nav p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 flex flex-col p-4 space-y-4">
                <a href="#about" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">About</a>
                <a href="#skills" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Skills</a>
                <a href="#projects" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Projects</a>
                <a href="#education" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Education</a>
                <a href="#contact" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Contact</a>
            </div>
        </div>
    `;

    document.body.appendChild(mobileNav);

    mobileNavButton.addEventListener('click', () => {
        mobileNav.classList.remove('hidden');
    });

    mobileNav.querySelector('.close-mobile-nav').addEventListener('click', () => {
        mobileNav.classList.add('hidden');
    });

    // Close mobile nav when clicking a link
    mobileNav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileNav.classList.add('hidden');
        });
    });

    // Insert mobile nav button before the navigation links
    const navLinks = nav.querySelector('.flex.items-center.space-x-4');
    nav.insertBefore(mobileNavButton, navLinks);
};

createMobileNav();

// Project image lazy loading
document.addEventListener('DOMContentLoaded', () => {
    const projectImages = document.querySelectorAll('.project-image');
    projectImages.forEach(img => {
        img.loading = 'lazy';
    });
});

// Add scroll progress indicator
const createScrollProgress = () => {
    const progressBar = document.createElement('div');
    progressBar.className = 'fixed top-0 left-0 w-full h-1 bg-gray-200 dark:bg-gray-700 z-50';
    progressBar.innerHTML = '<div class="h-full bg-indigo-600 dark:bg-indigo-400 transition-all duration-300" style="width: 0%"></div>';
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.querySelector('div').style.width = scrolled + '%';
    });
};

createScrollProgress(); 