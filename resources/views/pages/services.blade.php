@extends('layouts.app')

@section('content')
@if (!Auth::guest())
<div class="modal-header">
    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
        Add new Post
      </button>
</div>
@endif
    {{ Form::open(['action' => 'PostsController@storepost', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
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
                    {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}

                </div>

                <div class="form-group">
                    {{Form::label('body', 'Description')}}
                    {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
                </div>
                <div class="form-group">
                    {{Form::Label('item', 'Color:') }}
                    <select id="item_id"  class="form-control text-white bg-primary" name="item_id" onchange="changecolor()">
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
                var strUser = e.options[e.selectedIndex].value;
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
          {{Form::submit('Submit', ['class'=>'btn btn-success'])}}
          {{ Form::close() }}

        </div>
      </div>

    </div>


    @if(count($posts) > 0)
    @foreach($posts as $post)
    <div class="card-deck">
        @if($post->category == "bg-warning")
    <div class="card {{$post->category}} mt-3 mb-3" >
     @else <div class="card text-white {{$post->category}} mt-3 mb-3" >
        @endif
        <div class="card-body">
            <h2>{{$post->title}}</h2>
            <a href="/posts/{{$post->id}}">
                   <img class="img-thumbnail " src="/storage/post_image/{{$post->URLi}}" alt="Card image cap" style="width: auto; height: 220px;"></a>
         </div>
                        <div class="card-footer">
                              <small>Written on {{$post->created_at}}</small>
                        </div>
                   </div>

         </div>
    @endforeach
  {{$posts->links()}}
 @else
    <p>No posts found</p>
@endif


@endsection
