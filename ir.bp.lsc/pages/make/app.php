<?php
$include_lang = true;
$include_database = true;
$include_function = true;
include '../../config.php';

$ids_string = $_POST['ids'] ?? '';
$ids_array = array_filter(explode(',', $ids_string));
$type = $_POST['type'] ?? null;

$where = [];
if (!empty($ids_array)) {
    $where["id"] = $ids_array;
}
if (!empty($type)) {
    $where["type"] = $type;
}

$trusted = $database->select("user", "trusted", ["email"=> $email , "trusted[>]" => strtotime('now') ]) ? ['true', 'false'] : 'false';


$array = ($type == "webview")
    ? $database->select("googlePlay", [
        "id",
        "title", 
        "icon"
    ], ["type"=> $type , "trusted"=>$trusted])
    : $database->select("googlePlay", [
        "id",
        "title", 
        "icon"
    ], $where);



$body = '<div class="flex flex-wrap !gap-2 p-2 ">';

$statisticIds = [];

// آماده‌سازی داده‌های آماری در صورت وجود ایمیل
if (isset($email)) {
    $statisticList = $database->select("statistic", ["id", "traffic", "ttl"], [ 
        "ORDER" => ["modified" => "DESC"],  
        "email" => $email
    ]);

    $statisticData = [];
    foreach ($statisticList as $stat) {
        $statisticData[$stat['id']] = $stat;
    }
} else {
    $statisticData = [];
}

// به جای استفاده از usort، از روش جدا سازی استفاده می‌کنیم
$withStat = [];
$withoutStat = [];
foreach ($array as $app) {
    if (isset($statisticData[$app['id']])) {
        $withStat[] = $app;
    } else {
        $withoutStat[] = $app;
    }
}
// ترکیب آرایه‌ها: آیتم‌های دارای آمار در ابتدای لیست می‌آیند
$array = array_merge($withStat, $withoutStat);

foreach ($array as $v) {
    $traffic = '0 0 0';
    $dataused = '0 0 0';
    $colored1 = "text-white";
    $colored2 = "text-white opacity-25";
    $used = '';
    
    if (!empty($statisticData[$v['id']])) {
        $stat = $statisticData[$v['id']];
        $traffic = formatBytes($stat['traffic']);
        $dataused = readableSeconds($stat['ttl']);
        $colored1 = "from-[#9362eb] to-[#8be9fd]";
        $colored2 = "text-[#53eafd]";
        $used = '
		<div class="relative">
		<div class="absolute top-0 right-2">
		<div class="text-lg text-green-500">
                    <div class="animate-pulse">●</div>  
                 </div>
				 </div> </div>
				 ';
    }
    
    $body .= '
    <div onclick="showServers({thiz:this, appID:`'.$v['id'].'`})" class="dLTR grow shrink basis-1/3 min-w-[calc(33.33333%-0.5rem)] bg-main-1 m-0 p-1 rounded-lg">
		'.$used.'
		
        <div class="relative flex flex-col items-center gap-5 p-1">
 
            <div class="p-2 bg-main-0 rounded-lg shadow-[inset_0_2px_8px_var(--color-main-0)]">
                <div class="lozad w-12 h-12 rounded-lg !bg-center !bg-no-repeat !bg-[auto_115%]" data-background-image="'.$v['icon'].'"></div>
            </div>
            <div class="flex items-baseline justify-center truncate w-full">
                <div class="text-lg font-semibold bg-gradient-to-r '.$colored1.' bg-clip-text text-transparent truncate px-3">
                     '.$v['title'].'
                </div>
            </div>
            <div class="flex flex-row w-full">
                <div class="flex justify-between w-full">
                    <div class="flex flex-col items-start gap-2.5">
                        <div class="p-1.5 bg-main-0 rounded-md">
                            <svg class="w-5 h-5 '.$colored2.'" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-300">'.$dataused.'</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2.5">
                        <div>
                            <p class="text-xs font-medium text-gray-300">'.$traffic.'</p>
                        </div>
                        <div class="p-1.5 bg-main-0 rounded-md">
                            <svg class="w-5 h-5 '.$colored2.'" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}


 if (empty($array)){
	$body .= '
	<div class="w-full flex flex-col gap-5 items-center justify-center h-[calc(100vh-12rem)]">
	
   <svg class="size-24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
	  <path fill="#fff" d="M2 5h2v2H2zm4 4H4V7h2zm2 0H6v2H4v2H2v6h20v-6h-2v-2h-2V9h2V7h2V5h-2v2h-2v2h-2V7H8zm0 0h8v2h2v2h2v4H4v-4h2v-2h2zm2 4H8v2h2zm4 0h2v2h-2z" />
   </svg> 

	'.$language['hbgtaq'][$lang].'
	
	</div>';
 }
 
$body .= '</div>';

echo $body;
?>
