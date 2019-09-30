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

<style>
{
  box-sizing: border-box;
}

#map {
  width: 500px;
  height: 400px;
}

#circle {
  width: 100px;
  height: 100px;
  background: red;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 50px;
}

</style>


<div id="map" style="height: 500px; width: 500px;"></div>

<script type="text/javascript">


     function initMap() {
        var loc = {lat: {{$lat}}, lng: {{$lng}}};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: loc
        });

        var contentString = 
            "<div id='bodyContent'><p>Rate:{{$rating}} Total reviews:{{$total_rate}}</p></div>";

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

        var marker = new google.maps.Marker({
          position: loc,
          map: map
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      }



</script>






<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3guzpLs_LTMr4h364kIoSy-670C1mTEM&callback=initMap&libraries=places"
    async defer></script>


@endsection
 

