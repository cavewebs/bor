
<?php
require 'vendor/autoload.php';
use Goutte\Client;

require 'db.php';

//get the country id and link from db
$sql = "SELECT com_id, com_link FROM competitions";
$competitions = $conn->query($sql);


while($row = $competitions->fetch_assoc()) {
     
          $url1 = $row['com_link'];
          $client1 = new Client();
          $fixtureCrawler = $client1->request('GET', $url1);
          $fixturesLink = $fixtureCrawler->selectLink('Fixtures')->link()->getUri();
        //prepare statements
          $stmt = $conn->prepare("UPDATE competitions SET com_fixtures_link = '$fixturesLink' WHERE com_id = ".$row['com_id']);
              // execute the query
          $stmt->execute();
      echo 'updated '.$fixturesLink. ' <br >';
      
}

echo 'another milestone';