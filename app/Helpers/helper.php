<?php
    namespace  app\Helpers;

    use DateTime;
    use DB;

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

        public static function flash_message($text, $passed = false)
        {
            $message['text'] = $text;
            $message['class'] = 'alert-success';
            $message['title'] = 'Info!';

            if($passed == false)
            {
                $message['class'] = 'alert-danger';
                $message['title'] = 'Error!';
            }
            \Session::flash('message', $message);
        }
        public static function google_client()
        {
            $google = new \Google_Client();
            $google->setAuthConfigFile(storage_path('app/client_secrets.json'));
            $google->setAccessType('offline');
            $google->setRedirectUri(url('gapi'));
            $google->addScope('https://www.googleapis.com/auth/calendar');
            return $google;
        }

        public static function get_refresh_token()
        {
            return DB::table('tokens')->where('name', 'google')->value('token');
        }

        public static function put_refresh_token($token)
        {
            $result = DB::table('tokens')->where('name', 'google')->value('name');
            if($result == 'google')
            {
            //  update
                return DB::table('tokens')->where('name', 'google')->update(['token' => $token]);
            }

            return DB::table('tokens')->insert(['name' => 'google', 'token' => $token]);
        }

        public static function del_refresh_token()
        {
            return DB::table('tokens')->where('name', 'google')->update(['token' => null]);
        }
    }
