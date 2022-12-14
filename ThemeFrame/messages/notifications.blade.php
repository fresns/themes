@extends('commons.fresns')

@section('title', fs_db_config('menu_notifications'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('account.sidebar')
            </div>

            {{-- Notification List --}}
            <div class="col-sm-9">
                <div class="card">
                    {{-- Menus --}}
                    @if(fs_db_config('fs_theme_notifications', []))
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                {{-- all notifications --}}
                                <li class="nav-item">
                                    <a class="nav-link @if(empty($types)) active @endif" href="{{ fs_route(route('fresns.message.notifications')) }}">
                                        {{ fs_db_config('menu_notifications_all') }}
                                        @if(array_sum(fs_user_panel('unreadNotifications')) > 0)
                                            <span class="badge bg-danger">{{ array_sum(fs_user_panel('unreadNotifications')) }}</span>
                                        @endif
                                    </a>
                                </li>

                                {{-- system notifications --}}
                                @if(in_array('systems', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 1) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 1])) }}">
                                            {{ fs_db_config('menu_notifications_systems') }}
                                            @if(fs_user_panel('unreadNotifications.systems') > 0)
                                                <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.systems') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- recommend notifications --}}
                                @if(in_array('recommends', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 2) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 2])) }}">
                                            {{ fs_db_config('menu_notifications_recommends') }}
                                            @if(fs_user_panel('unreadNotifications.recommends') > 0)
                                                <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.recommends') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- like notifications --}}
                                @if(in_array('likes', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 3) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 3])) }}">
                                            {{ fs_db_config('menu_notifications_likes') }}
                                            @if(fs_user_panel('unreadNotifications.likes') > 0)
                                                <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.likes') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- dislike notifications --}}
                                @if(in_array('dislikes', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 4) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 4])) }}">
                                            {{ fs_db_config('menu_notifications_dislikes') }}
                                            @if(fs_user_panel('unreadNotifications.dislikes') > 0)
                                                <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.dislikes') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- follow notifications --}}
                                @if(in_array('follows', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 5) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 5])) }}">
                                            {{ fs_db_config('menu_notifications_follows') }}
                                            @if(fs_user_panel('unreadNotifications.follows') > 0)
                                                <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.follows') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- block notifications --}}
                                @if(in_array('blocks', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 6) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 6])) }}">
                                            {{ fs_db_config('menu_notifications_blocks') }}
                                            @if(fs_user_panel('unreadNotifications.blocks') > 0)
                                                <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.blocks') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- mention notifications --}}
                                @if(in_array('mentions', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 7) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 7])) }}">
                                            {{ fs_db_config('menu_notifications_mentions') }}
                                            @if(fs_user_panel('unreadNotifications.mentions') > 0)
                                                <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.mentions') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- comment notifications --}}
                                @if(in_array('comments', fs_db_config('fs_theme_notifications', [])))
                                    <li class="nav-item">
                                        <a class="nav-link @if($types == 8) active @endif" href="{{ fs_route(route('fresns.message.notifications', ['types' => 8])) }}">
                                            {{ fs_db_config('menu_notifications_comments') }}
                                            @if(fs_user_panel('unreadNotifications.comments') > 0)
                                                <span class="badge bg-danger">{{ fs_user_panel('unreadNotifications.comments') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    {{-- Notifications --}}
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            {{-- No Notification --}}
                            @if ($notifications->isEmpty())
                                <li class="list-group-item text-center my-5 text-muted fs-7"><i class="bi bi-chat-square"></i> {{ fs_lang('listEmpty') }}</li>
                            @endif

                            {{-- Mark all as read --}}
                            @if ($notifications->isNotEmpty() && $types)
                                <li class="list-group-item d-flex justify-content-center align-items-center pb-3">
                                    <form class="api-request-form" action="{{ route('fresns.api.message.mark.as.read', ['type' => 'notification')) }}" method="put">
                                        @csrf
                                        <input type="hidden" name="type" value="all"/>
                                        <input type="hidden" name="notificationType" value="{{ $types }}"/>
                                        <input type="hidden" name="notificationIds" value=""/>
                                        <button class="btn btn-success btn-sm" type="submit">{{ fs_lang('notificationMarkAllAsRead') }}</button>
                                    </form>
                                </li>
                            @endif

                            {{-- Notification List --}}
                            @foreach($notifications as $notification)
                                @component('components.message.notification', compact('notification'))@endcomponent
                            @endforeach
                        </ul>

                        <div class="my-3">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
