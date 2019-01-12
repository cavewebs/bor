
<?php
require 'vendor/autoload.php';
require 'db.php';
use Goutte\Client;

$url = "http://www.soccervista.com";
$css_selector = "ul#navlist2 a";
$thing_to_scrape = "_text";

$client = new Client();
$crawler = $client->request('GET', $url);

//country urls
$getCountry = $crawler->filter($css_selector)->extract(array('_text', 'href'));

// prepare and bind
$stmt = $conn->prepare("INSERT INTO countries (c_name, c_link) VALUES (?, ?)");
$stmt->bind_param("ss", $country_name, $country_link);
echo '<table class="table">
  <thead>
<tr> <td>S/N</td><td>Country</td><td>Link</td></tr></thead>
  <tbody>';
  $h = 1;
foreach ($getCountry as $key => $value) {
$co_name = htmlentities($value[0] , null, 'utf-8');
$dname = str_replace("&nbsp;", "", $co_name);
$country_name = $dname ;
$country_link = 'https://soccervista.com'.$value[1];
$stmt->execute();$country_link = 'https://soccervista.com'.$value[1];
$stmt->execute();
   echo '<tr> <td>' .$h.'</td> <td>' .$value[0].'</td> <td> '. $value[1].'</td> <td>';

$h++;
}
$stmt->close();
$conn->close();
echo 'We done here';
?>
