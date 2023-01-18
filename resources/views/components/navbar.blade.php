<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbar">
    
    <div class="offcanvas-header">

        <a class="offcanvas-logo" href="{{ url('/') }}">
            <img src="{{ Vite::asset('resources/images/logo-icon.png') }}" alt="{{ config('app.name', 'Laravel') }}" />
        </a>

        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    
    </div>

    <div class="offcanvas-body d-flex flex-column">

        <ul class="nav nav-pills flex-column" id="navMain">

            <li class="nav-item">
                <a href="{{ route('entry.create') }}" class="nav-link"><i class="bi bi-plus-square-fill"></i> <span>New Entry</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vault.all') }}" class="nav-link"><i class="bi bi-safe-fill"></i> <span>My Vaults</span></a>
            </li>
            @if (Auth::user()->pendingInvites()->isNotEmpty())
            <li class="nav-item">
                <a href="{{ route('invite.all') }}" class="nav-link"><i class="bi bi-envelope-paper-heart"></i> <span>Invites</span></a>
            </li>
            @endif

        </ul>

        <ul class="nav nav-pills flex-column mt-auto" id="navMainBottom">

            <li class="nav-item">
                <a href="#" class="nav-link"><i class="bi bi-question-lg"></i> <span>Help</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.account') }}" class="nav-link"><i class="bi bi-person"></i> <span>Account</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link"><i class="bi bi-door-open"></i> <span>Logout</span></a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>

        </ul>

    </div>

</div>