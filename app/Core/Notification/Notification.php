<?php namespace Portico\Core\Notification;


class Notification
{
    protected $message;

    protected $replacements;

    protected $compiledMessage;

    public function __construct($message, array $replacements = [])
    {
        $this->message = $message;
        $this->replacements = $replacements;
        $this->compiledMessage = false;
    }

    public function __toString()
    {
        try {
            if ($this->compiledMessage === false) {
                $this->compiledMessage = $this->compileMessage();
            }
        }

        catch (\Exception $e) {
            $this->compiledMessage = '';
        }

        return $this->compiledMessage;
    }

    protected function compileMessage()
    {
        $args = array_merge([$this->message], $this->replacements);
        return call_user_func_array('sprintf', $args);
    }
} 