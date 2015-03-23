<?php namespace JohnGerome\Sm\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProjectsTable extends Migration
{

    public function up()
    {
        Schema::create('johng_sm_projects', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('johng_sm_contacts_projects', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('contact_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->primary(['contact_id', 'project_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('johng_sm_projects');
        Schema::dropIfExists('johng_sm_contacts_projects');
    }

}
