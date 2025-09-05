@php
    $userId = auth()->id();
@endphp
<ul id="admin-menu" class="tw-space-y-2">
    <li class="menu-section">
        <a href="#" class="menu-toggle tw-flex tw-items-center tw-gap-2 tw-py-2 tw-px-3">
            <i class="fas fa-users"></i>
            <span>User Management</span>
        </a>
        <ul class="submenu tw-ml-4 tw-space-y-1">
            <li>
                <a href="{{ route('admin.roles.index') }}" class="tw-flex tw-items-center tw-gap-2">
                    <i class="fas fa-user-tag"></i> <span>Roles</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.permissions.index') }}" class="tw-flex tw-items-center tw-gap-2">
                    <i class="fas fa-key"></i> <span>Permissions</span>
                </a>
            </li>
        </ul>
    </li>
</ul>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var userId = @json($userId);
        document.querySelectorAll('#admin-menu .menu-section').forEach(function (section, index) {
            var toggle = section.querySelector('.menu-toggle');
            var submenu = section.querySelector('.submenu');
            var key = 'admin_menu_' + userId + '_' + index;
            if (localStorage.getItem(key) === 'collapsed') {
                submenu.style.display = 'none';
            }
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                var isHidden = submenu.style.display === 'none';
                submenu.style.display = isHidden ? 'block' : 'none';
                localStorage.setItem(key, isHidden ? 'expanded' : 'collapsed');
            });
        });
    });
</script>
