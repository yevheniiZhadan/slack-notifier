<?php

namespace Lolly\Slack;

interface iNotifier
{
    public function sendMessage(string $title, string $message, string $channel);
}