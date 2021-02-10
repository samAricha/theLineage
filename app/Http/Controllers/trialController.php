<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class trialController extends Controller
{
   
    public function index()
    {
       /*  $results = DB::select('SELECT clan_name FROM clans');
        foreach($results as $result){
            return $result -> clan_name;
        } */
       /*  $count_query = "SELECT * FROM luo WHERE clan_id = 2";
        $result = DB::select($count_query);
        $num = count($result); */

        $output = $this->displayRow(2, 2);
        return $output;
       
    }
     //returns the info rows
     function displayRow($clan_id, $info_no){  
        $info_query = "SELECT * FROM luo WHERE clan_id = $clan_id AND info_no = $info_no"; 
        $query_result = DB::select($info_query);
        $info = '';
        /* foreach($query_results as $query_result){
            $info = $query_result->clan_name."<br>\n".$query_result->info;
        } */          
        return $query_result;
    }

}
