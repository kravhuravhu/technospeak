<div class="sidebar_nav_container">
    <div class="sidebar-header">
        <img src="@secureAsset('images/logo-primary-navy-cr.png')" alt="TechnoSpeak Logo">
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('content-manager.admin') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('content-manager.courses.index') }}" class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span>Courses</span>
            </a>
        </li>
        <li>
            <a href="{{ route('content-manager.clients.clients') }}" class="{{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Clients</span>
            </a>
        </li>
        <li>
            <a href="{{ route('content-manager.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>
        </li>
        <li>
            <a href="{{ route('content-manager.trainings.index') }}" class="{{ request()->routeIs('admin.trainings.*') ? 'active' : '' }}">
                <i class="fas fa-video"></i>
                <span>Trainings</span>
            </a>
        </li>

        <li>
            <a href="{{ route('content-manager.other-features.index') }}" class="{{ request()->routeIs('content-manager.other-features.*') ? 'active' : '' }}">
                <i class="fa-solid fa-square-caret-down" style="border-radius:50px;"></i>
                <span>Other</span>
            </a>
        </li>

        <div class="menu-divider"></div>
        
        <li>
            <a href="{{ route('content-manager.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
        <li>
            <form action="{{ route('content-manager.logout') }}" method="POST" style="display: inline;" class="lg-out-button">
                @csrf
                <button class="bttn logout-button" type="submit">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </li>

    </ul>
</div>