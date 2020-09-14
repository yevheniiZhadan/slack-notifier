<?php

namespace Lolly;

interface iNotifier
{
    public function sendMessage(string $title, string $message, string $channel);
}