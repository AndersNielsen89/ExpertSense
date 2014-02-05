function sendMail(){
	var username = "expertsensedtu";
	var hostname = "gmail.com";
	var linktext = "mail" ;
	
	$("#mail").html("<a href='" + "mail" + "to:" + username + "@" + hostname + "'>" + linktext + "</a>");
}