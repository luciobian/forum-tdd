<div id="reply-{{$reply->id}}" class="card">
        <div class="card-header">
                <div class="level">
                        <h6 class="flex">
                                <a href="{{route('profile',  $reply->owner->name)}}">
                                        {{$reply->owner->name}}
                                </a>
                                said {{$reply->created_at->diffForHumans()}}...
                        </h6>
                        <div>
                                <form action="/replies/{{ $reply->id }}/favorites" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-default"
                                                {{ $reply->isFavorited() ? 'disabled' : '' }}>
                                                {{$reply->favorites_count}}
                                                {{str_plural('Favorite', $reply->favorites_count)}}
                                        </button>

                                </form>
                        </div>
                </div>
        </div>
        <div class="card-body">
                {{$reply->body}}
        </div>

        @can('update', $reply)
        <div class="card-footer">
                <form action="/replies/{{$reply->id}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-danger btn-sm">
                                Delete
                        </button>
                </form>
        </div>
        @endcan

</div>