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
use function json_decode;

/**
 * @author dresnite
 */
class MessageManager {

    /** @var string[] */
    private array $messages;

    public function __construct() {
        $this->messages = json_decode(file_get_contents(SkyWars::getInstance()->getDataFolder() . "messages.json"), true);
    }

    public function getMessage(MessageContainer $container): string {
        $identifier = $container->getId();
        $message = $this->messages[$identifier] ?? "Message ($identifier) not found";
        foreach($container->getArguments() as $key => $value) {
            $message = str_replace("{" . $key . "}", (string) $value, $message);
        }
        return ColorUtils::translate($message);
    }

    public function addMessage(string $identifier, string $message): void {
        $this->messages[$identifier] = $message;
    }

}