<div class="list-group">
    @foreach ($following as $follow)
        <a href="/post/{{ $follow->userBeingFollowed->username }}" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src="{{ $follow->userBeingFollowed->avatar }}" />
            {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('n/j/Y') }} --}}
            {{ $follow->userBeingFollowed->username }}
        </a>
    @endforeach
</div>
