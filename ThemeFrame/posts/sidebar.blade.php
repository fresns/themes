<nav class="navbar navbar-expand-lg navbar-light bg-light py-lg-0 mb-4 mx-3 mx-lg-0">
    <span class="navbar-brand mb-0 h1 d-lg-none ms-3">{{ fs_db_config('post_name') }}</span>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#fresnsMenus" aria-controls="fresnsMenus" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-signpost-2"></i>
    </button>
    <div class="collapse navbar-collapse list-group mt-2 mt-lg-0" id="fresnsMenus">
        {{-- Post Home --}}
        @if (fs_db_config('menu_post_status'))
            <a href="{{ fs_route(route('fresns.post.index')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.post.index') ? 'active' : '' }}
                @if (request()->url() === rtrim(fs_route(route('fresns.home')), '/')) active @endif">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-post-home.png" width="36" height="36">
                {{ fs_db_config('menu_post_name') }}
            </a>
        @endif

        {{-- Post List --}}
        @if (fs_db_config('menu_post_list_status'))
            <a href="{{ fs_route(route('fresns.post.list')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.post.list') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-post-list.png" width="36" height="36">
                {{ fs_db_config('menu_post_list_name') }}
            </a>
        @endif

        {{-- Posts from nearby --}}
        @if (fs_api_config('post_editor_location'))
            <a href="{{ fs_route(route('fresns.post.nearby')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.post.nearby') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-nearby.png" width="36" height="36">
                {{ fs_db_config('menu_nearby_posts') }}
            </a>
        @endif

        {{-- My like posts --}}
        @if (fs_api_config('like_post_setting'))
            <a href="{{ fs_route(route('fresns.post.likes')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.post.likes') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-likes.png" width="36" height="36">
                {{ fs_db_config('menu_like_posts') }}
            </a>
        @endif

        {{-- My dislike posts --}}
        @if (fs_api_config('dislike_post_setting'))
            <a href="{{ fs_route(route('fresns.post.dislikes')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.post.dislikes') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-dislikes.png" width="36" height="36">
                {{ fs_db_config('menu_dislike_posts') }}
            </a>
        @endif

        {{-- My follow posts --}}
        @if (fs_api_config('follow_post_setting'))
            <a href="{{ fs_route(route('fresns.post.following')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.post.following') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-following.png" width="36" height="36">
                {{ fs_db_config('menu_follow_posts') }}
            </a>
        @endif

        {{-- My block posts --}}
        @if (fs_api_config('block_post_setting'))
            <a href="{{ fs_route(route('fresns.post.blocking')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.post.blocking') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-blocking.png" width="36" height="36">
                {{ fs_db_config('menu_block_posts') }}
            </a>
        @endif

        {{-- Posts from I follow (users, groups, hashtags) --}}
        @if (fs_api_config('view_posts_by_follow_object'))
            <a href="{{ fs_route(route('fresns.follow.all.posts')) }}" class="list-group-item list-group-item-action {{ Route::is('fresns.follow.all.posts') ? 'active' : '' }}">
                <img class="img-fluid" src="/assets/themes/ThemeFrame/images/menu-follow-posts.png" width="36" height="36">
                {{ fs_db_config('menu_follow_all_posts') }}
            </a>
        @endif
    </div>
</nav>
