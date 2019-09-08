@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 offset-md-2">

            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h1>
                    {{ $profileUser->name }}
                </h1>
                <small> Since: {{ $profileUser->created_at->diffForHumans() }} </small>
            </div>
            @foreach ($activities as $date => $activity)
            <div class="pb-2 mt-4 mb-2 border-bottom">
                {{$date}}
            </div>
                @foreach ($activity as $item)
                  @if (view()->exists("profiles.activities.{$item->type}"))
                    @include("profiles.activities.{$item->type}", ['activity' => $item]) 
                  @endif
                @endforeach
            @endforeach

        </div>

    </div>

</div>


@endsection