<?php  
$include_lang = true;
include '../config.php';

?>

<div class="flex flex-col items-center gap-5 p-5 w-full">
 
 
 
 <div class="block text-2xl p-3"><?php echo $language['ovloia'][$lang]; ?></div> 
 
 <div class="block text-jusitfy leading-8"><?php echo $language['jnjnaz'][$lang]; ?></div>

<div class="flex flex-row gap-3 items-center justify-between w-full overflow-hidden">
  
  
  <div onclick="Android.askPermission(`POST_NOTIFICATIONS`)" class="post-notify text-center w-full p-4 truncate text-base font-bold text-gray-50 bg-main-1 rounded-md">
     <?php echo $language['njuhza'][$lang]; ?>
  </div>

 
  <div onclick="Android.askPermission(`BIND_VPN_SERVICE`)" class="vpn-service text-center w-full p-4 truncate text-base font-bold text-gray-50 bg-main-1 rounded-md">
   <?php echo $language['eqwscz'][$lang]; ?>
   </div>  
 
</div>

</div>