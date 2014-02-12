<?php 
  include 'login_header.php';
  securePage($_SERVER['PHP_SELF']);
?>
<html>
<head>
<title>
      <?php echo "Expert Sense - " . strval($_GET['expertName']);?>
    </title>
  <?php include 'header.php'; ?>
  <?php include 'php/expertPageBackend.php'; ?>

  <script type="text/javascript" src="js/expertFinding.js"></script>
    
</head>

<body>

  <div class="content">
    <div id="logoAndTitleResult">
      <div id="logo">
        <a href="index.php"><h1 id="h1Result">Expert sense</h1></a>
      </div>
      <div id="searchElementResult">
          <input id="tagsResult" onfocus="autoCompleteSetup()" value="asd">
          <button class="btn goButtonResult btn-success btn" onClick="goButtonClick()">Go</button>
      </div>

      <hr>
</div>
      <div class="mainContent">
      
        <div id="expertName">
          <h1><?php echo $expert_name; ?></h1>
        </div>
        <div id="contactInfo">
          <?php echo $expert_contact_info; ?>
        </div>
        </br>
        <div id="Articles">
          <?php 
          foreach ($article_link_array as &$article){
            echo $article;
          } 
          ?>
        </div>
        <div id="similarExperts">
          <b>Related experts</b>
          </br>
          <?php 
          foreach ($expert_community as &$expert){
            echo "<a href=\"expertPage.php?expertName=" . $expert . "\">" . $expert . "</a><br/>";
          } 
          ?>
        </div>

      </div>
    </div>



  
</body>

</html>