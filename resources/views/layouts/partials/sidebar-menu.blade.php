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
        <span>Users</span>
    </a>
</li>
<li class="{{ Request::is('customers/session*') ? 'active' : '' }}">
    <a href="{{ route('manage.users') }}" class="nav-link">
        <i class="fas fa-fire"></i>
        <span>Sessions</span>
    </a>
</li>

{{-- Add your menu items here --}}
<li class="menu-header">Setting</li>
<li class="{{ Request::is('management/users*') ? 'active' : '' }}">
    <a href="{{ route('manage.users') }}" class="nav-link">
        <i class="fas fa-fire"></i>
        <span>Booth</span>
    </a>
</li>
<li class="{{ Request::is('custpmers/session*') ? 'active' : '' }}">
    <a href="{{ route('manage.users') }}" class="nav-link">
        <i class="fas fa-fire"></i>
        <span>Frames</span>
    </a>
</li>
<li class="{{ Request::is('custpmers/session*') ? 'active' : '' }}">
    <a href="{{ route('manage.users') }}" class="nav-link">
        <i class="fas fa-fire"></i>
        <span>Frame Categories</span>
    </a>
</li>
<li class="{{ Request::is('custpmers/session*') ? 'active' : '' }}">
    <a href="{{ route('manage.users') }}" class="nav-link">
        <i class="fas fa-fire"></i>
        <span>Themes</span>
    </a>
</li>

@stack('sidebar-items')
