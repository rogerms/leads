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
            return $time->format('m/d/Y');
        }
    }


    //convert date from database to show in form input type date 2015-01-02
    if(!function_exists('toInputDate'))
	{
        function toInputDate($time)
        {
        	if(! $time instanceof Datetime)
        	{
        		$time = new Datetime($time);
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


