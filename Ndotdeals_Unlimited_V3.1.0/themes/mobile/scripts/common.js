//Get the docroot form js Url
var scripts = document.getElementsByTagName("script");
var thisScript = scripts[scripts.length-1];
var thisScriptsSrc = thisScript.src;

 function get_hostname_from_url(url) {
     return url.match(/:\/\/(.[^/]+)/)[1];
 }
  
this.hostname = 'http://'+get_hostname_from_url(thisScriptsSrc);

// Ajax Basic Functions Starts here..
agent = navigator.userAgent;
var responseVal;
var xmlhttp 

if (!xmlhttp && typeof XMLHttpRequest != 'undefined')
{
  try {
	xmlhttp = new XMLHttpRequest ();
  }
  catch (e) {
  xmlhttp = false;
  }
}

function myXMLHttpRequest ()
{
  var xmlhttplocal;
  try {
  	xmlhttplocal = new ActiveXObject ("Msxml2.XMLHTTP")}
  catch (e) {
	try {
	xmlhttplocal = new ActiveXObject ("Microsoft.XMLHTTP")}
	catch (E) {
	  xmlhttplocal = false;
	}
  }

  if (!xmlhttplocal && typeof XMLHttpRequest != 'undefined') {
	try {
	  var xmlhttplocal = new XMLHttpRequest ();
	}
	catch (e) {
	  var xmlhttplocal = false;
	}
  }
  return (xmlhttplocal);
}

// Ajax Basic Functions Ends here..

var mnmxmlhttp = Array ();
var xvotesString = Array ();
var mnmPrevColor = Array ();
var responsestring = Array ();
var myxmlhttp = Array ();
var responseString = new String;
var previd = -1;


function loadurl(url,divid){ // url-posturl,content - poststring,id=newdiv,target2=olddiv
 var response;
	if(!xmlhttp){
		xmlhttp = new myXMLHttpRequest ();		
	}
	if (xmlhttp) {
		xmlht = new myXMLHttpRequest ();
		if (xmlht) {
			try{
			xmlht.open ("POST", url, true);
			xmlht.setRequestHeader ('Content-Type','application/x-www-form-urlencoded');
			xmlht.send ("");
			errormatch = new RegExp ("^ERROR:");
			xmlht.onreadystatechange = function () {
				if (xmlht.readyState == 4) {
					response = xmlht.responseText;
					
				if (divid=='ca')
                                        {
                                            if(response!='F')
                                              {
                                                document.registration_form.action="/user/adduser.php";
				        document.registration_form.submit();  
                                              }
                                            else
                                              {
					document.getElementById(divid).innerHTML ="Captcha Not Valid";
                                                                                             
                                              }
				}                                        
					
				else
				{
				 document.getElementById(divid).innerHTML =response;
				}	
                                       
				                                       
				}
			}
			}/*** try***/
			catch(e){
				//alert("Errpr" + e);
			}
		}
           
	}
	return response;  
}

