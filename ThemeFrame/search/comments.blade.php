@extends('commons.fresns')

@section('title', fs_db_config('menu_search').': '.fs_db_config('comment_name'))

@section('content')
    <main class="container-fluid">
        <div class="row mt-5 pt-5">
            {{-- Left Sidebar --}}
            <div class="col-sm-3">
                @include('search.sidebar')
            </div>

            {{-- Middle Content --}}
            <div class="col-sm-6">
                {{-- Comment List --}}
                <article class="card clearfix">
                    @foreach($comments as $comment)
                        @component('components.comment.list', compact('comment'))@endcomponent
                        @if (! $loop->last)
                            <hr>
                        @endif
                    @endforeach
                </article>

                {{-- Pagination --}}
                <div class="my-3">
                    {{ $comments->links() }}
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-sm-3">
                @include('commons.sidebar')
            </div>
        </div>
    </main>
@endsection
