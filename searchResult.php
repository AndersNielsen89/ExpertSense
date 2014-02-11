<html>
<head>
  <title>
      <?php echo "Expert Sense - " . strval($_GET['disease_chosen']);?>
    </title>
  <?php include 'header.php'; ?>
  <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADJ1OOwHiXBPNkvB2gw8e4POhoyM-8tDo&sensor=false">
    </script>
  <script type="text/javascript" src="js/expertFinding.js"></script>
  <script type="text/javascript" src="js/expertResult.js"></script>
  <script type="text/javascript" src="js/notify.min.js"></script>

<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 300px; width: 120px; }
    </style>
    
</head>

<body>

  <div class="content">
    <div id="logoAndTitleResult">
      <div id="logo">
        <a href="index.php"><h1 id="h1Result">Expert sense</h1></a>
      </div>
      <div id="searchElementResult">
          <input id="tagsResult" onfocus="autoCompleteSetup()" value="<?php echo $_GET['disease_chosen'];?>">
          <button class="btn goButtonResult btn-success btn" onClick="goButtonClick()">Go</button>
      </div>

      <hr>
</div>
      <div class="mainContent">
      
      <div id="resultDiv">Searching for experts</div>

        
        <div class="filters">
          <div id="loading">Finding experts</div>
          <div id="countryFilter">
          </div>
          <hr>
          <div id="activityFilter">
          </div>
          <hr>
          <div id="articlesPublishedFilter">
          </div>
          <div id="resetFilters" class="btn" onclick="resetFilters()">Reset all filters</div><div id="loadingFilter"></div>
        <hr>
          <div id="map-canvas"></div>
        </div>
        <div class="expertResults">
          
          
        
          <div id="expertList"></div>
        </div>
      </div>
    </div>
    <div id="scrollInfoBox"></div>



  
</body>

</html>