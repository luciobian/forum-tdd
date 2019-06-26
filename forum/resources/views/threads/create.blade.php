@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new thread</div>

                <div class="card-body">

                    <form action="/threads" class="form-group" method="post">
                        {{csrf_field()}}
                        <label for="tittle">Title:</label>
                        <input type="text" name="title" id="title" class="form-control">

                        <label for="body">Body:</label>
                        <textarea name="body" id="body" rows="8" class="form-control"></textarea>

                        <button type="submit" class="btn btn-primary mt-2" >Publish</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
