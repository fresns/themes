<nav class="navbar navbar-expand-lg navbar-light bg-light py-lg-0 mb-4 mx-3 mx-lg-0">
    <span class="navbar-brand mb-0 h1 d-lg-none ms-3">{{ fs_db_config('user_name') }}</span>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#fresnsMenus" aria-controls="fresnsMenus" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-signpost-2"></i>
    </button>
    <div class="collapse navbar-collapse list-group mt-2 mt-lg-0" id="fresnsMenus">
        {{-- User Home --}}
        @if (fs_db_config('menu_user_status'))
            <a href="{{ fs_route(route('fresns.user.index')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.user.index') ? 'active' : '' }}
                @if (request()->url() === rtrim(fs_route(route('fresns.home')), '/')) active @endif">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-user-home.png" width="36" height="36">
                {{ fs_db_config('menu_user_name') }}
            </a>
        @endif

        {{-- User List --}}
        @if (fs_db_config('menu_user_list_status'))
            <a href="{{ fs_route(route('fresns.user.list')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.user.list') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-user-list.png" width="36" height="36">
                {{ fs_db_config('menu_user_list_name') }}
            </a>
        @endif

        {{-- My like users --}}
        @if (fs_api_config('like_user_setting'))
            <a href="{{ fs_route(route('fresns.user.likes')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.user.likes') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-likes.png" width="36" height="36">
                {{ fs_db_config('menu_like_users') }}
            </a>
        @endif

        {{-- My dislike users --}}
        @if (fs_api_config('dislike_user_setting'))
            <a href="{{ fs_route(route('fresns.user.dislikes')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.user.dislikes') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-dislikes.png" width="36" height="36">
                {{ fs_db_config('menu_dislike_users') }}
            </a>
        @endif

        {{-- My follow users --}}
        @if (fs_api_config('follow_user_setting'))
            <a href="{{ fs_route(route('fresns.user.following')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.user.following') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-following.png" width="36" height="36">
                {{ fs_db_config('menu_follow_users') }}
            </a>
        @endif

        {{-- My block users --}}
        @if (fs_api_config('block_user_setting'))
            <a href="{{ fs_route(route('fresns.user.blocking')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.user.blocking') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-blocking.png" width="36" height="36">
                {{ fs_db_config('menu_block_users') }}
            </a>
        @endif

        {{-- I follow the users posts --}}
        @if (fs_api_config('view_posts_by_follow_object'))
            <a href="{{ fs_route(route('fresns.follow.user.posts')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.follow.user.posts') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-follow-posts.png" width="36" height="36">
                {{ fs_db_config('menu_follow_user_posts') }}
            </a>
        @endif

        {{-- I follow the users comments --}}
        @if (fs_api_config('view_comments_by_follow_object'))
            <a href="{{ fs_route(route('fresns.follow.user.comments')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.follow.user.comments') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-follow-comments.png" width="36" height="36">
                {{ fs_db_config('menu_follow_user_comments') }}
            </a>
        @endif
    </div>
</nav>
