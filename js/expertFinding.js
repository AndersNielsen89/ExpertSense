var availableTags;
function updateExpertRow(str){
    console.log(str);
    if (str==""){
        document.getElementById("row1Update").innerHTML="";
        return;
    } 
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("row1Update").innerHTML=xmlhttp.responseText;
        }
    }

    //document.getElementById("sicknessChosen").innerHTML="Experts for " + str;
    
    xmlhttp.open("GET","php/updateExpertRow.php?disease="+str + "&method=updateRow1&sicknessChosen=null",true);
    xmlhttp.send();
    
}


window.onresize = function(event) {
    var screenWidth = $(window).width();
    if(screenWidth>600){
        $(".expandExpert").animate({ "height": "0" }, "quick" );
    }
}



function expandExpertElement(elementNumber){
    var activeId = "#expandExpert" + elementNumber.substr(-1,1);
    $(activeId).animate({ "height": "500px" }, "quick" );
}

function hideExpertElement(elementNumber){
    var activeId = "#expandExpert" + elementNumber.substr(-1,1);
    console.log("activeID " + activeId);
    
}

function updateExpertDescription(str, str2){
    var screenWidth = $(window).width();
    console.log(str2[str2.length-2]);
    if(isNaN(str2[str2.length-2])){
        var expertName = $('#author' + str2[str2.length-1]).text();
    }
    else{
        var expertName = $('#author' + str2.substr(str2.length-2,str2.length-1)).text();
    }

    var activeId = "#" + str2;
    //var expertName = $('#author0').text()
    console.log(expertName);

    $('#row1Update a.mouseHover').removeClass('active');
    $(activeId).addClass('active');

    if(screenWidth<600){
        $("#row2Update").css('display', 'none');
        
        $(activeId).click(
            expandExpertElement(str2)
        );
    }
    else{
        console.log("in else");
        if (str==""){
            //document.getElementById("row2Update").innerHTML="";
            return;
        }
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else{// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById("panel_body_id").innerHTML=xmlhttp.responseText;
                $("#row2Update").css('display', 'block');
            }
        }
        var sicknessChosen = $('#sicknessChosen').text();
        sicknessChosen = sicknessChosen.substr(12, sicknessChosen.length);
        xmlhttp.open("GET","php/updateExpertRow.php?disease="+ expertName + "&method=updateRow2&sicknessChosen=" + sicknessChosen,true);
        xmlhttp.send();
    }
  

}
function queryModel(){
    var sessionId = createUUID();
    document.getElementById('asyncExperts').innerHTML += 'Hello from Javascript <br />'
    
    
    callPhpMethod("php/asyncModelCall.php", "?date="+ "010289" + "&articles=2&id="+ sessionId, "asyncExperts");
    var count = 0;
    //document.getElementById('asyncExperts').innerHTML += xmlhttp.responseText;
    var intervalId = setInterval(function(){
        callPhpMethod("php/readExperts.php", "?id="+sessionId, "asyncExperts");
        count = count+1;
        if (count==10){
            clearInterval(intervalId);
        }
    },1000);

}
function callPhpMethod(method, params, insertInto){
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
         xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
               
                document.getElementById(insertInto).innerHTML += xmlhttp.responseText;
            }
        }

    xmlhttp.open("GET", method+params,true);
    xmlhttp.send();
}

function continousUpdate(){
    var amount = document.getElementById('asyncExperts');
    var current = 138276343;
    update();

    function update() {
        amount.innerText = formatMoney(current);
    }

    setInterval(function(){
        current += .158;
        update();
    },1000);

    function formatMoney(amount) {
        var dollars = Math.floor(amount).toString().split('');
        var cents = (Math.round((amount%1)*100)/100).toString().split('.')[1];
        if(typeof cents == 'undefined'){
         cents = '00';
        }else if(cents.length == 1){
            cents = cents + '0';
        }
        var str = '';
        for(i=dollars.length-1; i>=0; i--){
            str += dollars.splice(0,1);
            if(i%3 == 0 && i != 0) str += ',';
        }
        return '$' + str + '.' + cents;
    }
}
function createUUID() {
    // http://www.ietf.org/rfc/rfc4122.txt
    var s = [];
    var hexDigits = "0123456789abcdef";
    for (var i = 0; i < 36; i++) {
        s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
    }
    s[14] = "4";  // bits 12-15 of the time_hi_and_version field to 0010
    s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1);  // bits 6-7 of the clock_seq_hi_and_reserved to 01
    s[8] = s[13] = s[18] = s[23] = "-";

    var uuid = s.join("");
    return uuid;
}
function autoCompleteSetup(){

    $("#tags").val("");
    $("#tags").css("color", "black");
    availableTags = [];
    
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
         xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                if($("#searchElement").length == 0){
                    $("#searchElementResult").append("<p id=\"errorMessage\" style=\"color:red; margin-left:280px;margin-top:10px;\"></p>");
                }else{
                    $("#searchElement").append("<p id=\"errorMessage\" style=\"color:red;\"></p>");
                }
                
               
               //document.getElementById("asyncExperts").innerHTML += xmlhttp.responseText;
                console.log(xmlhttp.responseText);
                responseStr = xmlhttp.responseText;
                availableTags = (responseStr.substring(0,responseStr.length-1)).split(',');
                $( "#tags" ).autocomplete({
                    source: availableTags,
                });
                
                $( "#tags" ).on( "autocompleteselect", function( event, ui ) {
                    var rareDiseaseChosen = ui.item.value;
                    postDisease(rareDiseaseChosen);

                } );

                $( "#tagsResult" ).autocomplete({
                    source: availableTags, 
                });
                
                $( "#tagsResult" ).on( "autocompleteselect", function( event, ui ) {
                    var rareDiseaseChosen = ui.item.value;
                    postDisease(rareDiseaseChosen);
                } );

            }
        }

    xmlhttp.open("GET", "php/autoComplete.php",true);
    xmlhttp.send();

    
    //var dbTags = callPhpMethod("php/autoComplete.php", "", "asyncExperts");
    
    
  //});
}

function postDisease(rareDiseaseChosen){
    console.log("post: " + rareDiseaseChosen);
    window.location.href = "searchResult.php?disease_chosen=" + rareDiseaseChosen;
}


  $(document).ready(function() {
    $("#tags").css("color", "grey");
  });

  document.addEventListener('keypress', function (e) {
    var key = e.which || e.keyCode;
    if (key == 13) { // 13 is enter
        var rareDiseaseChosen = getRareDisease();
        if(availableTags.indexOf(rareDiseaseChosen)!=-1){
            postDisease(rareDiseaseChosen);
        }else{
            $("#errorMessage").text("Please select a rare disease");
        }
    }
});

function goButtonClick(){
    var rareDiseaseChosen = getRareDisease();
    if(availableTags.indexOf(rareDiseaseChosen)!=-1){
            postDisease(rareDiseaseChosen);
    }else{
        $("#errorMessage").text("Please select a rare disease");
    }
}


