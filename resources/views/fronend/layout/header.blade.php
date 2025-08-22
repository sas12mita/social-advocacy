
<header>
    <!-- Top bar -->
    <div class="bg-primary d-flex justify-content-between align-items-center px-2 px-lg-5 py-2 text-white flex-wrap row-gap-2"
        style="font-size: 14px;">
        <div class="d-flex align-items-center gap-4 flex-fill justify-content-evenly justify-content-lg-start">
            <div class="d-flex align-items-center gap-2">
                <span class="material-icons">mail</span>
                <span>info@socialadvocacy.org</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="material-icons">phone</span>
                <a href="tel:+9779800000000" class="m-0 text-white text-decoration-none">+977-9800000000</a>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 flex-fill justify-content-evenly justify-content-lg-end">
            <!-- Social icons -->
            <div class="d-flex align-items-center gap-3">
                <i class="fa-brands fa-facebook fa-lg"></i>
                <i class="fa-brands fa-instagram fa-lg"></i>
                <i class="fa-brands fa-youtube fa-lg"></i>
            </div>
            <!-- Language switch -->
            <div class="d-flex align-items-center gap-2">
                <span class="d-flex align-items-center gap-2">
                    <img class="mb-1" width="24" height="24" src="https://img.icons8.com/color/48/great-britain.png" alt="great-britain" />
                    <span>ENG</span>
                </span>
                <div class="form-check form-switch lang_div">
                    <style>
                        .lang_div .form-check-input {
                            width: 40px;
                            height: 18px;
                        }

                        .lang_div .form-check-input:checked {
                            background-color: #003399 !important;
                            border-color: #003399 !important;
                        }
                    </style>
                    <input class="form-check-input" type="checkbox" id="lang-switch" onclick="switchLang()">
                    <label class="form-check-label" for="lang-switch"></label>
                </div>
                <span class="d-flex align-items-center gap-1">
                    <img class="mb-1" width="24" height="24" src="https://img.icons8.com/color/48/nepal.png" alt="nepal" />
                    <span>NEP</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <style>
        .link:hover {
            text-decoration: underline !important;
            transition: all 0.3s ease-in-out;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-2 px-lg-5" style="font-size: 18px;">
        <div class="container-fluid">
            <a href="#" class="navbar-brand"><img src="assets/images/social-logo.png"
                    alt="Social Advocacy Logo" class="img-fluid" style="width: 76px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-2 flex-wrap justify-content-evenly align-items-center px-5">
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="nav-link active" href="#" data-i18n="गृहपृष्ठ">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-i18n="अभियान">Campaigns</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-i18n="ब्लग">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-i18n="सम्पर्क">Contact Us</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3 justify-content-center my-2 my-lg-0">
                    <!-- Authentication -->
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginModal"
                        class="link text-primary text-decoration-none">Login</a>

                    <!-- Call-to-action button -->
                    <a href="#" class="btn btn-primary">
                        <span data-i18n="सामेल">Join</span>
                        <span class="text-nowrap"><span data-i18n="हुनुहोस्">Us</span> <i class="bi bi-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
@push('scripts')
<script>
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
    document.addEventListener('DOMContentLoaded', function() {
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
            langSwitch.addEventListener = function(type, listener) {
                if (type === 'change') {
                    originalAddEventListener.call(this, type, function(e) {
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
</script>

@endpush
