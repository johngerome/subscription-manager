<?php namespace JohnGerome\Sm\Models;

use Model;
use JohnGerome\Sm\Models\Project;

/**
 * Contact Model
 */
class Contact extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'johng_sm_contacts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    protected $rules = [
        'email' => 'required|email',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['firstname', 'lastname', 'email', 'latitude', 'longitude', 'contact_att'];

    public $belongsToMany = [
        'projects' => [
            'JohnGerome\Sm\Models\Project',
            'table'    => 'johng_sm_contacts_projects',
            'order'    => 'name ASC',
            'key'      => 'contact_id',
            'otherKey' => 'project_id'
        ]
    ];

     /**
     * @return array of Project Name
     */
    public function getNameOptions() {
        return Project::lists('name', 'id');
    }

}