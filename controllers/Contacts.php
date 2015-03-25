<?php namespace JohnGerome\Sm\Controllers;

use Flash;
use DB;
use Lang;
use BackendMenu;
use Backend\Classes\Controller;
use johnGerome\Sm\Models\Contact;
use johnGerome\Sm\Models\Project;

/**
 * Contacts Back-end Controller
 */
class Contacts extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['johngerome.sm.contacts'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('JohnGerome.Sm', 'sm', 'contacts');
    }

    public function index() {
        $projects = array();
        $i = 0;
        foreach(Project::all() as $project) {
                $projects[$i]['color'] = $project['color'];
                $projects[$i]['name']  = $project['name'];
                $projects[$i]['numContact']  = DB::table('johng_sm_contacts_projects')
                                                ->where('project_id', $project['id'])
                                                ->count();
                $i++;
        }
        $this->vars['projects'] = $projects;
        $this->asExtension('ListController')->index();
    }

    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $contactId) {
                if (!$contact = Contact::find($contactId))
                    continue;

                $contact->delete();
                // Delete Also on Contacts Projects
                DB::table('johng_sm_contacts_projects')
                    ->where('contact_id', $contactId)
                    ->delete();
            }

            Flash::success(Lang::get('johngerome.sm::lang.contacts.delete_contacts_success'));
        }

        return $this->listRefresh();
    }
}