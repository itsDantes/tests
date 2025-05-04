<?php
$include_lang = true;
$include_database = true;
$include_function = true;
include '../config.php'; 
 

try {
    // دریافت اطلاعات کاربر
    $user = $database->get("user", "*", ["email" => $email]) ?? [];
    
    // دریافت اطلاعات ترافیک و ttl
    $stats = $database->sum("statistic", "traffic", ["email" => $email]);
    $ttl = $database->sum("statistic", "ttl", ["email" => $email]);

    // مقداردهی پیش‌فرض در صورت نبودن اطلاعات معتبر
    $stats = is_numeric($stats) && $stats > 0 ? $stats : 0;
    $ttl = is_numeric($ttl) && $ttl > 0 ? $ttl : 0;

    // محاسبه زمان باقی‌مانده از فیلد 'paid' (در صورتی که وجود داشته باشد)
    $paid = $user['paid'] ?? null;
    $remaining_time = 0;
    $remaining_percent = 0;

    if ($paid) {
        $current_time = time();
        if ($paid > $current_time) {
            $remaining_time = $paid - $current_time;
            $total_time = 24 * 3600;  // 1 روز به ثانیه
            $remaining_percent = ($remaining_time / $total_time) * 100;
        }
    }

    // خروجی‌های نمایشی
    $displayStats = $stats > 0 ? formatBytes($stats, "en") : '0 0 0';
    $displayTtl = $ttl > 0 ? readableSeconds($ttl, "en") : '0 0 0';

    // فقط در صورتی که هردو مقدار داشته باشن گرادینت رو حساب کنیم
    if ($stats > 0 && $ttl > 0) {
        $ttlInHours = $ttl / 3600;
        $ttlVirtualMB = $ttlInHours * 500;
        $ttlVirtualBytes = $ttlVirtualMB * 1024 * 1024;

        $total = $stats + $ttlVirtualBytes;
        $percentStats = $total > 0 ? ($stats / $total) * 100 : 0;

        $split = round($percentStats, 2);
        $transitionWidth = 10;
        $fadeStart = max(0, $split - $transitionWidth);
        $fadeEnd = min(100, $split + $transitionWidth);
    } else {
        // حالت امن برای وقتی که یکی از دو مقدار صفره
        $fadeStart = 0;
        $fadeEnd = 0;
    }

} catch (Exception $e) {
    // خطای دیتابیس یا غیره → مقدار پیش‌فرض
    $user = [];
    $displayStats = '0 0 0';
    $displayTtl = '0 0 0';
    $fadeStart = 0;
    $fadeEnd = 0;
}

 
$records = $database->select("statistic", ["traffic", "download", "upload", "modified"], [
    "email" => $email,
    "ORDER" => ["modified" => "ASC"],
    "LIMIT" => 100
]);


$data = [];

foreach ($records as $row) {
    $timestamp = strtotime($row['modified']);
    
    // اطمینان از معتبر بودن داده‌ها
    if (!$timestamp || !is_numeric($row['traffic']) || !is_numeric($row['download']) || !is_numeric($row['upload'])) {
        continue; // رد کردن رکوردهای خراب
    }

    $data[] = [
        'time' => $row['modified'],
        'traffic' => $row['traffic'],
        'download' => $row['download'],
		'upload' => $row['upload'],
    ];
}

// اگر داده‌ها خالی باشند، چارت نمایش داده نمی‌شود
if (empty($data)) {
    $showChart = false;
} else {
    $showChart = true;
}

?>

<!-- کانتینر اصلی صفحه -->
 
    <div class="flex flex-col items-center justify-center gap-5 text-white p-5 my-10">
      

       <div class="p-1 bg-main-2 rounded-full shadow-[inset_0_2px_8px_var(--color-main-0)]">

        <div class="relative flex justify-center items-center">
   
            <div class="absolute size-30 rounded-full bg-black opacity-80"></div>

            <!-- تصویر پروفایل -->
            <div class="lozad size-30 rounded-full !bg-center !bg-no-repeat !bg-[auto_100%]" data-background-image="<?php echo $user['profileUrl']; ?>"></div>

            <!-- دایره درصد باقی‌مانده -->
            <div id="userProfileTTL" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-2xl font-bold">
                <?php echo round($remaining_percent); ?>
            </div>

            <!-- دایره وضعیت -->
            <div class="absolute top-5 left-0 w-4 h-4 bg-green-500 border-3 border-gray-100 rounded-full shadow-sm shadow-indigo-500"></div>
        </div>

     </div>
 
		
        <div class="text-3xl font-extrabold bg-gradient-to-r from-indigo-500 to-blue-500 bg-clip-text text-transparent tracking-wide">
            <?php echo $user['givenName']; ?>
        </div>
        <div class="text-indigo-2++00 font-mono tracking-wider"><?php echo $user['email']; ?></div>

        <!-- آمار به‌صورت کارت گیمینگ -->
        <div class="w-full rounded-lg p-0.5 bg-gradient-to-r from-rose-500 to-indigo-500">
            <div class="rounded-lg p-5 bg-main-0 flex flex-col justify-between gap-10">
                <div class="flex flex-row justify-between">
                    <div class="flex justify-end items-center gap-3">
                        
	 

                        <div class="p-1.5 bg-main-1 rounded-md">
  
<svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
	<path class="fill-indigo-500" d="M8 20h8v-3q0-1.65-1.175-2.825T12 13t-2.825 1.175T8 17zm-4 2v-2h2v-3q0-1.525.713-2.863T8.7 12q-1.275-.8-1.987-2.137T6 7V4H4V2h16v2h-2v3q0 1.525-.712 2.863T15.3 12q1.275.8 1.988 2.138T18 17v3h2v2z" />
</svg>
                        </div>
						
                        <div class="text-lg font-bold tracking-wider dLTR"><?php echo $displayTtl; ?></div>
                    </div>
                    <div class="flex justify-end items-center gap-3">
                        <div class="text-lg font-bold tracking-wider dLTR"><?php echo $displayStats; ?></div>

                        <div class="p-1.5 bg-main-1 rounded-md">
<svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
	<path class="fill-rose-500"  d="M13 3.87v.02c0 .67.45 1.23 1.08 1.43C16.93 6.21 19 8.86 19 12c0 .52-.06 1.01-.17 1.49c-.14.64.12 1.3.69 1.64l.01.01c.86.5 1.98.05 2.21-.91c.17-.72.26-1.47.26-2.23c0-4.5-2.98-8.32-7.08-9.57c-.95-.29-1.92.44-1.92 1.44m-2.06 15.05c-2.99-.43-5.42-2.86-5.86-5.84a6.996 6.996 0 0 1 4.83-7.76c.64-.19 1.09-.76 1.09-1.43v-.02c0-1-.97-1.73-1.93-1.44a10.02 10.02 0 0 0-6.98 10.96c.59 4.38 4.13 7.92 8.51 8.51c3.14.42 6.04-.61 8.13-2.53c.74-.68.61-1.89-.26-2.39c-.58-.34-1.3-.23-1.8.22c-1.47 1.34-3.51 2.05-5.73 1.72" />
</svg>
                        </div>
						
                    </div>
                </div>

                <div class="h-1 @animate-hue bg-purple-900 rounded-full overflow-hidden"
                     style="background-image: linear-gradient(
                       to right,
                       #ff2056 0%,
                       #ff2056 <?php echo $fadeStart; ?>%,
                       #615fff <?php echo $fadeEnd; ?>%,
                       #615fff 100%
                     );">
                </div>

                <!-- چارت در صورت وجود داده‌ها -->
				<div id="chart" class="hidden relative z-1 w-full h-[100px]"></div>

            </div>
        </div>


 


 


<div class="flex flex-row gap-3 items-center justify-between w-full overflow-hidden">

  <div onclick="about();"  class="p-1.5 bg-main-1 rounded-md">
<svg class="size-8"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
	<circle cx="12" cy="7.25" r="1.25" fill="#fff" />
	<path fill="#fff" d="M11 10h2v8h-2z" />
</svg>
  </div>

  <div onclick="viewPV(`<?php echo $ownerEmail; ?>`);"  class="p-1.5 bg-main-1 rounded-md me-auto">
<svg class="size-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
	<path fill="#fff" d="M18.72 14.76c.35-.85.54-1.76.54-2.76c0-.72-.11-1.41-.3-2.05c-.65.15-1.33.23-2.04.23A9.07 9.07 0 0 1 9.5 6.34a9.2 9.2 0 0 1-4.73 4.88c-.04.25-.04.52-.04.78A7.27 7.27 0 0 0 12 19.27c1.05 0 2.06-.23 2.97-.64c.57 1.09.83 1.63.81 1.63c-1.64.55-2.91.82-3.78.82c-2.42 0-4.73-.95-6.43-2.66a9 9 0 0 1-2.24-3.69H2v-4.55h1.09a9.09 9.09 0 0 1 15.33-4.6a9 9 0 0 1 2.47 4.6H22v4.55h-.06L18.38 18l-5.3-.6v-1.67h4.83zm-9.45-2.99c.3 0 .59.12.8.34a1.136 1.136 0 0 1 0 1.6c-.21.21-.5.33-.8.33c-.63 0-1.14-.5-1.14-1.13s.51-1.14 1.14-1.14m5.45 0c.63 0 1.13.51 1.13 1.14s-.5 1.13-1.13 1.13s-1.14-.5-1.14-1.13a1.14 1.14 0 0 1 1.14-1.14" />
</svg>
  </div>
  
  <div onclick="buy();"  class="p-1.5 bg-main-1 rounded-md">
<svg class="size-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
	<path fill="#fff" fill-opacity="0.3" d="M17 5.33C17 4.6 16.4 4 15.67 4H14V2h-4v2H8.33C7.6 4 7 4.6 7 5.33V11h10z" />
	<path fill="#fff" d="M7 11v9.67C7 21.4 7.6 22 8.33 22h7.33c.74 0 1.34-.6 1.34-1.33V11z" />
</svg>
  </div>


  <div onclick="edit();"  class="p-1.5 bg-main-1 rounded-md">
<svg class="size-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
  <path fill="#ffc107" d="M21.8055 10.0415H21V10H12v4h5.6515c-0.8245 2.3285-3.04 4-5.6515 4c-3.3135 0-6-2.6865-6-6s2.6865-6 6-6c1.5295 0 2.921 0.577 3.9805 1.5195l2.8285-2.8285C17.023 3.0265 14.634 2 12 2C6.4775 2 2 6.4775 2 12s4.4775 10 10 10s10-4.4775 10-10c0-0.6705-0.069-1.325-0.1945-1.9585" />
  <path fill="#ff3d00" d="m3.153 7.3455l3.2855 2.4095C7.3275 7.554 9.4805 6 12 6c1.5295 0 2.921 0.577 3.9805 1.5195l2.8285-2.8285C17.023 3.0265 14.634 2 12 2C8.159 2 4.828 4.1685 3.153 7.3455" />
  <path fill="#4caf50" d="M12 22c2.583 0 4.93-0.9885 6.7045-2.596l-3.095-2.619A5.95 5.95 0 0 1 12 18c-2.601 0-4.8095-1.6585-5.6415-3.973l-3.261 2.5125C4.7525 19.778 8.1135 22 12 22" />
  <path fill="#1976d2" d="M21.8055 10.0415H21V10H12v4h5.6515a6.02 6.02 0 0 1-2.0435 2.7855l.0015-.001l3.095 2.619C18.4855 19.6025 22 17 22 12c0-0.6705-0.069-1.325-0.1945-1.9585" />
</svg>

  </div>
   
  
 

</div>

 


    </div>
	
 

<script>
 
function smoothData(data, windowSize = 3) {
    const smoothed = [];
    for (let i = 0; i < data.length; i++) {
        let start = Math.max(0, i - Math.floor(windowSize / 2));
        let end = Math.min(data.length, i + Math.ceil(windowSize / 2));
        let subset = data.slice(start, end);
        let avg = subset.reduce((sum, val) => sum + val.value, 0) / subset.length;
        smoothed.push({ time: data[i].time, value: avg });
    }
    return smoothed;
}

function createChart() {
    // اگر چارت قبلی وجود دارد، آن را حذف کن
    if (chart) {
        chart.remove();  // حذف چارت قبلی
        chart = null;  // متغیر چارت را به null اختصاص بده
    }
      
    const chartContainer = $('#chart'); // گرفتن المنت با jQuery
	
	chartContainer.removeClass(`hidden`);
    chart = LightweightCharts.createChart(chartContainer[0], {
        width: chartContainer.innerWidth(),
        height: 100,
        layout: {
            background: { color: '#ffffff00' },
            textColor: '#fff',
            fontSize: 12
        },
        grid: {
            vertLines: { color: '#ffffff00' },
            horzLines: { color: '#ffffff00' }
        },
        timeScale: {
            timeVisible: false,
            secondsVisible: false,
            visible: false,
            fixLeftEdge: true,
            fixRightEdge: true,
            minBarSpacing: 0.05,
            barSpacing: 5,
            rightOffset: 0,
            leftOffset: 0,
        },
        crosshair: {
            mode: 0,
        },
        rightPriceScale: {
            visible: false,
            borderVisible: false,
        },
        leftPriceScale: {
            visible: false,
            borderVisible: false,
        }
    });

    // آماده‌سازی دیتا
    const trafficData = [];
    const download = [];
    const upload = [];
	
    <?php foreach ($data as $row): ?>
    trafficData.push({
        time: <?php echo $row['time']; ?>,
        value: <?php echo $row['traffic']; ?>
    });
    <?php endforeach; ?>

    <?php foreach ($data as $row): ?>
    download.push({
        time: <?php echo $row['time']; ?>,
        value: <?php echo $row['download']; ?>
    });
    <?php endforeach; ?>

    <?php foreach ($data as $row): ?>
    upload.push({
        time: <?php echo $row['time']; ?>,
        value: <?php echo $row['upload']; ?>
    });
    <?php endforeach; ?>
    // اضافه کردن سری‌ها
    const smoothedTraffic = smoothData(trafficData, 3);
    chart.addLineSeries({
		visible:true,
        priceLineVisible: false,
        color: '#53eafd',
        lineWidth: 3
    }).setData(smoothedTraffic);

    const smoothedDownload = smoothData(download, 3);
    chart.addLineSeries({
		visible:false,
        priceLineVisible: false,
        color: '#615fff',
        lineWidth: 1
    }).setData(smoothedDownload);


    const smoothedUpload = smoothData(upload, 3);
    chart.addLineSeries({
		visible:false,
        priceLineVisible: false,
        color: '#ff2056',
        lineWidth: 1
    }).setData(smoothedUpload);
	
    const firstTimestamp = trafficData[0].time;
    const lastTimestamp = trafficData[trafficData.length - 1].time;
    chart.timeScale().setVisibleRange({
        from: firstTimestamp,
        to: lastTimestamp
    });
}

// هنگام فراخوانی این تابع، چارت قبلی حذف شده و چارت جدید ساخته خواهد شد
 
setTimeout(function() {
 
 <?php if ($showChart): ?>
   createChart();
 <?php endif; ?>
 
const showHideTippy = (tippyInstance, selector, delay = 5000) => {
  if ($(selector).length) {
    tippyInstance.show();
    setTimeout(() => {
      if ($(selector).length) tippyInstance.hide();
    }, delay);
  }
};

// تنظیم tippy برای userProfileTTL
const userProfileTTL = tippy('#userProfileTTL', {
  content: `<?php echo remainingTime($user['paid'], $lang); ?>`,
  placement: 'bottom',
  animation: 'scale',
  theme: 'customTheme',
})[0];

 

// اجرای tippyها
showHideTippy(userProfileTTL, '#userProfileTTL');
 
 
}, 0);


 
</script>

