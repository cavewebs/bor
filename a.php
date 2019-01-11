
<?php
require 'vendor/autoload.php';
use Goutte\Client;
require 'db.php';

//get the country id and link from db
$sql = "SELECT c_id, c_link FROM countries";
$countries = $conn->query($sql);
// geting individual leagues within each country
$css_selector = "li.longer a";
$thing_to_scrape = "_text";

$client = new Client();
// prepare and bind
$stmt = $conn->prepare("INSERT INTO competitions (com_name, com_c_id, com_link) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $com_name, $com_cid, $com_link);

    while($row = $countries->fetch_assoc()) {
      // added when the insert ddnt complete
      // if ($row['c_id'] > 1098) {

            $crawler = $client->request('GET', $row['c_link']);

            //country urls
            $getCountry = $crawler->filter($css_selector)->extract(array('_text', 'href'));

            // //will hold the list
            // $countryCompetitions=[];
            foreach ($getCountry as $key => $value) {
              if($key==0){

              }else{
                $com_name = strip_tags($value[0]) ;
                $com_cid = $row['c_id'];
                $com_link = 'https://soccervista.com'.$value[1];
                $stmt->execute();

                }
                // $stmt->close();
                // $conn->close();
              
              } 
            // }
            
          }
echo 'also done and dusted';