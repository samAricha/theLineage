<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class genealogyController extends Controller
{
   
    public function index(Request $request)
    {
        $sessionId   = $request->get('session_id');
        $serviceCode = $request->get('serviceCode');
        $phoneNumber = $request->get('phoneNumber');
        $text        = $request->get('text');
         // use explode to split the string text response from Africa's talking gateway into an array.
         $ussd_string_exploded = explode("*", $text);
         // Get ussd menu level number from the gateway
         $level = count($ussd_string_exploded);
         //Open database connection
         //$conn = openCon();
        
        if ($text == "") {
            // first response when a user dials ussd code
            $response  = "CON Welcome to NYI KWA RAMOGI GENEALOGY/LUO GENEALOGY\n";
            $response .= "1. Clans \n";
            $response .= "2. About THE LINEAGE";
        }
        elseif ($text == "1") {
            // when user respond with option one for clans
            $response = "CON Which clan do you want to find out about? \n";
            $results = DB::select('SELECT clan_name FROM clans');

            $i = 0;
            foreach($results as $result){
                $i++; 
                $response .= $i.". ".$result -> clan_name. "\n";
            }     
        }
        elseif ($ussd_string_exploded[0] == 1 && $level > 1) {
            if($level === 2)
            $response = "CON Please enter your name to register";
          
            if($level > 2){
                
                $this->mpesaStkPush();
                $selected_clan_id = $ussd_string_exploded[1]; 
                $count = $this->totalRowsInClan($selected_clan_id);
                      
                if($level-2<=$count){
                    $output = $this->displayRow($selected_clan_id, $level-2);
                    $response = "CON ".$output."\n---\n";
                    if($level-2 < $count){
                      $response .= "98. NEXT"; 
                   }
                }else{
                    $response ="END Thank you for visiting THE LINEAGE";
                }    
            }           
        }
         elseif ($ussd_string_exploded[0] == 2) {
             // Our response a user respond with input 2 from our first level
             $response = "END At THE LINEAGE we show you your lineage, the great people in your bloodline who came before you and
             the great things they have done.";
         }
        
         // send your response back to the API
         header('Content-type: text/plain');
         echo $response;
        
         //TODO
         
        // 1.find a way of displaying the clan information by row i.e id. 
         //2.adding the NEXT button to the display - for navigating from one paragraph to another.
         
    }

    //returns total number of clans per row
    function totalRowsInClan($clan_id){
        $count_query = "SELECT * FROM luo2 WHERE clan_id = $clan_id";
        $count_result = DB::select($count_query);
        $num_rows = count($count_result);

        return $num_rows;
    }
    //returns the info rows
    function displayRow($clan_id, $info_no){  
        $info_query = "SELECT * FROM luo2 WHERE clan_id = $clan_id AND info_no = $info_no"; 
        $query_result = DB::select($info_query);
        
        return $query_result[0]->clan_name."\n\n".$query_result[0]->info."\n";
        //info num of total info rows coming sooon
    }
    //call the stk push method
    function mpesaStkPush(){
        app('App\Http\Controllers\MpesaController')->customerMpesaSTKPush();
    }
}