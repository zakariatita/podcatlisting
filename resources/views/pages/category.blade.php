@extends('layouts.app')

@section('content')

<div class="container ">
    @if (!Auth::guest())
    <div class="modal-header">
    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
        Add new Category
      </button>
    </div>
    @endif
    {{ Form::open(['action' => 'CategoryController@store', 'method' => 'POST','files'=>'true', 'enctype' => 'multipart/form-data']) }}
    <div class="modal" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Adding new Category</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

                <div class="form-group">
                    {{Form::label('title', 'Title :')}}
                    {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}

                </div>
                <div class="form-group">
                    {{Form::Label('item', 'Color:') }}
                    <select id="item_id"  class="form-control text-white bg-primary" name="item_id" onchange="changecolor()">
                        <option value="bg-primary" class="text-white bg-primary m-3">Blue</option>
                        <option value="bg-secondary" class="text-white bg-secondary m-3">Grey</option>
                        <option value="bg-success" class="text-white bg-success m-3">Green</option>
                        <option value="bg-danger" class="text-white bg-danger m-3">Red</option>
                        <option value="bg-warning" class="text-white bg-warning m-3">Orange</option>
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
                            Select Category image
                            {{Form::file('category_image', ['class' => 'custom-file-input',])}}
                        </label>
                </div>
          </div>
          {{Form::submit('Submit', ['class'=>'btn btn-success'])}}
          {{ Form::close() }}
        </div>
      </div>

    </div>

<div class="card-deck">

    @if(count($categorys) > 0)
            @foreach($categorys as $category)

            <div class="card text-white {{$category->color}} mt-2 mb-2" style="min-width: 20rem;max-width: 22rem;">
                <div class="card-body ">

                  <figure >
                    <a href="/category/{{$category->id}}">
                    <img class="img-thumbnail " src="/storage/category/{{$category->id}}/{{$category->URLi}}" alt="Card image cap" style="width: auto; height: 220px;">
                    </a>
                    <figcaption><h3>{{$category->title}}</h3></figcaption>
                    </figure>
                </div>

                <div class="card-footer">
                    <small> Written on {{$category->created_at}}</small>
                </div>
              </div>

            @endforeach

            {{$categorys->links()}}
        @else
            <h1>No podcasts found</h1>
        @endif

    </div>
</div>

@endsection
