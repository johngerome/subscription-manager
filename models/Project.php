<?php namespace JohnGerome\Sm\Models;

use Model;

/**
 * Project Model
 */
class Project extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'johng_sm_projects';


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    protected $rules = [
        'name'  => 'required|unique:johng_sm_projects',
        'color' => 'required',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'color'];

    public $belongsToMany = [
        'contacts' => [
            'JohnGerome\Sm\Models\Contact',
            'table'    => 'johng_sm_contacts_projects',
            'key'      => 'contact_id',
            'otherKey' => 'project_id'
        ]
    ];


    public function scopeListProjectName($query) {
        return $query->lists('name');
    }

}