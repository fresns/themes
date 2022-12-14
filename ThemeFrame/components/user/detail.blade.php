@php
    $user = $user ?? $profile;
    $followersYouFollow = $followersYouFollow ?? [];
@endphp

@if ($user['banner'])
    <img src="{{ $user['banner'] }}" class="card-img-top">
@endif

<section class="avatar">
    @if ($user['decorate'])
        <img src="{{ $user['decorate'] }}" alt="Avatar Decorate" class="profile-decorate">
    @endif
    <img src="{{ $user['avatar'] }}" alt="{{ $user['nickname'] }}" class="profile-avatar rounded-circle">
</section>

<section class="userinfo">
    <div class="profile-nickname d-flex justify-content-center">
        <h1 style="color:{{ $user['nicknameColor'] }};">{{ $user['nickname'] }}</h1>
        @if ($user['verifiedStatus'])
            @if ($user['verifiedIcon'])
                <img src="{{ $user['verifiedIcon'] }}" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user['verifiedDesc'] }}">
            @else
                <img src="/assets/themes/ThemeFrame/images/icon-verified.png" alt="Verified" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user['verifiedDesc'] }}">
            @endif
        @endif
        @if ($user['roleIconDisplay'] && $user['roleIcon'])
            <img src="{{ $user['roleIcon'] }}" alt="{{ $user['roleName'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user['roleName'] }}">
        @endif
        @if ($user['roleNameDisplay'])
            <span class="badge text-bg-secondary">{{ $user['roleName'] }}</span>
        @endif
    </div>
    <div class="mb-2 text-secondary">{{ '@'.$user['fsid'] }}</div>
    <p class="fs-7 text-secondary">{{ $user['bio'] }}</p>

    {{-- User Attachment Icons --}}
    @if ($user['operations']['diversifyImages'])
        <div class="text-center">
            @foreach($user['operations']['diversifyImages'] as $icon)
                <img src="{{ $icon['imageUrl'] }}" alt="{{ $icon['name'] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $icon['name'] }}" style="height:2rem">
            @endforeach
        </div>
    @endif
</section>

@if (fs_api_config('it_followers_you_follow') && $followersYouFollow)
    <section class="text-center my-3">
        <a href="{{ fs_route(route('fresns.profile.followers.you.follow', ['uidOrUsername' => $user['fsid']])) }}" class="text-muted fs-7 text-decoration-none">
            @foreach($followersYouFollow as $friend)
                {{ $friend['nickname'] }}@if (! $loop->last), @endif
            @endforeach
            {{ fs_lang('userFollowersYouKnow') }}
        </a>
    </section>
@endif

<section class="d-flex justify-content-center overflow-hidden mb-4">
    {{-- Conversation --}}
    @if (fs_api_config('conversation_status') && $user['conversation']['status'])
        <button type="button" class="btn btn-outline-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#conversationModal-{{ $user['fsid'] }}">{{ fs_db_config('menu_conversations') }}</button>
    @endif

    {{-- Like --}}
    @if ($user['interaction']['likeSetting'])
        @component('components.user.mark.like', [
            'uid' => $user['uid'],
            'interaction' => $user['interaction'],
            'count' => $user['stats']['likeMeCount']
        ])@endcomponent
    @endif

    {{-- Dislike --}}
    @if ($user['interaction']['dislikeSetting'])
        @component('components.user.mark.dislike', [
            'uid' => $user['uid'],
            'interaction' => $user['interaction'],
            'count' => $user['stats']['dislikeMeCount']
        ])@endcomponent
    @endif

    {{-- Follow --}}
    @if ($user['interaction']['followSetting'])
        @component('components.user.mark.follow', [
            'uid' => $user['uid'],
            'interaction' => $user['interaction'],
            'count' => $user['stats']['followMeCount']
        ])@endcomponent
    @endif

    {{-- Block --}}
    @if ($user['interaction']['blockSetting'])
        @component('components.user.mark.block', [
            'uid' => $user['uid'],
            'interaction' => $user['interaction'],
            'count' => $user['stats']['blockMeCount']
        ])@endcomponent
    @endif

    {{-- Follow Status --}}
    @if ($user['interaction']['followMeStatus'] && $user['interaction']['followStatus'])
        <span class="badge rounded-pill bg-secondary m-1">{{ fs_lang('userFollowMutual') }}</span>
    @elseif ($user['interaction']['followMeStatus'])
        <span class="badge rounded-pill bg-secondary m-1">{{ fs_lang('userFollowMe') }}</span>
    @endif
</section>

{{-- Conversation Modal --}}
@if (fs_api_config('conversation_status') && $user['conversation']['status'])
    <div class="modal fade" id="conversationModal-{{ $user['fsid'] }}" tabindex="-1" aria-labelledby="conversationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="conversationModalLabel">
                        <a href="{{ fs_route(route('fresns.message.index')) }}" target="_blank" class="text-decoration-none"><i class="bi bi-chat-square-dots"></i> {{ fs_db_config('menu_conversations') }}</a>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @component('components.message.send', [
                        'user' => $user,
                    ])@endcomponent
                </div>
            </div>
        </div>
    </div>
@endif
