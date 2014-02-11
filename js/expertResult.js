var chosenDisease = "";
var totalCountriesString = "";
var activityFilter = "";
var acticlesPublishedFilterString = "";

$(document).ready(function() {

//$("#scrollInfoBox").notify("lol");
$.notify.defaults({ className: "success" });
$.notify("Scroll to load more experts",  {globalPosition:"bottom right"});
console.log("in here");

$(window).scroll(function(){
    console.log("called");
        if($(window).scrollTop() == $(document).height() - $(window).height()) {
            console.log("in bottom");
            
            if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else{// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                $("#loading").text("Experts found");
                        $("#loading").css("background", "none");
                        var jsonResponse = eval("(" + xmlhttp.responseText + ")");
                        $("#expertList").append(jsonResponse['expertResultsDiv']);
                        //$("#expertList").append("<div id=loading class=updateLoader></div>");
                        $(".updateLoader").remove();
                        var expertCounter = 1;
                        $( "#expertList #progressbar" ).each(function(){
                            $(this).html(expertCounter);
                            expertCounter += 1;
                        });
                        var numberOfExperts = $("#expertList #expert").length;
                        var numberOfDocuments = jsonResponse["numberOfDocuments"];
                        showExpertResultString(chosenDisease, numberOfExperts, numberOfDocuments);
            }
        }

        //document.getElementById("sicknessChosen").innerHTML="Experts for " + str;
        var numberOfExpertsScroll = $("#expertList #expert").length;
        xmlhttp.open("GET","php/populateExpertResults.php" + "?disease_chosen=" + chosenDisease + "&initialLaunch=false&countriesFilter=" + totalCountriesString + "&activityFilter=" + activityFilter + "&articlesPublishedFilter=" + acticlesPublishedFilterString + "&numberOfExperts=" + numberOfExpertsScroll,true);
        xmlhttp.send();
           // ajax call get data from server and append to the div
        }
    });


    var map;
    function initialize() {
        var myLatlng = new google.maps.LatLng(0,0);
        var mapOptions = {
        center: myLatlng,
        zoom: 1, 
    };

    map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);

        }
        google.maps.event.addDomListener(window, 'load', initialize);

    chosenDisease = getUrlVars()["disease_chosen"];

    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp1=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp1.onreadystatechange=function(){
        //All authors loaded
        if (xmlhttp1.readyState==4 && xmlhttp1.status==200){
            $("#loading").text("Experts found");
            var jsonResponse = eval("(" + xmlhttp1.responseText + ")");
            var numberOfExperts = jsonResponse["numberOfExperts"];
            var numberOfDocuments = jsonResponse["numberOfDocuments"];
            showExpertResultString(chosenDisease, numberOfExperts, numberOfDocuments);
            $("#expertList").html(jsonResponse['expertResultsDiv']);
            //$("#expertList").append("<div id=loading class=updateLoader></div>");
            var expertCounter = 1;
            $( "#expertList #progressbar" ).each(function(){
                $(this).html(expertCounter);
                expertCounter += 1;
            });
            //console.log(jsonResponse);
            $("#countryFilter").html(jsonResponse['countryFilter']);
            $("#activityFilter").html(jsonResponse['activityFilter']);
            $("#articlesPublishedFilter").html(jsonResponse['articlesPublishedFilter']);
            
       
            var countriesFilter = new Array();

            $("#activityFilter input:checkbox").click(function() {
                    if ($(this).is(":checked")) {
                        var group = "input:checkbox[name='" + $(this).attr("name") + "']";
                        $(group).prop("checked", false);
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                });

            $("#articlesPublishedFilter input:checkbox").click(function() {
                    if ($(this).is(":checked")) {
                        var group = "input:checkbox[name='" + $(this).attr("name") + "']";
                        $(group).prop("checked", false);
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                });



            $(".filters").change(function(){
                showLoadingAnimation();
                countriesFilter = new Array();
                totalCountriesString = "";
                $("#countryFilter input").each(function(){
                    if(this.checked){
                        var countryChecked = $(this).val();
                        totalCountriesString = countryChecked + ";" + totalCountriesString;
                    }
                });
                console.log("countriesString: " + totalCountriesString);
            
                activityFilter = "";
                $("#activityFilter input").each(function(){
                    if(this.checked){
                        var activityChecked = $(this).val().split(" ")[0];
                        activityFilter = activityChecked;
                    }
                });

                acticlesPublishedFilterString = "";
                $("#articlesPublishedFilter input").each(function(){
                    if(this.checked){
                        var articlesPublishedChecked = $(this).val();
                        acticlesPublishedFilterString = articlesPublishedChecked;
                    }
                });




                

                if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttpFilter=new XMLHttpRequest();
                }
                else{// code for IE6, IE5
                    xmlhttpFilter=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttpFilter.onreadystatechange=function(){
                    //filters applied
                    if (xmlhttpFilter.readyState==4 && xmlhttpFilter.status==200){
                        //$("#loading").css("display", "none");
                        $("#loading").text("Experts found");
                        $("#loading").css("background", "none");
                        var jsonResponse = eval("(" + xmlhttpFilter.responseText + ")");
                        $("#expertList").html(jsonResponse['expertResultsDiv']);
                        //$("#expertList").append("<div id=loading class=updateLoader></div>");
                        var expertCounter = 1;
                        $( "#expertList #progressbar" ).each(function(){
                            $(this).html(expertCounter);
                            expertCounter += 1;
                        });
                        var numberOfExperts = jsonResponse["numberOfExperts"];
                        var numberOfDocuments = jsonResponse["numberOfDocuments"];
                        showExpertResultString(chosenDisease, numberOfExperts, numberOfDocuments);
                    }
                }

                xmlhttpFilter.open("GET","php/populateExpertResults.php" + "?disease_chosen=" + chosenDisease + "&initialLaunch=false&countriesFilter=" + totalCountriesString + "&activityFilter=" + activityFilter + "&articlesPublishedFilter=" + acticlesPublishedFilterString + "&numberOfExperts=" + "",true);
                xmlhttpFilter.send();
            });


            //$("#loading").css("display", "none");
            $("#loading").css("background", "none");


            geocoder = new google.maps.Geocoder();
            //http://stackoverflow.com/questions/18744500/google-maps-api-place-markers-on-countries-without-using-coordinates
            function getCountry(country) {
                geocoder.geocode( { 'address': country }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                       //map.setCenter(results[0].geometry.location);
                       var marker = new google.maps.Marker({
                           map: map,
                           position: results[0].geometry.location
                       });
                    } else {
                      console.log("Geocode was not successful for the following reason: " + status);
                    }
                });
            }


            //What you gonna do??? Call the cops??? There is no hacking cops!
            var countriesArray = jsonResponse['countryFilter'].split("</br>");
            var counter = 0;

            var lengthOfArray = countriesArray.length; 
            console.log(lengthOfArray);
            countriesArray.forEach(function(entry){
                if((counter != 0) && (counter != lengthOfArray-1)){
                    var country = entry.split("value")[1].split("\"")[1];
                    getCountry(country);
                }
                counter += 1;
            });
        }
    }

    activityFilter = "";
    acticlesPublishedFilterString = "";
    xmlhttp1.open("GET","php/populateExpertResults.php" + "?disease_chosen=" + chosenDisease + "&initialLaunch=true&countriesFilter=false" + "&activityFilter=" + activityFilter + "&articlesPublishedFilter=" + acticlesPublishedFilterString + "&numberOfExperts=" + "",true);
    xmlhttp1.send();
  });


function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}


function showExpertResultString(sicknessChosen, numberOfExperts, numberOfDocuments){
    var numberofDocumentsString = "";
    if(numberOfDocuments == 1){
        numberofDocumentsString = "<b> " + numberOfDocuments + " document </b>";
    }
    else{
        numberofDocumentsString = "<b> " + numberOfDocuments + " documents </b>";
    }
    if(numberOfExperts == 0){
        $("#resultDiv").html("No experts </b> found in " + numberofDocumentsString + " for <b>" + sicknessChosen.replace(/%20/g," ") + "</b>, ranked after relevance");
    }
    else if(numberOfExperts == 1){
        $("#resultDiv").html("Showing <b> " + numberOfExperts + " expert </b> found in " + numberofDocumentsString + " for <b>" + sicknessChosen.replace(/%20/g," ") + "</b>, ranked after relevance");
    }
    else{
        $("#resultDiv").html("Showing <b> " + numberOfExperts + " experts </b> found in " + numberofDocumentsString + " for <b>" + sicknessChosen.replace(/%20/g," ") + "</b>, ranked after relevance");
    }
    
}

function resetFilters(){
    showLoadingAnimation();
    $("#loadingFilter").css("display", "block");
    
    console.log("resetting filters");



if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    //Reset filter ajax callback
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            var jsonResponse = eval("(" + xmlhttp.responseText + ")");
            var numberOfExperts = jsonResponse["numberOfExperts"];
            $("#expertList").html(jsonResponse['expertResultsDiv']);
            //$("#expertList").append("<div id=loading class=updateLoader></div>");
            var numberOfDocuments = jsonResponse["numberOfDocuments"];
            showExpertResultString(chosenDisease, numberOfExperts, numberOfDocuments);
            $("#loading").text("Experts found");
            $("#loading").css("background", "none");
            var expertCounter = 1;
            $( "#expertList #progressbar" ).each(function(){
                $(this).html(expertCounter);
                expertCounter += 1;
            });

            $("#loadingFilter").css("display", "none");
            removeCheckedInputs();
        }

    }

    activityFilter = "";
    acticlesPublishedFilterString = "";
    xmlhttp.open("GET","php/populateExpertResults.php" + "?disease_chosen=" + chosenDisease + "&initialLaunch=true&countriesFilter=false" + "&activityFilter=" + activityFilter + "&articlesPublishedFilter=" + acticlesPublishedFilterString + "&numberOfExperts=" + "",true);
    xmlhttp.send();
}

function removeCheckedInputs(){
    $("#countryFilter input").each(function(input){
        $(this).prop('checked', false);
    });
    
    $("#activityFilter input").each(function(input){
        $(this).prop('checked', false);
    });
    $("#articlesPublishedFilter input").each(function(input){
        $(this).prop('checked', false);
    });
    
    
}

function showLoadingAnimation(){
    $('#loading').css('background', 'url(images/301.gif) no-repeat left');
    $("#loading").text("Finding experts");
    $('#loading').css('background-size', '15px 15px');
    $('#loading').css('background-position-x', '110');
    $('#loading').css('background-position-y', '5');  
    
      
}