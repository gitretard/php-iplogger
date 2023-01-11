<?php
   // Set your own timezone
   date_default_timezone_set("Asia/Bangkok");
   // Turn off display warns
   ini_set('display_errors','Off');
   function getip()
   {
      //Idk exactly how to get ip adress
      $ipadress = getenv('HTTP_CLIENT_IP');
      if(empty($ipadress))
      {
         $ipadress = getenv("HTTP_X_FORWARDED_FOR");
      }
      if(empty($ipadress))
      {
         $ipadress = $_SERVER['REMOTE_ADDR'];
      }
      return $ipadress;
   }
   function stuff($ipadress)
   {
      $browseragent = $_SERVER['HTTP_USER_AGENT'];
      $cdate = date('l jS \of F Y h:i:s A');
      $remote_port = $_SERVER['REMOTE_PORT'];
      return "\n |Browser_Agent: {$browseragent} \n -Visittime: {$cdate}\n --Remote port: {$remote_port}";
   }
   function iplocation($ipadress)
   {
      $ip_details = json_decode(file_get_contents("http://ipinfo.io/{$ipadress}/json"));
      return $ip_details;
   }
   $localips = array("127.0.0.1", "::1");
   $ip = getip();
   $location = iplocation($ip);
   $log = fopen("log.txt", "a") or die("cant log");
   if(in_array($ip,$localips))
   {
      fwrite($log, "\n\n###############IP is localhost##############\n\n");
   }
   // ty https://github.com/CybrDev
   fwrite($log, "IP Adress: {$ip}");
   fwrite($log, stuff($ip));
   fwrite($log, "\n\n-----------Location--------------\n\n");
   fwrite($log, "\n\nCity (Inaccurate):" . $location->city . PHP_EOL);
	fwrite($log, "Region:" . $location->region . PHP_EOL);
	fwrite($log, "Country:" . $location->country . PHP_EOL);
	fwrite($log, "Location:" . $location->loc . PHP_EOL);
	fwrite($log, "Isp: " . $location->org . PHP_EOL);
    fwrite($log, "Hostname: " . $location->hostname .PHP_EOL);
    fwrite($log, "Postal_code:" . $location->postal ."\n");
   fclose($log);

?>
