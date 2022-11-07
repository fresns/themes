<form action="{{ route('fresns.api.user.mark') }}" method="post" class="float-start me-2">
    @csrf
    <input type="hidden" name="interactiveType" value="block"/>
    <input type="hidden" name="markType" value="user"/>
    <input type="hidden" name="fsid" value="{{ $uid }}"/>
    @if ($interactive['blockStatus'])
        <a class="btn btn-success btn-sm fs-mark" data-interactive-active="{{ $interactive['blockStatus'] }}" data-bi="bi-x-octagon">
            <i class="bi bi-x-octagon-fill"></i>
            @if (fs_api_config('user_blocker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @else
        <a class="btn btn-outline-success btn-sm fs-mark" data-bi="bi-x-octagon-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $interactive['blockName'] }}">
            <i class="bi bi-x-octagon"></i>
            @if (fs_api_config('user_blocker_count'))
                <span class="show-count">{{ $count }}</span>
            @endif
        </a>
    @endif
</form>