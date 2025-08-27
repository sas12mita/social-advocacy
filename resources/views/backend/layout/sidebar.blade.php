<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="position: fixed; top: 0; bottom: 0; overflow-y: auto; overflow-x: hidden; width: 250px;">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Bindabasini</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Team Management -->
        <li class="menu-item {{ 
            request()->routeIs('our-teams.*') || 
            request()->routeIs('what-expert-says.*')
            ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Layouts">Team Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('our-teams.*') ? 'active' : '' }}">
                    <a href="{{ route('our-teams.index') }}" class="menu-link">
                        <div data-i18n="Without menu">All Team Members</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('what-expert-says.*') ? 'active' : '' }}">
                    <a href="{{ route('what-expert-says.index') }}" class="menu-link">
                        <div data-i18n="Without menu">What Expert saya</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Articles Management -->
        <li class="menu-item {{
            request()->routeIs('articles.*') ||
            request()->routeIs('article-categories.*')
            ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div data-i18n="Layouts">Articles Management</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('article-categories.*') ? 'active' : '' }}">
                    <a href="{{ route('article-categories.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Article Categories</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                    <a href="{{ route('articles.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">All Articles</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Service Management -->
        <li class="menu-item {{
            request()->routeIs('services.*') ||
            request()->routeIs('service-categories.*') ||
            request()->routeIs('service-sessions.*') ||
            request()->routeIs('service-benefits.*')||
            request()->routeIs('service-specialists.*')
            ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Layouts">Service Management</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                    <a href="{{ route('services.index') }}" class="menu-link">
                        <div data-i18n="Without menu">All Services</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('service-categories.*') ? 'active' : '' }}">
                    <a href="{{ route('service-categories.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">Service Categories</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('service-sessions.*') ? 'active' : '' }}">
                    <a href="{{ route('service-sessions.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">Service Sessions</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('service-benefits.*') ? 'active' : '' }}">
                    <a href="{{ route('service-benefits.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">Service Benefits</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('service-specialists.*') ? 'active' : '' }}">
                    <a href="{{ route('service-specialists.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Service Specialist</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Disease Management -->
        <li class="menu-item {{
            request()->routeIs('diseases.*') ||
            request()->routeIs('disease-treatments.*') ||
            request()->routeIs('disease-dietary-guidelines.*') ||
            request()->routeIs('disease-symptoms.*') ||
            request()->routeIs('symptoms.*')
            ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-plus-medical"></i>
                <div data-i18n="Layouts">Disease Management</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('diseases.*') ? 'active' : '' }}">
                    <a href="{{ route('diseases.index') }}" class="menu-link">
                        <div data-i18n="Without menu">All Diseases</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('disease-dietary-guidelines.*') ? 'active' : '' }}">
                    <a href="{{ route('disease-dietary-guidelines.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">Dietary Guidelines</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('disease-treatments.*') ? 'active' : '' }}">
                    <a href="{{ route('disease-treatments.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">Disease Treatments</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('symptoms.*') ? 'active' : '' }}">
                    <a href="{{ route('symptoms.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">All Symptoms</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('disease-symptoms.*') ? 'active' : '' }}">
                    <a href="{{ route('disease-symptoms.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">Disease Symptoms</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Room Management -->
        <li class="menu-item {{
            request()->routeIs('rooms.*') ||
            request()->routeIs('room-bookings.*')
            ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-plus-medical"></i>
                <div data-i18n="Layouts">Room Management</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                    <a href="{{ route('rooms.index') }}" class="menu-link">
                        <div data-i18n="Without menu">All Rooms</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('room-bookings.*') ? 'active' : '' }}">
                    <a href="{{ route('room-bookings.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">Rooms Booking</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Consultation Booking -->
        <li class="menu-item {{ request()->routeIs('consultation-bookings.*') ? 'active' : '' }}">
            <a href="{{ route('consultation-bookings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Analytics">Consultation Bookings</div>
            </a>
        </li>

        <!-- Discussion Forum -->
        <li class="menu-item">
            <a class="menu-link">
                <i class="menu-icon tf-icons bx bx-message-rounded"></i>
                <div data-i18n="Analytics">Discussion Forum</div>
            </a>
        </li>
        <li class="menu-item {{
            request()->routeIs('discussion-forum.*') ||
            request()->routeIs('discussion-category.*')
            ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Layouts">Discussion Forum Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('discussion-forum.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Discussion Forum</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('discussion-category.*') ? 'active' : '' }}">
                    <a href="{{ route('discussion-category.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Discussion Forum Category</div>
                    </a>
                </li>
            </ul>
        </li>


        <!-- Donor History -->
        <li class="menu-item {{ request()->routeIs('donor-histories.*') ? 'active' : '' }}">
            <a href="{{ route('donor-histories.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div data-i18n="Analytics">Donor History</div>
            </a>
        </li>

        <!-- Settings -->
        <li class="menu-item {{
            request()->routeIs('success-stories.*') ||
            request()->routeIs('faqs.*') ||
            request()->routeIs('analytics.*') ||
            request()->routeIs('payments.*')
            ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Layouts">Settings</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('enquires.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Enquiries</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('success-stories.*') ? 'active' : '' }}">
                    <a href="{{ route('success-stories.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Success Stories</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('faqs.*') ? 'active' : '' }}">
                    <a href="{{ route('faqs.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">FAQs</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link">
                        <div data-i18n="Without navbar">Analytics Log</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link">
                        <div data-i18n="Without navbar">Payments</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>