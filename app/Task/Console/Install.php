<?php namespace Portico\Task\Console;

use Portico\Task\Application\Application;
use Portico\Task\Project\Project;
use Portico\Task\User\User;
use Portico\Task\Project\ProjectValidator;
use Portico\Task\Application\ApplicationRepository;
use Portico\Task\User\UserValidator\UserValidator;

class Install extends AbstractCommand
{

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
	public function __construct(UserValidator $validator, ProjectValidator $projectValidator, ApplicationRepository $applicationRepo)
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
        if (!$this->tablesExist()) {
            $this->info('The database migrations have not been run.');
            $response = $this->ask('They are required to continue with this script, do you want to run them now?[Y|N]');
            if (!in_array($response, ['Y', 'y'])) {
                return false;
            }
            $this->info('Running database migrations');
            $this->call('migrate');
            $this->info('');
        }

        if ($this->applicationIsAlreadySetup()) {
            $this->error('Application has already been setup.');
            $this->info('You can access Tasker here: ' . route('home'));
            return true;
        }

        $this->info('Generating encryption key');
        $this->call('key:generate');

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

        $this->info('Setup complete!');
        $this->info('You can access Tasker here: ' . route('home'));
	}

    /**
     * Determine if the database tables exists.
     *
     * It does this by testing if the `select * from application limit 1` can be run.
     *
     * @return bool
     */
    protected function tablesExist()
    {
        return $this->applicationRepo->tableExists();
    }

    protected function applicationIsAlreadySetup()
    {
        return $this->applicationRepo->findSettings()->isAlreadySetup();
    }

    protected function promptForUserInfo()
    {
        $user = new User();

        $user->first_name = $this->askQuestionAndValidate(
            'What is your first name?',
            $this->userValidator,
            'first_name'
        );

        $user->last_name = $this->askQuestionAndValidate(
            'What is your last name?',
            $this->userValidator,
            'last_name'
        );

        $user->email = $this->askQuestionAndValidate(
            'What is your email address?',
            $this->userValidator,
            'email'
        );


        return $user;
    }

    protected function promptForProjectInfo()
    {
        $project = new Project();

        $project->name = $this->askQuestionAndValidate(
            'What is the name of your project? ',
            $this->projectValidator,
            'name'
        );

        $project->description = $this->askQuestionAndValidate(
            'Give a project description ',
            $this->projectValidator,
            'description'
        );

        return $project;
    }
}
