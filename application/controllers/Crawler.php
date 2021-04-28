<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use voku\helper\HtmlDomParser;
require_once 'vendor/autoload.php';

class Crawler extends CI_Controller {

	public function index(){ 
           
        // For stockholm
        $str = file_get_contents('https://www.spotifyjobs.com/locations/stockholm');
        $dom = HtmlDomParser::str_get_html($str);
        $elementsOrFalse = $dom->findMultiOrFalse('#__NEXT_DATA__'); 
        $data = json_decode($elementsOrFalse[0]->nodeValue, true);
        $jobContents = $data['props']['pageProps']['freshContentData']['fresh_content'];

        $final_data = [];
        if (sizeof($jobContents) > 0){
            foreach ($jobContents as $key => $value) {
                array_push($final_data, 
                    [
                        "title"=>$value['title'],
                        "url"=>$value['url'],
                        "category"=>$value['category'],
                    ]
                );
            }
        }


        echo json_encode(["data"=>$final_data]);
    }

}
