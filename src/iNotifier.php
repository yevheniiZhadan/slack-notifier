<?php

namespace Yevheniizhadan\Slack\Notifier;

interface iNotifier
{
    public function sendMessage(string $title, string $message, string $channel);
}