<?php namespace JohnGerome\Sm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use JohnGerome\Sm\Models\Project;

/**
 * Projects Back-end Controller
 */
class Projects extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['johngerome.sm.projects'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('JohnGerome.Sm', 'sm', 'projects');

        $this->addCss('/plugins/johngerome/sm/assets/css/johngerome-sm.css');
    }
}