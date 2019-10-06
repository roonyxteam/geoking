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


public function search1(SearchRequest $request) {

$query = $request->get('query');
$request = urlencode($query);

$client = new \GuzzleHttp\Client();

$response = $client->get('https://maps.googleapis.com/maps/api/place/textsearch/json?query='.$query.'&key=AIzaSyB3guzpLs_LTMr4h364kIoSy-670C1mTEM');

 foreach ($response['results'] as $place_id)
 {
     $googleID = $place_id['place_id'];
 };

$searches = $response->getBody()->getContents();
$data = json_decode($searches, true);


 $lat=$data ['results'][0]['geometry']['location']['lat']; 
 $lng=$data ['results'][0]['geometry']['location']['lng'];
 $address=$data ['results'][0]['formatted_address'];
 $rating=$data ['results'][0]['rating'];
 $total_rate=$data ['results'][0]['user_ratings_total'];
 $review =$data ['results'][0]['rating']['reviews']['author_name'];

 
        

return view('search.search1')->with('searches', $searches)->with('query',$query)->with('lat',$lat)->with('lng',$lng)->with('rating',$rating)->with('total_rate', $total_rate)->with('address', $address)->with('data', $data)->with('data_arr',$data_arr)->with('review',$review);



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


$color="color:";
$red= "red";


$baseUrl="http://lara.local";
$cloud = new TagCloud();
$cloud->addString($cloud_text);
$cloud->addString($query);
$cloud->addString($cloud_rating);
$cloud->addString($cloud_user_rating);


return view('search.search')->with('query',$query)->with('info1',$info1)->with('info2',$info2)->with('cloud',$cloud)->with("color",$color)->with("red",$red);


}











}
