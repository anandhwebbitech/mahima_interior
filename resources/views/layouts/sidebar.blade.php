<style>
    .sidebar {
        background: #000000;
        color: #fff;
        padding: 19px;
        min-height: 100vh;
    }

    .sidebar a {
        display: block;
        color: #ccc;
        text-decoration: none;
        padding: 10px 12px;
        border-radius: 6px;
        margin-bottom: 8px;
        transition: 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: #caf0a8ff;
        color: #fff;
    }

    .sidebar button {
        border: none;
        font-weight: 600;
        color: #ccc;
    }

    .sidebar button:hover {
        color: #fff;
    }

    .Logout:hover {
        background: red;
        color: white;

    }

    .text-gold {
        color: #0dcaf0 !important;
        /* classic gold */
    }

    .text-gold:hover {
        color: #198754 !important;
        /* brighter gold on hover */
    }
</style>

<div class="sidebar text-white position-fixed top-0 vh-100" style="width:250px;">
    <div class="mb-3 border-bottom border-secondary">
        <h4 class="text-center ">Admin Panel</h4>
    </div>

    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
                class="nav-link  text-gold">
                <i class="fa-solid fa-house me-2"></i> Dashboard
            </a>
        </li>
        <!-- <li class="nav-item">
            <a href="{{ route('customer') }}"
                class="nav-link text-gold ">
                <i class="fa-solid fa-user-group me-2"></i> Customers
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('followup') }}"
                class="nav-link text-gold ">
                <i class="fa-solid  fa-user-group  me-2"></i> FollowUp
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('followup_list') }}"
                class="nav-link text-gold ">
                <i class="fa-solid fa-users me-2"></i> FollowUp List
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('building_stage') }}"
                class="nav-link text-gold ">
                <i class="fa-solid  fa-building  me-2"></i> Buildiing Stage
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('project_type') }}"
                class="nav-link text-gold ">
                <i class="fa-solid  fa-folder  me-2"></i> Project Type
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('reminder_followup_list') }}"
                class="nav-link text-gold ">
                <i class="fa-solid fa-bell me-2"></i> Reminders
                @if($reminderCount > 0)
                    <span class="badge bg-danger ms-2">{{ $reminderCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('menu') }}"
                class="nav-link text-gold ">
                <i class="fa-solid fa-bell me-2"></i> Menu
            </a>
        </li> -->
        @foreach($sidebarMenus ?? [] as $menu)
            <li class="nav-item">
                <a href="{{ route($menu->route) }}"
                class="nav-link text-gold {{ request()->routeIs($menu->route) ? 'active' : '' }}">
                    <i class="fa-solid {{ $menu->icon }} me-2"></i>
                    {{ $menu->name }}

                    @if($menu->route == 'reminder_followup_list' && $reminderCount > 0)
                        <span class="badge bg-danger ms-2">{{ $reminderCount }}</span>
                    @endif
                </a>
            </li>
        @endforeach

        <li class="nav-item mt-auto">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link Logout text-white btn btn-link pl-10">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</div>