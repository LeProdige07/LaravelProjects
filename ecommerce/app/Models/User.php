<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function evaluations()
    {

      return $this->hasMany(Evaluation::class,'user_id');
    }
    public function groups(){
        return $this->belongsToMany(Group::class,"group_users", "user_id", "group_id");
    }
    //utilisation $user->hasGroup('nameGroup')
    public function hasGroup($group){
        return $this->groups()->where("name", $group)->first() !== null;
    }
    //utilisation $user->hasAnyGroup(['group1', 'group2'])
    public function hasAnyGroup($groups){
        return $this->groups()->whereIn("name", $groups)->first() !== null;
    }
    public function getRolesUser()
    {
        $roleName = "";
        $i = 0;
        foreach ($this->roles as $role) {
            $roleName .= $role->name;
            if ($i < sizeof($this->roles) - 1) {
                $roleName .= ",";
            }
            $i++;
        }
        return $roleName;
    }
    public function getGroupsUser(){
        $groupName = "";
        $i = 0;

        foreach($this->groups as $group){
            $groupName .=$group->name;

            if($i < sizeof($this->groups) - 1){
                $groupName .= ",";
            }

            $i++;
        }

        return $groupName;

    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles','user_id', 'role_id');
    }

    public function hasRole($role){
        return $this->roles()->where("name", $role)->first() !== null;
    }
    public function checkAdmin()
    {
        return $this->roles()->where("name", "Admin")->first() !== null;
    }
    public function isAuthorized($object, $operation)
    {
        if ($this->checkAdmin()) {
            return true;
        } else {
            $query = Db::table('role_permissions')
                ->where('object', $object)
                ->where('operation', $operation)
                ->join('user_roles', 'user_roles.role_id', '=', 'role_permissions.role_id')
                ->where('user_roles.user_id', $this->id)
                ->get();
            if ($query->count() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function assignRole($id)
    {
        $this->roles()->attach($id);
    }

}
