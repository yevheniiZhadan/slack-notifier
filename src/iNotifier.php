<?php

namespace Slack;

interface iNotifier
{
    public function sendMessage(string $title, string $message, string $channel);
}