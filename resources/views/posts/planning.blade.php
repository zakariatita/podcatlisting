@extends('layouts.app')

@section('content')
  {{ Form::open(['action' => ['EventController@update',$event->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

      <div class=" modal-content mt-2 mb-2">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Editing event</h4>
          <a type="button" class="close" data-dismiss="modal" href="/contact">&times;</a>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

            <div class="form-group">

                {{Form::label('time', 'Time :')}}
                {{Form::time('time', $event->time, ['class' => 'form-control', 'placeholder' => 'zaki'])}}

            </div>
            <div class="form-group">
                {{Form::label('title', 'Title :')}}
                {{Form::text('title', $event->title, ['class' => 'form-control', 'placeholder' => 'zaki'])}}

            </div>

            <div class="form-group">
                {{Form::label('body', 'Description')}}
                {{Form::textarea('body', $event->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
            </div>
            <div class="form-group">
                {{Form::Label('item', 'Color:') }}
                <select id="item_id" value="" class="form-control text-white {{$event->color}}" name="item_id" onchange="changecolor()">
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
            var strUser ="{{$event->color}}";
            document.getElementById("item_id").value =  "{{ $event->color}}";
             function changecolor() {
                document.getElementById("item_id").classList.remove(strUser);
                 strUser = e.options[e.selectedIndex].value;
                document.getElementById("item_id").classList.add(strUser);

          }
            </script>
            <div class="form-group">
                {{Form::Label('item', 'Day:') }}
               <select id="day" value="{{$event->day}}" class="form-control text-white bg-success" name="day">
                    <option value="Saturdays" class="text-white bg-success m-3">Saturdays</option>
                    <option value="Sundays" class="text-white bg-success m-3">Sundays</option>
                    <option value="Mondays" class="text-white bg-success m-3">Mondays</option>
                    <option value="Tuesdays" class="text-white bg-success m-3">Tuesdays</option>
                    <option value="Wednesdays" class="text-white bg-success m-3">Wednesdays</option>
                    <option value="Thursdays" class="text-white bg-success m-3">Thursdays</option>
                    <option value="Fridays" class="text-white bg-success m-3">Fridays</option>
                </select>
                <script>
                    //document.getElementById("day").value =  "{{ $event->day}}";
                    </script>
        </div>
            <div class="form-group">
                <label class="btn btn-primary" >
                    Select image
                    {{Form::file('event_image', ['class' => 'custom-file-input',])}}
                </label>
            </div>
      </div>
      {{Form::hidden('_method', 'PUT')}}
      {{Form::submit('Submit', ['class'=>'btn btn-success'])}}
      {{ Form::close() }}

    </div>


@endsection
