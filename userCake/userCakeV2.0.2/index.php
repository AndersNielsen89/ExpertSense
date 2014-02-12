<?php include 'login_header.php'; ?>
<html>
<head>

  <?php include 'header.php'; ?>
  <script type="text/javascript" src="js/expertFinding.js"></script>
  <?php include 'php/mostSearchedRareDiseases.php'; ?>
  </head>

<body>

<div class="content_index">

    <div id="logoAndTitle" class="verticalTextCentering">

      <span><h1><a href="index.php">Expert sense</a></h1></span>
      <div id="subtitle">Finding experts witin rare diseases</div>
    </div>
<div class="center">
    <div id="searchElement">
          <input id="tags" onfocus="autoCompleteSetup()" value="Search for a rare disease">
          <button class="btn goButton btn-success btn-lg" onClick="goButtonClick()">Go</button>
    </div>
    <div id="mostSearchedRareDiseases">
      
      <?php
      if(sizeof($most_searched_result_array)!=0){
        echo "Most searched rare diseases";
      }
      foreach ($most_searched_result_array as &$rare_disease){
            echo $rare_disease;
      } 
      ?>
    </div>

    <br/>
    <br/>

    <table border="0" cellpadding="3" id="tableBorder">
      <tr>
        <th>
          <!--
          Row 1
          -->
          <div class="list-group">
            <div id="row1Update"></div>
          </div>
        </th>
        <th>
          <!--
          Row 2
          -->
          <div id="row2Update">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Expert details</h3>
              </div>
              <div class="panel-body" id="panel_body_id">Panel content</div>
            </div>
          </div>
        </th>
      </tr>
    </table>

    <div id="footer"> Copyright &#169; 2014 ExpertSense | <a href="about.php"> About </a></div>

 </div>
 </div>
 <br />
 <br/ >
<div class="addthis_toolbox addthis_default_style share">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>

<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
</div>

    
   <!--  <div id="asyncExperts">
      
    </div>
    <button onclick="queryModel()">Click me</button> -->
  
<!-- AddThis Button BEGIN -->


<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52f251df064b2ed1"></script>
<!-- AddThis Button END -->

</body>
  </html>



