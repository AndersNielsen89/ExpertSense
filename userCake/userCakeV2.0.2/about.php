<html>
<head>
	<?php include 'header.php'; 
	include 'login_header.php';?>

	<script type="text/javascript" src="js/expertFinding.js"></script>
	<script type="text/javascript" src="js/mail.js"></script>

	</head>
<body>
  <div class="content_index">
    <div id="logoAndTitle" class="verticalTextCentering">
      <span><h1><a href="index.php">Expert sense</a></h1></span>
      <div id="subtitle">Finding experts witin rare diseases</div>
    </div>
<div class="center">	
<h3>About</h3><br />
	Expert Sense is a search tool that locates experts of rare diseases. <br />
	The experts presented are the ones who are most likely to have done research <br />
	and/or clinical trials within a disease. <br />
	Therefore, the experts are assumed to be in contact with currently un-cured patients.<br />
	It is intended for pharmaceutical companies to locate patients for clinical trials of newly developed drugs<br />
	 targeting rare conditions. Expert Sense is not (and should not be) used for diagnostics.<br />
	 <br />

	<h3>How do we find the experts?</h3><br />
	Our database contains thousands of medicinal publications from PubMed and <br />
	clinical trials from ClinicalTrials.org – all which is publicly available. <br />
	The data is analysed using a tweaked version of a probabilistic document model. <br />
	In short, the model identifies the experts using probabilities and statistics to <br />
	identify which of the world’s medicinal professionals actually have the relevant <br />
	knowledge to perform population studies.<br />
	<br />

	<h3>Who are we?</h3><br />
	We are two master students in our last year of an engineering degree at Technical University of Denmark (DTU). <br />
	Our focus is primarily on machine learning, big data analysis and software engineering. <br />
	If you want to get in touch - both with questions about the site and <br />
	also with business related matters - please don't hesitate to write us a <span id="mail"></span>.<br />
	<br />

	<h3>Credits</h3><br />
	This site and all concepts behind it have been developed in collaboration with FindWise AB and Rare Disease Management. <br />
	It originated from a project made at DTU Compute with Ole Winther, PhD, as our supervisor.<br />
	</div>
	
</div>

	<script type="text/javascript">
    sendMail();
  </script>
</body>
</html>