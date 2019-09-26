@extends('layouts.app')
@section('title', 'Search results')
@section('content')
<div class="container">
<div class="row text-center">  
<h2>Search:</h2>
 <div class="form-group">    
 <form class="typeahead" role="search" method="GET" action= "{{ url('search') }}">
<div class="form-group">
@if ($errors->has('query'))
<span class="help-block">
<strong>{{ $errors->first('query') }}</strong>
</span>
@endif
<input type="search" name="query" id="query" placeholder="restaurants amsterdam" type="search">
</div>
<div class="form-group">
<input id="btn-submit" class="btn btn-send-message btn-md" value="Search" type="submit">
<span class="glyphicon glyphicon-search"></span>
 </button>
</div>
</form> 
<div class="container">

 <h4>Query: <i>{{$query}} </i></h4>
<br>
<br> 


<div id="map" style="height: 500px; width: 500px;">
    
    </div>

    <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat:{{$lat}}, lng: {{$lng}}},
                zoom: 20

            });
        }
    </script>

</div> 

<div id="info" style="height: 300px; width: 300px;">
<p>Title:{{$name}}</p>

<p>Address:{{$address
}}</p>
<p>Rate:{{$rating}}</p>

<p>Total reviews:{{$total_rate}}</p> 

</div>


</div>
</div>
 <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyB3guzpLs_LTMr4h364kIoSy-670C1mTEM&callback=initMap"
    async defer></script>


@endsection
 

