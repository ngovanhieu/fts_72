<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'chatwork_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the exams for the user.
     */
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Get the questions for the user.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Check if current user is admin.
     *
     * @param  void
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role == config('user.role.admin');
    }

    public function isCurrent()
    {
        return auth()->check() && auth()->id() == $this->id;
    }

    public function isMember()
    {
        return $this->role == config('user.role.member');
    }

    public function delete()
    {
        $this->exams()->delete();

        return parent::delete();
    }
}
