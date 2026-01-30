// ====================================
// WEB PLAY STORE - MAIN JAVASCRIPT
// File: assets/js/script.js
// ====================================

document.addEventListener('DOMContentLoaded', function() {
    
    // === SEARCH FUNCTIONALITY === //
    const searchForm = document.getElementById('searchForm');
    const searchBox = document.getElementById('searchBox');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const searchTerm = searchBox.value.trim();
            
            if (searchTerm.length > 0) {
                window.location.href = 'search.php?q=' + encodeURIComponent(searchTerm);
            }
        });
    }
    
    // === INSTALL BUTTON FUNCTIONALITY === //
    const installButtons = document.querySelectorAll('.install-btn');
    
    installButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const appId = this.getAttribute('data-app-id');
            const appName = this.getAttribute('data-app-name');
            
            if (confirm('Install ' + appName + '?')) {
                window.location.href = 'install.php?id=' + appId;
            }
        });
    });
    
    // === APP CARD CLICK (navigate to details) === //
    const appCards = document.querySelectorAll('.app-card');
    
    appCards.forEach(function(card) {
        card.addEventListener('click', function(e) {
            // Don't navigate if clicking on install button
            if (e.target.classList.contains('install-btn')) {
                return;
            }
            
            const appId = this.getAttribute('data-app-id');
            if (appId) {
                window.location.href = 'app-details.php?id=' + appId;
            }
        });
    });
    
    // === CATEGORY CARD CLICK === //
    const categoryCards = document.querySelectorAll('.category-card');
    
    categoryCards.forEach(function(card) {
        card.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            if (categoryId) {
                window.location.href = 'category.php?id=' + categoryId;
            }
        });
    });
    
    // === SMOOTH SCROLL === //
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
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
    
    // === DOWNLOAD BUTTON === //
    const downloadButton = document.getElementById('downloadBtn');
    
    if (downloadButton) {
        downloadButton.addEventListener('click', function() {
            const appId = this.getAttribute('data-app-id');
            const appName = this.getAttribute('data-app-name');
            
            if (confirm('Download and install ' + appName + '?')) {
                // Show loading state
                this.disabled = true;
                this.innerHTML = '<span class="loading"></span> Downloading...';
                
                // Redirect to install page
                window.location.href = 'install.php?id=' + appId;
            }
        });
    }
    
    // === REAL-TIME SEARCH (optional enhancement) === //
    if (searchBox) {
        let searchTimeout;
        
        searchBox.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.trim();
            
            if (searchTerm.length >= 2) {
                searchTimeout = setTimeout(function() {
                    // Show search suggestions (optional)
                    // This can be enhanced with AJAX
                }, 300);
            }
        });
    }
    
    // === BACK BUTTON === //
    const backButtons = document.querySelectorAll('.back-btn');
    
    backButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            window.history.back();
        });
    });
    
    // === LAZY LOADING IMAGES === //
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.getAttribute('data-src');
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(function(img) {
        imageObserver.observe(img);
    });
    
    // === FORM VALIDATION === //
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(function(input) {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'var(--danger-color)';
                } else {
                    input.style.borderColor = 'var(--border-color)';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    });
    
    // === COPY TO CLIPBOARD === //
    const copyButtons = document.querySelectorAll('[data-copy]');
    
    copyButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const text = this.getAttribute('data-copy');
            
            navigator.clipboard.writeText(text).then(function() {
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                
                setTimeout(function() {
                    button.textContent = originalText;
                }, 2000);
            });
        });
    });
    
});

// === UTILITY FUNCTIONS === //

// Format numbers with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = function() {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = 'notification notification-' + type;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(function() {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(function() {
        notification.classList.remove('show');
        setTimeout(function() {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
