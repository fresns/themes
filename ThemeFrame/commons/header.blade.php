@push('script')
    @if (fs_account()->check() && fs_user()->guest() && Route::is('fresns.account.login'))
        <script>
            $(function () {
                var userCount = "{{ count(fs_account('detail.users')) }}";

                switch (Number(userCount)) {
                    default:
                        new bootstrap.Modal('#userAuth').show();
                    break;
                    case 1:
                        var hasPassword = "{{ fs_account('detail.users.0.hasPassword') }}" || true;
                        if (hasPassword == "true") {
                            new bootstrap.Modal('#userPwdLogin').show()
                        } else {
                            $("#uid-{{ fs_account('detail.users.0.uid') }} button").click()
                        }
                    break;
                }
            })
        </script>
    @endif
@endpush

<header class="fixed-top">
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ fs_route(route('fresns.home')) }}"><img src="{{ fs_db_config('site_logo') }}" height="40"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#fresnsNavbar" aria-controls="fresnsNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ms-3" id="fresnsNavbar">
                {{-- navbar --}}
                <ul class="nav nav-pills me-auto my-4 my-lg-0">
                    {{-- portal --}}
                    @if (fs_db_config('menu_portal_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('fresns.portal') ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'portal') active @endif"
                                href="{{ fs_route(route('fresns.portal')) }}">
                                {{fs_db_config('menu_portal_name')}}
                            </a>
                        </li>
                    @endif

                    {{-- user --}}
                    @if (fs_db_config('menu_user_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.user.*', 'fresns.follow.user.*']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'user') active @endif"
                                href="{{ fs_route(route('fresns.user.index')) }}">
                                {{fs_db_config('menu_user_name')}}
                            </a>
                        </li>
                    @endif

                    {{-- group --}}
                    @if (fs_db_config('menu_group_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.group.*', 'fresns.follow.group.*']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'group') active @endif"
                                href="{{ fs_route(route('fresns.group.index')) }}">
                                {{fs_db_config('menu_group_name')}}
                            </a>
                        </li>
                    @endif

                    {{-- hashtag --}}
                    @if (fs_db_config('menu_hashtag_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.hashtag.*', 'fresns.follow.hashtag.*']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'hashtag') active @endif"
                                href="{{ fs_route(route('fresns.hashtag.index')) }}">
                                {{fs_db_config('menu_hashtag_name')}}
                            </a>
                        </li>
                    @endif

                    {{-- post --}}
                    @if (fs_db_config('menu_post_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.post.*', 'fresns.follow.all.posts']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'post') active @endif"
                                href="{{ fs_route(route('fresns.post.index')) }}">
                                {{fs_db_config('menu_post_name')}}
                            </a>
                        </li>
                    @endif

                    {{-- comment --}}
                    @if (fs_db_config('menu_comment_status'))
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is(['fresns.comment.*', 'fresns.follow.all.comments']) ? 'active' : '' }}
                                @if (request()->url() == rtrim(fs_route(route('fresns.home')), '/') && fs_db_config('default_homepage') == 'comment') active @endif"
                                href="{{ fs_route(route('fresns.comment.index')) }}">
                                {{fs_db_config('menu_comment_name')}}
                            </a>
                        </li>
                    @endif
                </ul>

                {{-- search --}}
                <form class="me-3 my-4 my-lg-0" action="{{ fs_route(route('fresns.search.index')) }}" method="get">
                    <input class="form-control" name="searchKey" value="{{ request('searchKey') }}" placeholder="{{ fs_lang('search') }} Fresns" aria-label="Search">
                </form>

                {{-- Login Status --}}
                <div class="d-flex mb-4 mb-lg-0">
                    @if (fs_user()->check())
                        {{-- Logged in --}}
                        <a class="btn" href="{{ fs_route(route('fresns.account.index')) }}" role="button"><img src="{{ fs_user('detail.avatar') }}" class="nav-avatar rounded-circle"> {{ fs_user('detail.nickname') }}</a>

                        <button type="button" class="btn btn-outline-secondary btn-nav ms-2 rounded-circle" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-plus-lg"></i></button>

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-nav ms-2 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-caret-down-fill"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.index')) }}"><i class="bi bi-person-fill"></i> {{ fs_api_config('menu_account') }}</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ fs_route(route('fresns.message.notify', ['types' => 1])) }}">
                                        <i class="bi bi-chat-square-dots"></i>
                                        {{ fs_api_config('menu_notifies') }}

                                        @if(array_sum($userPanel['notifyUnread']) > 0)
                                            <span class="badge bg-danger">{{ array_sum($userPanel['notifyUnread']) }}</span>
                                        @endif
                                    </a>
                                </li>
                                @if (fs_api_config('dialog_status'))
                                    <li>
                                        <a class="dropdown-item" href="{{ fs_route(route('fresns.message.index')) }}">
                                            <i class="bi bi-envelope"></i>
                                            {{ fs_db_config('menu_dialogs') }}

                                            @if($userPanel['dialogUnread']['messages'] > 0)
                                                <span class="badge bg-danger">{{ $userPanel['dialogUnread']['messages'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ fs_route(route('fresns.editor.drafts', ['type' => 'posts'])) }}">
                                        <i class="bi bi-file-earmark-text"></i>
                                        {{ fs_api_config('menu_editor_drafts') }}

                                        @if(array_sum($userPanel['draftCount']) > 0)
                                            <span class="badge bg-primary">{{ array_sum($userPanel['draftCount']) }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.wallet')) }}"><i class="bi bi-wallet"></i> {{ fs_api_config('menu_account_wallet') }}</a></li>
                                @if (count(fs_account('detail.users')) > 1)
                                    <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.users')) }}"><i class="bi bi-people"></i> {{ fs_api_config('menu_account_users') }}</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.settings')) }}"><i class="bi bi-gear"></i> {{ fs_api_config('menu_account_settings') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @if (fs_api_config('language_status'))
                                    <li><a class="dropdown-item" href="#translate" data-bs-toggle="modal"><i class="bi bi-translate"></i> {{ fs_lang('optionLanguage') }}</a></li>
                                @endif
                                @if (count(fs_account('detail.users')) > 1)
                                    <li><a class="dropdown-item" href="#userAuth" id="switch-user" data-bs-toggle="modal"><i class="bi bi-people"></i> {{ fs_lang('optionUser') }}</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ fs_route(route('fresns.account.logout')) }}"><i class="bi bi-power"></i> {{ fs_lang('accountLogout') }}</a></li>
                            </ul>
                        </div>
                    @else
                        {{-- Not logged in --}}
                        <a class="btn btn-outline-success me-3" href="{{ fs_route(route('fresns.account.login')) }}" role="button">{{ fs_lang('accountLogin') }}</a>

                        @if (fs_api_config('site_public_status'))
                            @if (fs_api_config('site_public_service'))
                                <button class="btn btn-success me-3" type="button" data-bs-toggle="modal" data-bs-target="#fresnsModal"
                                    data-lang-tag="{{ current_lang_tag() }}"
                                    data-type="account"
                                    data-scene="join"
                                    data-post-message-key="fresnsJoin"
                                    data-title="{{ fs_lang('accountRegister') }}"
                                    data-url="{{ fs_api_config('site_public_service') }}">
                                    {{ fs_lang('accountRegister') }}
                                </button>
                            @else
                                <a class="btn btn-success me-3" href="{{ fs_route(route('fresns.account.register')) }}" role="button">{{ fs_lang('accountRegister') }}</a>
                            @endif
                        @endif

                        @if (fs_api_config('language_status'))
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="language" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-translate"></i>
                                    @foreach(fs_api_config('language_menus') as $lang)
                                        @if (current_lang_tag() == $lang['langTag']) {{ $lang['langName'] }} @endif
                                    @endforeach
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @foreach(fs_api_config('language_menus') as $lang)
                                        @if ($lang['isEnable'])
                                            <li>
                                                <a class="dropdown-item @if (current_lang_tag() == $lang['langTag']) active @endif" hreflang="{{ $lang['langTag'] }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($lang['langTag'], null, [], true) }}">
                                                    {{ $lang['langName'] }}
                                                    @if ($lang['areaName'])
                                                        {{ '('.$lang['areaName'].')' }}
                                                    @endif
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    @endif
                </div>

            </div>
        </div>
    </nav>
</header>

@if (fs_api_config('language_status'))
    {{-- Switching Languages --}}
    <div class="modal fade" id="translate" tabindex="-1" aria-labelledby="translateModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ fs_lang('optionLanguage') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        @foreach(fs_api_config('language_menus') as $lang)
                            @if ($lang['isEnable'])
                                <a class="list-group-item list-group-item-action @if (current_lang_tag() == $lang['langTag']) active @endif" hreflang="{{ $lang['langTag'] }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($lang['langTag'], null, [], true) }}">
                                    {{ $lang['langName'] }}
                                    @if ($lang['areaName'])
                                        {{ '('.$lang['areaName'].')' }}
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

@if (fs_account()->check())
    {{-- After login: Select user --}}
    <div class="modal fade" id="userAuth" data-bs-backdrop="static" tabindex="-1"  aria-hidden="true" aria-labelledby="userAuthModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ fs_lang('optionUser') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach(fs_account('detail.users') as $item)
                            <div class="col-sm-3 d-flex flex-column align-items-center">
                                <img src="{{ $item['avatar'] }}" class="auth-avatar rounded-circle">
                                <div class="auth-nickname mt-2">{{ $item['nickname'] }}</div>
                                <div class="text-secondary">{{ '@' . $item['username'] }}</div>
                                <form action="{{ route('fresns.api.user.auth') }}" id="#uid-{{ $item['uid'] }}" method="post">
                                    @csrf
                                    <input type="hidden" name="uidOrUsername" value="{{ $item['uid'] }}">
                                    @if ($item['hasPassword'])
                                        <a data-bs-target="#userPwdLogin" data-uid="{{ $item['uid'] }}" data-nickname="{{ $item['nickname'] }}" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-outline-secondary btn-sm my-2" onclick="$('#userPwdLoginLabel').text($(this).data('nickname'));$('#userPwdLogin input[name=uidOrUsername]').val($(this).data('uid'))">{{ fs_lang('userPassword') }}</a>
                                    @else
                                        <button type="submit" class="btn btn-outline-secondary btn-sm my-2">{{ fs_lang('choose') }}</button>
                                    @endif
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- After login: select user - enter password --}}
    <div class="modal fade" id="userPwdLogin" aria-hidden="true" aria-labelledby="userPwdLoginLabel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('fresns.api.user.auth') }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userPwdLoginLabel">
                            @if (count(fs_account('detail.users')) == 1)
                                {{ fs_account('detail.users.0.nickname') }}
                            @else
                                User Password Login
                            @endif
                        </h5>
                        <button type="button" class="btn-close" data-bs-target="#userAuth" data-bs-toggle="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @if (count(fs_account('detail.users')) == 1)
                            <input type="hidden" name="uidOrUsername" value="{{ fs_account('detail.users.0.uid') }}">
                        @else
                            <input type="hidden" name="uidOrUsername">
                        @endif
                        <div class="input-group">
                            <span class="input-group-text">{{ fs_lang('userAuthPassword') }}</span>
                            <input type="password" class="form-control" required name="password">
                        </div>
                        <div class="invalid-feedback" style="display: block"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ fs_lang('userAuth') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif