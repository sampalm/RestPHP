<?php

namespace Core;;

/**
 * Class Message
 * @package Store\Support
 */
class Message
{
    private string $title;
    private string $text;
    private string $type;
    private string $position;
    private int $code;
    private array $data;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string $title
     * @param string $message
     * @param string $position
     *
     * @return array
     */
    public function info(string $title, string $message, string $position = "top right"): Message
    {
        $this->type = "info";
        $this->title = $this->filter($title);
        $this->text = $this->filter($message);
        $this->position = $this->filter($position);
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function success(string $title, string $message, string $position = "top right"): Message
    {
        $this->type = "success";
        $this->title = $this->filter($title);
        $this->text = $this->filter($message);
        $this->position = $this->filter($position);
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function warning(string $title, string $message, string $position = "top right"): Message
    {
        $this->type = "warning";
        $this->title = $this->filter($title);
        $this->text = $this->filter($message);
        $this->position = $this->filter($position);
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function error(string $title, string $message, string $position = "top right"): Message
    {
        $this->type = "error";
        $this->title = $this->filter($title);
        $this->text = $this->filter($message);
        $this->position = $this->filter($position);
        return $this;
    }

    public function response(string $message, int $code): Message 
    {
        $this->text = $this->filter($message);
        $this->code = $code;
        return $this;
    }

    /**
     * @return array
     */
    public function render(): array
    {
        return array(
            "title" => $this->getTitle(),
            "message" => $this->getText(),
            "type" => $this->getType(),
            "position" => $this->getPosition()
        );
    }

    /**
     * @return string
     */
    public function json(): string
    {
        return json_encode(["message" => $this->getText(), "code" => $this->getCode()]);
    }

    /**
     * @param string $message
     * @return string
     */
    private function filter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}
