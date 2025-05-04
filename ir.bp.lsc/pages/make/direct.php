<?php

$include_lang = true;
$include_database = true;
$include_function = true;
include '../../config.php'; 

$targetInfo = $database->get("user", ["email", "profileUrl", "givenName", "modified"], ["email" => $target]);
$targetIsOnline = (int)($targetInfo['modified'] ?? 0) > strtotime("-5 minutes") ? $language["bhbgaq"][$lang] : timeAgo($targetInfo['modified'], false, true, $lang);

$dir = $lang == "fa" ? "dRTL" : "dLTR";

$body = '';
$body .= '<div class="flex flex-col h-screen">';
$body .= '
<header class="m-1 rounded-lg bg-main-1">
    
        <div class="flex flex-row justify-between items-center p-4">
            <div class="flex-1 flex flex-row justify-start items-center gap-3 text-white">
                <div class="block" data-uid="'.$targetInfo["email"].'">
                    <div class="w-12 h-12 lozad rounded-lg !bg-no-repeat !bg-cover" data-background-image="'.$targetInfo["profileUrl"].'"></div>
                </div>
                <div class="flex flex-col justify-between items-start gap-1 text-white">
                    <div class="block text-base whitespace-normal">'.$targetInfo["givenName"].'</div>
                    <div class="block text-xs">'.$targetIsOnline.'</div>
                </div>
            </div>
            <div class="min-w-0">
                <div class="w-12 h-12 rounded-lg bg-main-0 flex items-center justify-center" onclick="closePV()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="#fff" d="m12 14.122l5.303 5.303a1.5 1.5 0 0 0 2.122-2.122L14.12 12l5.304-5.303a1.5 1.5 0 1 0-2.122-2.121L12 9.879L6.697 4.576a1.5 1.5 0 1 0-2.122 2.12L9.88 12l-5.304 5.304a1.5 1.5 0 1 0 2.122 2.12z" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
 
</header>';

$body .= '<div id="msg-list" class="flex-1 overflow-y-auto">';

 
// دریافت لیست چت‌ها با استفاده از تابع getChatList
$chatList = getChatList($email, $target);
$chatListPV = $chatList['list']; // لیست چت‌ها
 
foreach ($chatListPV as $k => $chat) {

    $seen = $chat['seen'] ? 'bg-green-500' : 'bg-yellow-300';
 
    $seenText = '';

    if (!isset($chatListPV[$k + 1])) {
        $seenText = $chat['self'] && $chat["seen"] ? '<div class="block text-xs mt-5 text-yellow-300">' . $language["njhytq"][$lang] . '</div>' : '';
    }
    
 
	if ($lang == "fa"){
    $selfClass = $chat['self'] ? "" : 'dLTR opacity-50';
	}else{
    $selfClass = $chat['self'] ? 'dRTL' : "opacity-50";
	}
	
    $justifySelfClass = $chat['self'] ? 'justify-between' : 'justify-end';

    $body .= '<div class="message-body px-3 flex flex-row items-center gap-2 last-div ' . $selfClass . '" onclick="setClipboard(`' . $chat["message"] . '`)">';
    $body .= '<div class="block min-w-0">
                <div class="w-12 h-12 lozad rounded-lg !bg-no-repeat !bg-cover" data-background-image="' . $chat["profileUrl"] . '"></div>
              </div>';

    $body .= '<div dir="auto" class="flex-1 min-w-0 w-full flex flex-row ' . $justifySelfClass . ' items-center gap-2 m-3 rounded-lg p-3 bg-main-1" onclick="setClipboard(`' . $chat["message"] . '`)">
                <div class="flex flex-col gap-3 p-2 w-full">
                    <div class="block text-white text-justify break-words overflow-hidden text-sm leading-6" dir="auto">
                        ' . $chat["message"] . ' 
                    </div>
                    <div class="text-xs text-gray-600 mt-2 text-start">' . timeAgo($chat['created'], false, true, $lang) . '</div>
                    ' . $seenText . '
                </div>
              </div>';
    $body .= '</div>';
}

if (empty($chatListPV)) {
    $body .= '<div class="w-full flex text-center flex-col gap-5 items-center justify-center h-[calc(100vh-12rem)]">
                <svg class="size-24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="#fff" d="M7.291 20.824L2 22l1.176-5.291A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10a9.96 9.96 0 0 1-4.709-1.176m.29-2.113l.653.35A7.96 7.96 0 0 0 12 20a8 8 0 1 0-8-8c0 1.335.325 2.617.94 3.766l.349.653l-.655 2.947zM7 12h2a3 3 0 1 0 6 0h2a5 5 0 0 1-10 0" />
                </svg>
                <div class="leading-8">
                    '.$language['cacazc'][$lang].'
                </div>
              </div>';
}

$body .= '</div>';

 
$body .= '
<footer class="m-1 rounded-lg bg-main-1">
    <div class="flex items-center justify-between mx-auto p-4">
        <div class="flex-1 size-12">
            <textarea data-sender="' . $email . '" data-receiver="' . $targetInfo["email"] . '" dir="auto" class="w-full rounded-lg bg-main-0 p-3 text-sm leading-6 text-white ' . $dir . '" rows="1" placeholder="' . $language['cncjau'][$lang] . '"></textarea>
        </div>
        <div class="mx-1"></div>
        <svg id="send-btn" class="size-12 rounded-lg bg-main-0 p-3 block hover:scale-90 transition-all ease-in-out duration-200 transform" onclick="sendMessage()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.76 12H6.832m0 0c0-.275-.057-.55-.17-.808L4.285 5.814c-.76-1.72 1.058-3.442 2.734-2.591L20.8 10.217c1.46.74 1.46 2.826 0 3.566L7.02 20.777c-1.677.851-3.495-.872-2.735-2.591l2.375-5.378A2 2 0 0 0 6.83 12" />
        </svg>
    </div>
</footer>';

$body .= '</div>';

echo $body;
?>
