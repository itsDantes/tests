<?php  
$include_lang = true;
$include_database = true;
 
include '../config.php';

$user = $database->get("user", "*", ["email" => $email]) ?? [];
    
?>

<div class="flex flex-col items-center gap-5 p-5 w-full">
 
 
<svg class="size-24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
  <path fill="#ffc107" d="M21.8055 10.0415H21V10H12v4h5.6515c-0.8245 2.3285-3.04 4-5.6515 4c-3.3135 0-6-2.6865-6-6s2.6865-6 6-6c1.5295 0 2.921 0.577 3.9805 1.5195l2.8285-2.8285C17.023 3.0265 14.634 2 12 2C6.4775 2 2 6.4775 2 12s4.4775 10 10 10s10-4.4775 10-10c0-0.6705-0.069-1.325-0.1945-1.9585"></path>
  <path fill="#ff3d00" d="m3.153 7.3455l3.2855 2.4095C7.3275 7.554 9.4805 6 12 6c1.5295 0 2.921 0.577 3.9805 1.5195l2.8285-2.8285C17.023 3.0265 14.634 2 12 2C8.159 2 4.828 4.1685 3.153 7.3455"></path>
  <path fill="#4caf50" d="M12 22c2.583 0 4.93-0.9885 6.7045-2.596l-3.095-2.619A5.95 5.95 0 0 1 12 18c-2.601 0-4.8095-1.6585-5.6415-3.973l-3.261 2.5125C4.7525 19.778 8.1135 22 12 22"></path>
  <path fill="#1976d2" d="M21.8055 10.0415H21V10H12v4h5.6515a6.02 6.02 0 0 1-2.0435 2.7855l.0015-.001l3.095 2.619C18.4855 19.6025 22 17 22 12c0-0.6705-0.069-1.325-0.1945-1.9585"></path>
</svg>

 <div class="block text-2xl p-3"><?php echo $language['jhbhga'][$lang]; ?></div> 
 
 <div class="block text-jusitfy leading-8"><?php echo $language['jhuhay'][$lang]; ?></div>

 <div class="flex flex-row gap-3 items-center justify-between w-full">
 
   <div onclick="Android.signIn()" class="text-center w-full p-4 truncate text-base font-bold text-gray-50 bg-main-1 rounded-md">
     <?php echo $language['ddsweq'][$lang]; ?>
   </div> 

   
  <div onclick="privacy();" class="text-center m-auto w-1/5 p-4.5 truncate text-center m-auto bg-main-1 rounded-md">
 
<svg class="w-full size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
	<g fill="none">
		<path stroke="#fff" stroke-linecap="round" stroke-width="1.5" d="M12 17v-6" />
		<circle cx="1" cy="1" r="1" fill="#fff" transform="matrix(1 0 0 -1 11 9)" />
		<path stroke="#fff" stroke-linecap="round" stroke-width="1.5" d="M22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2s7.071 0 8.535 1.464c.974.974 1.3 2.343 1.41 4.536" />
	</g>
</svg>

   </div> 
   
 </div>

</div>