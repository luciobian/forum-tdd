<reply :attributes="{{ $reply }}" inline-template v-cloak>
        <div id="reply-{{$reply->id}}" class="card">
                <div class="card-header">
                        <div class="level">
                                <h6 class="flex">
                                        <a href="{{route('profile',  $reply->owner->name)}}">
                                                {{$reply->owner->name}}
                                        </a>
                                        said {{$reply->created_at->diffForHumans()}}...
                                </h6>

                                @if (Auth::check())
                                        <div>
                                                <favorite :reply="{{$reply}}"></favorite>
                                        </div>
                                @endif
                        </div>
                </div>
                <div class="card-body">
                        <div v-if="editing">
                                <form action="" class="form-group">
                                        <textarea class="form-control" v-model="body"></textarea>
                                </form>
                                <button class="btn btn-primary btn-sm" @click="update">Update</button>
                                <button class="btn btn-link btn-sm" @click="editing = false">Cancel</button>
                        </div>

                        <div v-else v-text="body"></div>
                </div>

                @can('update', $reply)
                <div class="card-footer level">

                        <button class="btn btn-secondary btn-sm mr-1" @click="editing = true">Edit</button>
                        <button class="btn btn-danger btn-sm mr-1" @click="destroy">Delete</button>
                </div>
                @endcan
        </div>
</reply>