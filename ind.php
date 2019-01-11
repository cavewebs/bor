
<?php
require 'vendor/autoload.php';
use Goutte\Client;


// geting individual leagues within each country
$url = "https://www.soccervista.com/England-Premier_League-2018_2019-855968.html";
$css_selector = "li.longer a";
$fixtures_css_selector = "div.menu2 a";
$thing_to_scrape = "_text";

$client = new Client();
$crawler = $client->request('GET', $url);

$otherGroups = $crawler->selectLink('Other groups');
// $fixturesLink = $crawler->selectLink('Fixtures')->link()->getUri();

//country urls
$getCountry = $crawler->filter($css_selector)->extract(array('_text', 'href'));

// //will hold the list
$countryCompetitions=[];
foreach ($getCountry as $key => $value) {
  if($key==0){

  }else{
    $url1 = 'http://soccervista.com'.$value[1];
    // $css_selector = "li.longer a";
    // $thing_to_scrape = "_text";

    $client1 = new Client();
    $fixtureCrawler = $client1->request('GET', $url1);
    $fixturesLink = $fixtureCrawler->selectLink('Fixtures')->link()->getUri();
  $countryCompetitions[] = [
    'countryCompetitionTitle'=> $value[0],
    'countryCompetitionLink'=> $value[1],
    'fixtureLink' => $fixturesLink
  ];


      }
  # code...
}


// Summary [0]
// Season  [1]
// Results [2]
// Fixtures [3]
// Top scorers [4]
// Cards [5]
// other groups [6] may or may not exist
// Other leagues [7]

// Code for high scorers, cards, and 

//Lets check if the competition has Groups,eg world cup
//will do so later

foreach ($countryCompetitions as $key => $value) {
  echo $value['countryCompetitionTitle'] .' - '.
       $value['countryCompetitionLink'].' - '.
       $value['fixtureLink'].'<br /> <br />';
   # code...
 } 

