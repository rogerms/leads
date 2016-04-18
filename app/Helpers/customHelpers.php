<?php

	if(!function_exists('hello'))
	{
		function hello($name)
		{
			return "hello ".$name;
		}
	}

	if(!function_exists('timeformat2'))
	{
        function timeformat2($time)
        {
        	if(! $time instanceof Datetime)
        	{
        		$time = new Datetime($time);
        	}
            return $time->format('F j, y \a\t h:i a');
        } 

    }

    if(!function_exists('toFormatted'))
	{
        function toFormatted($time)
        {
        	$zero = new DateTime('0000-00-00 00:00:00');
        	$now = new DateTime("now");
            if(! $time instanceof Datetime)
        	{
        		$time = new Datetime($time);
        	}
        	if($time == $zero)
        	{
        		return "Unknown";
        	}
        	if($time->format('d') == $now->format('d'))
        	{
        		return $time->diffForHumans();
        	}
            return $time->format('F j, Y \a\t h:i a');
        } 
    }

    if(!function_exists('formatAppoint'))
    {
        function formatAppoint($time)
        {
            $zero = new DateTime('0000-00-00 00:00:00');
            if(! $time instanceof Datetime)
            {
                $time = new Datetime($time);
            }
            if($time == $zero)
            {
                return '';
            }
            if($time->format('H') == '00')
            {
                return $time->format('M j, Y');
            }
            return $time->format('M j, Y \a\t h:ia');
        }
    }

    if(!function_exists('format_date'))
    {
        function format_date($time)
        {
            $zero = new DateTime('0000-00-00 00:00:00');
            if($time == null)
            {
                return '';
            }
            if(! $time instanceof Datetime)
            {
                if(is_int($time ))
                {
                    $tmp = new DateTime();
                    $tmp->setTimestamp($time);
                    $time = $tmp;
                }
                else{
                    $time = new Datetime($time);
                }
            }
            if($time->format('Y') < 2000)
            {
                return '';
            }
            return $time->format('m/d/Y');
        }
    }

    if(!function_exists('format_time'))
    {
        function format_time($time)
        {
            if($time == null)
            {
                return '';
            }
            if(! $time instanceof Datetime)
            {
                if(is_int($time ))
                {
                    $tmp = new DateTime();
                    $tmp->setTimestamp($time);
                    $time = $tmp;
                }
                else{
                    $time = new Datetime($time);
                }
            }
            if($time->format('Y') < 2000)
            {
                return '';
            }
            return $time->format('h:ia');
        }
    }

    if(!function_exists('format_datetime'))
    {
        function format_datetime($time)
        {
            $zero = new DateTime('0000-00-00 00:00:00');
            if(! $time instanceof Datetime)
            {
                if(is_int($time ))
                {
                    $tmp = new DateTime();
                    $tmp->setTimestamp($time);
                    $time = $tmp;
                }
                else{
                    $time = new Datetime($time);
                }
            }
            if($time == $zero)
            {
                return '';
            }
            return $time->format('m/d/Y h:i A');
        }
    }

    if(!function_exists('get_selected_drawing'))
    {
        function get_selected_drawing($drawings)
        {
            foreach($drawings as $drawing){
                if($drawing->selected) return $drawing->path;
            }
            return "";
        }
    }

    //convert date from database to show in form input type date 2015-01-02
    if(!function_exists('toInputDate'))
	{
        function toInputDate($time)
        {
            if($time == null)
            {
                return '';
            }
        	if(! $time instanceof Datetime)
        	{
        		$time = new Datetime($time);
        	}
            if($time->format('d') == '00')
            {
                return '';
            }
            return $time->format('Y-m-d');
        } 

    }

    //convert date from database to show in form input type date 2015-01-02
    if(!function_exists('toInputTime'))
	{
        function toInputTime($time)
        {
            $zero = new DateTime('0000-00-00 00:00:00');
        	if(! $time instanceof Datetime)
        	{
        		$time = new Datetime($time);
        	}
            if($time->format('Hi') == 0)
            {
                return '';
            }
           return $time->format('H:i');
        } 

    }

    if(!function_exists('isChecked'))
	{
		function isChecked($value)
        {
            if($value == null) return '';
			if($value) 
				return 'checked';
			return '';
		}
    }

    if(!function_exists('isSelected'))
    {
        function isSelected($val1, $val2)
        {
            if($val1 == $val2)
                return 'selected';
            return '';
        }
    }

	if(!function_exists('isActive'))
	{
		function isActive($path, $class = 'active')
		{
            if(isPage($path))
            {
                return $class;
            }
            return '';
		}
	}

    if(!function_exists('isPage'))
    {
        function isPage($path)
        {
            if(is_array($path))
            {
                foreach($path as $p)
                {
                    if(Request::is($p)) return true;
                }
                return false;
            }
            return (Request::is($path)) ? true : false;
        }
    }

    if(!function_exists('getIds'))
    {
        function getIds($jobs)
        {
            $result = '';
            foreach($jobs as $job)
            {
                $result .= $job->id." ";
            }
            return $result;
        }
    }

    if(!function_exists('number_or_blank'))
    {
        function number_or_blank($value)
        {
            if($value <= 0)
            {
                return '';
            }
            return $value;
        }
    }

    if(!function_exists('number_fmt'))
    {
        function number_fmt($number, $showzero=false)
        {
            if($number == null) return ($showzero == false)? '': '0';
            list($whole, $decimal) = explode('.', $number);
            if($decimal == 0) // 4.00 shows as 4, 4.50 = 4.5
            {
                return $whole;
            }
            $decimals = ($decimal % 10 == 0)? 1: 2;
            return number_format($number, $decimals);
        }
    }

    if(!function_exists('job_name')) {
        function job_name($job)
        {
            if ($job['customer_type'] == 'Contractor') {
                return $job['contractor'];
            }
            return $job->lead['customer_name'];
        }
    }

    if(!function_exists('job_number')) {
        function job_number($job)
        {
            if (empty($job->code)) {
                return $job->id;
            }
            return $job->code;
        }
    }

    if(!function_exists('all_tags')) {
        function all_tags($notes)
        {
            $list['tag-all'] = 'all';
            foreach ($notes as $note)
            {
                preg_match('/#(\w+)/', $note, $matches);
                if(isset($matches[1]))
                {
                    $list['tag-'.$matches[1]] = $matches[1];
                }
            }
            return $list;
        }
    }

    if(!function_exists('get_tag')) {
        function get_tag($note)
        {
            preg_match('/#(\w+)/', $note, $matches);
            if(isset($matches[1]))
            {
                return ' tag-'.$matches[1];
            }
            return '';
        }
    }


