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

if(!xmlhttp && typeof XMLHttpRequest != 'undefined')
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

/*
  Function Name: loadurl.
  Purpose      : Load the inner html details of particular element using the ajax.
*/

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

				if(divid=='ca')
		                {
					if(response!='F')
					  {
						  document.getElementById('ca').innerHTML = '';
						  return;
					  }
					  else
					  {
							document.getElementById(divid).innerHTML ="Captcha Not Valid";
					  }
				}                                        
				else if(divid=='deal_permalink')
				{
					document.getElementById(divid).value=trim(response);
				}
				else
				{
				 	document.getElementById(divid).innerHTML=response;
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
  Function Name: loadcountry.
  Purpose      : load the city based on the Country.
*/

function loadcountry(val,type)
{
	if(document.getElementById('dynamiclocation')!=null)
	{
		document.getElementById('dynamiclocation').innerHTML=''; 
	}

	if(document.getElementById('shopnamelist')!=null)
	{
		document.getElementById('shopnamelist').innerHTML=''; 
	}

	if(document.getElementById('citytag')!=null)
	{
		document.getElementById('citytag').innerHTML=''; 
	}

	if(document.getElementById('edit_cm_citytag')!=null)
	{
		document.getElementById('edit_cm_citytag').innerHTML=''; 
	}
	 	
  if(val!='')
  {
	if(document.getElementById('citytag')!=null)
	{
		document.getElementById('citytag').innerHTML=''; 
	} 

     if(type=="cm")
       loadurl(this.hostname+"/site-admin/pages/loadstate.php?countrycode="+val,"dynamiclocation");
     else
	loadurl(this.hostname+"/site-admin/pages/loadstate.php?countrycode="+val+"&type=n","dynamiclocation");
 }
 
}


function ecloadcountry(val,type)
{

	if(document.getElementById('dynamiclocation')!=null)
	{
		document.getElementById('dynamiclocation').innerHTML=''; 
	}

	if(document.getElementById('shopnamelist')!=null)
	{
		document.getElementById('shopnamelist').innerHTML=''; 
	}

	if(document.getElementById('citytag')!=null)
	{
		document.getElementById('citytag').innerHTML=''; 
	}
	 	
  if(val!='')
  {
	if(document.getElementById('citytag')!=null)
	{
		document.getElementById('citytag').innerHTML=''; 
	} 

     if(type=="cm")
       loadurl(this.hostname+"/site-admin/pages/loadstate.php?eccountrycode="+val,"dynamiclocation");
      else
	loadurl(this.hostname+"/site-admin/pages/loadstate.php?eccountrycode="+val+"&type=n","dynamiclocation");
 }
 
}


/*
  Function Name: loadsubtype.
  Purpose      : load the coupon Subtype Based on the Coupon Type.
*/

function load_searchsubtype(val)
{

  if(val!='')
  { 
       document.getElementById('subcatlist').innerHTML='';
       loadurl(this.hostname+"/user/loadstate.php?search_subtype="+val,"subcatlist");
     
  }else
  {

	document.getElementById('subcatlist').innerHTML='';
	document.getElementById('subcatlist').innerHTML='<select name="subcatId" style="width:200px;"><option value="" > - Choose - </option></select>';
  
  }

}

/*
  Function Name: loadshop.
  Purpose      : load the Shop id based on the Shop Details.
*/

function loadshop(val)
{
  if(val!=''){
	loadurl(this.hostname+"/user/loadstate.php?shopcode="+val,"shopdetails");
	}
}

function load_cooponshopdetails(val)
{

	if(document.getElementById('shopnamelist')!=null)
	{
		document.getElementById('shopnamelist').innerHTML=''; 
	}

	loadurl(this.hostname+"/site-admin/pages/loadstate.php?eccitycode="+val,"shopnamelist");

}

function loadshopdetails(val)
{
document.getElementById('lshopdetails').innerHTML='';

	if(document.getElementById('dynamiclocation')!=null)
	{
		document.getElementById('dynamiclocation').innerHTML=''; 
	}
	 
	if(val!=''){
		loadurl(this.hostname+"/site-admin/pages/loadstate.php?shopcodedetails="+val,"lshopdetails");
	}
}

/*
  Function Name: loadcityshop.
  Purpose      : load the City id based on the Shop Details.
*/

function loadcityshop(val)
{

	if(document.getElementById('cityshopdetails')!=null)
	{
		document.getElementById('cityshopdetails').innerHTML=''; 
	}

	if(val!='')
	{ 
		if(document.getElementById('shoptag')!=null)
		{
			document.getElementById('shoptag').innerHTML=''; 
		}

	loadurl(this.hostname+"/site-admin/pages/loadstate.php?citycode="+val,"cityshopdetails");
	}

}

function ecloadcityshop(val)
{

	if(document.getElementById('cityshopdetails')!=null)
	{
		document.getElementById('cityshopdetails').innerHTML=''; 
	}

	if(val!='')
	{ 
		if(document.getElementById('shoptag')!=null)
		{
			document.getElementById('shoptag').innerHTML=''; 
		}

	loadurl(this.hostname+"/site-admin/pages/loadstate.php?eccitycode="+val,"cityshopdetails");
	}

}

/*
  Function Name: checkusername.
  Purpose      : Checking the user name avilable in db or not.
*/

function checkusername(val)
{  
  if(trim(val).length!=0)
    loadurl(this.hostname+"/site-admin/pages/adduser.php?type="+val,"unameavilable");
  
  // username empty
  if(trim(val).length==0)
    	val ='empty';
  	loadurl(this.hostname+"/site-admin/pages/adduser.php?type="+val,"unameavilable");
  
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
			 
	loadurl(this.hostname+"/site-admin/pages/adduser.php?mail="+str,"emailavilable");
	}
	
	// Email empty
	if(trim(str).length==0)
	{
	str ='empty';
	}
	loadurl(this.hostname+"/site-admin/pages/adduser.php?mail="+str,"emailavilable");
}

function closecouponvalidate()
{ 

	var val=document.getElementById('vid').value;
	if(document.getElementById('vid').value!="")
	loadurl(this.hostname+"/site-admin/pages/buycoupon.php?type=c&couponcode="+val,"offererror");
	else
	document.getElementById('offererror').innerHTML="Enter Coupon Validity Id";
}

function getPid(val)
{
	document.getElementById('pid').value=val;
	document.getElementById('offer').style.display='block';
}

function buycoupon(val)
{
	loadurl(this.hostname+"/process/buycoupon.php?couponcode="+val,"purchasestatus");
}

function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
}

function shoploadcountry(val)
{

	if(document.getElementById('dynamiclocation')!=null)
	{
		document.getElementById('dynamiclocation').innerHTML=''; 
	} 
	 
	if(val!='')
	{ 
		if(document.getElementById('citytag')!=null)
		{
			document.getElementById('citytag').innerHTML=''; 
		} 

		loadurl(this.hostname+"/site-admin/pages/loadstate.php?shopcountrycode="+val,"dynamiclocation");
	} 
}

function loadcooponcountry(val,type)
{
 
	if(document.getElementById('cdynamiclocation')!=null)
	{
		document.getElementById('cdynamiclocation').innerHTML=''; 
	}  

	if(document.getElementById('eccitytag')!=null)
	{
		document.getElementById('eccitytag').innerHTML=''; 
	}

	if(document.getElementById('shopnamelist')!=null)
	{
		document.getElementById('shopnamelist').innerHTML=''; 
	}
	 	   
	if(val!='')
	{
		if(document.getElementById('eccitytag')!=null)
		{
			document.getElementById('eccitytag').innerHTML=''; 
		}  

		if(type=="cm")
		loadurl(this.hostname+"/site-admin/pages/loadstate.php?loadcooponcountry="+val,"cdynamiclocation");
		else
		loadurl(this.hostname+"/site-admin/pages/loadstate.php?loadcooponcountry="+val+"&type=n","cdynamiclocation");

	}

}

function loadcooponcityshop(val)
{
	loadurl(this.hostname+"/site-admin/pages/loadstate.php?cooponcitycode="+val,"cityshopdetails");
}

function eusrloadcountry(val,type)
{
	if(val!='')
	{ 
		if(document.getElementById('eusrcitytag')!=null)
		{
			document.getElementById('eusrcitytag').innerHTML=''; 
		} 
		if(document.getElementById('shoptag')!=null)
		{
			document.getElementById('shoptag').innerHTML=''; 
		} 

			if(type=="cm")
				loadurl(this.hostname+"/site-admin/pages/loadstate.php?eusrcountrycode="+val,"eusrdynamiclocation");
	}
}


//load permalink
function generate_permalink(val,field_id)
{
		loadurl(this.hostname+"/site-admin/pages/loadstate.php?permalink="+val,field_id);
}
