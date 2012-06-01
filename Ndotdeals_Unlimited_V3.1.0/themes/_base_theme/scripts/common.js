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
/*
  Function Name: checkusername.
  Purpose      : Checking the user name avilable in db or not.
*/

function checkusername(val)
{  

//alert('test');
  if(trim(val).length!=0)
  loadurl(this.hostname+"/themes/_base_theme/pages/adduser.php?type="+val,"unameavilable");
}

/*
  Function Name: checkemail.
  Purpose      : Checking the user email avilable in db or not.
*/

function checkeamil(str)
{
	if(trim(str).length!=0)
	{

			var at="@"
			var dot="."
			var lat=str.indexOf(at)
			var lstr=str.length
			var ldot=str.indexOf(dot)

	         // check if '@' is at the first position or at last position or absent in given email 
			if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
			   //alert("Invalid E-mail ID")
			   return false
			}

	        // check if '.' is at the first position or at last position or absent in given email
			if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
			    //alert("Invalid E-mail ID")
			    return false
			}

	        // check if '@' is used more than one times in given email
			if (str.indexOf(at,(lat+1))!=-1){
			    //alert("Invalid E-mail ID")
			    return false
			 }
	   

	         // check for the position of '.'
			 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
			    //alert("Invalid E-mail ID")
			    return false
			 }

	         // check if '.' is present after two characters from location of '@'
			 if (str.indexOf(dot,(lat+2))==-1){
			    //alert("Invalid E-mail ID")
			    return false
			 }
		

		// check for blank spaces in given email
			 if (str.indexOf(" ")!=-1){
			    //alert("Invalid E-mail ID")
			    return false
			 }
			 
	loadurl(this.hostname+"/themes/_base_theme/pages/adduser.php?mail="+str,"emailavilable");
	}
}

function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
}
