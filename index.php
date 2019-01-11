
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

foreach ($getCountry as $key => $value) {
$country_name = strip_tags($value[0]) ;
$country_link = 'https://soccervista.com'.$value[1];
$stmt->execute();

}
$stmt->close();
$conn->close();
echo 'We done here';
?>
