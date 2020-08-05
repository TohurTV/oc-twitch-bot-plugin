<?php namespace Tohur\Bot\Models;

use Model;
use Tohur\Bot\Models\Users;
use Tohur\Bot\Models\Roles;

/**
 * Permissions Model
 */
class Permission extends Model
{
    use \October\Rain\Database\Traits\Validation;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tohur_bot_botpermissions_permissions';

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required',
    ];

    public $belongsToMany = [
        'users' => ['Tohur\Bot\Models\Users',
            'table' => 'tohur_bot_botpermissions_user_permission',
            'key' => 'permission_id',
            'otherKey' => 'user_id',
            'timestamps' => true,
            'pivot' => ['permission_state'],
        ],
        'roles' => ['Tohur\Bot\Models\Roles',
            'table' => 'tohur_bot_botpermissions_role_permission',
            'key' => 'permission_id',
            'otherKey' => 'role_id',
            'timestamps' => true,
        ],
    ];

    public function beforeSave()
    {
        $this->setCodeIfEmpty();
        $this->sluggifyCode();
    }

    protected function setCodeIfEmpty()
    {
        if (empty($this->code)) {
            $this->code = str_slug($this->name, '-');
        }
    }

    protected function sluggifyCode()
    {
        $this->code = str_slug($this->code, '-');
    }

    public function afterCreate()
    {
        $this->addNewPermissionToUsers();
    }

    protected function addNewPermissionToUsers()
    {
        $users = Users::all();
        if($users) {
            foreach($users as $user) {
                $user->user_permissions()->attach($this->id, ['permission_state' => 2]);
            }
        }
    }
}
