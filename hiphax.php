#!/usr/bin/env php
<?php

if(!file_exists('/Applications/HipChat.app/Contents/Resources/chat.html')){
	die('Unable to find chat.html');
}

$chat = file_get_contents('/Applications/HipChat.app/Contents/Resources/chat.html');

if(!strpos($chat, '<!--hiphax_start-->')){
	$chat = str_replace('</body></html>', '<!--hiphax_start-->'.'<!--hiphax_end-->'.'</body></html>', $chat);
}

$payload = file_get_contents('./payload.html');
$payload = '<!--hiphax_start-->'.$payload.'<!--hiphax_end-->';

$chat = preg_replace('/<!--hiphax_start-->(.*?)<!--hiphax_end-->/s', $payload, $chat);

file_put_contents('/Applications/HipChat.app/Contents/Resources/chat.html', $chat);

print "Installed hiphax into HipChat!\n";	

print "Closing HipChat\n";
exec("osascript -e 'quit app \"HipChat\"'");
sleep(1);
print "Opening HipChat\n";
exec("open /Applications/HipChat.app");