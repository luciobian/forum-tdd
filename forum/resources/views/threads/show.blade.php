@extends('layouts.app')

@section('content')
<div class="row ml-5">
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-header">
                <div class="level">
                    <span class="flex">
                        <a href="{{route('profile',  $thread->creator->name )}}"> {{$thread->creator->name}}</a> posted:
                        {{$thread->title}}
                    </span>
                    @if (Auth::check())
                    <form action="{{ $thread->path() }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-link">Delete thread</button>
                    </form>
                    @endif
                </div>
            </div>

            <div class="card-body">
                {{$thread->body}}
            </div>
        </div>

        <div class="mb-3">
            @foreach ($replies as $reply)
            @include('threads.reply')
            @endforeach
        </div>

        <div class="mb-3">
            {{ $replies->links() }}
        </div>

        @if(auth()->check())
        <form action="{{$thread->path().'/replies'}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <textarea name="body" class="form-control" id="body" placeholder="Have something to say?"></textarea>
            </div>
            <button class="btn" type="submit">Post</button>
        </form>
        @else
        <p class="text-center">Please <a href="{{ route('login') }}"> sign in</a> to participate in this discussion.</p>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p>
                    This thread was published {{$thread->created_at->diffForHumans()}} by
                    <a href="{{route('profile',  $thread->creator->name )}}">{{$thread->creator->name}} </a>, and
                    currently has {{$thread->replies_count}} {{str_plural('comment', $thread->replies_count)}}.
                </p>

            </div>
        </div>

    </div>
    <br>


    @endsection