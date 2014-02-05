<?php


$username = "sharemybike_dk";
$password = "c26gxrkh";
$hostname = "mysql23.unoeuro.com"; 
$database = "sharemybike_dk_db";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
or die("Unable to connect to MySQL");
$selected = mysql_select_db($database,$dbhandle);


$expert_name = strval($_GET['expertName']);



$result2 = mysql_query("SELECT pubMedId, Titel FROM pubmed_article where articleId in (select articleId from topArticles where authorName = '".$expert_name."')");
$indexCounter1 = 0;

$article_link_array = array();

while ($row3 = mysql_fetch_array($result2)) {
  if($indexCounter1==0){
    array_push($article_link_array,"<b>Most relevant Articles: </b> <br/>");
  }
  $article_title = $row3{'Titel'};
  $numberOfLetters = 90;
  if(strlen($article_title) > $numberOfLetters){
    $article_title = substr($article_title, 0, $numberOfLetters) . "...";
  }
  else{
    $article_title = $article_title;
  }
  
  array_push($article_link_array, "<a href=\"http://www.ncbi.nlm.nih.gov/pubmed/?term=" . $row3{'pubMedId'} . "\">" . $article_title . "</a><br/>");
  $indexCounter1 +=1;
}

$uniqueAuthorsResult = mysql_query("SELECT LastPublishedDate, NrOfArticles, Area, Country FROM uniqueAuthors where Name like '" . $expert_name . "'");
$uniqueAuthorsRow = mysql_fetch_array($uniqueAuthorsResult);

$last_published_date_web = (($uniqueAuthorsRow{'LastPublishedDate'}) ? ($uniqueAuthorsRow{'LastPublishedDate'} . " | ") : "");
$nr_of_articles_web = (($uniqueAuthorsRow{'NrOfArticles'}) ? ($uniqueAuthorsRow{'NrOfArticles'} . " | ") : "");
$area_web = (($uniqueAuthorsRow{'Area'}) ? ($uniqueAuthorsRow{'Area'} . " | ") : "");
$country_web = (($uniqueAuthorsRow{'Country'}) ? ($uniqueAuthorsRow{'Country'} . " | ") : "");

$last_published_date = $uniqueAuthorsRow{'LastPublishedDate'};
$nr_of_articles = $uniqueAuthorsRow{'NrOfArticles'};
$area = $uniqueAuthorsRow{'Area'};
$country = $uniqueAuthorsRow{'Country'};

$expertParts = explode(' ', $expert_name);
$expert_lastname = substr($expertParts[0], 0, -1);
$query = "SELECT name, title, department, phone, fax, email  FROM authorContactInfo where name LIKE '%" . $expert_lastname . "%'";
$result1 = mysql_query($query);



$row2 = mysql_fetch_array($result1);


$title = (($row2{'title'}) ? ($row2{'title'} .  " | ")  : "");
$department = (($row2{'department'}) ? ($row2{'department'} .  " | ") : "");
$phone = (($row2{'phone'}) ? ($row2{'phone'} .  " | ") : "");
$fax = (($row2{'fax'}) ? ($row2{'fax'} .  " | ") : "");
$email = (($row2{'email'}) ? ((substr($row2{'email'},8)) .  " | ") : "");



$expert_contact_info = $title . $department . $phone . $fax . $email . $country_web . $area_web;


$community_query = "SELECT communityString  FROM expertCommunities";
$community_result = mysql_query($community_query);

$expert_community;

$community_counter = 0;
while ($community_row = mysql_fetch_array($community_result)) {
	$communities = explode(":", $community_row{'communityString'});
	$expert_counter = 0;
	$sub_communities = array_slice($communities, 1, sizeof($communities));
	foreach($sub_communities as &$community){
		$community = explode("'", $community);
		$community = $community[1];
		$community_experts = explode(";", $community);
		foreach($community_experts as &$expert){
			if($expert_name == $expert){
				$expert_community = $community_experts;
			}
			$expert_counter += 1;
		}
	}
	$community_counter += 1;
}












function log_text($text){
  error_log($text . "\n", 3, "C:/xampp/apache/logs/error.log");
}
?>