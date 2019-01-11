
<?php
require 'vendor/autoload.php';
use Goutte\Client;

require 'db.php';

//get the country id and link from db
$sql = "SELECT com_id, com_c_id, com_fixtures_link FROM competitions";
$matches = $conn->query($sql);

$css_selector = "tbody tr.predict td a";
$fixtures_css_selector = "div.menu2 a";
$thing_to_scrape = "_text";

try {

// prepare and bind
$stmt = $conn->prepare("INSERT INTO teams (t_name, t_c_id) VALUES (?, ?)");
$stmt->bind_param("si", $t_name, $t_c_id);

$client = new Client();

while($row = $matches->fetch_assoc()) {
  // if ($row['com_c_id'] > 1079){

$crawler = $client->request('GET', $row['com_fixtures_link']);
// $competitionFixtureRaw = $crawler->filter($css_selector)->extract('href');

$competitionFixtureRaw = $crawler->filter('tr.predict')->each(function ($tr, $i) { 
        return $tr->filter('td')->each (
          function ($td, $i) 
        { 
            if($i==9) 
              { return $td->filter('a')->extract('href')[0]; } 
                else 
                  {
                    return trim($td->text()); 
                  }
          });
      
    });
      foreach ($competitionFixtureRaw as $key => $value) {           
          $t_name = $value[3];
          // $m_awayteam= $value[5];
          $t_c_id = $row['com_c_id'];
          $stmt->execute();
          echo '-----------------------------------------------------------';
          echo 'updated '.$t_name. ' /n <br />';


      // }
      }
        }
         }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
echo 'bingo /<br />';