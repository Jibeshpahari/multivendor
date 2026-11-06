<script>
    (function () {
        var html = document.documentElement;
        var KEY = 'sidebar_collapsed_pages';
        var page = @json(Route::currentRouteName() ?? request()->path());

        html.classList.add('no-transition');

        try {
            var saved = JSON.parse(localStorage.getItem(KEY)) || {};
            if (saved[page]) {
                html.classList.add('sb-collapsed');

                if (sessionStorage.getItem('sb_peek') === '1') {
                    html.classList.add('sb-peek');
                }
            }
            sessionStorage.removeItem('sb_peek');
        } catch (e) {}
    })();
</script>

<div id="sidebar">

    <div class="sidebar-logo">
        <div class="logo-mark">N</div>
        <span class="logo-text">Nova<span>Hub</span></span>
    </div>

    <nav class="nav-section">

        <p class="nav-label">Main</p>

        <ul class="nav-list">

            <li class="nav-item {{ isActive('admin.dashboard') || isActive('admin.dashboard.*') ? 'active open' : '' }}" data-tip="Dashboard">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon"><i class="fa-solid fa-gauge-high"></i></span>
                    <span class="nav-text {{ isActive('admin.dashboard') ? 'active' : '' }}">Dashboard</span>
                </a>
            </li>

            <li class="nav-item has-sub" data-tip="Analytics">
                <a href="#">
                    <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span>
                    <span class="nav-text">Analytics</span>
                    <i class="fa-solid fa-chevron-right nav-arrow"></i>
                </a>
                <ul class="sub-menu">
                    <li class="sub-item"><span class="sub-dot"></span>Overview</li>
                    <li class="sub-item"><span class="sub-dot"></span>Reports</li>
                    <li class="sub-item"><span class="sub-dot"></span>Real-time</li>
                </ul>
            </li>

            <li class="nav-item has-sub {{ isActive('admin.products.*') ? 'active open' : '' }}" data-tip="Products">
                <a href="javascript:void(0)">
                    <span class="nav-icon"><i class="fa-solid fa-box"></i></span>
                    <span class="nav-text">Products</span>
                    <span class="nav-badge">12</span>
                    <i class="fa-solid fa-chevron-right nav-arrow"></i>
                </a>
                <ul class="sub-menu {{ isActive('admin.products.*') ? 'open' : '' }}">
                    <li class="sub-item {{ isActive('admin.products.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.index') }}"><span class="sub-dot"></span>All Product</a>
                    </li>
                    <li class="sub-item {{ isActive('admin.products.add') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.add') }}"><span class="sub-dot"></span>Add Product</a>
                    </li>
                    <li class="sub-item">
                        <a href="{{ route('admin.products.index') }}"><span class="sub-dot"></span>Inventory</a>
                    </li>
                    <li class="sub-item">
                        <a href="{{ route('admin.products.index') }}"><span class="sub-dot"></span>Pricing</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ isActive('admin.categories.*') ? 'active' : '' }}" data-tip="Categories">
                <a href="{{ route('admin.categories.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-chart-diagram"></i></span>
                    <span class="nav-text">Categories</span>
                    <span class="nav-badge">5</span>
                </a>
            </li>

            <li class="nav-item" data-tip="Orders">
                <a href="#">
                    <span class="nav-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                    <span class="nav-text">Orders</span>
                    <span class="nav-badge">5</span>
                </a>
            </li>

            <li class="nav-item has-sub {{ isActive('admin.customers.*') ? 'active open' : '' }}" data-tip="Customers">
                <a href="javascript:void(0)">
                    <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                    <span class="nav-text">Customers</span>
                    <i class="fa-solid fa-chevron-right nav-arrow"></i>
                </a>
                <ul class="sub-menu {{ isActive('admin.customers.*') ? 'open' : '' }}">
                    <li class="sub-item">
                        <a href="{{ route('admin.customers.index') }}">All Customers</a>
                    </li>
                    <li class="sub-item">
                        <a href="">Add New</a>
                    </li>
                    <li class="sub-item">
                        <a href="">Reports</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-sub {{ isActive('admin.vendors.*') ? 'active open' : '' }}" data-tip="Vendors">
                <a href="javascript:void(0)">
                    <span class="nav-icon"><i class="fa-solid fa-store"></i></span>
                    <span class="nav-text">Vendors</span>
                    <i class="fa-solid fa-chevron-right nav-arrow"></i>
                </a>
                <ul class="sub-menu {{ isActive('admin.vendors.*') ? 'open' : '' }}">
                    <li class="sub-item {{ isActive('admin.vendors.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.vendors.index') }}">All Vendors</a>
                    </li>
                    <li class="sub-item {{ isActive('admin.vendors.add') ? 'active' : '' }}">
                        <a href="{{ route('admin.vendors.add') }}">Add Vendors</a>
                    </li>
                    <li class="sub-item">
                        <a href="">Reports</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item" data-tip="Notes">
                <a href="{{ route('admin.notes.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-note-sticky"></i></span>
                    <span class="nav-text">Notes</span>
                </a>
            </li>

        </ul>

        <p class="nav-label" style="margin-top:12px;">Management</p>

        <ul class="nav-list">
            <li class="nav-item has-sub {{ isActive('admin.settings.*') ? 'active open' : '' }}" data-tip="Settings">
                <a href="javascript:void(0)">
                    <span class="nav-icon"><i class="fa-solid fa-sliders"></i></span>
                    <span class="nav-text">Settings</span>
                    <i class="fa-solid fa-chevron-right nav-arrow"></i>
                </a>
                <ul class="sub-menu {{ isActive('admin.settings.*') ? 'open' : '' }}">
                    <li class="sub-item {{ isActive('admin.settings.site-settings') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.site-settings') }}">General</a>
                    </li>
                    <li class="sub-item {{ isActive('admin.settings.security') ? 'active' : '' }}">
                        <a
                            href="{{ Route::has('admin.settings.security') ? route('admin.settings.security') : 'javascript:void(0)' }}">Security</a>
                    </li>
                    <li class="sub-item {{ isActive('admin.settings.integrations') ? 'active' : '' }}">
                        <a
                            href="{{ Route::has('admin.settings.integrations') ? route('admin.settings.integrations') : 'javascript:void(0)' }}"><span
                                class="sub-dot"></span>Integrations</a>
                    </li>
                    <li class="sub-item {{ isActive('admin.settings.billing') ? 'active' : '' }}">
                        <a
                            href="{{ Route::has('admin.settings.billing') ? route('admin.settings.billing') : 'javascript:void(0)' }}"><span
                                class="sub-dot"></span>Billing</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item" data-tip="Team">
                <a href="#">
                    <span class="nav-icon"><i class="fa-solid fa-user-group"></i></span>
                    <span class="nav-text">Team</span>
                </a>
            </li>

            <li class="nav-item" data-tip="Support">
                <a href="#">
                    <span class="nav-icon"><i class="fa-regular fa-circle-question"></i></span>
                    <span class="nav-text">Help &amp; Support</span>
                </a>
            </li>

        </ul>

    </nav>

    <div class="sidebar-profile d-none">
        <div class="profile-avatar">JD</div>
        <div class="profile-info">
            <div class="profile-name">John Doe</div>
            <div class="profile-role">Administrator</div>
        </div>
        <i class="fa-solid fa-ellipsis profile-more"></i>
    </div>

    <div class="sidebar-toggle" id="sidebarToggle">
        <i class="fa-solid fa-chevron-left"></i>
    </div>

</div>

@push('js')
    <script>
        $(function() {
            var STORAGE_KEY = 'sidebar_collapsed_pages';
            var PAGE_KEY = @json(Route::currentRouteName() ?? request()->path());

            var $html = $(document.documentElement);
            var $sidebar = $('#sidebar');
            var peekTimer = null;
            var suppressPeek = false;

            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    $html.removeClass('no-transition');
                });
            });

            if ($html.hasClass('sb-peek')) {
                setTimeout(function() {
                    if (!$sidebar.is(':hover')) {
                        $html.removeClass('sb-peek');
                    }
                }, 400);
            }

            function saveSidebarState(collapsed) {
                try {
                    var saved = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
                    if (collapsed) {
                        saved[PAGE_KEY] = true;
                    } else {
                        delete saved[PAGE_KEY];
                    }
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(saved));
                } catch (e) {}
            }

            $sidebar
                .on('mouseenter', function() {
                    if (suppressPeek) return;
                    clearTimeout(peekTimer);
                    peekTimer = setTimeout(function() {
                        $html.addClass('sb-peek');
                    }, 120);
                })
                .on('mouseleave', function() {
                    suppressPeek = false;
                    clearTimeout(peekTimer);
                    $html.removeClass('sb-peek');
                });

            $sidebar.on('click', 'a[href]', function() {
                var href = $(this).attr('href');
                if (!href || href === '#' || href.indexOf('javascript:') === 0) return;
                try {
                    if ($html.hasClass('sb-collapsed') && $html.hasClass('sb-peek')) {
                        sessionStorage.setItem('sb_peek', '1');
                    }
                } catch (e) {}
            });

            $('#sidebarToggle').on('click', function() {
                var collapsed = $html.toggleClass('sb-collapsed').hasClass('sb-collapsed');

                if (collapsed) {
                    clearTimeout(peekTimer);
                    $html.removeClass('sb-peek');
                    suppressPeek = true;
                }

                saveSidebarState(collapsed);
            });

            $('.has-sub').on('click', function(e) {
                if ($(e.target).closest('.sub-menu').length) return;

                var $item = $(this);
                var $sub = $item.find('.sub-menu');
                var isOpen = $item.hasClass('open');

                $('.has-sub.open').not($item).removeClass('open')
                    .find('.sub-menu').removeClass('open');

                $item.toggleClass('open', !isOpen);
                $sub.toggleClass('open', !isOpen);
            });

            $('.sub-menu').each(function() {
                if ($(this).find('.sub-item.active').length) {
                    $(this).addClass('open')
                        .closest('.has-sub').addClass('open');
                }
            });
        });
    </script>
@endpush