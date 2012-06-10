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
			{code:"&#31616;&#20171;", url:"Index_About_Us_Introduction.html",style:STYLE, size:[33,150]},
			{code:"&#24895;&#26223;", url:"Index_About_Us_Vision.html",style:STYLE, size:[33,150]},
			{code:"&#20256;&#25215;", url:"Index_About_Us_Heritage.html",style:STYLE, size:[33,150]},
			
		
		]
	},
	{itemoff:[0,85]},
	{code:'<img src="images/main/menu/2.jpg" width="160" height="30" />',url:"Index_Why_TriVox.html",
		sub:[
			{itemoff:[32,0]},
			{code:"&#24066;&#22330;&#33829;&#38144; 24-7", url:"Index_TriVox_Marketing_24-7.html",style:STYLE, size:[33,150]},
			{code:"&#25105;&#20204;&#30340;&#21592;&#24037;", url:"Index_TriVox_Our_Staff.html",style:STYLE, size:[33,150]}
	]
		},
			
	{itemoff:[0,160]},
	{code:'<img src="images/main/menu/3.jpg" width="130" height="30" />', url:"Index_P_S_Overview.html",
		sub:[
			{itemoff:[32,0]},
			{code:"&#27010;&#36848;", url:"Index_P_S_Overview.html",style:STYLE, size:[33,180]},
			{code:"&#36130;&#21153;&#23433;&#20840;", url:"Index_P_S_Financial_Sercurity.html",style:STYLE, size:[33,180]},
			{code:"&#23454;&#20307;&#23433;&#20840;", url:"Index_P_S_Physical_Sercurity.html",style:STYLE, size:[33,180]},
			{code:"&#20154;&#36523;&#23433;&#20840;", url:"Index_P_S_Personal_Sercurity.html",style:STYLE, size:[33,180]},
			{code:"&#22521;&#35757;", url:"Index_P_S_Education.html",style:STYLE, size:[33,180]}
	]
		},
		
		{itemoff:[0,130]},
	{code:'<img src="images/main/menu/4.jpg" width="104" height="30" />',url:"Index_Contact_Us.html",
		sub:[
			
	]
		},


		
];
