<nav class="navbar navbar bg-light">
    <div class="container">
        <h1><a href="/">Recepto</a></h1>
        <ul class="navbar-nav flex-row gap-2">
            @if (Illuminate\Support\Facades\Auth::check())
                <li class="nav-item"><a class="nav-link" href="/admin/approved-recipes">Approved recipes</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/not-approved-recipes">Not approved recipes</a></li>
                <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
            @endif
        </ul>
    </div>
</nav>