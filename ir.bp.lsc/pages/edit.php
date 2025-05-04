<?php  
$include_lang = true;
$include_database = true;
 
include '../config.php';

$user = $database->get("user", "*", ["email" => $email]) ?? [];
    
?>

<div class="flex flex-col items-center gap-5 p-5 w-full">
 
 
        <div class="relative flex justify-center items-center">
            <!-- لایه مشکی پشت پروفایل -->
            <div class="absolute border-2 border-gray-950 size-33 rounded-full"></div>

            <div class="absolute size-30 rounded-full bg-black opacity-80"></div>

            <!-- تصویر پروفایل -->
            <div class="lozad size-30 rounded-full !bg-center !bg-no-repeat !bg-[auto_100%]" data-background-image="<?php echo $user['profileUrl']; ?>"></div>

            <!-- دایره درصد باقی‌مانده -->
            <div class="w-full brightness-90 p-5 text-center truncate overflow-hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-2xl font-bold">

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
  <path fill="#ffc107" d="M21.8055 10.0415H21V10H12v4h5.6515c-0.8245 2.3285-3.04 4-5.6515 4c-3.3135 0-6-2.6865-6-6s2.6865-6 6-6c1.5295 0 2.921 0.577 3.9805 1.5195l2.8285-2.8285C17.023 3.0265 14.634 2 12 2C6.4775 2 2 6.4775 2 12s4.4775 10 10 10s10-4.4775 10-10c0-0.6705-0.069-1.325-0.1945-1.9585" />
  <path fill="#ff3d00" d="m3.153 7.3455l3.2855 2.4095C7.3275 7.554 9.4805 6 12 6c1.5295 0 2.921 0.577 3.9805 1.5195l2.8285-2.8285C17.023 3.0265 14.634 2 12 2C8.159 2 4.828 4.1685 3.153 7.3455" />
  <path fill="#4caf50" d="M12 22c2.583 0 4.93-0.9885 6.7045-2.596l-3.095-2.619A5.95 5.95 0 0 1 12 18c-2.601 0-4.8095-1.6585-5.6415-3.973l-3.261 2.5125C4.7525 19.778 8.1135 22 12 22" />
  <path fill="#1976d2" d="M21.8055 10.0415H21V10H12v4h5.6515a6.02 6.02 0 0 1-2.0435 2.7855l.0015-.001l3.095 2.619C18.4855 19.6025 22 17 22 12c0-0.6705-0.069-1.325-0.1945-1.9585" />
</svg>

            </div>
 
	   </div>
		
 <div class="block text-2xl p-3"><?php echo $language['wdbhga'][$lang]; ?></div> 
 
 <div class="block text-jusitfy leading-8"><?php echo $language['qervxb'][$lang]; ?></div>

<div class="flex flex-row gap-3 items-center justify-between w-full overflow-hidden">
  
  
  <div onclick="Android.openURL(`https://myaccount.google.com/personal-info`);" class="text-center w-full p-4 truncate text-base font-bold text-gray-50 bg-main-1 rounded-md">
     <?php echo $language['wdbhga'][$lang]; ?>
  </div>

 
  <div onclick="Android.resetFactory();" class="text-center w-full p-4 truncate text-base font-bold text-gray-50 bg-red-500/10 rounded-md">
   <?php echo $language['hhbhga'][$lang]; ?>
   </div> 
 
</div>

</div>