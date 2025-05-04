<?php  
$include_lang = true;
 
include '../config.php'; 
 
$languages = [
    ['displayName' => $language['jqhzcq'][$lang], 'code' => 'en', 'image' => 'usa_flag.png'],
    ['displayName' => $language['eqwfac'][$lang], 'code' => 'zh', 'image' => 'china_flag.png'],
 
    ['displayName' => $language['vzdftq'][$lang], 'code' => 'tr', 'image' => 'turkey_flag.png'],
    ['displayName' => $language['fqrttq'][$lang], 'code' => 'ar', 'image' => 'arab_flag.png'],
	['displayName' => $language['bftwtj'][$lang], 'code' => 'fa', 'image' => 'iran_flag.png'],
];

?>

<div class="flex flex-col items-center gap-5 p-5 w-full">

<div class="block text-xl"><?php echo $language['jhuuia'][$lang]; ?></div>

<div class="flex flex-wrap gap-2 p-2 w-full">
  <?php foreach ($languages as $item): ?>
    <div onclick="changeLanguage(`<?php echo $item['code']; ?>`);" class="<?php echo $lang == $item['code'] ? 'pointer-events-none opacity-50' : ''; ?> grow shrink basis-1/3 min-w-[calc(33.33333%-0.5rem)] bg-main-1 m-0 p-4 rounded-lg flex items-center gap-2 justify-center">
      <div class="w-5 h-5 lozad rounded-lg !bg-no-repeat !bg-cover" data-background-image="assets/png/<?= $item['image'] ?>"></div>
      <?= $item['displayName'] ?> 
    </div>
  <?php endforeach; ?>
</div>
</div>