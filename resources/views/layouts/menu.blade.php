<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
    with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('tag') }}" class="nav-link">
                <i class="nav-icon fas fa-tags"></i>
                <p>
                    Tag
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('business') }}" class="nav-link">
                <i class="nav-icon fas fa-building"></i>
                <p>
                    Business
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('rules.update') }}" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                <p>
                    Rules
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('notification.index') }}" class="nav-link">
                <i class="nav-icon fas fa-bell"></i>
                <p>
                    Notification
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('review') }}" class="nav-link">
                <i class="nav-icon fas fa-bell"></i>
                <p>
                  Review
                </p>
            </a>
        </li>
        
    </ul>
</nav>