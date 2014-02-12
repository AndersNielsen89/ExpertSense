<?php
$disease = strval($_GET['disease']);
$method = strval($_GET['method']);
$sicknessChosen = strval($_GET['sicknessChosen']);


$username = "sharemybike_dk";
$password = "c26gxrkh";
$hostname = "mysql23.unoeuro.com"; 
$database = "sharemybike_dk_db";

/*
$username = "root";
$password = "";
$hostname = "localhost"; 
$database = "expert_search";
*/

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
or die("Unable to connect to MySQL");
$selected = mysql_select_db($database,$dbhandle);

if($method=="updateRow1"){
  updateRow1($disease);
}
elseif ($method == "updateRow2") {
  updateExpertDescription($disease, $sicknessChosen);
}

mysql_close($dbhandle);

function updateRow1($disease){
  $diseaseChosen = $disease;
      $result = mysql_query("SELECT name, relevance FROM expertsresult where queryId = (select id from totalQueries where query='".$disease."')  order by relevance DESC");
  //fetch tha data from the database
  $indexCounter = 0;
  while ($row = mysql_fetch_array($result)) {
      if ($indexCounter==0){

        echo "<a class=\"list-group-item\" id=\"expertListTop\">
            Expert name
            </a>";
        }
        $label = $indexCounter + 1;
        echo "<a id=\"expertName" . $indexCounter . "\"class=\"list-group-item mouseHover\" onclick=\"updateExpertDescription(this.id, this.id)\"> ";
        echo "<span class=\"label label-default\">" . $label . "</span>";
        echo "<span class=\"authorList\" id=\"author" . $indexCounter . "\">" . $row{'name'} . "</span>";
        echo "<span id=\"expertRelevance" . $indexCounter . "\" ></span>";
        
        echo "</a>";
        echo "<div class=\"expandExpert\" id=\"expandExpert" . $indexCounter . "\"></div>";
        $indexCounter++;
  }
}

function findBestAuthorMatch($authorArray, $authorName){
  //print_r($authorArray);
  foreach($authorArray as &$author){
    $databaseAuthorName =  $authorArray{'name'};
    //echo $databaseAuthorName;
  }
  //return bestMatch;
}

function updateExpertDescription($disease, $sicknessChosen){
  //echo "SELECT pubMedId FROM pubmed_article where articleId = (select articleId from topArticles where query = '".$sicknessChosen."' and authorName = '".$disease."'";
  //echo($sicknessChosen);
  //echo($disease);
  
  //print_r($result);
  echo "<b>Name: </b> " . $disease . "<br/><br/>";

  $authorParts = explode(' ', $disease);
  $query = "SELECT name, title, department, phone, fax, email  FROM authorContactInfo where name LIKE '%" . $authorParts[sizeof($authorParts)-1] . "%'";
  //echo $query;
  $result = mysql_query($query);
  $row = mysql_fetch_array($result);
  //echo $row{'name'};
  if(sizeof($row)!=1 and (sizeof($row)!=0)){
    findBestAuthorMatch($row, $disease);
  }

  $number_of_articles_published_query = "SELECT numberOfArticles FROM  authorNumberOfArticles WHERE  queryName LIKE  '" . $sicknessChosen . "' AND authorName LIKE  '" . $disease . "'";
  $number_of_articles_published_result = mysql_query($number_of_articles_published_query);
  $number_of_articles_published_row = mysql_fetch_array($number_of_articles_published_result);
  
  //$row = mysql_fetch_array($result);
  if($row{'title'}){
    echo "<b>Title: </b> " . $row{'title'} .  " <br/><br/>";
  }
  if($row{'department'}){
    echo "<b>Department: </b> " . $row{'department'} .  " <br/><br/>";
  }
  if($row{'phone'}){
    echo "<b>Phone: </b> " . $row{'phone'} .  " <br/><br/>";
  }
  if($row{'fax'}){
    echo "<b>Fax: </b> " . $row{'fax'} .  " <br/><br/>";
  }
  if($row{'email'}){
    echo "<b>Email: </b> " . $row{'email'} .  " <br/><br/>";
  }

  $result = mysql_query("SELECT pubMedId FROM pubmed_article where articleId in (select articleId from topArticles where query = '".$sicknessChosen."' and authorName = '".$disease."')");
  $indexCounter = 0;
  while ($row = mysql_fetch_array($result)) {
    if($indexCounter==0){
      echo "<b>Most relevant Articles: </b> <br/>";
    }
    echo "<a href=\"http://www.ncbi.nlm.nih.gov/pubmed/?term=" . $row{'pubMedId'} . "\">http://www.ncbi.nlm.nih.gov/pubmed/?term=" . $row{'pubMedId'} . "</a><br/>";
    $indexCounter +=1;
  }
  echo "<br/>";
  
  
  
}
?>