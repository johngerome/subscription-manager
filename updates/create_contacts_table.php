<?php namespace JohnGerome\Sm\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateContactsTable extends Migration
{

    public function up()
    {
        Schema::create('johng_sm_contacts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('contact_att')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('johng_sm_contacts');
    }

}
