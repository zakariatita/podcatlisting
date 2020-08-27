@extends('layouts.app')

@section('content')

<div class="container ">
    @if (!Auth::guest())
    <div class="modal-header">
        <div>
    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
        Add new podcast
      </button></div>
      <div>
      <button type="button" class="btn btn-success text-white float-right mr-2 mb-1" data-toggle="modal" data-target="#myModalc">
        Edit category
      </button>
      <a type="button" href="/category/{{$Category->id}}/edit" onclick="return confirm('Are you sure?')" class="btn btn-danger float-right mr-2 mb-1">
        Delete category
      </a></div>

    </div>
    @endif
    {{ Form::open(['action' => ['CategoryController@updatecaCategory',$Category->id], 'method' => 'POST','files'=>'true', 'enctype' => 'multipart/form-data']) }}
                    <div class="modal" id="myModalc">
                        <div class="modal-dialog">
                          <div class="modal-content">

                                   <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editing Category</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                 <div class="modal-body">

                                <div class="form-group">
                                    {{Form::label('title', 'Title :')}}
                                    {{Form::text('title', $Category->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}

                                </div>
                                <div class="form-group">
                                    {{Form::Label('item', 'Color:') }}
                                    <select id="item_idc" value="" class="form-control text-white " name="item_idc" onchange="changecolor()">
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
                                document.getElementById("item_idc").classList.add("{{$Category->color}}");
                                var e = document.getElementById("item_idc");
                                var strUser ="{{$Category->color}}";
                                document.getElementById("item_idc").value =  "{{$Category->color}}";
                                 function changecolor() {
                                    document.getElementById("item_idc").classList.remove(strUser);
                                     strUser = e.options[e.selectedIndex].value;
                                    document.getElementById("item_idc").classList.add(strUser);

                              }
                                </script>
                                <div class="form-group">
                                        <label class="btn btn-primary" >
                                            Select Category image
                                            {{Form::file('category_image', ['class' => 'custom-file-input',])}}
                                        </label>
                                </div>
                          </div>
                          {{Form::hidden('_method', 'PUT')}}
                                {{Form::submit('Submit', ['class'=>'btn btn-success'])}}
                        </div>
                    </div>
                  </div>

                          {{ Form::close() }}
    {{ Form::open(['action' => 'PostsController@store', 'method' => 'POST','files'=>'true', 'enctype' => 'multipart/form-data']) }}
    <div class="modal" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Adding new podcast</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class="form-group">
                    <input type="hidden" name="category_id" value="{{$Category->id}}">
                    {{Form::label('title', 'Title :')}}
                    {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}

                </div>

                <div class="form-group">
                    {{Form::label('body', 'Description')}}
                    {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
                </div>
                <div class="form-group">
                    <label class="btn btn-primary" >
                        Select the podcast file
                        {{Form::file('podcast_file', ['class' => 'custom-file-input',])}}
                    </label>

                </div>
                <div class="form-group">
                        <label class="btn btn-primary" >
                            Select the podcast image
                            {{Form::file('podcast_image', ['class' => 'custom-file-input',])}}
                        </label>
                </div>
          </div>
          {{Form::submit('Submit', ['class'=>'btn btn-success'])}}
          {{ Form::close() }}
        </div>
      </div>

    </div>

<div class="card-deck">
    @if(count($podcasts) > 0)
            @foreach($podcasts as $podcast)

            <div class="card text-white bg-dark mb-3 mt-2" style="min-width: 20rem;max-width: 22rem;">

                <img class="img-thumbnail " src="/storage/category/{{$Category->id}}/podcast_image/{{$podcast->URLi}}" alt="Card image cap" style="width: auto; height: 220px;">
                <div class="card-body">
                  <figure>
                      <audio title="{{$podcast->title}}" preload="auto" controls loop>
                      <source src="/storage/category/{{$Category->id}}/podcast_file/{{$podcast->URLa}}" type="audio/mp3">
                      <p>Votre navigateur est trop ancien pour lire ce fichier</p>
                      </audio>
                    <figcaption><h3>{{$podcast->title }}</h3></figcaption>
                      <figcaption><h5>{{$podcast->body}}</h5></figcaption>
                      </figure>
                </div>

                <div class="card-footer">
                    <small> Post on {{$podcast->created_at}}</small>
                    @if (!Auth::guest())
                    <a  class="btn btn-primary float-right" data-toggle="modal" data-target="#myModale" >Edit </a>
                    {!!Form::open(['action' => ['CategoryController@destroy', $podcast->id], 'method' => 'POST', 'class' => 'float-right mr-1'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn btn-danger','onclick'=>'return confirm(\'Are you sure?\')'])}}
                    {!!Form::close()!!}
                    @endif

                </div>
              </div>
              {{ Form::open(['action' => ['CategoryController@update',$podcast->id], 'method' => 'POST','files'=>'true', 'enctype' => 'multipart/form-data']) }}
              <div class="modal" id="myModale">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Editing podcast</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                          <div class="form-group">
                              <input type="hidden" name="category_id" value="{{ $podcast->idcategory}}">
                              {{Form::label('title', 'Title :')}}
                              {{Form::text('title', $podcast->title , ['class' => 'form-control', 'placeholder' => 'Title'])}}

                          </div>

                          <div class="form-group">
                              {{Form::label('body', 'Description')}}
                              {{Form::textarea('body', $podcast->body , ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
                          </div>
                          <div class="form-group">
                              {{Form::Label('item', 'Change category:') }}
                              <select id="item_idp" value="" class="form-control text-white bg-primary" name="item_idp" onchange="changecolor()">
                                  @if(count($Categorys) > 0)
                                    @foreach($Categorys as $Cat)
                                  <option value="{{$Cat->id}}" class="text-white bg-primary m-3">{{$Cat->title}}</option>
                                  @endforeach
                                  @endif

                              </select>

                      </div>
                      <script>
                          var e = document.getElementById("item_idp");
                          var strUser ="{{$Category->title}}";
                          document.getElementById("item_idp").value =  "{{$Category->id}}";
                          </script>
                          <div class="form-group">
                              <label class="btn btn-primary" >
                                  Select the podcast file
                                  {{Form::file('podcast_file', ['class' => 'custom-file-input',])}}
                              </label>

                          </div>
                          <div class="form-group">
                                  <label class="btn btn-primary" >
                                      Select the podcast image
                                      {{Form::file('podcast_image', ['class' => 'custom-file-input',])}}
                                  </label>
                          </div>
                    </div>
                    {{Form::hidden('_method', 'PUT')}}
                          {{Form::submit('Submit', ['class'=>'btn btn-success'])}}
                  </div>
              </div>
            </div>

                    {{ Form::close() }}

            @endforeach

            {{$podcasts->links()}}
        @else
            <h1>No podcasts found</h1>
        @endif

    </div>
</div>

@endsection
