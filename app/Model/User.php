<?php namespace Task\Model;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Task\Service\Presenter\Presentable;

/**
 * Task\Model\User
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property integer $logout_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\User whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\User whereFirstName($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\User whereLastName($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\User whereEmail($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\User whereLogoutAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\User whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Task\Model\User whereUpdatedAt($value) 
 */
class User extends Eloquent implements UserInterface
{
    use Presentable;

    protected $presenterName = 'Task\Model\User\Presenter';

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
        return $this->belongsToMany('Task\Model\Project', 'user_projects');
    }

    public function createOneTimeToken()
    {
        $this->one_time_token = \Str::random(32);
    }
}
