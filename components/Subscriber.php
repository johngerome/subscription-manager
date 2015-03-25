<?php namespace JohnGerome\Sm\Components;

use Response;
use Mail;
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

    $project_id = post('project');
    $data = [
        "email"        => post('email'),
        "firstname"    => post('firstname'),
        "lastname"     => post('lastname'),
        "latitude"     => post('latitude'),
        "longitude"    => post('longitude'),
        "contact_att"  => post('contact_att'),
        "debug"        => (post('debug')) ? post('debug') : false,
    ];

    try{

        if(!Project::find($project_id)) {
          $error   = true;
          $message = 'Project Not Found!';
        }
        else {
          // Add Contact to the Database.
          $contact = Contact::create($data);
          $contact->projects()->attach($project_id);

          // Send eMail
          $sm = $this->onSendMail($data);

          $this->page['result'] = $message;
        }
    }
    catch (\Exception $e) {
        $this->page['error']  = $error;
        $this->page['result'] = $e->getMessage();
    }
  }

  public function onSendMail($data = array()) {
    $result = true;
    $debug  = $data['debug'];
    try {
      $explodeEmail = explode("@", $data['email']);
      array_pop($explodeEmail);
      $usernameEmail = join('@', $explodeEmail);

      $toName = ($data['firstname']) ? $data['firstname'] : $usernameEmail;
      $params = ['name' => $toName];

      Mail::send('johngerome.sm::mail.confirmed_opt_in', $params, function($message) use ($data)
      {
          // $message->from('jessicasanders@gsapparel.org', 'Jessica Sanders');
          $message->to($data['email']);
      });
    }
    catch (\Exception $e) {
        $result = false;
        if($debug) {
          $result = $e;
        }
    }
    return $result;
  }
}
