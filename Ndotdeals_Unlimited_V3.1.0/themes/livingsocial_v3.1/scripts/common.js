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

Count down until any date script-

By JavaScript Kit (www.javascriptkit.com)

Over 200+ free scripts here!

Modified by Robert M. Kuhnhenn, D.O.

on 5/30/2006 to count down to a specific date AND time,

and on 1/10/2010 to include time zone offset.

*/


/*  Change the items below to create your countdown target date and announcement once the target date and time are reached.  */



//—>    DO NOT CHANGE THE CODE BELOW!    <—




function countdown(yr,m,d,hr,min,sec,id_d,url,gettimezone){
theyear=yr;themonth=m;theday=d;thehour=hr;theminute=min;id_de=id_d;thesec=sec;
var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
//alert('correct');
var tz=+5.5//gettimezone;
var minute=min;
var hour=hr;
var day=d;
var month=m;
var year=yr;
var second=sec;
var today=new Date();

var todayy=today.getYear();

if (todayy < 1000) { todayy+=1900; }

var todaym=today.getMonth();
//alert(todaym);
var todayd=today.getDate();

var todayh=today.getHours();

var todaymin=today.getMinutes();

var today_timezone=today.getTimezoneOffset();

var todaysec=today.getSeconds();

var todaystring1=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec;

var todaystring=Date.parse(todaystring1)+(tz*1000*60*60);
//alert(todaystring);
var futurestring1=(montharray[m-1]+" "+d+", "+yr+" "+hr+":"+min+":"+sec);
//alert(futurestring1);
//alert(montharray[m-1]);
var futurestring=Date.parse(futurestring1)-(today_timezone*(1000*60));
//alert(futurestring);
var dd=futurestring-todaystring;

var dday=Math.floor(dd/(60*60*1000*24)*1);

var dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1);

dday = (dday*24)+dhour; //converted days to hour

var dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);

var dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
	
	if(dday<=0&&dmin<=0&&dsec<=0)
	{
		document.getElementById(id_de+'tot_hrs2').innerHTML='00';
		document.getElementById(id_de+'tot_mins2').innerHTML='00';
		document.getElementById(id_d+'tot_secs2').innerHTML='00';
		setTimeout("redirect_url_fn('"+url+"')",2000);
	
	}
	else 
	{
		if(dday<10)
		 {
		  dday='0'+dday;
		 }
		 if(dmin<10)
		 {
		  dmin='0'+dmin;
		 }
		 if(dsec<10)
		 {
		  dsec='0'+dsec;
		 }
		 //alert(dhour+'/'+dmin+'/'+dsec);
		document.getElementById(id_de+'tot_hrs2').innerHTML=dday;
		
		document.getElementById(id_de+'tot_mins2').innerHTML=dmin;
		
		document.getElementById(id_d+'tot_secs2').innerHTML=dsec;
		
		setTimeout("countdown('"+year+"','"+month+"','"+day+"','"+hour+"','"+minute+"','"+second+"','"+id_de+"','"+url+"','"+tz+"')",1000);
		//setTimeout("cou("+id_d+")",1000);
		//setTimeout("redirect_url_fn('"+url+"')",2000);
                  if(dday<=0) // dday zero allowed here
		     {
			document.getElementById(id_de+'tot_hrs2').innerHTML=''; 
		        document.getElementById('hrs').innerHTML='';               		
		     }      
		
	}
	
}
	//redirect the URL
	function redirect_url_fn(url)
	{
		window.location=url;
	}

