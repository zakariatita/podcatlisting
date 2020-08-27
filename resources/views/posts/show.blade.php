@extends('layouts.app')

@section('content')

{{ Form::open(['action' => ['PostsController@update',$post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
    <div class="modal" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Editing Post</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class="form-group">

                    {{Form::label('title', 'Title :')}}
                    {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}

                </div>

                <div class="form-group">
                    {{Form::label('body', 'Description')}}
                    {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
                </div>
                <div class="form-group">
                    {{Form::Label('item', 'Color:') }}
                    <select id="item_id" value="" class="form-control text-white {{$post->category}}" name="item_id" onchange="changecolor()">
                        <option value="bg-primary" class="text-white bg-primary m-3">Blue</option>
                        <option value="bg-secondary" class="text-white bg-secondary m-3">Grey</option>
                        <option value="bg-success" class="text-white bg-success m-3">Green</option>
                        <option value="bg-danger" class="text-white bg-danger m-3">Red</option>
                        <option value="bg-warning" class=" bg-warning m-3">Orange</option>
                        <option value="bg-info" class="text-white bg-info m-3">Blue 2</option>
                        <option value="bg-dark" class="text-white bg-dark m-3">Black</option>

                    </select>

            </div>
            <script>
                var e = document.getElementById("item_id");
                var strUser ="{{$post->category}}";
                document.getElementById("item_id").value =  "{{ $post->category}}";
                 function changecolor() {
                    document.getElementById("item_id").classList.remove(strUser);
                     strUser = e.options[e.selectedIndex].value;
                    document.getElementById("item_id").classList.add(strUser);

              }
                </script>
                <div class="form-group">
                    <label class="btn btn-primary" >
                        Select post image
                        {{Form::file('post_image', ['class' => 'custom-file-input',])}}
                    </label>

                </div>
          </div>
          {{Form::hidden('_method', 'PUT')}}
          {{Form::submit('Submit', ['class'=>'btn btn-success'])}}
          {{ Form::close() }}

        </div>
      </div>

    </div>
    <a href="/posts" class="btn btn-primary mt-2">Go back</a>
<div class="card-deck mt-2">
    @if($post->category == "bg-warning")
    <div class="card {{$post->category}}  mb-3" >
     @else <div class="card text-white {{$post->category}} mb-3" >
        @endif

            <div class="card-body">
                       <h1>{{$post->title}}</h1>
                       <h5> {{$post->body}}</h5>
                       <br><br>
                       <img class="img-thumbnail" src="/storage/post_image/{{$post->URLi}}" alt="Card image cap">
                       <br><br>
                        <div class="card-footer ">
                          <small>Written on {{$post->created_at}}</small>
                          @if (!Auth::guest())
                          <a  class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal" >Edit </a>

                          {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right mr-1'])!!}
                          {{Form::hidden('_method', 'DELETE')}}
                          {{Form::submit('Delete', ['class' => 'btn btn-danger','onclick'=>'return confirm(\'Are you sure?\')'])}}
                      {!!Form::close()!!}
                      @endif

                          </div>

                        </div>
                    </div>
                </div>


@endsection
