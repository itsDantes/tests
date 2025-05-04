<?php  
$include_lang = true;
$include_database = true;
$include_function = true;
include '../../config.php'; 

$dir = $lang == "fa" ? "dRTL" : "dLTR";

echo '<div class="h-screen flex flex-col bg-main-0">';

 
echo '<div id="msg-list" class="flex-1 m-1">';

 
$chatList = getChatList($email, "group"); 
$list = $chatList['list'] ?? [];

foreach ($list as $chat) {
    $selfClass = $chat['self'] ? '' : 'dLTR';
    $justifySelfClass = $chat['self'] ? 'justify-between' : 'justify-end';
    $profileUrl = htmlspecialchars($chat["profileUrl"]);
    $givenName = htmlspecialchars($chat["givenName"]);
    $message = htmlspecialchars($chat["message"]);

    echo '
    <div class="message-body px-3 flex flex-row items-center '.$selfClass.'">
        <div class="block min-w-0" onclick="viewPV(`'.$chat['email'].'`)">
            <div class="w-12 h-12 lozad rounded-lg !bg-no-repeat !bg-cover" data-background-image="'.$profileUrl.'"></div>
        </div>

        <div class="flex-1 min-w-0 w-full flex flex-row '.$justifySelfClass.' items-center gap-2 m-3 rounded-lg p-3 bg-main-1" onclick="setClipboard(`'.$message.'`)">
            <div class="flex flex-col gap-3 p-2 w-full">
                <div class="block text-white text-justify break-words overflow-hidden text-sm leading-6" dir="auto">
                    '.$message.'
                </div>
                <div class="text-xs text-gray-600 mt-2 text-start" dir="auto">
                    '.timeAgo($chat['created'], false, true, $lang).'
                </div>
            </div>
        </div>
    </div>';
}

echo '</div>';  

 
echo '
<footer class="m-1 rounded-lg sticky bottom-1 z-50 bg-main-1 shadow-lg">
    <div class="flex items-center justify-between mx-auto px-2 py-2">
        <div class="flex-1 size-12">
            <textarea data-sender="' . $email . '" data-receiver="group" dir="auto" class="w-full rounded-lg bg-main-0 p-3 text-sm leading-6 text-white ' . $dir . '" rows="1" placeholder="' . $language['cncjau'][$lang] . '"></textarea>
        </div>
        <div class="mx-1"></div>
        <svg id="send-btn" class="size-12 rounded-lg bg-main-0 p-3 block hover:scale-90 transition-all ease-in-out duration-200 transform" onclick="sendMessage()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.76 12H6.832m0 0c0-.275-.057-.55-.17-.808L4.285 5.814c-.76-1.72 1.058-3.442 2.734-2.591L20.8 10.217c1.46.74 1.46 2.826 0 3.566L7.02 20.777c-1.677.851-3.495-.872-2.735-2.591l2.375-5.378A2 2 0 0 0 6.83 12" />
        </svg>
    </div>
</footer>';

echo '</div>'; 

?>
