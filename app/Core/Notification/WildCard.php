<?php namespace Portico\Core\Notification;

use Illuminate\Html\HtmlBuilder;

class WildCard
{
    protected $builder;

    public function __construct(HtmlBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function make($text, $type, array $attributes = [])
    {
        $attributes = $this->builder->attributes($attributes);

        return "<{$type}{$attributes}>" . e($text) . "</{$type}>";
    }
} 