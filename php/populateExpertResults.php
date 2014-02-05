<?php

$disease_chosen = strval($_GET['disease_chosen']);
$initial_launch = strval($_GET['initialLaunch']);
$country_filter = ((strval($_GET['countriesFilter'])) ? strval($_GET['countriesFilter']) : "");
$activity_filter = ((strval($_GET['activityFilter'])) ? strval($_GET['activityFilter']) : "");
$articles_published_filter = ((strval($_GET['articlesPublishedFilter'])) ? strval($_GET['articlesPublishedFilter']) : "");


//echo "initial launch: " . $initial_launch . " country filter: " . $country_filter;

$username = "sharemybike_dk";
$password = "c26gxrkh";
$hostname = "mysql23.unoeuro.com"; 
$database = "sharemybike_dk_db";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
or die("Unable to connect to MySQL");
$selected = mysql_select_db($database,$dbhandle);
//echo "SELECT name, relevance FROM expertsresult where queryId = (select id from totalQueries where query='".$disease_chosen."')  order by relevance DESC";
if($initial_launch == "true"){
  $result = mysql_query("SELECT name, relevance FROM expertsresult where queryId = (select id from totalQueries where query='".$disease_chosen."')  order by relevance ASC");
}else{
  //echo "SELECT expertsresult.name, expertsresult.relevance, uniqueAuthors.Country, expertsresult.queryId FROM expertsresult INNER JOIN uniqueAuthors on uniqueAuthors.Name = expertsresult.name WHERE (queryId = (select id from totalQueries where query='".$disease_chosen."')) AND (Country = '" . $country_filter . "' ) order by relevance ASC";
  //echo "SELECT name, relevance FROM expertsresult where (queryId = (select id from totalQueries where query='".$disease_chosen."')) order by relevance ASC";
  //$result = mysql_query("SELECT name, relevance FROM expertsresult where (queryId = (select id from totalQueries where query='".$disease_chosen."')) AND (name = (SELECT Name FROM uniqueAuthors WHERE Country = '" . $country_filter . "' ))  order by relevance ASC");
  //SELECT expertsresult.name, expertsresult.relevance, uniqueAuthors.Country, expertsresult.queryId FROM expertsresult INNER JOIN uniqueAuthors on uniqueAuthors.Name = expertsresult.name WHERE (queryId = 43) AND (Country = 'United States' ) order by relevance ASC
  //$result = mysql_query("SELECT name, relevance FROM expertsresult where (queryId = (select id from totalQueries where query='".$disease_chosen."')) AND (name = (SELECT Name FROM uniqueAuthors WHERE Country = '" . $country_filter . "' ))  order by relevance ASC");
  //$result = "SELECT name, relevance FROM expertsresult where (queryId = (select id from totalQueries where query='".$disease_chosen."')) order by relevance ASC";
  $result = mysql_query(createFilterQuery($disease_chosen, $country_filter, $activity_filter, $articles_published_filter));
  //$result = );
  //$result =  mysql_query("SELECT expertsresult.name, expertsresult.relevance, uniqueAuthors.Country, expertsresult.queryId FROM expertsresult INNER JOIN uniqueAuthors on uniqueAuthors.Name = expertsresult.name WHERE (queryId = (select id from totalQueries where query='".$disease_chosen."')) AND (Country = '" . $country_filter . "' ) order by relevance ASC");
}

$indexCounter = 0;

$countryArray = array();

$experts_filters_array = array();

$total_experts_list = array();

$total_experts_str = "";

$max_published_articles = 0;

$number_of_experts = 0;
  //get expertlist for specific query
  while ($row = mysql_fetch_array($result)) {
    
    $expert_name = $row{'name'};
    $expertParts = explode(' ', $expert_name);
    $expert_lastname = substr($expertParts[0], 0, -1);
    $query = "SELECT name, title, department, phone, fax, email  FROM authorContactInfo where name LIKE '%" . $expert_lastname . "%'";
    //log_text($query);
    $result1 = mysql_query($query);


  
    $row2 = mysql_fetch_array($result1);
  

    $title = (($row2{'title'}) ? ($row2{'title'} .  " | ")  : "");
    $department = (($row2{'department'}) ? ($row2{'department'} .  " | ") : "");
    $phone = (($row2{'phone'}) ? ($row2{'phone'} .  " | ") : "");
    $fax = (($row2{'fax'}) ? ($row2{'fax'} .  " | ") : "");
    $email = (($row2{'email'}) ? ((substr($row2{'email'},8)) .  " | ") : "");

    $result2 = mysql_query("SELECT pubMedId, Titel FROM pubmed_article where articleId in (select articleId from topArticles where query = '".$disease_chosen."' and authorName = '".$expert_name."')");
    $indexCounter1 = 0;

    $article_link_array = array();

    while ($row3 = mysql_fetch_array($result2)) {
      if($indexCounter1==0){
        //echo "<b>Most relevant Articles: </b> <br/>";
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

    
    $total_contact_info = $title . $department . $phone . $fax . $email . $country_web . $area_web;
    $total_contact_info = substr($total_contact_info, 0, -2);
    $total_contact_info = $total_contact_info . "</br>";
    $title = (($total_contact_info) ? ($total_contact_info . "</br>")  : "");

    $total_experts_str_1 = include("templates/expertResultTemplate.php");

    $total_experts_str = $total_experts_str_1 . $total_experts_str;
    array_push($total_experts_list, include("templates/expertResultTemplate.php"));

    //calculate unique countries

   

    //Calculate max number of articles
    if($nr_of_articles > $max_published_articles){
      $max_published_articles = $nr_of_articles;
    }
    

    if((!is_null($country))  && ($country!="?")){
      if(!array_key_exists($country, $countryArray) ){
        $countryArray[$country] = 1;
      }
      else{
        $countryArray[$country] = $countryArray[$country] + 1;
      }
    }
    $number_of_experts += 1;
  }

$experts_filters_array["numberOfExperts"] = $number_of_experts;


$numberOfDocumentsQuery = "SELECT numberOfDocuments FROM numberOfDocuments where queryString = '" . $disease_chosen . "'";
$numberOfDocumentsResult = mysql_query($numberOfDocumentsQuery);
$numberOfDocuments = mysql_fetch_array($numberOfDocumentsResult);
$experts_filters_array["numberOfDocuments"] = $numberOfDocuments{'numberOfDocuments'};

$experts_filters_array["expertResultsDiv"] = $total_experts_str;

//inserting country filter
$filter_title = "Country";
$div_id = "countryFilter";
$filter_checkboxes = $countryArray;
$experts_filters_array["countryFilter"] = include("templates/countryFilterTemplate.php");


$filter_title = "Latest author activity";
$div_id = "activityFilter";
$filter_checkboxes = array(0 => "5 Year", 1 => "10 years", 2 => "15 years", 3 => "20 years");
$experts_filters_array["activityFilter"] = include("templates/activityFilterTemplate.php");


$filter_title = "Min number of published articles";
$div_id = "articlesPublishedFilter";
$max_published_articles_interval = $max_published_articles/4;
$max_published_articles_array = array();
for ($i = 0; $i < $max_published_articles; $i = $i + $max_published_articles_interval){
  array_push($max_published_articles_array, intval($i));
}

$filter_checkboxes = $max_published_articles_array;
$experts_filters_array["articlesPublishedFilter"] = include("templates/articlesPublishedFilterTemplate.php");

echo json_encode(($experts_filters_array));





function createFilterQuery($disease_chosen, $country_filters, $activity_filter, $published_number){
  
  //$error_string = 
  
  //$base_query_string = "";
  $countries_query_string = "";
  if($country_filters != ""){
  $countries_array = explode(";", $country_filters);
    $countries_counter = 0;
    $countries_query_string = "";
    foreach ($countries_array as &$country){
      if($country != ""){
        if($countries_counter == 0){
          $countries_query_string = "(Country = '" . $country . "' ) AND ";
        }
        else{
          $countries_query_string = $countries_query_string . "(Country = '" . $country . "' ) AND ";
        }
      }
      $countries_counter += 1;
    }
  }

    $current_year = date("Y");
    $min_year_number = $current_year - $activity_filter;
    $activity_query_string = (($activity_filter) ? ("(LastPublishedDate >= '" . $min_year_number . "' ) AND ") : "");
    //$activity_query_string = "(LastPublishedDate = '" . $activity_filter . "' ) AND ";
  

  
    $published_number_query_string = (($published_number) ? ("(NrOfArticles >= '" . $published_number . "' ) AND ") : "");
    $totalFilterQuery = "";
    if(($countries_query_string != "") || ($activity_query_string != "") || ($published_number_query_string != "")){
      $totalFilterQuery = $countries_query_string . $activity_query_string . $published_number_query_string;
      $totalFilterQuery = " AND " . substr($totalFilterQuery, 0, -5);
    }
  

  //$country_filters, $activity_filter, $published_number
  //$total_query_string = "SELECT expertsresult.name, expertsresult.relevance, uniqueAuthors.Country, expertsresult.queryId FROM expertsresult INNER JOIN uniqueAuthors on uniqueAuthors.Name = expertsresult.name WHERE (queryId = (select id from totalQueries where query='".$disease_chosen."')) " . $country_filter . $activity_query_string . $published_number_query_string . " order by relevance ASC";
  //if($country_filters == ""){
  $total_query_string = "SELECT expertsresult.name, expertsresult.relevance, uniqueAuthors.Country, uniqueAuthors.NrOfArticles, uniqueAuthors.LastPublishedDate, expertsresult.queryId FROM expertsresult INNER JOIN uniqueAuthors on uniqueAuthors.Name = expertsresult.name WHERE (queryId = (select id from totalQueries where query='".$disease_chosen."'))" . $totalFilterQuery . " order by relevance ASC";
  /*
  }else{
    if(($country_filters != "") && ($activity_filter = "") && ($published_number = "")){
      $total_query_string = "SELECT expertsresult.name, expertsresult.relevance, uniqueAuthors.Country, expertsresult.queryId FROM expertsresult INNER JOIN uniqueAuthors on uniqueAuthors.Name = expertsresult.name WHERE (queryId = (select id from totalQueries where query='".$disease_chosen."')) AND " . $countries_query_string . " order by relevance ASC";
    }
    if()
  }
  */
  
  //log_text("new" . $total_query_string);
  //$query_string = "";

  //"SELECT expertsresult.name, expertsresult.relevance, uniqueAuthors.Country, expertsresult.queryId FROM expertsresult INNER JOIN uniqueAuthors on uniqueAuthors.Name = expertsresult.name WHERE (queryId = (select id from totalQueries where query='".$disease_chosen."')) AND (Country = '" . $country_filter . "' ) order by relevance ASC";
  //return "SELECT expertsresult.name, expertsresult.relevance, uniqueAuthors.Country, expertsresult.queryId FROM expertsresult INNER JOIN uniqueAuthors on uniqueAuthors.Name = expertsresult.name WHERE (queryId = (select id from totalQueries where query='".$disease_chosen."')) AND (Country = '" . $country_filter . "' ) order by relevance ASC";

  return $total_query_string;
}


function log_text($text){
  error_log($text . "\n", 3, "C:/xampp/apache/logs/error.log");
}

?>