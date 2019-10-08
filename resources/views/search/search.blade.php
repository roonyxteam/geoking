@extends('layouts.app')
@section('title', 'Search results')
@section('content')
    <div class="container">
        <div class="row text-center">
            <h2>Search:</h2>
            <div class="form-group">
                <form class="typeahead" role="search" method="GET" action="{{ url('search') }}">
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
                            box-sizing: border-box
                        ;
                        }

                        #map {
                            width: 500px;
                            height: 400px;
                        }

                        #google-reviews {
                            display: flex;
                            flex-wrap: wrap;
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
                            */
                        }
                    </style>


                    <div id="map" style="height: 500px; width: 500px;"></div>
                    <script type="text/javascript">
                        function initMap() {
                            var locations = [
                                @foreach ( $info1['results'] as $loc)
                                    ["@if(isset($loc['rating'])){!! $loc['rating']!!}@endif",
                                        {!! $loc['geometry']['location']['lat']!!},
                                        {!! $loc['geometry']['location']['lng']!!},
                                    ],
                                @endforeach
                            ];


                            var loc = {
                                lat:  {!! $info1['results'][0]['geometry']['location']['lat'] !!},
                                lng:  {!! $info1['results'][0]['geometry']['location']['lng'] !!}};

                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 12,
                                center: loc,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            });

                            var infowindow = new google.maps.InfoWindow;

                            var marker, i;
                            var mtitle = "@php echo $query; @endphp";
                            for (i = 0; i < locations.length; i++) {
                                marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                                    map: map,
                                    label: locations[i][0],
                                    title: mtitle,
                                    icon: {

                                        @foreach ( $info1['results'] as $loc)

                                                @if(isset($loc['rating']) && ($loc['rating']<=1 || $loc['rating']<=3.2))

                                                @php
                                                    echo "fillColor:'red',";
                                                @endphp
                                                @break


                                                @elseif(isset($loc['rating']) && ($loc['rating']<=3.3 || $loc['rating']<=4))

                                                @php
                                                    echo "fillColor:'orange',";
                                                @endphp
                                                @break


                                                @elseif(isset($loc['rating']) && ($loc['rating']<=4.1 || $loc['rating']<=5))

                                                @php
                                                    echo "fillColor:'green', ";
                                                @endphp
                                                @break




                                                @endif

                                                @endforeach


                                        fillOpacity: 0.5,
                                        path: google.maps.SymbolPath.CIRCLE,
                                        scale: 26,
                                        strokeColor: "#000099",
                                        strokeWeight: 1.0
                                    }

                                });

                                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                    return function () {
                                        infowindow.setContent(locations[i][0]);
                                        infowindow.open(map, marker);
                                    }
                                })(marker, i));
                            }

                        }

                    </script>

                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3guzpLs_LTMr4h364kIoSy-670C1mTEM&callback=initMap&libraries=places"
                            async defer></script>

                    <div class="tagcloud01">
                        <ul>
                            <li>performance testing
                                @php
                                    echo $cloud->render();
                                @endphp
                            </li>
                        </ul>
                    </div>

                    @if(isset($info2['result']['reviews']))
                        @foreach ( $info2['result']['reviews'] as $review)
                            <div id="google-reviews">
                                <b>Author:{!! $review['author_name']!!}<br>
                                    <img src="{!! $review['profile_photo_url']!!}" alt="{!! $review['author_name']!!}"
                                         height="42" width="42"> <br>
                                </b><i>{!! $review['text']!!} </i><br>User Rating </b><h5>@if(isset($review['rating'])){!! $review['rating']!!}@endif</h5>
                            </div>
                        @endforeach
                    @endif






@endsection
 




