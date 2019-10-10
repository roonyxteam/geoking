@extends('layouts.app')
@section('title', 'Search results')
@section('content')
    <div class="container">
        <div class="row text-center">

        </div>
        <div class="row">

                <div class="container">

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
                        }
                    </style>



                    <script type="text/javascript">
                        $('#myModal').on('shown.bs.modal', function () {
                            $('#myInput').trigger('focus')
                        });
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
                                lat:  @if(isset($info1['results'][0])){!! $info1['results'][0]['geometry']['location']['lat'] !!}@else 0 @endif,
                                lng:  @if(isset($info1['results'][0])){!! $info1['results'][0]['geometry']['location']['lng'] !!}@else 0 @endif
                            };

                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 12,
                                center: loc,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            });

                            var infowindow = new google.maps.InfoWindow;

                            var marker, i;
                            var mtitle = "@php echo $query; @endphp";
                            for (i = 0; i < locations.length; i++) {
                                var spotColorStyle = "";
                                if (locations[i][0] >=1 && locations[i][0] <= 3.2) {
                                    spotColorStyle = "red";
                                } else if (locations[i][0] >=3.3 && locations[i][0] <= 4) {
                                    spotColorStyle = "orange";
                                } else if (locations[i][0] >=4.1 && locations[i][0] <= 5) {
                                    spotColorStyle = "green";
                                }
                                // console.log('---->', locations[i][1], locations[i][2]);
                                marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                                    map: map,
                                    label: locations[i][0],
                                    title: mtitle,
                                    icon: {
                                        fillColor: spotColorStyle,
                                        fillOpacity: 0.5,
                                        path: google.maps.SymbolPath.CIRCLE,
                                        scale: 26,
                                        strokeColor: "#000099",
                                        strokeWeight: 1.0
                                    }

                                });
                                console.log('latLNG', marker);

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
                            async ></script>


                    <div class = "container mt-5">
                        <h2 class = "center">Search Places</h2>
                        <p class ="center">Set Location and Place</p>
                        <div class="form-group">
                            <form class="typeahead" role="search" method="GET" action="{{ url('search') }}">
                                @if ($errors->has('query'))
                                    <span class="help-block">
                                <strong>
                                    {{ $errors->first('query') }}
                                </strong>
                            </span>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        {{--<button class="btn btn-outline-secondary" type="button" id="query">Button</button>--}}
                                        <input class="btn btn-outline-secondary" type="submit" name="query" id="query" value="Search" placeholder="restaurants amsterdam">
                                    </div>
                                    <input type="search" value="{{$query}}" name="query" id="query" placeholder="restaurants amsterdam" class="form-control" aria-label="Example text with button addon" aria-describedby="query">
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Locations</h3>
                                        <div class="tagcloud01">
                                            <ul>
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Location</th>
                                                        <th scope="col">Reviews</th>
                                                        <th scope="col">Rating</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ( $info1['results'] as $loc)
                                                        @if(isset($loc['rating']))
                                                            <tr>
                                                                <th scope="row" ><span title="{!! $loc['formatted_address']!!}">{!! $loc['name']!!}</span></th>
                                                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#review_modal_{!! $loc['place_id']!!}">
                                                                        Show {!! $loc['reviews_count']!!} Reviews
                                                                    </button>
                                                                    <div class="modal fade" id="review_modal_{!! $loc['place_id']!!}" tabindex="-1" role="dialog" aria-labelledby="review_modal_label_{!! $loc['place_id']!!}" aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h3 class="modal-title" id="review_modal_label_{!! $loc['name']!!}">{!! $loc['name']!!}</h3>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-12">
                                                                                            <div class="card">
                                                                                                <div class="card-body">
                                                                                                    <h3 class="card-title">Reviews</h3>
                                                                                                    <div id="google-reviews">
                                                                                                        <ul class="list-unstyled">
                                                                                                            @if(isset($loc['reviews']))
                                                                                                                @foreach ( $loc['reviews'] as $ind => $review)
                                                                                                                    <li class="media">
                                                                                                                        <img src="{!! $review['profile_photo_url']!!}" alt="{!! $review['author_name']!!}"
                                                                                                                             height="42" width="42" class="mr-3" >
                                                                                                                        <div class="media-body">
                                                                                                                            <h5 class="mt-0 mb-1">{!! $review['author_name']!!}</h5>
                                                                                                                            {!! $review['text'] !!}
                                                                                                                            <div></b>
                                                                                                                                <h4>@if(isset($review['rating']))
                                                                                                                                        {!! $review['rating']!!}
                                                                                                                                    @endif
                                                                                                                                </h4>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    @if($ind < count($loc['reviews'])-1)<hr>@endif
                                                                                                                @endforeach
                                                                                                            @endif
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div></td>
                                                                <td><span class="glyphicon glyphicon-star
                                                                        @if($loc['rating']>=1 && $loc['rating'] <= 3.2)
                                                                            text-danger
                                                                        @elseif($loc['rating'] > 3.2 && $loc['rating'] <= 4)
                                                                            text-warning
                                                                        @elseif($loc['rating'] > 4 && $loc['rating'] <= 5)
                                                                            text-success
                                                                        @endif">
                                                                    </span>{!! $loc['rating']!!}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="map" style="height: 500px; width: 500px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Tags</h3>
                                        <div class="tagcloud01">
                                            <ul>
                                                <li>
                                                    @php
                                                        echo $cloud->render();
                                                    @endphp
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
    </div>




@endsection
 




