<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Http\Requests\SearchRequest;
use Khill\Lavacharts\Lavacharts;
use Image;

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
$request = urlencode($query);

$client = new \GuzzleHttp\Client();

$response = $client->get('https://maps.googleapis.com/maps/api/place/textsearch/json?query='.$query.'&key=AIzaSyB3guzpLs_LTMr4h364kIoSy-670C1mTEM');



$searches = $response->getBody()->getContents();
$data = json_decode($searches, true);


 $lat=$data ['results'][0]['geometry']['location']['lat']; 
 $lng=$data ['results'][0]['geometry']['location']['lng'];
 $address=$data ['results'][0]['formatted_address'];
 $rating=$data ['results'][0]['rating'];
 $total_rate=$data ['results'][0]['user_ratings_total'];



return view('search.search')->with('searches', $searches)->with('query',$query)->with('lat',$lat)->with('lng',$lng)->with('rating',$rating)->with('total_rate', $total_rate)->with('address', $address)->with('data', $data);


}















}
