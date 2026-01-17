{{-- Dashboard Menu --}}
<li class="menu-header">Dashboard</li>
<li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" class="nav-link">
        <i class="fas fa-fire"></i>
        <span>Dashboard</span>
    </a>
</li>

{{-- Add your menu items here --}}
<li class="menu-header">Menu</li>
<li class="{{ Request::is('management/users*') ? 'active' : '' }}">
    <a href="{{ route('manage.users') }}" class="nav-link">
        <i class="fas fa-fire"></i>
        <span>Pengguna</span>
    </a>
</li>

@stack('sidebar-items')
