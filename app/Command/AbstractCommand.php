<?php namespace Task\Command;

use Illuminate\Console\Command;
use Task\Service\Validator\ValidatorInterface;

class AbstractCommand extends Command
{

    /**
     * Asks a user a supplied question until the answer validates.
     *
     * @param String                $question   Question to ask the user
     * @param ValidatorInterface    $validator  Validator that contains the rule to validate users input with
     * @param String                $ruleName   Name of the rule to validate user input
     *
     * @return string Unsanitized user input
     */
    protected function askQuestionAndValidate($question, ValidatorInterface $validator, $ruleName)
    {
        do {
            $answer = $this->ask($question);
            $errors = $validator->getErrors([$ruleName => $answer]);
            if ($hasError = $errors->has($ruleName)) {
                $this->error($errors->first($ruleName));
            }
        } while ($hasError);

        return $answer;
    }
} 