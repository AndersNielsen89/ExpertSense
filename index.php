<html>
<head>
  <?php include 'header.php'; ?>
  <script type="text/javascript" src="js/expertFinding.js"></script>
  
  </head>

<body>

  <div class="content">

    <div id="logoAndTitle" class="verticalTextCentering">

      <span><h1>Expert sense</h1></span>
      <div id="subtitle">Putting the sense back in experts</div>
    </div>

    <div id="searchElement">
          <input id="tags" onfocus="autoCompleteSetup()" value="Search for a rare disease">
          <button class="btn goButton btn-success btn-lg" onClick="goButtonClick()">Go</button>
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
 
    
   <!--  <div id="asyncExperts">
      
    </div>
    <button onclick="queryModel()">Click me</button> -->
    
</body>
  </html>



