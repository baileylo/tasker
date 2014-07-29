<?php namespace Task\Command;

use Illuminate\Console\Command;
use Task\Model\Application;
use Task\Model\Project;
use Task\Model\User;
use Task\Service\Validator\User\Validator as UserValidator;
use Task\Service\Validator\Project\Validator as ProjectValidator;
use Task\Model\Application\RepositoryInterface as ApplicationRepo;

class Install extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup your first project and user.';

    protected $userValidator;

    protected $projectValidator;

    protected $applicationRepo;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(UserValidator $validator, ProjectValidator $projectValidator, ApplicationRepo $applicationRepo)
	{
		parent::__construct();

        $this->userValidator = $validator;
        $this->projectValidator = $projectValidator;
        $this->applicationRepo = $applicationRepo;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        if ($this->applicationIsAlreadySetup()) {
            $this->error('Application has already been setup.');
            return true;
        }

		$this->info('Welcome to Tasker!');
        $this->info('This will help you setup your account and first project');
        $user = $this->promptForUserInfo();

        $this->info('');
        $this->info("Hi  {$user->first_name}, lets get started on creating your first project!");

        $project = $this->promptForProjectInfo();

        // Generate a one time token used for login links!
        $user->createOneTimeToken();

        $user->save();
        $project->save();

        $application = new Application();
        $application->is_setup = true;
        $application->save();
	}

    protected function applicationIsAlreadySetup()
    {
        return $this->applicationRepo->findSettings()->isAlreadySetup();
    }

    protected function promptForUserInfo()
    {
        $user = new User();

        $user->first_name = $this->loopQuestionTillValidateReceiveAnswer(
            'What is your first name?',
            $this->userValidator,
            'first_name'
        );

        $user->last_name = $this->loopQuestionTillValidateReceiveAnswer(
            'What is your last name?',
            $this->userValidator,
            'last_name'
        );

        $user->email = $this->loopQuestionTillValidateReceiveAnswer(
            'What is your email address?',
            $this->userValidator,
            'email'
        );


        return $user;
    }

    protected function promptForProjectInfo()
    {
        $project = new Project();

        $project->name = $this->loopQuestionTillValidateReceiveAnswer(
            'What is the name of your project? ',
            $this->projectValidator,
            'name'
        );

        $project->description = $this->loopQuestionTillValidateReceiveAnswer(
            'Give a project description ',
            $this->projectValidator,
            'description'
        );

        return $project;
    }

    protected function loopQuestionTillValidateReceiveAnswer($question, $validator, $fieldName)
    {
        do {
            $answer = $this->ask($question);
            $errors = $validator->getErrors([$fieldName => $answer]);
            if ($hasError = $errors->has($fieldName)) {
                $this->error($errors->first($fieldName));
            }
        } while ($hasError);

        return $answer;
    }
}
