<?php

namespace Yevheniizhadan\Slack\Notifier;

class TokenSlackNotifier implements iNotifier
{
    private $token;

    public function __construct($token) {
        $this->token = $token;
    }

    /**
     * @param string $title
     * @param string $message
     * @param string $channel
     * @return mixed
     */
    public function sendMessage(string $title, string $message, string $channel)
    {
        $curlHandler = curl_init("https://slack.com/api/chat.postMessage");

        $data = http_build_query([
            "token" => $this->token,
            "channel" => $channel,
            "text" => $message,
            "username" => $title,
        ]);

        return $this->executeMessage($curlHandler, $data);

    }

    /**
     * @param string $name
     * @param bool $is_private
     * @return mixed
     */
    public function createChannel(string $name, bool $is_private = false)
    {
        $curlHandler = curl_init("https://slack.com/api/conversations.create");
        $data = http_build_query([
            "token" => $this->token,
            "name" => $name,
            "is_private" => $is_private
        ]);

        return $this->executeMessage($curlHandler, $data);
    }

    /**
     * @param string $channel
     * @param array $users
     * @return mixed
     */
    public function inviteUsers(string $channel, array $users)
    {
        $curlHandler = curl_init("https://slack.com/api/conversations.invite");
        $usersList = implode(',', $users);
        $data = http_build_query([
            "token" => $this->token,
            "channel" => $channel,
            "users" => $usersList
        ]);

        return $this->executeMessage($curlHandler, $data);
    }

    /**
     * @param string $channel
     * @return mixed
     */
    public function archiveChannel(string $channel)
    {
        $curlHandler = curl_init("https://slack.com/api/conversations.archive");
        $data = http_build_query([
            "token" => $this->token,
            "channel" => $channel
        ]);

        return $this->executeMessage($curlHandler, $data);
    }

    /**
     * @param string $channel
     * @param string $topic
     * @return mixed
     */
    public function setChannelTopic(string $channel, string $topic)
    {
        $curlHandler = curl_init("https://slack.com/api/conversations.setTopic");
        $data = http_build_query([
            "token" => $this->token,
            "channel" => $channel,
            "topic" => $topic
        ]);

        return $this->executeMessage($curlHandler, $data);
    }

    /**
     * @param $curlHandler
     * @param $payload
     * @return mixed
     */
    private function executeMessage($curlHandler, $payload)
    {
        curl_setopt($curlHandler, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curlHandler);
        curl_close($curlHandler);

        return json_decode($result);
    }
}