<div class="ntfc_name">
    <div class="ntfc nt_nm">
        <i class="fa-solid fa-bell"></i>
    </div>
    <div class="name nt_nm name_rightbar_tr_active">
        <div class="cont">
            <p>{{ Auth::user()->name }} {{ Auth::user()->surname }}</p>
            <div class="ms-1">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        @if (!isset($showDropdown) || $showDropdown)
            <div id="dropdownMenu" class="dropdown hidden">
                <a href="#usr_settings" class="content-section">Profile</a>
                <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        @endif
    </div>
</div>