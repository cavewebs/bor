
<?php
require 'vendor/autoload.php';
use Goutte\Client;

$url = "http://www.soccervista.com";
$css_selector = "ul#navlist2 a";
$thing_to_scrape = "_text";

$client = new Client();
$crawler = $client->request('GET', $url);

//country urls
$getCountry = $crawler->filter($css_selector)->extract(array('_text', 'href'));
// $cntry = $crawler->filter($css_selector)->extract('href');

// // Lets get selectors
// $selector = "a.title.may-blank";
// $attribute = "_text";

// //will hold the list
// $country_list=[];

// //loop  all country links and get compettion links

// foreach ($getCountry as $key => $link) {
//  $client1 = new Client();


//     // on the first iteration, $value = 'https://www.reddit.com', on the second $value = 'https://www.reddit.com/new/', and so forth. 
//     $crawler = $client->request('GET', $value[1]);

//     $output[$key] = $crawler
//         ->filter($selector)
//         ->eq(1) // scrape the second post only
//         ->extract($attribute);
// }

// var_dump($output);

//  # code...
// }
var_dump($getCountry);
/*
for ($row = 0; $row < count($cntry)+1; $row++) {
  for ($col = 0; $col < 2; $col++) {
    echo "<li>".$cntry[$row][$col]."</li>";
  }
  echo "</ul>";
}
*/
