// ========================================
// DOM ELEMENTS
// ========================================
const navbar = document.getElementById('navbar');
const backToTop = document.getElementById('backToTop');
const searchForm = document.getElementById('searchForm');
const searchQuery = document.getElementById('searchQuery');
const locationQuery = document.getElementById('locationQuery');
const menuToggle = document.getElementById('menuToggle');
const favoriteButtons = document.querySelectorAll('.btn-favorite');

// ========================================
// NAVBAR SCROLL EFFECT
// ========================================
function handleNavbarScroll() {
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
}

window.addEventListener('scroll', handleNavbarScroll);

// ========================================
// BACK TO TOP BUTTON
// ========================================
function handleBackToTop() {
    if (window.scrollY > 500) {
        backToTop.classList.add('visible');
    } else {
        backToTop.classList.remove('visible');
    }
}

window.addEventListener('scroll', handleBackToTop);

backToTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ 
        top: 0, 
        behavior: 'smooth' 
    });
});

// ========================================
// SEARCH FORM
// ========================================
searchForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const query = searchQuery.value.trim();
    const location = locationQuery.value.trim();
    
    if (query || location) {
        // Here you would typically redirect to a search results page
        // For demo purposes, we'll show an alert
        alert(`Searching for "${query}" in "${location || 'all locations'}"...`);
        
        // Example redirect:
        // window.location.href = `/search?q=${encodeURIComponent(query)}&location=${encodeURIComponent(location)}`;
    }
});

// ========================================
// FAVORITE BUTTON TOGGLE
// ========================================
favoriteButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            // Add animation
            this.style.transform = 'scale(1.2)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
        }
    });
});

// ========================================
// MOBILE MENU TOGGLE
// ========================================
menuToggle.addEventListener('click', function() {
    this.classList.toggle('active');
    // Add mobile menu functionality here if needed
});

// ========================================
// SCROLL REVEAL ANIMATION
// ========================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            // Add delay based on index for staggered animation
            setTimeout(() => {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }, index * 100);
            
            // Stop observing once animated
            revealObserver.unobserve(entry.target);
        }
    });
}, observerOptions);

// Apply reveal animation to elements
const revealElements = document.querySelectorAll(
    '.category-card, .business-card, .step, .testimonial-card'
);

revealElements.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
    revealObserver.observe(el);
});

// ========================================
// COUNTER ANIMATION (Optional)
// ========================================
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);
    
    const updateCounter = () => {
        start += increment;
        if (start < target) {
            element.textContent = Math.floor(start).toLocaleString();
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target.toLocaleString();
        }
    };
    
    updateCounter();
}

// Observe stats section for counter animation
const statsSection = document.querySelector('.stats-bar');
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Animate counters when stats section is visible
            // This is optional - currently stats are static
            statsObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

if (statsSection) {
    statsObserver.observe(statsSection);
}

// ========================================
// SMOOTH SCROLL FOR ANCHOR LINKS
// ========================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// ========================================
// SEARCH INPUT FOCUS EFFECTS
// ========================================
const searchInputs = document.querySelectorAll('.search-input-wrapper input');

searchInputs.forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
    });
});

// ========================================
// LAZY LOADING IMAGES (Performance)
// ========================================
const lazyImages = document.querySelectorAll('img[data-src]');

const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.add('loaded');
            imageObserver.unobserve(img);
        }
    });
});

lazyImages.forEach(img => imageObserver.observe(img));

// ========================================
// KEYBOARD NAVIGATION
// ========================================
document.addEventListener('keydown', (e) => {
    // Press '/' to focus search
    if (e.key === '/' && document.activeElement.tagName !== 'INPUT') {
        e.preventDefault();
        searchQuery.focus();
    }
    
    // Press 'Escape' to blur search
    if (e.key === 'Escape') {
        document.activeElement.blur();
    }
});

// ========================================
// PAGE LOAD ANIMATION
// ========================================
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
    
    // Animate hero elements
    const heroElements = document.querySelectorAll('.search-container');
    heroElements.forEach((el, index) => {
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 200);
    });
});

// ========================================
// UTILITY FUNCTIONS
// ========================================

// Debounce function for performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle function for scroll events
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Apply throttle to scroll handlers for better performance
window.addEventListener('scroll', throttle(handleNavbarScroll, 100));
window.addEventListener('scroll', throttle(handleBackToTop, 100));



/* contact */

