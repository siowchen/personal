<?php /*

<style type="text/css">
.paginate {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

a.paginate {
	border: 1px solid #000080;
	padding: 2px 6px 2px 6px;
	text-decoration: none;
	color: #000080;
	font:bold 12px arial;
}


a.paginate:hover {
	text-decoration: underline;
}

a.current {
	border: 1px solid #000080;
	font: bold 12px Arial,Helvetica,sans-serif;
	padding: 2px 6px 2px 6px;
	cursor: default;
	color: #000;
	text-decoration: none;
}

span.inactive {
	border: 1px solid #000080;
	font-family: Arial, Helvetica, sans-serif;
	font:bold 12px arial;
	padding: 2px 6px 2px 6px;
	color: #000080;
	cursor: default;
}

table {
	margin: 8px;
}

th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000;
	padding: 2px 6px;
	border-collapse: separate;
}

td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>


*/ ?>

<?php
// 08-Aug-11 pagination script upgraded
class Paginator{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $return;
	var $default_ipp = 20;
	var $querystring;

	function Paginator()
	{
		$this->current_page = 1;
		$this->mid_range = 5;
		$this->items_per_page = (!empty($ippval)) ? $ippval:$this->default_ipp;
	}

	function paginate($query='')
	{

		$args = explode("?",$_SERVER['REQUEST_URI']);  
		$args = explode("&",$args[1]);
		
		foreach($args as $arg)
		{

			$keyval = explode("=",$arg);
			if($keyval[0]=='page'){ 
				$pageval = $keyval[1]; 
			}
			if($keyval[0]=='ipp'){ 
				$ippval = $keyval[1]; 
			}

		}

		//self url formation for paginations
		$selfurl = '';
		$url = $_SERVER['REQUEST_URI'];
		$selfurl = explode('?',$url);
		$self = $selfurl[0];

		//print_r($selfurl);

		if(!empty($selfurl[1])) { 

			$val = substr($selfurl[1],0,9);
			if($val=='searchkey'){ 
				$self_2 = 1; //echo $selfurl[1];
				$val2 = explode('=',$selfurl[1]); //print_r($val2);
 				$val2 = explode('&page',$val2[1]); //print_r($val2);
				$self=$selfurl[0].'?searchkey='.$val2[0];
			}

		}

		$result = mysql_query($query) or die(mysql_error());
		$this->items_total = mysql_num_rows($result);

		if($ippval == 'All')
		{
			$this->num_pages = ceil($this->items_total/$this->default_ipp);
			$this->items_per_page = $this->default_ipp;
		}
		else
		{
			if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
			$this->num_pages = ceil($this->items_total/$this->items_per_page);
		}
		$this->current_page = (int) $pageval; // must be numeric > 0
		if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;

		if($_GET)
		{
			$args = explode("&",$_SERVER['QUERY_STRING']);
			foreach($args as $arg)
			{
				$keyval = explode("=",$arg);
				if($keyval[0] != "page" And $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
			}
		}

		if($_POST)
		{
			foreach($_POST as $key=>$val)
			{
				if($key != "page" And $key != "ipp") $this->querystring .= "&$key=$val";
			}
		}

		if($this->num_pages > 10)
		{

			if($self_2)
			{

				$this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"paginate\"  href=\"$self&page=$prev_page&ipp=$this->items_per_page$this->querystring\">&laquo; Previous</a> ":"<span class=\"inactive\"  href=\"#\">&laquo; Previous</span> ";

			}
			else
			{

				$this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"paginate\"  href=\"$self?page=$prev_page&ipp=$this->items_per_page$this->querystring\">&laquo; Previous</a> ":"<span class=\"inactive\"  href=\"#\">&laquo; Previous</span> ";

			}

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0)
			{
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages)
			{
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range,$this->end_range);

			for($i=1;$i<=$this->num_pages;$i++)
			{
				if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " <span class=\"dot\">...</span> ";
				// loop through all pages. if first, last, or in range, display
				if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
				{

					if($self_2)
					{
						$this->return .= ($i == $this->current_page And $pageval != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\"  title=\"Go to page $i of $this->num_pages\" href=\"$self&page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";
					}
					else
					{
						$this->return .= ($i == $this->current_page And $pageval != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\"  title=\"Go to page $i of $this->num_pages\" href=\"$self?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";

					}


					//$this->return .= ($i == $this->current_page And $pageval != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"$self?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";


				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " <span class=\"dot\">...</span> ";
			}

				if($self_2)
				{

					$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($pageval != 'All')) ? "<a class=\"paginate\"  href=\"$self&page=$next_page&ipp=$this->items_per_page$this->querystring\">Next &raquo;</a>\n":"<span class=\"inactive\" href=\"#\">&raquo; Next</span>\n";

				}
				else
				{

					$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($pageval != 'All')) ? "<a class=\"paginate\"   href=\"$self?page=$next_page&ipp=$this->items_per_page$this->querystring\">Next &raquo;</a>\n":"<span class=\"inactive\" href=\"#\">&raquo; Next</span>\n";

				}


			//$this->return .= ($pageval == 'All') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\">All</a> \n":"<a class=\"paginate\" style=\"margin-left:10px\" href=\"$_SERVER[REQUEST_URI]?page=1&ipp=All$this->querystring\">All</a> \n";

		}
		else
		{
			for($i=1;$i<=$this->num_pages;$i++)
			{

				if($self_2)
				{

					$this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" href=\"$self&page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";

				}
				else
				{

					$this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\"  padding:5px 5px;\" href=\"$self?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";

				}

			}

			//$this->return .= "<a class=\"paginate\" href=\"$_SERVER[REQUEST_URI]?page=1&ipp=All$this->querystring\">All</a> \n";
		}
		$this->low = ($this->current_page-1) * $this->items_per_page;
		$this->high = ($ippval == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
		$this->limit = ($ippval == 'All') ? "":" LIMIT $this->low,$this->items_per_page";



		if($this->low >= 0)
		{
			$rspaginateTotal = mysql_query($query) or die(mysql_error());		
			$this->rspaginateTotal = mysql_num_rows($rspaginateTotal);
			$queryString = $query.' '.$this->limit;
		}
		else
		{
			$rspaginateTotal = mysql_query($query) or die(mysql_error());		
			$this->rspaginateTotal = mysql_num_rows($rspaginateTotal);		
			$queryString = $query;
		}

		$this->rspaginate = mysql_query($queryString) or die(mysql_error());

	}

	function display_items_per_page()
	{
		$items = '';
		$ipp_array = array(10,25,50,100,'All');
		foreach($ipp_array as $ipp_opt)	$items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
		return "<span class=\"paginate\">Items per page:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[REQUEST_URI]?page=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
	}

	function display_jump_menu()
	{
		for($i=1;$i<=$this->num_pages;$i++)
		{
			$option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
		}
		return "<span class=\"paginate\">Page:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[REQUEST_URI]?page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
	}

	function display_pages()
	{
		return $this->return;
	}
}
