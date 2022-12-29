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
                <a href="#" class="nav-link"><i class="bi bi-plus-square-fill"></i> <span>New Entry</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vault.all') }}" class="nav-link"><i class="bi bi-safe-fill"></i> <span>My Vaults</span></a>
            </li>
            @if (Auth::user()->receivedInvites()->isNotEmpty())
            <li class="nav-item">
                <a href="{{ route('invite.all') }}" class="nav-link"><i class="bi bi-envelope-paper-heart-fill"></i> <span>Invites</span></a>
            </li>
            @endif

        </ul>

        <div id="accountDropdown" class="nav mt-auto">

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle ps-0" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Account Settings</a>    
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>

        </div>

    </div>

</div>