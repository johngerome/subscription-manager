<?php namespace JohnGerome\Sm\Controllers;

use Flash;
use BackendMenu;
use Backend\Classes\Controller;
use johnGerome\Sm\Models\Contact;

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
        $this->addJs('/plugins/johngerome/sm/assets/js/tableExport.js');
        $this->addJs('/plugins/johngerome/sm/assets/js/jquery.base64.js');
        $this->addJs('/plugins/johngerome/sm/assets/js/backend.js');
    }

    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $contactId) {
                if (!$contact = Contact::find($contactId))
                    continue;

                $contact->delete();
            }

            Flash::success('johngerome.sm::lang.contacts.delete_contacts_success');
        }

        return $this->listRefresh();
    }
}