<?php

namespace Yevheniizhadan\Slack\Notifier;

class WebHookSlackNotifier implements iNotifier
{
    private $link;

    public function __construct($link) {
        $this->link = $link;
    }

        public  function sendMessage(string $title, string $message, string $channel) {
            try {

                $payload = json_encode(array(
                    "username"    =>  $title,
                    "channel"     =>  $channel,
                    "text"        =>  $message,
                ));

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->link);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_exec($ch);
                curl_close($ch);

                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
}