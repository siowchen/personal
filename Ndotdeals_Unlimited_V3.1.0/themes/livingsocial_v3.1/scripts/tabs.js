// JavaScript reviewsument
/***************************/
//@Author: Adrian "yEnS" Mato Gondelle &amp;amp;amp; Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!
/***************************/

$(document).ready(function(){
	$(".tab_mid > a").click(function(e){ //alert(e.target.id);
		switch(e.target.id){
			case "dealdetails":
				//change status &amp;amp;amp; style menu
				$("#lidealdetails").addClass("tab_active");
				$("#lifineprints").removeClass("tab_active");
				$("#lireviews").removeClass("tab_active");
				$("#licontactdetails").removeClass("tab_active");
				//display selected division, hide others
				$("div.dealdetails").fadeIn();
				
				$("div.fineprints").css("display", "none");
				$("div.contactdetails").css("display", "none");
				$("div.reviews").css("display", "none");
				
				
			break;
			case "fineprints":
				//change status &amp;amp;amp; style menu
				$("#lidealdetails").removeClass("tab_active");
				$("#lifineprints").addClass("tab_active");
				$("#lireviews").removeClass("tab_active");
				$("#licontactdetails").removeClass("tab_active");
				//display selected division, hide others
				$("div.fineprints").fadeIn();
				$("div.dealdetails").css("display", "none");
				$("div.contactdetails").css("display", "none");
				$("div.reviews").css("display", "none");
				
				
			break;
			case "contactdetails":
				//change status &amp;amp;amp; style menu
				$("#lidealdetails").removeClass("tab_active");
				$("#lifineprints").removeClass("tab_active");
				$("#lireviews").removeClass("tab_active");
				$("#licontactdetails").addClass("tab_active");
				//display selected division, hide others
				$("div.contactdetails").fadeIn();
				$("div.dealdetails").css("display", "none");
				$("div.fineprints").css("display", "none");
				$("div.reviews").css("display", "none");
				
		       break;
		       case "reviews":
				//change status &amp;amp;amp; style menu
				$("#lidealdetails").removeClass("tab_active");
				$("#lifineprints").removeClass("tab_active");
				$("#lireviews").addClass("tab_active");
				$("#licontactdetails").removeClass("tab_active");
				//display selected division, hide others
				$("div.reviews").fadeIn();
				$("div.dealdetails").css("display", "none");
				$("div.fineprints").css("display", "none");
				$("div.contactdetails").css("display", "none");
				
		       break;
		}
		//alert(e.target.id);
		return false;
	});
});
