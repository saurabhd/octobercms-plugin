<?php 
namespace SaurabhDhariwal\Revisionhistory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSaurabhdhariwalRevisionhistoryConfiguration extends Migration
{
    public function up()
    {
        Schema::create('saurabhdhariwal_revisionhistory_configuration', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('option_name');
            $table->text('option_value');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('saurabhdhariwal_revisionhistory_configuration');
    }
}
