<?php 

namespace SaurabhDhariwal\Comments\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSaurabhdhariwalCommentsPosts2 extends Migration
{
    public function up()
    {
        Schema::table('saurabhdhariwal_comments_posts', function($table)
        {
            $table->string('content', 500)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('saurabhdhariwal_comments_posts', function($table)
        {
            $table->text('content')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
