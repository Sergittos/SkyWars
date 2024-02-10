<?php
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);


namespace sergittos\skywars\utils\message;


use sergittos\skywars\SkyWars;
use sergittos\skywars\utils\ColorUtils;
use function array_map;
use function is_array;
use function json_decode;
use function str_replace;

/**
 * @author dresnite
 */
class MessageManager {

    /** @var string[] */
    private array $messages;

    public function __construct() {
        $this->messages = json_decode(file_get_contents(SkyWars::getInstance()->getDataFolder() . "messages.json"), true);
    }

    public function getMessage(MessageContainer $container): string|array {
        $identifier = $container->getId();
        $arguments = $container->getArguments();

        $message = $this->messages[$identifier] ?? "Message ($identifier) not found";
        if(is_array($message)) {
            return $this->processMessages($message, $arguments);
        }
        return $this->processMessage($message, $arguments);
    }

    private function processMessages(array $messages, array $arguments): array {
        return array_map(fn(string $message) => $this->processMessage($message, $arguments), $messages);
    }

    private function processMessage(string $message, array $arguments): string {
        foreach($arguments as $key => $value) {
            if($value instanceof MessageContainer) {
                $value = $value->getMessage();
            }
            $message = str_replace("{" . $key . "}", (string) $value, $message);
        }
        return ColorUtils::translate($message);
    }

    public function addMessage(string $identifier, string $message): void {
        $this->messages[$identifier] = $message;
    }

}