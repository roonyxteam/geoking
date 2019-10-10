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

                <div class="container mt-5">
                    <h2 class="center">Search Places</h2>
                    <p class="center">Set Location and Place</p>
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
                                    <input class="btn btn-outline-secondary" type="submit" name="query" id="query"
                                           value="Search" placeholder="restaurants amsterdam">
                                </div>
                                <input type="search"  name="query" id="query"
                                       placeholder="restaurants amsterdam" class="form-control"
                                       aria-label="Example text with button addon" aria-describedby="query">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection





