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
use LithiumDev\TagCloud\TagCloud;

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

$response1 = $client->get('https://maps.googleapis.com/maps/api/place/textsearch/json?query='.$query.'&key=AIzaSyB3guzpLs_LTMr4h364kIoSy-670C1mTEM');


$searches1 = $response1->getBody()->getContents();
$info1 = json_decode($searches1, true);


 foreach ($info1['results'] as $place_id)
 {
     $google_id = $place_id['place_id'];
 };

 foreach ($info1['results'] as $cloud)
 {
     $cloud_rating = $cloud['rating'];
     $cloud_user_rating = $cloud['user_ratings_total'];
 };




$response2 = $client->get('https://maps.googleapis.com/maps/api/place/details/json?placeid='.$google_id.'&key=AIzaSyB3guzpLs_LTMr4h364kIoSy-670C1mTEM');


$searches2 = $response2->getBody()->getContents();
$info2 = json_decode($searches2, true);



 foreach ($info2['result']['reviews'] as  $cloud1)
 {
     $cloud_text = $cloud1['text'];
     
 };


$baseUrl="http://lara.local";
$cloud = new TagCloud();
$cloud->addString($cloud_text);
$cloud->addString($query);
$cloud->addString($cloud_rating);
$cloud->addString($cloud_user_rating);


return view('search.search')->with('query',$query)->with('info1',$info1)->with('info2',$info2)->with('cloud',$cloud);


}











}
