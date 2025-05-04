<?php  
$include_lang = true;
$include_database = true;
$include_function = true;
include '../config.php'; 
 
?>
 
 
  <div id="tabs-servers" class="w-full">
    <div class="relative">
      <div class="flex text-center justify-center items-center" data-tab-container>
    <div data-tab data-url="pages/make/server.php?type=dns" class="active bg-main-0 py-2 my-2 w-full text-base text-gray-600 transition-all duration-300"><?php echo "DNS"; ?></div>
    <div data-tab data-url="pages/make/server.php?type=xray" class="bg-main-0 py-2 my-2 w-full text-base text-gray-600 transition-all duration-300"><?php echo "XRAY"; ?></div>
    <div data-tab data-url="pages/make/server.php?type=warp" class="bg-main-0 py-2 my-2 w-full text-base text-gray-600 transition-all duration-300"><?php echo "WARP"; ?></div>
      </div>
  
      <div class="absolute bottom-0 h-[3px] bg-indigo-500 transition-all duration-300" data-indicator></div>
    </div>
 
    <div data-content class="p-1"></div>
  </div>


 