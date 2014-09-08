<?php namespace Portico\Task\Console;

use DB;
use Laracasts\Commander\CommandBus;
use Portico\Core\Commander\CommanderConsoleTrait;
use Portico\Core\Validator\ValidationFailedException;
use Portico\Task\Application\Application;
use Portico\Task\Application\ApplicationRepository;
use Portico\Task\Project\Command\CreateProjectCommand;
use Portico\Task\Project\Command\CreateProjectValidator;
use Portico\Task\Project\Project;
use Portico\Task\User\Command\WatchProjectCommand;
use Portico\Task\User\User;
use Portico\Task\User\UserValidator;
use Portico\Task\User\Command\CreateUserCommand;


/**
 * Class Install
 * @method Project|User executeJob($commandName, array $input = array(), array $decorators = array())
 */
class Install extends AbstractCommand
{
    use CommanderConsoleTrait;

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

    /** @var UserValidator  */
    protected $userValidator;

    /** @var CreateProjectValidator */
    protected $projectValidator;

    /** @var ApplicationRepository */
    protected $applicationRepo;

    /** @var CommandBus */
    private $commandBus;

    /**
     * Create a new command instance.
     *
     * @param UserValidator $validator
     * @param CreateProjectValidator $projectValidator
     * @param ApplicationRepository $applicationRepo
     * @param CommandBus $commandBus
     * @return \Portico\Task\Console\Install
     */
    public function __construct(
        UserValidator $validator,
        CreateProjectValidator $projectValidator,
        ApplicationRepository $applicationRepo,
        CommandBus $commandBus

    ) {
        parent::__construct();

        $this->userValidator = $validator;
        $this->projectValidator = $projectValidator;
        $this->applicationRepo = $applicationRepo;
        $this->commandBus = $commandBus;
    }

    public function getCommandBus()
    {
        return $this->commandBus;
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
            $wantsToRunMigrations = $this->confirm('They are required to continue with this script, do you want to run them now?[Y|N]');
            if (!$wantsToRunMigrations) {
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

        \DB::beginTransaction();

        $this->info('Generating encryption key');
        $this->call('key:generate');

        $this->info('Welcome to Tasker!');
        $this->info('This will help you setup your account and first project');
        $user = $this->createUser();

        $this->info('');
        $this->info("Hi  {$user->first_name}, lets get started on creating your first project!");

        $project = $this->createProject();

        $application = new Application();
        $application->is_setup = true;
        $application->save();

        // Complete transaction
        DB::commit();

        $this->executeJob(WatchProjectCommand::class, compact('user', 'project'));

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

    /**
     * Creates a new user and then saves them to the databse.
     *
     * @return User
     */
    protected function createUser()
    {
        $data = [];

        $data['firstName'] = $this->askQuestionAndValidate(
            'What is your first name?',
            $this->userValidator,
            'first_name'
        );

        $data['lastName'] = $this->askQuestionAndValidate(
            'What is your last name?',
            $this->userValidator,
            'last_name'
        );

        $data['email'] = $this->askQuestionAndValidate(
            'What is your email address?',
            $this->userValidator,
            'email'
        );

        try {
            return $this->executeJob(CreateUserCommand::class, $data);
        } catch (ValidationFailedException $exception) {
            foreach ($exception->getErrors() as $error) {
                $this->error($error->first());
                exit(1);
            }
        }
    }

    /**
     * Prompts user for project information and then saves project to the database.
     *
     * @return Project
     */
    protected function createProject()
    {
        $data['name'] = $this->askQuestionAndValidate(
            'What is the name of your project? ',
            $this->projectValidator,
            'name'
        );

        $data['description'] = $this->askQuestionAndValidate(
            'Give a project description ',
            $this->projectValidator,
            'description'
        );

        try {
            /** @var Project $project */
            return $this->executeJob(CreateProjectCommand::class, $data);
        } catch (ValidationFailedException $exception) {
            foreach ($exception->getErrors() as $error) {
                $this->error($error->first());
                exit(1);
            }
        }
    }
}
