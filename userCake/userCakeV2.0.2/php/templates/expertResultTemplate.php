<?php
$total_div = "<div id=\"expert\">
	<div id=\"expertTitle\">
	<h3>" .
		"<a href=\"expertPage.php?expertName=" . $expert_name . "\">" . $expert_name . "</a><br/>" . "
	</h3></div><div id=\"progressbar\"></div><div id=\"expertInfo\">"

	. $total_contact_info . "</div>" .

	"<div id=\"articlesWrapper\">";

	foreach ($article_link_array as &$article){

			$total_div = $total_div . "<div id=\"articleWrapper\"> <div id=\"articleIcon\"></div>" . $article . "</div>";
			
		}
		
	$total_div = $total_div . "</div>
	
</div><hr>";
return $total_div;

?>