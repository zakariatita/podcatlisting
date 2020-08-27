@extends('layouts.app')

@section('content')
@if (!Auth::guest())
<div class="modal-header">
    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
        Add new Event
      </button>
</div>
@endif
{{ Form::open(['action' => 'EventController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->

        <div class="modal-header">
          <h4 class="modal-title">Adding new Event</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

            <div class="form-group">

                {{Form::label('time', 'Time :')}}
                {{Form::time('time', '00:00', ['class' => 'form-control', 'placeholder' => 'Time'])}}

            </div>
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
                <select id="item_id" class="form-control text-white bg-primary" name="item_id" onchange="changecolor()">
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
                {{Form::Label('item', 'Day:') }}
                <select id="day" class="form-control text-white bg-success" name="day"">
                    <option value="Saturdays" class="text-white bg-success m-3">Saturdays</option>
                    <option value="Sundays" class="text-white bg-success m-3">Sundays</option>
                    <option value="Mondays" class="text-white bg-success m-3">Mondays</option>
                    <option value="Tuesdays" class="text-white bg-success m-3">Tuesdays</option>
                    <option value="Wednesdays" class="text-white bg-success m-3">Wednesdays</option>
                    <option value="Thursdays" class="text-white bg-success m-3">Thursdays</option>
                    <option value="Fridays" class="text-white bg-info m-3">Fridays</option>
                </select>

        </div>
            <div class="form-group">
                <label class="btn btn-primary" >
                    Select image
                    {{Form::file('event_image', ['class' => 'custom-file-input',])}}
                </label>
            </div>
      </div>
      {{Form::submit('Submit', ['class'=>'btn btn-success'])}}
      {{ Form::close() }}

    </div>
  </div>

</div>

<div class="card  bg-dark  mt-2">
    <div class="card-body">

<!-- Nav tabs -->

 <ul class="nav nav-tabs">
        <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#Saturdays">Saturdays</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Sundays">Sundays</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Mondays">Mondays</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Tuesdays">Tuesdays</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Wednesdays">Wednesdays</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Thursdays">Thursdays</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#Fridays">Fridays</a>
    </li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane container active" id="Saturdays">
         <!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
        @if(count($events) > 0)
        @foreach($events as $event)
        @if($event->day == "Saturdays")
 <!-- Accordion card -->
 <div class="card text-white {{$event->color}} mt-3" >

    <!-- Card header -->
    <div class="card-header" role="tab" id="h{{$event->id}}">
      <a  data-toggle="collapse" data-parent="#accordionEx" href="#c{{$event->id}}" aria-expanded="true" aria-controls="c{{$event->id}}">
        <h5 class="mb-0 text-white font-weight-bold">
            {{$event->time}}
            {{$event->title}}
        </h5>
        @if (!Auth::guest())
        <a href="/event/{{$event->id}}" class="btn text-dark btn-light float-right" >Edit </a>
        {{Form::open(['action' => ['EventController@destroy', $event->id], 'method' => 'POST', 'class' => 'float-right mr-1'])}}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-light','onclick'=>'return confirm(\'Are you sure?\')'])}}
        {!!Form::close()!!}
        @endif
      </a>
    </div>

    <!-- Card body -->
    <div id="c{{$event->id}}" class="collapse " role="tabpanel" aria-labelledby="h{{$event->id}}" data-parent="#accordionEx">
      <div class="card-body">
        {{$event->body}}
        <br><br>
        <img class="img-thumbnail" src="/storage/event_image/{{$event->URLi}}" alt="Card image cap">
      </div>
      <small class="m-2">Written on {{$event->created_at}}</small>
    </div>

  </div>
         @endif
        @endforeach
        @else
        <h1>No event found</h1>
        @endif
    </div></div>
    <div class="tab-pane container fade" id="Sundays">
 <!--Accordion wrapper-->
 <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">
    @if(count($events) > 0)
    @foreach($events as $event)
    @if($event->day == "Sundays")
<!-- Accordion card -->
<div class="card text-white {{$event->color}} mt-3" >

<!-- Card header -->
<div class="card-header" role="tab" id="h{{$event->id}}">
  <a  data-toggle="collapse" data-parent="#accordionEx1" href="#c{{$event->id}}" aria-expanded="true" aria-controls="c{{$event->id}}">
    <h5 class="mb-0 text-white font-weight-bold">
        {{$event->time}}
        {{$event->title}}
    </h5>
    @if (!Auth::guest())
    <a href="/event/{{$event->id}}" class="btn text-dark btn-light float-right" >Edit </a>
    {{Form::open(['action' => ['EventController@destroy', $event->id], 'method' => 'POST', 'class' => 'float-right mr-1'])}}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Delete', ['class' => 'btn btn-light','onclick'=>'return confirm(\'Are you sure?\')'])}}
    {!!Form::close()!!}
 @endif
  </a>
</div>

<!-- Card body -->
<div id="c{{$event->id}}" class="collapse " role="tabpanel" aria-labelledby="h{{$event->id}}" data-parent="#accordionEx1">
  <div class="card-body">
    {{$event->body}}
    <br><br>
    <img class="img-thumbnail" src="/storage/event_image/{{$event->URLi}}" alt="Card image cap">
  </div>
  <small class="m-2">Written on {{$event->created_at}}</small>
</div>

</div>
     @endif
    @endforeach
    @else
    <h1>No event found</h1>
    @endif
</div>
    </div>
    <div class="tab-pane container fade" id="Mondays">
         <!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx2" role="tablist" aria-multiselectable="true">
    @if(count($events) > 0)
    @foreach($events as $event)
    @if($event->day == "Mondays")
<!-- Accordion card -->
<div class="card text-white {{$event->color}} mt-3" >

<!-- Card header -->
<div class="card-header" role="tab" id="h{{$event->id}}">
  <a  data-toggle="collapse" data-parent="#accordionEx2" href="#c{{$event->id}}" aria-expanded="true" aria-controls="c{{$event->id}}">
    <h5 class="mb-0 text-white font-weight-bold">
        {{$event->time}}
        {{$event->title}}
    </h5>
    @if (!Auth::guest())
    <a href="/event/{{$event->id}}" class="btn text-dark btn-light float-right" >Edit </a>
    {{Form::open(['action' => ['EventController@destroy', $event->id], 'method' => 'POST', 'class' => 'float-right mr-1'])}}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Delete', ['class' => 'btn btn-light' ,'onclick'=>'return confirm(\'Are you sure?\')'])}}
    {!!Form::close()!!}
    @endif

  </a>
</div>

<!-- Card body -->
<div id="c{{$event->id}}" class="collapse " role="tabpanel" aria-labelledby="h{{$event->id}}" data-parent="#accordionEx2">
  <div class="card-body">
    {{$event->body}}
    <br><br>
    <img class="img-thumbnail" src="/storage/event_image/{{$event->URLi}}" alt="Card image cap">
  </div>
  <small class="m-2">Written on {{$event->created_at}}</small>
</div>

</div>
     @endif
    @endforeach
    @else
    <h1>No event found</h1>
    @endif
</div>

    </div>
    <div class="tab-pane container fade" id="Tuesdays">
         <!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx3" role="tablist" aria-multiselectable="true">
    @if(count($events) > 0)
    @foreach($events as $event)
    @if($event->day == "Tuesdays")
<!-- Accordion card -->
<div class="card text-white {{$event->color}} mt-3" >

<!-- Card header -->
<div class="card-header" role="tab" id="h{{$event->id}}">
  <a  data-toggle="collapse" data-parent="#accordionEx3" href="#c{{$event->id}}" aria-expanded="true" aria-controls="c{{$event->id}}">
    <h5 class="mb-0 text-white font-weight-bold">
        {{$event->time}}
        {{$event->title}}
    </h5>
    @if (!Auth::guest())
    <a href="/event/{{$event->id}}" class="btn text-dark btn-light float-right" >Edit </a>
    {{Form::open(['action' => ['EventController@destroy', $event->id], 'method' => 'POST', 'class' => 'float-right mr-1'])}}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Delete', ['class' => 'btn btn-light','onclick'=>'return confirm(\'Are you sure?\')'])}}
    {!!Form::close()!!}
    @endif

  </a>
</div>

<!-- Card body -->
<div id="c{{$event->id}}" class="collapse " role="tabpanel" aria-labelledby="h{{$event->id}}" data-parent="#accordionEx3">
  <div class="card-body">
    {{$event->body}}
    <br><br>
    <img class="img-thumbnail" src="/storage/event_image/{{$event->URLi}}" alt="Card image cap">
  </div>
  <small class="m-2">Written on {{$event->created_at}}</small>
</div>

</div>
     @endif
    @endforeach
    @else
    <h1>No event found</h1>
    @endif
</div>
    </div>
    <div class="tab-pane container fade" id="Wednesdays">
         <!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx4" role="tablist" aria-multiselectable="true">
    @if(count($events) > 0)
    @foreach($events as $event)
    @if($event->day == "Wednesdays")
<!-- Accordion card -->
<div class="card text-white {{$event->color}} mt-3" >

<!-- Card header -->
<div class="card-header" role="tab" id="h{{$event->id}}">
  <a  data-toggle="collapse" data-parent="#accordionEx4" href="#c{{$event->id}}" aria-expanded="true" aria-controls="c{{$event->id}}">
    <h5 class="mb-0 text-white font-weight-bold">
        {{$event->time}}
        {{$event->title}}
    </h5>
    @if (!Auth::guest())
    <a href="/event/{{$event->id}}" class="btn text-dark btn-light float-right" >Edit </a>
    {{Form::open(['action' => ['EventController@destroy', $event->id], 'method' => 'POST', 'class' => 'float-right mr-1'])}}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Delete', ['class' => 'btn btn-light','onclick'=>'return confirm(\'Are you sure?\')'])}}
    {!!Form::close()!!}
    @endif

  </a>
</div>

<!-- Card body -->
<div id="c{{$event->id}}" class="collapse " role="tabpanel" aria-labelledby="h{{$event->id}}" data-parent="#accordionEx4">
  <div class="card-body">
    {{$event->body}}
    <br><br>
    <img class="img-thumbnail" src="/storage/event_image/{{$event->URLi}}" alt="Card image cap">
  </div>
  <small class="m-2">Written on {{$event->created_at}}</small>
</div>

</div>
     @endif
    @endforeach
    @else
    <h1>No event found</h1>
    @endif
</div>
    </div>
    <div class="tab-pane container fade" id="Thursdays">
         <!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx5" role="tablist" aria-multiselectable="true">
    @if(count($events) > 0)
    @foreach($events as $event)
    @if($event->day == "Thursdays")
<!-- Accordion card -->
<div class="card text-white {{$event->color}} mt-3" >

<!-- Card header -->
<div class="card-header" role="tab" id="h{{$event->id}}">
  <a  data-toggle="collapse" data-parent="#accordionEx5" href="#c{{$event->id}}" aria-expanded="true" aria-controls="c{{$event->id}}">
    <h5 class="mb-0 text-white font-weight-bold">
        {{$event->time}}
        {{$event->title}}
    </h5>
    @if (!Auth::guest())
    <a href="/event/{{$event->id}}" class="btn text-dark btn-light float-right" >Edit </a>
    {{Form::open(['action' => ['EventController@destroy', $event->id], 'method' => 'POST', 'class' => 'float-right mr-1'])}}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Delete', ['class' => 'btn btn-light','onclick'=>'return confirm(\'Are you sure?\')'])}}
    {!!Form::close()!!}
    @endif

  </a>
</div>

<!-- Card body -->
<div id="c{{$event->id}}" class="collapse " role="tabpanel" aria-labelledby="h{{$event->id}}" data-parent="#accordionEx5">
  <div class="card-body">
    {{$event->body}}
    <br><br>
    <img class="img-thumbnail" src="/storage/event_image/{{$event->URLi}}" alt="Card image cap">
  </div>
  <small class="m-2">Written on {{$event->created_at}}</small>
</div>

</div>
     @endif
    @endforeach
    @else
    <h1>No event found</h1>
    @endif
</div>
    </div>
  <div class="tab-pane container fade" id="Fridays">
        <!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx7" role="tablist" aria-multiselectable="true">
       @if(count($events) > 0)
       @foreach($events as $event)
       @if($event->day == "Fridays")
<!-- Accordion card -->
<div class="card text-white {{$event->color}} mt-3">

   <!-- Card header -->
   <div class="card-header" role="tab" id="h{{$event->id}}">
     <a data-toggle="collapse" data-parent="#accordionEx7" href="#c{{$event->id}}" aria-expanded="true" aria-controls="c{{$event->id}}">
       <h5 class="mb-0 text-white font-weight-bold">
           {{$event->time}}
           {{$event->title}}
       </h5>
       @if (!Auth::guest())
       <a href="/event/{{$event->id}}" class="btn text-dark btn-light float-right" >Edit </a>
        {!!Form::open(['action' => ['EventController@destroy', $event->id], 'method' => 'POST', 'class' => 'float-right mr-1'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-light','onclick'=>'return confirm(\'Are you sure?\')'])}}
        {!!Form::close()!!}
        @endif
     </a>
   </div>

   <!-- Card body -->
   <div id="c{{$event->id}}" class="collapse " role="tabpanel" aria-labelledby="h{{$event->id}}" data-parent="#accordionEx7">
     <div class="card-body">
       {{$event->body}}
       <br><br>
       <img class="img-thumbnail" src="/storage/event_image/{{$event->URLi}}" alt="Card image cap">
     </div>
     <small class="m-2">Written on {{$event->created_at}}</small>
   </div>

 </div>
        @endif
       @endforeach
       @else
       <h1>No event found</h1>
       @endif
   </div></div>

  </div>

  </div>
</div>

@endsection


