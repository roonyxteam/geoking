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

</div>
</div>
</div>
</div>
</div>
</div>
@endsection
