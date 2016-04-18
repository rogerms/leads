<?php
    namespace  app\Helpers;

    use DateTime;

    class Helper{
        
        public static function db_date($datestr)
        {
            if(empty($datestr)) return null;
            $date = strtotime($datestr);
            return date('Y-m-d H:i:s', $date);
        }

        public static function db_datetime($datestr, $timestr)
        {
            if(empty($datestr)) return null;
            $date = strtotime($datestr.' '.$timestr);
            return date('Y-m-d H:i:s', $date);
        }

        public static function show_job_num($job)
        {
            if($job->code) return $job->code." ($job->id)";
            if(Helper::is_before_2016($job->date_sold)) return $job->id;
            return '';
        }

        private static function is_before_2016($time)
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
                return false;
            }
            if($time->format('Y') < 2016)
                return true;
            return false;
        }
    }
