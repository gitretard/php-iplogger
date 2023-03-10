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
   function ipinfo($ipadress)
   {
      $ipinfo = json_decode(file_get_contents("https://ipinfo.io/{$ipadress}/json"));
      return $ipinfo;
   }
   function ipapi($ipadress)
  {
   $ipapi = json_decode(file_get_contents("https://ip-api.com/json{$ipadress}"));
   return $ipapi;
  }
   $localips = array("127.0.0.1", "::1");
   $ip = getip();
   $ipinfov = ipinfo($ip);
   $ipapiv = ipapi($ip);
   $log = fopen("log.txt", "a") or die("cant log");
   if(in_array($ip,$localips))
   {
      fwrite($log, "\n\n###############IP is localhost##############\n\n");
   }
   // ty https://github.com/CybrDev
   fwrite($log, "IP Adress: {$ip}");
   fwrite($log, stuff($ip));
   fwrite($log, "\n\n-----------Location--------------\n\n");
   fwrite($log,"Continent: {$ipapiv->continent} \n");
   fwrite($log,"Country: {$ipapiv->country}\n");
   fwrite($log,"Region/Province(?): {$ipinfov->region}\n");
   fwrite($log,"Postal Code: {$ipinfov->postal}\n");
   fwrite($log,"Location(la,lon): {$ipinfov->loc}\n");
   fwrite($log,"Visitor timezone: {$ipapt->timezone}\n");
   fwrite($log,"ISP: {$ipapiv->isp}\n");
   fwrite($log,"ISP Corp/Org: {$ipapiv->org}\n");
   fclose($log);
?>
