<div id="topbar">

    @if ($search ?? false)
        <div class="search-wrap">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass s-icon"></i>
                <form method="GET">
                    <input type="text" placeholder="Search {{ Str::headline(collect(request()->segments())->last() ?? 'Dashboard') }}…"
                        id="searchInput" name="keyword" value="{{ request()->query('keyword', '') }}">
                </form>
                <div class="search-kbd">
                    <span class="kbd" id="searchModKey">Ctrl</span>
                    <span class="kbd-plus">+</span>
                    <span class="kbd">K</span>
                </div>
            </div>
        </div>
    @endif

    <div class="d-flex align-items-center gap-2 ms-auto">
        <div class="top-btn" id="darkModeBtn"><i class="fa-regular fa-moon"></i></div>
        <div class="top-btn" onclick="showAlert('info')">
            <i class="fa-regular fa-bell"></i>
            <span class="notif-dot"></span>
        </div>
        <div class="top-btn" onclick="showNotice('progress')"><i class="fa-solid fa-rotate"></i></div>
        <div class="avatar-btn">JD</div>
    </div>
</div>

@push('js')
    <script>
        $(function() {

            const isApple = /Mac|iPhone|iPad|iPod/i.test(
                navigator.userAgentData?.platform || navigator.platform || navigator.userAgent
            );
            if (isApple) {
                $('#searchModKey').text('⌘');
            }

            $(document).on('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    if (!$('#searchInput').length) return;
                    e.preventDefault();
                    $('#searchInput').focus();
                }
                if (e.key === 'Escape') {
                    $('#searchInput').blur();
                }
            });

            $('#darkModeBtn').on('click', function() {
                $('body').toggleClass('dark-mode');
                const isDark = $('body').hasClass('dark-mode');
                $(this).find('i').toggleClass('fa-moon', !isDark).toggleClass('fa-sun', isDark);
                localStorage.setItem('darkMode', isDark ? '1' : '0');
            });

            if (localStorage.getItem('darkMode') === '1') {
                $('body').addClass('dark-mode');
                $('#darkModeBtn i').removeClass('fa-moon').addClass('fa-sun');
            }

        });
    </script>
@endpush
