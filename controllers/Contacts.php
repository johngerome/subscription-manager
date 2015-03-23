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

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('JohnGerome.Sm', 'sm', 'contacts');
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