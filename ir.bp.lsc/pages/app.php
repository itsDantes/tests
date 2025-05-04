<?php  
$include_lang = true;
$include_database = true;
$include_function = true;
include '../config.php'; 

 

cleanUpDatabase();

?>
 
 

 
  <div id="tabs-apps" class="w-full">
    <div class="relative">
      <div class="flex text-center justify-center items-center" data-tab-container>
    <div data-tab data-url="pages/make/app.php?type=game" class="active bg-main-0 py-2 my-2 w-full text-base text-gray-600 transition-all duration-300"><?php echo $language['nbhuza'][$lang]; ?></div>
    <div data-tab data-url="pages/make/app.php?type=app" class="bg-main-0 py-2 my-2 w-full text-base text-gray-600 transition-all duration-300"><?php echo $language['nbhzyq'][$lang]; ?></div>
    <div data-tab data-url="pages/make/app.php?type=webview" class="bg-main-0 py-2 my-2 w-full text-base text-gray-600 transition-all duration-300"><?php echo $language['naxgza'][$lang]; ?></div>
      </div>
  
      <div class="absolute bottom-0 h-[3px] bg-indigo-500 transition-all duration-300" data-indicator></div>
    </div>
 
    <div data-content class="p-1"></div>
  </div>


 