<?php namespace Portico\Task\User;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Query\Builder;
use Laracasts\Commander\Events\EventGenerator;
use Portico\Core\Presenter\Presentable;
use Portico\Task\Project\Project;
use Portico\Task\User\Command\CreateUserCommand;
use Portico\Task\User\Events\ProjectWasWatched;
use Portico\Task\User\Events\UserWasCreated;

/**
 * Task\Model\User
 *
 * @property integer    $id
 * @property string     $first_name
 * @property string     $last_name
 * @property string     $email
 * @property integer    $logout_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereLogoutAt($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 */
class User extends Eloquent implements UserInterface
{
    use Presentable;
    use EventGenerator;

    protected $presenterName = 'Portico\Task\User\Presenter';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return false;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return false;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        return;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return false;
    }


    public function projects()
    {
        return $this->belongsToMany('Portico\Task\Project\Project', 'user_projects');
    }

    public function watchProject(Project $project)
    {
        $this->projects()->save($project);
        $this->raise(new ProjectWasWatched($this, $project));
    }

    public static function createUser(CreateUserCommand $command)
    {
        $user = new User();
        $user->email = $command->getEmail();
        $user->first_name = $command->getFirstName();
        $user->last_name = $command->getLastName();

        $user->save();

        $user->raise(new UserWasCreated($user));

        return $user;
    }
}
