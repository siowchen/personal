// JavaScript Document
/***************************/
//@Author: Adrian "yEnS" Mato Gondelle &amp;amp;amp; Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!
/***************************/

$(document).ready(function(){
	$(".tab_menu > li").click(function(e){
		switch(e.target.id){
			case "news":
				//change status &amp;amp;amp; style menu
				$("#news").addClass("active");
				$("#links").removeClass("active");
				$("#doc").removeClass("active");
				$("#desc").removeClass("active");
				$("#request_failed").removeClass("active");
				$("#all").removeClass("active");
				//display selected division, hide others
				$("div.news").fadeIn();
				$("div.links").css("display", "none");
				$("div.desc").css("display", "none");
				$("div.doc").css("display", "none");
				$("div.request_failed").css("display", "none");
				$("div.all").css("display", "none");
			break;
			case "links":
				//change status &amp;amp;amp; style menu
				$("#news").removeClass("active");
				$("#links").addClass("active");
				$("#doc").removeClass("active");
				$("#desc").removeClass("active");
				$("#request_failed").removeClass("active");
				$("#all").removeClass("active");

				//display selected division, hide others
				$("div.links").fadeIn();
				$("div.news").css("display", "none");
				$("div.desc").css("display", "none");
				$("div.doc").css("display", "none");
				$("div.request_failed").css("display", "none");
				$("div.all").css("display", "none");
				
			break;
			case "desc":
				//change status &amp;amp;amp; style menu
				$("#news").removeClass("active");
				$("#links").removeClass("active");
				$("#doc").removeClass("active");
				$("#desc").addClass("active");
				$("#request_failed").removeClass("active");
				$("#all").removeClass("active");
				//display selected division, hide others
				$("div.desc").fadeIn();
				$("div.news").css("display", "none");
				$("div.links").css("display", "none");
				$("div.doc").css("display", "none");
				$("div.request_failed").css("display", "none");
				$("div.all").css("display", "none");
		       break;
		       
		       case "doc":
				//change status &amp;amp;amp; style menu
				$("#news").removeClass("active");
				$("#links").removeClass("active");
				$("#doc").addClass("active");
				$("#desc").removeClass("active");
				$("#request_failed").removeClass("active");
				$("#all").removeClass("active");
				//display selected division, hide others
				$("div.doc").fadeIn();
				$("div.news").css("display", "none");
				$("div.links").css("display", "none");
				$("div.desc").css("display", "none");
				$("div.request_failed").css("display", "none");
				$("div.all").css("display", "none");
		       break;
			   
		       case "request_failed":
				//change status &amp;amp;amp; style menu
				$("#news").removeClass("active");
				$("#links").removeClass("active");
				$("#doc").removeClass("active");
				$("#desc").removeClass("active");
				$("#request_failed").addClass("active");
				$("#all").removeClass("active");
				//display selected division, hide others
				$("div.request_failed").fadeIn();				
				$("div.links").css("display", "none");
				$("div.desc").css("display", "none");
				$("div.doc").css("display", "none");
				$("div.news").css("display", "none");				
				$("div.all").css("display", "none");
		       break;
		       case "all":
				//change status &amp;amp;amp; style menu
				$("#news").removeClass("active");
				$("#links").removeClass("active");
				$("#doc").removeClass("active");
				$("#desc").removeClass("active");
				$("#request_failed").removeClass("active");
				$("#all").addClass("active");
				//display selected division, hide others
				$("div.all").fadeIn();				
				$("div.links").css("display", "none");
				$("div.desc").css("display", "none");
				$("div.doc").css("display", "none");
				$("div.news").css("display", "none");
				$("div.request_failed").css("display", "none");				
		       break;

}
		//alert(e.target.id);
		return false;
	});
});
