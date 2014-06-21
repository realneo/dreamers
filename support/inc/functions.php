<?php
function protect($string) {
	$protection = htmlspecialchars(trim($string), ENT_QUOTES);
	return $protection;
}

function idinfo($id,$value) {
	$sql = mysql_query("SELECT * FROM ls_operators WHERE usern='$id'");
	$row = mysql_fetch_array($sql);
	return $row[$value];
}

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function check_urls($text){
            $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,6}(\/\S*)?/";
            preg_match_all($reg_exUrl, $text, $matches);
            $usedPatterns = array();
            foreach($matches[0] as $pattern){
                if(!array_key_exists($pattern, $usedPatterns)){
                    $usedPatterns[$pattern]=true;
                    $text = str_replace($pattern, "<a href='$pattern' target='_blank'>$pattern</a> ", $text);   
                }
            }
            return $text;            
}

function success($text) {
	return '<div class="alert alert-success">'.$text.'</div>';
}

function info($text) {
	return '<div class="alert alert-info">'.$text.'</div>';
}

function error($text) {
	return '<div class="alert alert-danger">'.$text.'</div>';
}

function isValidURL($url) {
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

function isValidUsername($str) {
    return preg_match('/^[a-zA-Z0-9-_]+$/',$str);
}

function isValidEmail($str) {
	return filter_var($str, FILTER_VALIDATE_EMAIL);
}

function pagination($query,$ver,$per_page = 10,$page = 1, $url = '?') { 
		if($idd) { $ver = $ver."/".$idd; }
    	$query = "SELECT COUNT(*) as `num` FROM {$query}";
    	$row = mysql_fetch_array(mysql_query($query));
    	$total = $row['num'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='active'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'>...</li>";
    				$pagination.= "<li><a href='$ver&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='$ver&page=1'>1</a></li>";
    				$pagination.= "<li><a href='$murl$ver/2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>...</a></li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$murl$ver/$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='$ver&page=1'>1</a></li>";
    				$pagination.= "<li><a href='$ver&page=2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='$ver&page=$next'>Next</a></li>";
                $pagination.= "<li><a href='$ver&page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='disabled'>Next</a></li>";
                $pagination.= "<li><a class='disabled'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
} 

function timeago($datefrom,$dateto=-1) {
	if($datefrom<=0) { return "A long time ago"; }
	if($dateto==-1) { $dateto = time(); }

	// Calculate the difference in seconds betweeen
	// the two timestamps

	$difference = $dateto - $datefrom;

	// If difference is less than 60 seconds,
	// seconds is a good interval of choice

	if($difference < 60)
	{
	$interval = "s";
	}

	// If difference is between 60 seconds and
	// 60 minutes, minutes is a good interval
	elseif($difference >= 60 && $difference<60*60)
	{
	$interval = "n";
	}

	// If difference is between 1 hour and 24 hours
	// hours is a good interval
	elseif($difference >= 60*60 && $difference<60*60*24)
	{
	$interval = "h";
	}

	// If difference is between 1 day and 7 days
	// days is a good interval
	elseif($difference >= 60*60*24 && $difference<60*60*24*7)
	{
	$interval = "d";
	}

	// If difference is between 1 week and 30 days
	// weeks is a good interval
	elseif($difference >= 60*60*24*7 && $difference <
	60*60*24*30)
	{
	$interval = "ww";
	}

	// If difference is between 30 days and 365 days
	// months is a good interval, again, the same thing
	// applies, if the 29th February happens to exist
	// between your 2 dates, the function will return
	// the 'incorrect' value for a day
	elseif($difference >= 60*60*24*30 && $difference <
	60*60*24*365)
	{
	$interval = "m";
	}

	// If difference is greater than or equal to 365
	// days, return year. This will be incorrect if
	// for example, you call the function on the 28th April
	// 2008 passing in 29th April 2007. It will return
	// 1 year ago when in actual fact (yawn!) not quite
	// a year has gone by
	elseif($difference >= 60*60*24*365)
	{
	$interval = "y";
	}

	// Based on the interval, determine the
	// number of units between the two dates
	// From this point on, you would be hard
	// pushed telling the difference between
	// this function and DateDiff. If the $datediff
	// returned is 1, be sure to return the singular
	// of the unit, e.g. 'day' rather 'days'

    switch($interval)
    {
        case "m":
            $months_difference = floor($difference / 60 / 60 / 24 /
            29);
            while (mktime(date("H", $datefrom), date("i", $datefrom),
            date("s", $datefrom), date("n", $datefrom)+($months_difference),
            date("j", $dateto), date("Y", $datefrom)) < $dateto)
            {
                $months_difference++;
            }
            $datediff = $months_difference;

            // We need this in here because it is possible
            // to have an 'm' interval and a months
            // difference of 12 because we are using 29 days
            // in a month

            if($datediff==12)
            {
                $datediff--;
            }

            $res = ($datediff==1) ? "$datediff month ago" : "$datediff
months ago";
            break;

        case "y":
            $datediff = floor($difference / 60 / 60 / 24 / 365);
            $res = ($datediff==1) ? "$datediff year ago" : "$datediff
years ago";
            break;

        case "d":
            $datediff = floor($difference / 60 / 60 / 24);
            $res = ($datediff==1) ? "$datediff day ago" : "$datediff
days ago";
            break;

        case "ww":
            $datediff = floor($difference / 60 / 60 / 24 / 7);
            $res = ($datediff==1) ? "$datediff week ago" : "$datediff
weeks ago";
            break;

        case "h":
            $datediff = floor($difference / 60 / 60);
            $res = ($datediff==1) ? "$datediff hour ago" : "$datediff
hours ago";
            break;

        case "n":
            $datediff = floor($difference / 60);
            $res = ($datediff==1) ? "$datediff minute ago" :
"$datediff minutes ago";
            break;

        case "s":
            $datediff = $difference;
            $res = ($datediff==1) ? "$datediff second ago" :
"$datediff seconds ago";
            break;
    }
    return $res;
}

function getCurrentURL() {
    $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $currentURL .= $_SERVER["SERVER_NAME"];
 
    if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
    {
        $currentURL .= ":".$_SERVER["SERVER_PORT"];
    } 
 
        $currentURL .= $_SERVER["REQUEST_URI"];
    $explode = explode("install.php",$currentURL);
	return $explode[0];
}
?>