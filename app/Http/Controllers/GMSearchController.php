<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Http\Requests\SearchRequest;

class GMSearchController extends Controller
{
   

    public function __construct()
    {
        $this->middleware('auth');
    }


public function index(){
        
return view('search.index');

}


      


public function search(SearchRequest $request) {

$query = $request->get('query');
$type = $request->get('type');
$request = urlencode($query);

$client = new \GuzzleHttp\Client();

$response = $client->get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input='.$query.'&inputtype=textquery&type='.$type.'&fields=photos,formatted_address,name,rating,opening_hours,geometry&key=AIzaSyB3guzpLs_LTMr4h364kIoSy-670C1mTEM');

$searches = $response->getBody()->getContents();
$data = json_decode($searches, true);


 $lat=$data ['candidates'][0]['geometry']['location']['lat']; 
 $lng=$data ['candidates'][0]['geometry']['location']['lng'];
 $rating=$data ['candidates'][0]['rating'];



return view('search.search')->with('searches', $searches)->with('query',$query)->with('lat',$lat)->with('lng',$lng)->with('rating',$rating);


}





}
