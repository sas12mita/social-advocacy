// Function to update main content margin based on header height
function updateHeaderSpacing() {
  const header = document.querySelector('header');
  const main = document.querySelector('main');
  if (header && main) {
    const headerHeight = header.offsetHeight;
    main.style.marginTop = `${headerHeight}px`;
  }
}

// Store original text on page load
document.addEventListener('DOMContentLoaded', function () {
  // Set up header height calculation
  updateHeaderSpacing();

  // Re-calculate on window resize
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(updateHeaderSpacing, 250);
  });

  // Store original text for all translatable elements
  document.querySelectorAll('[data-i18n]').forEach(element => {
    // Only set original text if it's not already set
    if (!element.hasAttribute('data-original')) {
      element.setAttribute('data-original', element.textContent);
    }
  });

  // Store original placeholders for all input elements with data-i18n-placeholder
  document.querySelectorAll('[data-i18n-placeholder]').forEach(input => {
    // Only set original placeholder if it's not already set
    if (!input.hasAttribute('data-original-placeholder')) {
      input.setAttribute('data-original-placeholder', input.placeholder);
    }
  });

  // Check for saved language preference and set up language switch
  const savedLang = localStorage.getItem('preferredLanguage');
  const langSwitch = document.getElementById('lang-switch');

  if (langSwitch) {
    // Set initial state of the switch
    if (savedLang === 'ne') {
      langSwitch.checked = true;
      switchToNepali();
    } else {
      langSwitch.checked = false;
      switchToEnglish();
    }

    // Wrap the addEventListener to include header spacing update
    const originalAddEventListener = langSwitch.addEventListener;
    langSwitch.addEventListener = function (type, listener) {
      if (type === 'change') {
        originalAddEventListener.call(this, type, function (e) {
          // Call the original listener
          if (listener) listener(e);

          // Handle language switch
          if (this.checked) {
            switchToNepali();
          } else {
            switchToEnglish();
          }

          // Update header spacing after language change
          setTimeout(updateHeaderSpacing, 100);
        });
      } else {
        originalAddEventListener.call(this, type, listener);
      }
    };

    // Initial call to set up the change listener
    langSwitch.addEventListener('change', null);
  }
});

function switchToNepali() {
  const html = document.documentElement;
  const body = document.body;

  body.classList.add('nepali-lang');
  html.lang = 'ne';

  // Switch to Nepali text for all elements with data-i18n
  document.querySelectorAll('[data-i18n]').forEach(element => {
    const neText = element.getAttribute('data-i18n');
    element.textContent = neText;
  });

  // Update placeholders for Nepali
  document.querySelectorAll('[data-i18n-placeholder]').forEach(input => {
    const nepaliPlaceholder = input.getAttribute('data-i18n-placeholder');
    input.placeholder = nepaliPlaceholder;
  });

  // Save language preference
  localStorage.setItem('preferredLanguage', 'ne');
}

function switchToEnglish() {
  const html = document.documentElement;
  const body = document.body;

  body.classList.remove('nepali-lang');
  html.lang = 'en';

  // Switch back to English (original text)
  document.querySelectorAll('[data-i18n]').forEach(element => {
    const originalText = element.getAttribute('data-original');
    if (originalText) {
      element.textContent = originalText;
    }
  });

  // Reset placeholders to English (use the original placeholder)
  document.querySelectorAll('[data-i18n-placeholder]').forEach(input => {
    const originalPlaceholder = input.getAttribute('data-original-placeholder');
    if (originalPlaceholder) {
      input.placeholder = originalPlaceholder;
    }
  });

  // Save language preference
  localStorage.setItem('preferredLanguage', 'en');
}



/**
 * Initialize Owl Carousel with consistent settings
 * @param {string} carouselId - The ID of the carousel element (without #)
 * @param {string} navContainerId - The ID of the navigation container (without #)
 * @param {object} options - Additional options to override defaults
 */
function initCarousel(carouselId, navContainerId, options = {}) {
  const defaults = {
    loop: true,
    margin: 20,
    nav: true,
    navContainer: `#${navContainerId}`,
    navText: [
      '<i class="bi bi-chevron-left"></i>',
      '<i class="bi bi-chevron-right">'
    ],
    slideBy: 1,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    responsive: {
      0: { items: 1 },
      768: { items: 2 },
      1200: { items: 3 },
      1400: { items: 3 }
    },
    dots: false
  };

  // Merge default options with custom options
  const settings = { ...defaults, ...options };

  // Initialize the carousel
  $(`#${carouselId}`).owlCarousel(settings);

  console.log(`Carousel initialized: #${carouselId}`);
}

// Initialize all carousels when document is ready
$(document).ready(function () {
  if (typeof $.fn.owlCarousel === 'undefined') {
    console.error('Owl Carousel is not loaded');
    return;
  }

  // Initialize carousels with their respective navigation containers
  initCarousel('natural-therapeutics-carousel', 'natural-therapeutics-nav');
  initCarousel('expert-team-carousel', 'expert-team-nav', { autoplayTimeout: 5000 });
  initCarousel('success-stories-carousel', 'success-stories-nav');
  initCarousel('blogs-carousel', 'blogs-carousel-nav');
  initCarousel('experts-say-carousel', 'experts-say-carousel-nav');
  initCarousel('donor-history-carousel','donor-history-nav')

  // Add more carousels as needed
  // initCarousel('anotherCarousel', 'anotherNav', { /* custom options */ });
});

function getBaseUrl() {
  return window.location.protocol + "//" + window.location.host;
}

function formatDateWithComma(timestamp) {
  const date = new Date(timestamp);
  const day = date.getDate();
  const month = date.toLocaleString('en-US', {
    month: 'long'
  });
  const year = date.getFullYear();
  return `${day} ${month}, ${year}`;
}