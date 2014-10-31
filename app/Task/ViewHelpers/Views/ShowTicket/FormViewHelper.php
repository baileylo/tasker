<?php namespace Portico\Task\ViewHelpers\Views\ShowTicket;

use Illuminate\Support\MessageBag;
use Portico\Core\EmptyObject;

class FormViewHelper
{
    protected $showForm;

    /** @var MessageBag */
    protected $editFormErrors;

    /** @var MessageBag */
    private $commentFormErrors;

    public function __construct(MessageBag $editFormErrors, MessageBag $commentFormErrors)
    {
        $this->editFormErrors = $editFormErrors;
        $this->commentFormErrors = $commentFormErrors;
    }

    public function fieldToggle()
    {
        return $this->editFormErrors->isEmpty() ? 'show-details' : 'show-errors';
    }

    public function editFormClasses($fieldName)
    {
        $classes = [];
        if ($this->editFormErrors->has($fieldName)) {
            $classes[] = 'has-error';
        }

        return implode(' ', $classes);
    }

    public function renderErrorMessage($fieldName, $messageFormat = '<dd class="ticket-edit-form text-danger">%s</dd>')
    {
        if (!$this->editFormErrors->has($fieldName)) {
            return '';
        }

        return sprintf($messageFormat, e($this->editFormErrors->first($fieldName)));
    }

    public function getAssigneesName($assignee, $empty)
    {
        if (!$assignee) {
            return $empty;
        }

        return e($assignee->present()->full_name);
    }

    public function something($object, $value = '')
    {
        if (!$object) {
            return new EmptyObject($value);
        }

        return $object;
    }

}