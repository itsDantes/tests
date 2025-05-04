<?php  
$include_lang = true;
$include_database = true;
include './config.php'; 
?> 
<!DOCTYPE html>
<html class="dark" dir="<?php echo in_array($lang, ["fa", "ar"]) ? "rtl": "ltr"; ?>" lang="<?php echo $lang; ?>" data-loaded="true" data-googleAPI="<?php echo $googleAPI; ?>">
  <head> 
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   
  </head>
<body class="h-screen flex flex-col bg-main-0 font-changa text-white">

    <header class="sticky top-0 w-full z-9">

    <div class="flex flex-row justify-between items-center bg-main-1 top-bar">
     
	 <div class="text-2xl font-extrabold bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent tracking-wide"><?php echo $language['caxrqx'][$lang]; ?></div>


<svg onclick="selectLanguage()" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
	<path fill="#fff" d="m12.87 15.07l-2.54-2.51l.03-.03A17.5 17.5 0 0 0 14.07 6H17V4h-7V2H8v2H1v2h11.17C11.5 7.92 10.44 9.75 9 11.35C8.07 10.32 7.3 9.19 6.69 8h-2c.73 1.63 1.73 3.17 2.98 4.56l-5.09 5.02L4 19l5-5l3.11 3.11zM18.5 10h-2L12 22h2l1.12-3h4.75L21 22h2zm-2.62 7l1.62-4.33L19.12 17z" />
</svg>

	     </div>
  

  </header>


    <main id="contents" class="flex-1 overflow-y-auto dotted-bg">
 
  
    </main>
	
<footer class="mt-auto relative z-9">
<div id="bottom-bar" class="flex flex-row justify-between items-center bg-main-1 bottom-bar">
	
	    <div class="w-full">
        <div class="nb-item" data-url="pages/chats.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                <path fill="#fff" d="M17 3a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H3a1 1 0 0 1-1-1V8a5 5 0 0 1 5-5zm0 2H7a3 3 0 0 0-3 3v11h13a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3m-8 5a1 1 0 0 1 1 1v2a1 1 0 1 1-2 0v-2a1 1 0 0 1 1-1m6 0a1 1 0 0 1 .993.883L16 11v2a1 1 0 0 1-1.993.117L14 13v-2a1 1 0 0 1 1-1"/>
            </svg>
		 
            <div class="name"><?php echo $language['hwbczv'][$lang]; ?></div>
        </div>
		</div>
        
        <div class="w-full">
        <div class="nb-item active" data-url="pages/app.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                <path fill="#fff" d="M19.49 5.57a6 6 0 0 1-1.893 8.962c-.649.351-1.43.135-1.952-.386l-5.79-5.791c-.522-.522-.738-1.303-.388-1.952A6 6 0 0 1 18.43 4.51l2.29-2.29a.75.75 0 1 1 1.061 1.06zm-2.017 7.263a4.5 4.5 0 1 0-6.306-6.306c-.266.349-.186.833.125 1.143l5.038 5.038c.31.31.794.391 1.143.125M3.28 21.78l2.29-2.29a6 6 0 0 0 8.962-1.893c.351-.649.135-1.43-.387-1.952l-5.79-5.79c-.522-.522-1.303-.738-1.952-.388A6 6 0 0 0 4.51 18.43l-2.29 2.29a.75.75 0 1 0 1.06 1.061m4.39-10.488l5.038 5.038c.31.31.39.794.125 1.143a4.5 4.5 0 1 1-6.306-6.306c.349-.266.833-.186 1.143.125"/>
            </svg>
		 
            <div class="name"><?php echo $language['gqmxrf'][$lang]; ?></div>
        </div>
       </div>
	   
        <div class="w-full">
        <div class="nb-item"  data-url="pages/profile.php">
<svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
	<path fill="#fff" d="M12 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8M6 8a6 6 0 1 1 12 0A6 6 0 0 1 6 8m2 10a3 3 0 0 0-3 3a1 1 0 1 1-2 0a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5a1 1 0 1 1-2 0a3 3 0 0 0-3-3z" />
</svg>
 
            <div class="name"><?php echo $language['bxbuqt'][$lang]; ?></div>
        </div>
		</div>
	 
		
    </div>
</footer>

	
  </body>
   
   
   <script>
    const language = <?php echo json_encode($language); ?>;
   </script>
   
   <script src="./assets/js/jquery.js"></script>
   <script src="./assets/js/tailwindcss.js"></script>

   <script src="./assets/js/bp.js?v=<?php echo time(); ?>"></script>
   
<script src="https://unpkg.com/lightweight-charts@4.1.0/dist/lightweight-charts.standalone.production.js"></script>

<!-- Tippy.js CSS -->
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

<!-- Tippy.js JS -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
 
 
   <script src="./assets/js/bottomsheet.js?v=<?php echo time(); ?>"></script>
  
   <script src="./assets/js/lozad.js"></script>
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>" />
	
</html>
