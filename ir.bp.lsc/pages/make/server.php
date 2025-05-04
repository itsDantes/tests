<?php   
$include_lang = true;
include '../../config.php'; 
 
// لیست کامل سرورها
$srvList = [ 
    "dns" => [
        "game" => [
            "title" => $language['cxcxqe'][$lang],
			"description" => $language['cxczzw'][$lang],
            "servers" => [
                "1" => [
                    "id" => "electrotm",
                    "name" => "LSC #1",
                    "icon" => "electrotm.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => false,
                    "ipv4" => "78.157.42.100,78.157.42.101",
                    "ipv6" => "",
                    "doh" => "" 
                ],
                "2" => [
                    "id" => "radar",
                    "name" => "LSC #2",
                    "icon" => "radar.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => false,
                    "ipv4" => "10.202.10.10,10.202.10.11",
                    "ipv6" => "",
                    "doh" => ""
                ],
                "3" => [
                    "id" => "shecan",
                    "name" => "LSC #3",
                    "icon" => "shecan.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => false,
                    "ipv4" => "178.22.122.100,185.51.200.2",
                    "ipv6" => "",
                    "doh" => ""
                ], 
            ],
        ],
        "public" => [
            "title" =>  $language['zczdwr'][$lang],
			"description" => $language['aczcwr'][$lang],
            "servers" => [
                "1" => [
                    "id" => "google",
                    "name" => "Google",
                    "icon" => "google.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "8.8.8.8,8.8.4.4",
                    "ipv6" => "2001:4860:4860::8888,2001:4860:4860::8844",
                    "doh" => "https://dns.google/dns-query" 
                ],
                "2" => [
                    "id" => "cloudflare",
                    "name" => "CloudFlare",
                    "icon" => "cloudflare.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "1.1.1.1,1.0.0.1",
                    "ipv6" => "2606:4700:4700::1111,2606:4700:4700::1001",
                    "doh" => "https://cloudflare-dns.com/dns-query"
                ],
                "3" => [
                    "id" => "opendns",
                    "name" => "OpenDNS",
                    "icon" => "opendns.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "208.67.222.222,208.67.220.220",
                    "ipv6" => "2620:119:35::35,2620:119:53::53",
                    "doh" => "https://doh.opendns.com/dns-query"
                ],
                "4" => [
                    "id" => "quad9",
                    "name" => "Quad9",
                    "icon" => "quad9.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "9.9.9.9,149.112.112.112",
                    "ipv6" => "2620:fe::fe,2620:fe::9",
                    "doh" => "https://dns.quad9.net/dns-query"
                ],
                "5" => [
                    "id" => "adguard",
                    "name" => "Adguard",
                    "icon" => "adguard.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "94.140.14.14,94.140.15.15",
                    "ipv6" => "2a10:50c0::ad1:ff,2a10:50c0::ad2:ff",
                    "doh" => "https://dns.adguard.com/dns-query"
                ],
                "6" => [
                    "id" => "vodafonegermany",
                    "name" => "Vodafone DE",
                    "icon" => "vodafonegermany.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "139.7.30.125,139.7.30.126",
                    "ipv6" => "",
                    "doh" => ""
                ],
                "7" => [
                    "id" => "cleanbrowsing",
                    "name" => "Clean Browsing",
                    "icon" => "cleanbrowsing.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "185.228.168.9,185.228.169.9",
                    "ipv6" => "2a0d:2a00:1::2,2a0d:2a00:2::2",
                    "doh" => "https://doh.cleanbrowsing.org/doh/family-filter/"
                ],
                "8" => [
                    "id" => "comodo",
                    "name" => "Comodo",
                    "icon" => "comodo.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "8.26.56.26,8.20.247.20",
                    "ipv6" => "",
                    "doh" => ""
                ],
                "9" => [
                    "id" => "controld",
                    "name" => "controlD",
                    "icon" => "controld.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "76.76.2.11,76.76.10.11",
                    "ipv6" => "2606:1a40::11,2606:1a40:1::11",
                    "doh" => "https://freedns.controld.com/p0"
                ],
                "10" => [
                    "id" => "dnswatch",
                    "name" => "DNS.Watch",
                    "icon" => "dnswatch.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "84.200.69.80,84.200.70.40",
                    "ipv6" => "2001:1608:10:25::1c04:b12f,2001:1608:10:25::9249:d69b",
                    "doh" => ""
                ],
                "11" => [
                    "id" => "dynx",
                    "name" => "Dynx",
                    "icon" => "dynx.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "195.26.26.23,195.26.26.23",
                    "ipv6" => "2a00:c98:2050:a04d:1::400,2a00:c98:2050:a04d:1::400",
                    "doh" => "https://dns.dynx.pro/dns-query"
                ],
                "12" => [
                    "id" => "gcore",
                    "name" => "GCore",
                    "icon" => "gcore.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "92.223.123.1,92.223.123.2",
                    "ipv6" => "2a03:90c0:56::1,2a03:90c0:57::1",
                    "doh" => "https://dns.gcorelabs.com/dns-query"
                ],
                "13" => [
                    "id" => "level3dns",
                    "name" => "level3DNS",
                    "icon" => "level3dns.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "209.244.0.3,209.244.0.4",
                    "ipv6" => "",
                    "doh" => ""
                ],
                "14" => [
                    "id" => "neustar",
                    "name" => "Neustar",
                    "icon" => "neustar.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "156.154.70.1,156.154.71.1",
                    "ipv6" => "2610:a1:1018::1,2610:a1:1019::1",
                    "doh" => "https://doh.freeblahdns.com/dns-query"
                ],
                "15" => [
                    "id" => "yandex",
                    "name" => "Yandex",
                    "icon" => "yandex.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => true,
                    "ipv4" => "77.88.8.7,77.88.8.3",
                    "ipv6" => "2a02:6b8::feed:0ff,2a02:6b8:0:1::feed:0ff",
                    "doh" => "https://dns.yandex.com/dns-query"
                ],
            ]
        ],
    ],

    "xray" => [
        "public" => [
            "title" => $language['jnjhza'][$lang],
			"description" => $language['njnjkz'][$lang],
            "servers" => [
                "1" => [
                    "id" => "huma",
                    "name" => "Huma",
                    "icon" => "huma.png",
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => false,
                    "ipv4" => "",
                    "ipv6" => "",
                    "doh" => ""
                ],
            ]
        ],
        "paid" => [
            "title" => $language['njhzba'][$lang],
			"description" => $language['jnnazv'][$lang],
            "servers" => [
                "1" => [
                    "id" => "gopatshah",
                    "name" => "GopatShah",
                    "icon" => "gopatshah.png",
                    
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => false,
                    "ipv4" => "",
                    "ipv6" => "",
                    "doh" => ""
                ],
                "2" => [
                    "id" => "shir",
                    "name" => "Shir",
                    "icon" => "shir.png",
                    
                    "description" => "",
                    "acceptConnect" => true,
                    "showAddress" => false,
                    "ipv4" => "",
                    "ipv6" => "",
                    "doh" => ""
                ]
            ]
        ]
    ],

    "warp" => [
        "public" => [
            "title" => $language['jnjhza'][$lang],
			"description" => $language['njnjkz'][$lang],
            "servers" => [
                "1" => [
                    "id" => "shirdal",
                    "name" => "ShirDAL",
                    "icon" => "shirdal.png",
                    
                    "description" => "Based ON CloudFlare WARP",
                    "acceptConnect" => true,
                    "showAddress" => false,
                    "ipv4" => "",
                    "ipv6" => "",
                    "doh" => ""
                ]
            ]
        ],
        "paid" => [
            "title" => $language['njhzba'][$lang],
			"description" => $language['jnnazv'][$lang],
            "servers" => [
                "1" => [
                    "id" => "wingedsun",
                    "name" => "wingedSun",
                    "icon" => "wingedsun.png",
                    
                    "description" => "Based ON CloudFlare WARP",
                    "acceptConnect" => true,
                    "showAddress" => false,
                    "ipv4" => "",
                    "ipv6" => "",
                    "doh" => ""
                ],
                "2" => [
                    "id" => "shahbaz",
                    "name" => "ShahBaz",
                    "icon" => "shahbaz.png",
                    
                    "description" => "Based ON CloudFlare WARP",
                    "acceptConnect" => true,
                    "showAddress" => false,
                    "ipv4" => "",
                    "ipv6" => "",
                    "doh" => ""
                ]
            ]
        ]
    ]
];
 
$type = $_POST['type'] ?? null;

 
$sections = $srvList[$type];
 

echo '<div class="flex flex-col items-center gap-2 p-0 w-full bg-main-0 max-h-screen overflow-auto gap-3">';

foreach ($sections as $key => $section) {
    $title = $section['title'] ?? $key;
    $servers = $section['servers'] ?? [];
	$description = $section['description'] ?? '';
 
    if (empty($servers)) continue;

    // Title bar
    echo '<div class="flex items-center justify-center w-full px-4 mt-3">';
    echo '  <div class="flex-grow border-t border-gray-900"></div>';
    echo '  <div class="mx-4 text-gray-400 tracking-widest">' . ($title) . '</div>';
    echo '  <div class="flex-grow border-t border-gray-900"></div>';
    echo '</div>';
	
    echo '<div class="flex items-center justify-start w-full px-4">';
    echo '  <div class="text-gray-700 tracking-wide text-xs">' . ($description) . '</div>';
    echo '</div>';
 
    // Servers grid
    echo '<div class="flex flex-wrap gap-2 p-2 w-full">';
    foreach ($servers as $srv) {
        $id    = $srv['id'];
        $name  = $srv['name'];
        $icon  = './assets/png/' . $srv['icon'];
        $desc  = $srv['description'] ?? '';
		
		$isDNS = $type == "dns";
 
 
		$ipv4 = explode(',', $srv['ipv4'])[0];
		$ipv6 = explode(',', $srv['ipv6'])[0];
		$doh = $srv['doh'];
		
		$defaultIP = $isDNS ? $ipv4 : "";
		
        echo '<div data-ip="'.$defaultIP.'" data-ipv4="'.$ipv4.'" data-ipv6="'.$ipv6.'" data-doh="'.$doh.'" onclick="connectTo(\'' . ($id) . '\');" '
           . 'class="watch-item relative size-40 grow p-3 shrink basis-1/3 min-w-[calc(33.33333%-0.5rem)] '
           . 'bg-main-1 rounded-lg flex flex-col items-center gap-2 justify-evenly relative">';

        
		if ($isDNS){
			if (!$ipv6 && !$doh){
		       
		    }else{
				echo '<div class="refresh absolute z-1 left-0 top-0 rounded-lg m-1 p-1 border-2 border-gray-950 text-xs">IPV4</div>';
			}
		}
		
		echo '<div class="pinged-overlay absolute right-0 top-0 left-0 bottom-0 w-full h-full rounded-lg bg-black opacity-50"></div>';
		
		echo '<div class="relative flex justify-center items-center">
   
            <div class="absolute size-14 rounded-full bg-black opacity-80"></div>
  
            <div class="lozad size-12 rounded-full !bg-center !bg-no-repeat !bg-[auto_100%]" data-background-image="'.$icon.'"></div>
    
            <div class="pinged absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xl font-bold">
            
			<div class="flex items-center justify-center w-full text-center">
              <img class="size-5" src="./assets/gif/loader.gif" />
            </div>
			
            </div>
 
            <div class="pinged-status absolute bottom-8 -left-1 w-4 h-4 bg-orange-500 border-3 border-black rounded-full"></div>
        </div>';
		
        echo '  <div class="block text-base font-semibold tracking-wider">' . ($name) . '</div>';
		if (!empty($desc)){
         echo '  <div class="text-xs leading-tight text-center">' . ($desc) . '</div>';
		}
		
		if (!empty($defaultIP)){
		$showAddress = $srv['showAddress'] ? '' : 'blur-xs';
        echo '<div class="current-ip '.$showAddress.' text-xs w-full truncate text-center break-all p-1 '
		. 'rounded-lg tracking-widest">'.$defaultIP.'</div>';
		}
		
        echo '</div>';
    }
    echo '</div>'; 
}
echo '</div>'; 
?>