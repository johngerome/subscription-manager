<?php namespace JohnGerome\Sm\Components;

use Response;
use Cms\Classes\ComponentBase;
use JohnGerome\Sm\Models\Project;
use JohnGerome\Sm\Models\Contact;

class Subscriber extends ComponentBase
{

  public function componentDetails() {
    return [
      'name'        => 'johngerome.sm::lang.subscribe.com_name',
      'description' => 'johngerome.sm::lang.subscribe.com_description'
    ];
  }

  public function defineProperties() {
    return [
      'project' => [
          'title'     => 'johngerome.sm::lang.projects.project_name',
          'type'      => 'dropdown',
          'required'  => true,
          'options'   => $this->getProjectOptions(),
        ],
      'firstname' => [
          'title'     => 'johngerome.sm::lang.subscribe.display_firstname',
          'type'      => 'checkbox',
      ],
      'lastname' => [
          'title'     => 'johngerome.sm::lang.subscribe.display_lastname',
          'type'      => 'checkbox',
      ],
    ];
  }

  public function onRun()
  {
     $this->page['project']          = $this->property('project');
     $this->page['displayFirstName'] = $this->property('firstname');
     $this->page['displayLastName']  = $this->property('lastname');
     $this->page['contact_att']       = (isset($_GET)) ? json_encode($_GET) : '';
     $this->addJs('/plugins/johngerome/sm/assets/js/geo.js');
  }

  public function getProjectOptions() {
     return Project::lists('name', 'id');
  }

  public function onAddSubscriber() {
    $error   = false;
    $message = 'Thank You for Subscribing';

    $project_id   = post('project');
    $data = [
        "email"        => post('email'),
        "firstname"    => post('firstname'),
        "lastname"     => post('lastname'),
        "latitude"     => post('latitude'),
        "longitude"    => post('longitude'),
        "contact_att"  => post('contact_att'),
    ];

    try{

        if(!Project::find($project_id)) {
          $error = true;
          $message = 'Project Not Found!';
        }
        else {
          $contact = Contact::create($data);
          $contact->projects()->attach($project_id);
        }

        $this->page['result'] = $message;
    }
    catch (\Exception $e){
        $this->page['error'] = $error;
        $this->page['result'] = $e->getMessage();
    }
  }
}
