BLANK_IMAGE = 'images/b.gif';

var NOSTYLE = {
	border:0,
	shadow:0,
	color:{
		border:"",
		shadow:"",
		bgON:"",
		bgOVER:""
	},
	css:{
		ON:"",
		OVER:""
	}
};


var STYLE = {
	border:1,			// item's border width, pixels; zero means "none"
	shadow:0,			// item's shadow size, pixels; zero means "none"
	color:{
		border:"#4c4c4c",	// color of the item border, if any
		shadow:"#DBD8D1",	// color of the item shadow, if any
		bgON:"#000000",		// background color for the items
		bgOVER:"#222222"	// background color for the item which is under mouse right now
	},
	css:{
		ON:"clsCMOn",		// CSS class for items
		OVER:"clsCMOver"	// CSS class  for item which is under mouse
	}
};

var MENU_ITEMS = [
	{pos:["relative",199], itemoff:[0,0], leveloff:[32,0],style:NOSTYLE, size:[33,150]},
	{code:'<img src="images/main/menu/1.jpg" width="85" height="30" />', url:"Index_About_Us_Introduction.html",
		sub:[
			{itemoff:[32,0]},
			{code:"Introduction", url:"Index_About_Us_Introduction.html",style:STYLE, size:[33,150]},
			{code:"Vision", url:"Index_About_Us_Vision.html",style:STYLE, size:[33,150]},
			{code:"Heritage", url:"Index_About_Us_Heritage.html",style:STYLE, size:[33,150]},
			
		
		]
	},
	{itemoff:[0,85]},
	{code:'<img src="images/main/menu/2.jpg" width="123" height="30" />',url:"Index_Why_TriVox.html",
		sub:[
			{itemoff:[32,0]},
			{code:"Marketing 24-7", url:"Index_TriVox_Marketing_24-7.html",style:STYLE, size:[33,150]},
			{code:"Our Staff", url:"Index_TriVox_Our_Staff.html",style:STYLE, size:[33,150]}
	]
		},
			
	{itemoff:[0,123]},
	{code:'<img src="images/main/menu/3.jpg" width="205" height="30" />', url:"Index_P_S_Overview.html",
		sub:[
			{itemoff:[32,0]},
			{code:"Overview", url:"Index_P_S_Overview.html",style:STYLE, size:[33,180]},
			{code:"Financial Security", url:"Index_P_S_Financial_Sercurity.html",style:STYLE, size:[33,180]},
			{code:"Physical Security", url:"Index_P_S_Physical_Sercurity.html",style:STYLE, size:[33,180]},
			{code:"Personal Security", url:"Index_P_S_Personal_Sercurity.html",style:STYLE, size:[33,180]},
			{code:"Education", url:"Index_P_S_Education.html",style:STYLE, size:[33,180]}
	]
		},
		
		{itemoff:[0,205]},
	{code:'<img src="images/main/menu/4.jpg" width="104" height="30" />',url:"Index_Contact_Us.html",
		sub:[
			
	]
		},


		
];
