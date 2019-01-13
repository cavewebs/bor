
<?php
require 'vendor/autoload.php';
use Goutte\Client;
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php';
$j=1;
      // prepare and bind
      $stmt = $conn->prepare("INSERT INTO matches (m_date, m_hometeam, m_awayteam, m_round, m_com_id, m_sv_link, m_livescore_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("diiiisi", $m_date, $m_hometeam, $m_awayteam, $m_round, $m_com_id, $m_sv_link, $m_livescore_id);

$client = new Client();
try {
    // begin the transaction
    $conns->beginTransaction();
$matches = $conn->query("SELECT * FROM competitions WHERE com_status !='11'") or die($conn->error);
while($row =  $matches->fetch_assoc()){
if($row !=NULL){
                echo 'the com being processed is: '.$row['com_id'].'<br />';  

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
          // print_r($competitionFixtureRaw);
                foreach ($competitionFixtureRaw as $key => $value) { 
                   
               $sql1 = 'SELECT t_id FROM teams WHERE t_name = "'.$value[3].'" AND t_c_id = "' .$row['com_c_id'].'"';
                    $sql2 = 'SELECT t_id FROM teams WHERE t_name = "'.$value[5].'" AND t_c_id = "'.$row['com_c_id'].'"';
                    $ht_q = $conn->query($sql1)->fetch_assoc() ;
                    $at_q = $conn->query($sql2)->fetch_assoc() ;
;
                    $m_date = strtotime($value[0]);
                    if($ht_q){$m_hometeam = $ht_q['t_id'];} else {$m_hometeam =0; echo 'There was no result';}
                    if($at_q){$m_awayteam = $at_q['t_id'];} else {$m_awayteam =0; echo 'no result <br />';}
                    $m_round = $value[1];
                    $m_com_id = $row['com_id'];
                    $m_s_link = "https://soccervista.com".$value[9];
                    $m_sv_link = mysqli_real_escape_string($conn, $m_s_link);
                    $m_livescore_id = intval(explode("-", $value[9])[2]);
                    echo 'date: '.$m_date.'<br />'; 
                    echo 'hometeam: '.$m_hometeam.'<br />'; 
                    echo 'Awayteam: '.$m_awayteam.'<br />'; 
                    echo 'round: '.$m_round.'<br />'; 
                    echo 'competion Id: '.$m_com_id.'<br />'; 
                    echo 'The Link: '.$m_sv_link.'<br />'; 
                    echo 'Livescore Id: '.$m_livescore_id .'<br />';
                  $stmt->execute();

          if ($stmt){
                    echo "Just inserted :".$m_livescore_id.'<br />';
                } else {
                  echo 'bye';
                  
                }
              }
              // $conns->commit();
              $update_fixtured = $conn->query("UPDATE competitions set com_status='11' WHERE com_id='".$row['com_id']."'");
              if($update_fixtured){
                echo 'Updated '.$row['com_id'].'<br />';
              
              }
          }// if row !=nu;;
      }
      } 
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
echo "we Made it, We are rich";

?>