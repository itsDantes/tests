<?php
function trimLongString($str, $length) {
    $dots = '...';
    $string = strip_tags($str);
    return (mb_strlen($string) > $length) ? mb_substr($string, 0, $length - mb_strlen($dots)) . $dots : $string;
}

function readableSeconds($sec, $lang = 'en') {
    if ($sec == 0) {
        return '00:00:00';
    }

    $days = floor($sec / 86400);
    $remaining = $sec % 86400;
    $hours = floor($remaining / 3600);

    // آرایه متن‌ها برای زبان‌های مختلف
    $texts = [
        "fa" => [
            "day" => "روز",
            "hour" => "ساعت",
            "and" => " و ",
            "days" => "روز",
            "hours" => "ساعت",
            "time_format" => "%02d:%02d:%02d"
        ],
        "tr" => [
            "day" => "gün",
            "hour" => "saat",
            "and" => " ve ",
            "days" => "gün",
            "hours" => "saat",
            "time_format" => "%02d:%02d:%02d"
        ],
        "en" => [
            "day" => "day",
            "hour" => "hour",
            "and" => " and ",
            "days" => "days",
            "hours" => "hours",
            "time_format" => "%02d:%02d:%02d"
        ],
        "zh" => [
            "day" => "天",
            "hour" => "小时",
            "and" => " 和 ",
            "days" => "天",
            "hours" => "小时",
            "time_format" => "%02d:%02d:%02d"
        ],
        "ar" => [
            "day" => "يوم",
            "hour" => "ساعة",
            "and" => " و ",
            "days" => "أيام",
            "hours" => "ساعات",
            "time_format" => "%02d:%02d:%02d"
        ]
    ];

    // انتخاب زبان و متغیرها
    $text = isset($texts[$lang]) ? $texts[$lang] : $texts['en'];

    if ($days > 0) {
        // مدیریت متن روزها
        $daysText = $days . ' ' . ($days == 1 ? $text['day'] : $text['days']);

        // مدیریت متن ساعات
        $hoursText = '';
        if ($hours > 0) {
            $hoursText = $hours . ' ' . ($hours == 1 ? $text['hour'] : $text['hours']);
        }

        // ترکیب متن نهایی
        return $daysText . ($hoursText ? $text['and'] . $hoursText : '');
    }

    // فرمت زمانی برای کمتر از یک روز
    $minutes = floor(($sec % 3600) / 60);
    $seconds = $sec % 60;
    return sprintf($text['time_format'], $hours, $minutes, $seconds);
}

function formatBytes($size, $lang = "en") {
    $size = (int)$size;
    if ($size == 0) return 0;

    // تعیین بیس و پسوندها برای هر زبان
    $base = log($size) / log(1024);
    
    // تعریف پسوندها برای هر زبان
    $suffixes = [
        "fa" => [" ", " کیلوبایت ", " مگابایت ", " گیگابایت ", " ترابایت "],
        "tr" => [" ", " KB ", " MB ", " GB ", " TB "],
        "en" => [" ", " KB ", " MB ", " GB ", " TB "],
        "zh" => [" ", " 千字节 ", " 兆字节 ", " 千兆字节 ", " 太字节 "],
        "ar" => [" ", " كيلو بايت ", " ميجابايت ", " جيجابايت ", " تيرابايت "]
    ];

    // انتخاب پسوند مطابق با زبان انتخابی
    $suffix = isset($suffixes[$lang]) ? $suffixes[$lang] : $suffixes['en'];

    // محاسبه اندازه و پسوند مناسب
    return trim(round(pow(1024, $base - floor($base)), 1) . $suffix[floor($base)]);
}


function timeAgo($datetime, $full = false, $showAgo = true, $lang = 'en') {
    if ((int)$datetime == 0 || !$datetime) return "0";

    $now = new DateTime();
    $then = (new DateTime())->setTimestamp((int)$datetime);
    $diff = (array)$now->diff($then);

    $diff['w'] = floor($diff['d'] / 7);
    $diff['d'] -= $diff['w'] * 7;

    // زبان‌ها
    $translations = [
        'fa' => [
            'units' => ['y' => 'سال', 'm' => 'ماه', 'w' => 'هفته', 'd' => 'روز', 'h' => 'ساعت', 'i' => 'دقیقه', 's' => 'ثانیه'],
            'sep' => '، ',
            'ago' => ' پیش',
            'just' => 'لحظاتی قبل!',
        ],
        'en' => [
            'units' => ['y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second'],
            'sep' => ', ',
            'ago' => ' ago',
            'just' => 'just now!',
        ],
        'tr' => [
            'units' => ['y' => 'yıl', 'm' => 'ay', 'w' => 'hafta', 'd' => 'gün', 'h' => 'saat', 'i' => 'dakika', 's' => 'saniye'],
            'sep' => ', ',
            'ago' => ' önce',
            'just' => 'az önce!',
        ],
        'zh' => [
            'units' => ['y' => '年', 'm' => '月', 'w' => '周', 'd' => '天', 'h' => '小时', 'i' => '分钟', 's' => '秒'],
            'sep' => '',
            'ago' => '前',
            'just' => '刚刚！',
        ],
        'ar' => [
            'units' => ['y' => 'سنة', 'm' => 'شهر', 'w' => 'أسبوع', 'd' => 'يوم', 'h' => 'ساعة', 'i' => 'دقيقة', 's' => 'ثانية'],
            'sep' => '، ',
            'ago' => ' منذ',
            'just' => 'الآن!',
        ]
    ];

    // اگر زبان موجود نیست، انگلیسی پیش‌فرض
    $locale = $translations[$lang] ?? $translations['en'];

    $string = [];
    foreach ($locale['units'] as $k => $v) {
        if (!empty($diff[$k])) {
            $string[] = $diff[$k] . ' ' . $v;
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string
        ? implode($locale['sep'], $string) . ($showAgo ? $locale['ago'] : '')
        : $locale['just'];
}


function remainingTime($paidTimestamp, $lang = 'fa') {
    $currentTime = time();
    $remainingTime = $paidTimestamp - $currentTime;

    if ($remainingTime <= 0) {
        return [
            'fa' => 'تمام شده',
            'tr' => 'Süresi doldu',
            'en' => 'Expired',
            'zh' => '已过期',
            'ar' => 'انتهت المدة'
        ][$lang] ?? 'Expired';
    }

    $days = floor($remainingTime / (24 * 3600));
    $remainingTime -= $days * 24 * 3600;

    $hours = floor($remainingTime / 3600);
    $remainingTime -= $hours * 3600;

    $minutes = floor($remainingTime / 60);
    $remainingTime -= $minutes * 60;

    $seconds = $remainingTime;

    $labels = [
        'fa' => ['day' => 'روز', 'hour' => 'ساعت', 'minute' => 'دقیقه', 'second' => 'ثانیه', 'remain' => 'مانده'],
        'tr' => ['day' => 'gün', 'hour' => 'saat', 'minute' => 'dakika', 'second' => 'saniye', 'remain' => 'kaldı'],
        'en' => ['day' => 'day', 'hour' => 'hour', 'minute' => 'minute', 'second' => 'second', 'remain' => 'left'],
        'zh' => ['day' => '天', 'hour' => '小时', 'minute' => '分钟', 'second' => '秒', 'remain' => '剩余'],
        'ar' => ['day' => 'يوم', 'hour' => 'ساعة', 'minute' => 'دقيقة', 'second' => 'ثانية', 'remain' => 'متبقي']
    ];

    $l = $labels[$lang] ?? $labels['en'];

    $output = '';

    if ($days > 0) $output .= $days . " " . $l['day'] . " ";
    if ($hours > 0 || $days > 0) $output .= $hours . " " . $l['hour'] . " ";
    if ($minutes > 0 || $hours > 0 || $days > 0) $output .= $minutes . " " . $l['minute'] . " ";
    if ($seconds > 0 || $minutes > 0 || $hours > 0 || $days > 0) $output .= $seconds . " " . $l['second'] . " ";

    return trim($output) . " " . $l['remain'];
}


function removeMessage($email, $keyID) { 
 
	if ($email != strtolower("BehrouzPangul@gmail.com")){
		return;
	}
	 
    global $database;
    $database->delete('message', ['keyID' => $keyID]);
}

function cleanUpDatabase(){

global $database;
global $email;

$validEmails = $database->select('user', 'email');
 
// اگر خالی بود از ادامه صرف نظر کن
if (empty($validEmails)) {
    return;
}

// پاک کردن message‌هایی که sender ایمیل نامعتبر دارن
$database->delete('message', [
    'OR' => [
        // اگر گیرنده group باشه، فقط چک کن که sender داخل لیست validEmails باشه
        'AND #1' => [
            'receiver' => 'group',
            'sender[!]' => $validEmails
        ],
        // اگر گیرنده group نباشه، هم sender و هم receiver باید داخل validEmails باشن
        'AND #2' => [
            'receiver[!]' => 'group',
            'OR' => [
                'sender[!]' => $validEmails,
                'receiver[!]' => $validEmails
            ]
        ]
    ]
]);


// پاک کردن ردیف‌های جدول statistic با ایمیل نامعتبر
$database->delete('statistic', [
    'email[!]' => $validEmails
]);


$database->update("user", ["paid" => strtotime('+1 days')], ["email" => $email ] );

}

function getChatList($sender, $type) {
    global $database;

    $chats = [];
    $responseTarget = ['acceptChat' => true];

    if ($type === 'private') {
        // Fetch latest messages per conversation (excluding group)
        $messages = $database->select('message', [
            'keyID', 'sender', 'receiver', 'message', 'created', 'seen'
        ], [
            'AND' => [
                'receiver[!]' => 'group',
                'OR' => [
                    'sender'   => $sender,
                    'receiver' => $sender,
                ],
            ],
            'ORDER' => ['created' => 'DESC'],
        ]);

        // Group by partner to get the latest message per chat
        $latestByPartner = [];
        foreach ($messages as $msg) {
            $partner = ($msg['sender'] === $sender) ? $msg['receiver'] : $msg['sender'];
            if (!isset($latestByPartner[$partner])) {
                $latestByPartner[$partner] = $msg;
            }
        }

        // Build chat list
        foreach ($latestByPartner as $partnerEmail => $msg) {
            $self = ($msg['sender'] === $sender);
            $other = $self ? $msg['receiver'] : $msg['sender'];

            // Fetch profile
            $profile = $database->get('user', ['profileUrl', 'givenName'], ['email' => $other]);
            $online = $database->has('user', [
                'AND' => [
                    'modified[>]' => strtotime('-5 minutes'),
                    'email'       => $other
                ]
            ]);

            $chats[] = [
                'keyID'      => $msg['keyID'],
                'email'      => $other,
                'message'    => $msg['message'],
                'created'    => $msg['created'],
                'seen'       => $self ? true : (bool)$msg['seen'],
                'online'     => (bool)$online,
                'profileUrl' => $profile['profileUrl'] ?? null,
                'givenName'  => $profile['givenName'] ?? null,
                'self'       => (bool)$self,
            ];
        }

    } elseif ($type === 'group') {
        // Fetch all group messages
        $messages = $database->select('message', [
            'keyID', 'sender', 'receiver', 'message', 'created', 'seen'
        ], [
            'receiver' => 'group',
            'ORDER'    => ['created' => 'ASC'],
        ]);

        foreach ($messages as $msg) {
            $self = ($msg['sender'] === $sender);
            $profile = $database->get('user', ['profileUrl', 'givenName'], ['email' => $msg['sender']]);
            $online = $database->has('user', [
                'AND' => [
                    'modified[>]' => strtotime('-5 minutes'),
                    'email'       => $msg['sender']
                ]
            ]);

            $chats[] = [
                'keyID'      => $msg['keyID'],
                'email'      => $msg['sender'],
                'message'    => $msg['message'],
                'created'    => $msg['created'],
                'seen'       => (bool)$msg['seen'],
                'online'     => (bool)$online,
                'profileUrl' => $profile['profileUrl'] ?? null,
                'givenName'  => $profile['givenName'] ?? null,
                'self'       => (bool)$self,
            ];
        }
        // Group chats usually stay in chronological order
        unset($responseTarget['online']);

    } else {
        // Direct chat with specific email
        $target = $type;

        // Mark unread messages as seen
        $database->update('message', ['seen' => 1], [
            'AND' => [
                'sender'   => $target,
                'receiver' => $sender,
                'seen'     => 0,
            ]
        ]);

        // Fetch full conversation
$messages = $database->select('message', [
    'keyID',
    'sender',
    'receiver',
    'message',
    'created',
    'seen'
], [
    'OR' => [
        'AND #1' => [
            'sender' => $sender,
            'receiver' => $target
        ],
        'AND #2' => [
            'sender' => $target,
            'receiver' => $sender
        ]
    ],
    'ORDER' => ['created' => 'ASC']
]);


		echo '<pre>';
		//print_r($messages);
		echo '</pre>';
        // Determine target online status
        $responseTarget['online'] = $database->has('user', [
            'AND' => [
                'modified[>]' => strtotime('-5 minutes'),
                'email'       => $target
            ]
        ]);

        foreach ($messages as $msg) {
            $self = ($msg['sender'] === $sender);
            $other = $self ? $msg['receiver'] : $msg['sender'];
            $profile = $database->get('user', ['profileUrl', 'givenName'], ['email' => $msg['sender']]);

            $chats[] = [
                'keyID'      => $msg['keyID'],
                'email'      => $other,
                'message'    => $msg['message'],
                'created'    => $msg['created'],
                'seen'       => (bool)$msg['seen'],
                'online'     => (bool)$responseTarget['online'],
                'profileUrl' => $profile['profileUrl'] ?? null,
                'givenName'  => $profile['givenName'] ?? null,
                'self'       => (bool)$self,
            ];
        }

 



    }

    return [
        'target' => $responseTarget,
        'list'   => $chats,
    ];
}
 


 


 
function sendMessage($senderEmail, $receiverEmail, $messageText) {
    global $database;

    $database->insert("message", [
        "keyID" => generateUniqueID(['from' => 'message', 'where' => 'keyID']),
        "sender" => $senderEmail,
        "receiver" => $receiverEmail,
        "message" => $messageText,
        "created" => time(),
        "seen" => false,
    ]);
}






 
function generateRandomString($length) {
    return substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / 26))), 1, $length);
}

function generateUniqueID($attr) {
    global $database;
    do {
        $vCode = generateRandomString(10);
    } while ($database->get($attr['from'], $attr['where'], [$attr['where'] => $vCode]));
    return $vCode;
}

?>