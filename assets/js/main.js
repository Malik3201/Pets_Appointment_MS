/**
 * Veterinary Website - Main JavaScript
 * Handles background swaps, header transparency, and mobile menu
 */

class VeterinaryWebsite {
  constructor() {
    this.header = null;
    this.backgroundManager = null;
    this.mobileMenu = null;
    this.preloadedImages = new Set();
    this.reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    
    this.init();
  }

  init() {
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.setup());
    } else {
      this.setup();
    }
  }

  setup() {
    this.setupHeader();
    this.setupBackgroundManager();
    this.setupMobileMenu();
    this.setupAccessibility();
    this.preloadImages();
  }

  /**
   * Setup header (now fixed and white permanently)
   */
  setupHeader() {
    this.header = document.querySelector('.site-header');
    if (!this.header) return;

    // Header is now fixed and white permanently - no transparency changes needed
    console.log('Header is now fixed and white permanently');
  }

  /**
   * Setup background image swapping system
   */
  setupBackgroundManager() {
    const sections = document.querySelectorAll('section[data-bg]');
    if (sections.length === 0) return;

    // Create background container if it doesn't exist
    let bgContainer = document.querySelector('.page-bg');
    if (!bgContainer) {
      bgContainer = document.createElement('div');
      bgContainer.className = 'page-bg';
      document.body.appendChild(bgContainer);
    }

    // Create initial background image
    let bgImage = bgContainer.querySelector('.page-bg__image');
    if (!bgImage) {
      bgImage = document.createElement('img');
      bgImage.className = 'page-bg__image';
      bgImage.alt = '';
      bgImage.ariaHidden = 'true';
      bgContainer.appendChild(bgImage);
    }

    // Set initial background from hero or first section (only once)
    const heroSection = document.querySelector('.hero');
    const initialBg = heroSection?.dataset.bg || sections[0].dataset.bg;
    if (initialBg && !bgImage.src) {
      bgImage.src = initialBg;
    }

    // Setup intersection observers for each section
    const backgroundObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && entry.intersectionRatio >= 0.5) {
            this.swapBackground(entry.target.dataset.bg, bgImage);
          }
        });
      },
      {
        threshold: [0.5],
        rootMargin: '0px'
      }
    );

    sections.forEach(section => {
      if (section.dataset.bg) {
        backgroundObserver.observe(section);
      }
    });
  }

  /**
   * Swap background image with cross-fade effect
   */
  swapBackground(newBgSrc, bgImage) {
    if (!newBgSrc || bgImage.src === newBgSrc) return;

    // Preload the new image
    this.preloadImage(newBgSrc).then(() => {
      // Create new image element
      const newImage = document.createElement('img');
      newImage.className = 'page-bg__image';
      newImage.alt = '';
      newImage.ariaHidden = 'true';
      newImage.src = newBgSrc;

      // Insert new image
      bgImage.parentNode.appendChild(newImage);

      // Cross-fade transition
      if (!this.reducedMotion) {
        // Hide old image
        bgImage.classList.add('is-hidden');
        
        // Show new image after transition
        setTimeout(() => {
          bgImage.remove();
          bgImage = newImage;
        }, 600);
      } else {
        // Instant swap for reduced motion
        bgImage.remove();
        bgImage = newImage;
      }
    });
  }

  /**
   * Setup mobile menu functionality
   */
  setupMobileMenu() {
    const toggle = document.querySelector('.hamburger');
    const drawer = document.querySelector('.nav-drawer');
    const navLinks = drawer?.querySelectorAll('a');

    if (!toggle || !drawer) return;

    let isOpen = false;
    let previouslyFocusedElement = null;

    // Toggle menu
    toggle.addEventListener('click', () => {
      isOpen = !isOpen;
      this.toggleMobileMenu(isOpen, toggle, drawer);
    });

    // Close menu when clicking on links
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        if (isOpen) {
          isOpen = false;
          this.toggleMobileMenu(false, toggle, drawer);
        }
      });
    });

    // Close menu with Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && isOpen) {
        isOpen = false;
        this.toggleMobileMenu(false, toggle, drawer);
      }
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (isOpen && !toggle.contains(e.target) && !drawer.contains(e.target)) {
        isOpen = false;
        this.toggleMobileMenu(false, toggle, drawer);
      }
    });
  }

  /**
   * Toggle mobile menu open/closed state
   */
  toggleMobileMenu(isOpen, toggle, drawer) {
    toggle.setAttribute('aria-expanded', isOpen.toString());
    drawer.classList.toggle('is-open', isOpen);

    if (isOpen) {
      // Store currently focused element
      previouslyFocusedElement = document.activeElement;
      
      // Focus first link in drawer
      const firstLink = drawer.querySelector('a');
      if (firstLink) {
        firstLink.focus();
      }

      // Prevent body scroll
      document.body.style.overflow = 'hidden';
      
      // Make other elements inert
      this.setInert(true);
    } else {
      // Restore body scroll
      document.body.style.overflow = '';
      
      // Remove inert from other elements
      this.setInert(false);
      
      // Restore focus to previously focused element
      if (previouslyFocusedElement) {
        previouslyFocusedElement.focus();
        previouslyFocusedElement = null;
      }
    }
  }

  /**
   * Set inert attribute on non-menu elements
   */
  setInert(inert) {
    const elements = document.querySelectorAll('main, .site-header > *:not(.hamburger):not(.nav-drawer), .site-footer');
    elements.forEach(el => {
      if (inert) {
        el.setAttribute('inert', '');
      } else {
        el.removeAttribute('inert');
      }
    });
  }

  /**
   * Setup accessibility features
   */
  setupAccessibility() {
    // Add skip link
    this.addSkipLink();
    
    // Setup focus management
    this.setupFocusManagement();
    
    // Setup keyboard navigation
    this.setupKeyboardNavigation();
  }

  /**
   * Add skip link for keyboard navigation
   */
  addSkipLink() {
    const skipLink = document.createElement('a');
    skipLink.href = '#main-content';
    skipLink.textContent = 'Skip to main content';
    skipLink.className = 'skip-link sr-only';
    
    skipLink.addEventListener('focus', () => {
      skipLink.classList.remove('sr-only');
    });
    
    skipLink.addEventListener('blur', () => {
      skipLink.classList.add('sr-only');
    });
    
    document.body.insertBefore(skipLink, document.body.firstChild);
  }

  /**
   * Setup focus management for better keyboard navigation
   */
  setupFocusManagement() {
    // Add focus indicators
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Tab') {
        document.body.classList.add('keyboard-navigation');
      }
    });

    document.addEventListener('mousedown', () => {
      document.body.classList.remove('keyboard-navigation');
    });
  }

  /**
   * Setup keyboard navigation for interactive elements
   */
  setupKeyboardNavigation() {
    // Handle Enter key on buttons and links
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && (e.target.tagName === 'BUTTON' || e.target.classList.contains('btn'))) {
        e.target.click();
      }
    });

    // Handle arrow keys for card grids
    const cardGrids = document.querySelectorAll('.card-grid, .services-grid, .testimonials-grid');
    cardGrids.forEach(grid => {
      const cards = grid.querySelectorAll('.card, .service-card, .testimonial');
      cards.forEach((card, index) => {
        card.setAttribute('tabindex', '0');
        
        card.addEventListener('keydown', (e) => {
          let targetIndex = index;
          
          switch (e.key) {
            case 'ArrowRight':
            case 'ArrowDown':
              e.preventDefault();
              targetIndex = (index + 1) % cards.length;
              break;
            case 'ArrowLeft':
            case 'ArrowUp':
              e.preventDefault();
              targetIndex = (index - 1 + cards.length) % cards.length;
              break;
            case 'Home':
              e.preventDefault();
              targetIndex = 0;
              break;
            case 'End':
              e.preventDefault();
              targetIndex = cards.length - 1;
              break;
          }
          
          if (targetIndex !== index) {
            cards[targetIndex].focus();
          }
        });
      });
    });
  }

  /**
   * Preload images for better performance
   */
  preloadImages() {
    const sections = document.querySelectorAll('section[data-bg]');
    sections.forEach(section => {
      const bgSrc = section.dataset.bg;
      if (bgSrc) {
        this.preloadImage(bgSrc);
      }
    });
  }

  /**
   * Preload a single image
   */
  preloadImage(src) {
    if (this.preloadedImages.has(src)) {
      return Promise.resolve();
    }

    return new Promise((resolve, reject) => {
      const img = new Image();
      img.onload = () => {
        this.preloadedImages.add(src);
        resolve();
      };
      img.onerror = reject;
      img.src = src;
    });
  }

  /**
   * Debounce function for performance
   */
  debounce(func, wait) {
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

  /**
   * Throttle function for performance
   */
  throttle(func, limit) {
    let inThrottle;
    return function() {
      const args = arguments;
      const context = this;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => inThrottle = false, limit);
      }
    };
  }
}

// Initialize the website when DOM is ready
const website = new VeterinaryWebsite();

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
  module.exports = VeterinaryWebsite;
}

// Add some utility functions for external use
window.VeterinaryWebsite = {
  // Utility to manually swap background
  swapBackground: (bgSrc) => {
    const bgImage = document.querySelector('.page-bg__image');
    if (bgImage && bgSrc) {
      website.swapBackground(bgSrc, bgImage);
    }
  },
  
  // Utility to toggle mobile menu
  toggleMobileMenu: () => {
    const toggle = document.querySelector('.hamburger');
    if (toggle) {
      toggle.click();
    }
  },
  
  // Utility to check if mobile menu is open
  isMobileMenuOpen: () => {
    const drawer = document.querySelector('.nav-drawer');
    return drawer ? drawer.classList.contains('is-open') : false;
  }
};
