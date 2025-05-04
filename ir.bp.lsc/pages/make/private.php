<?php  
$include_lang = true;
$include_database = true;
$include_function = true;
include '../../config.php'; 
 
$body = '<div class="flex flex-col gap-3 p-3">';

$chatList = getChatList($email, "private");
$chatListPV = $chatList['list'];  // استفاده از 'list' به جای 'chats'

foreach ($chatListPV as $chat) {
    // تعیین وضعیت خواندن پیام
    $seen = $chat['seen'] ? 'bg-green-500' : 'bg-red-500';
    if ($chat['self'] && !$chat['seen']) {
        $seen = 'bg-yellow-300';
    }

    if (!$chat['self'] && $chat['seen']) {
        $seen = '';
    }

    // اضافه کردن هر چت به بدنه HTML
    $body .= '
    <div class="flex items-center bg-main-1 rounded-lg p-3 py-5 gap-3" onclick="viewPV(`'.$chat['email'].'`);">
        <div class="min-w-0">
            <div class="w-12 h-12 bg-main-0 lozad rounded-lg !bg-no-repeat !bg-cover" data-background-image="'.$chat['profileUrl'].'"></div>
        </div>
        <div class="flex-1 min-w-0 truncate flex flex-col gap-2">
            <div class="font-semibold text-lg text-white">'.$chat['givenName'].'</div>
            <div class="w-auto text-gray-500 text-sm truncate">'.trimLongString($chat['message'], 30).'</div>
            <div class="text-xs text-gray-600 mt-2 text-start" dir="auto">'.timeAgo($chat['created'], false, true, $lang).'</div>
        </div>
        <div class="min-w-0">
            <div class="h-5 w-5 rounded-full '.$seen.'"></div>
        </div>
    </div>';
}

// اگر هیچ چتی وجود ندارد، پیامی برای نمایش داده می‌شود
if (empty($chatListPV)) {
    $body .= '
    <div class="w-full flex flex-col gap-5 items-center justify-center h-[calc(100vh-12rem)]">
        <svg class="size-24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
            <path fill="#fff" d="M13.5 3a8.5 8.5 0 0 1 0 17H13v.99A1.01 1.01 0 0 1 11.989 22c-2.46-.002-4.952-.823-6.843-2.504C3.238 17.798 2.002 15.275 2 12.009V11.5A8.5 8.5 0 0 1 10.5 3zm0 2h-3A6.5 6.5 0 0 0 4 11.5l.001.665c.04 2.642 1.041 4.562 2.475 5.836C7.714 19.103 9.317 19.76 11 19.945v-.935c0-.558.452-1.01 1.01-1.01h1.49a6.5 6.5 0 1 0 0-13m-5 5a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3m7 0a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3" />
        </svg>
        '.$language['jshnzc'][$lang].'
    </div>';
}

$body .= '</div>';

echo $body;

 
?>