<?php 

namespace SaurabhDhariwal\Comments\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSaurabhdhariwalCommentsPosts extends Migration
{
    public function up()
    {
        Schema::table('saurabhdhariwal_comments_posts', function($table)
        {
            $table->string('url', 70)->index();
            $table->dropColumn('type');
        });
    }
    
    public function down()
    {
        Schema::table('saurabhdhariwal_comments_posts', function($table)
        {
            $table->dropColumn('url');
            $table->string('type', 20)->nullable();
        });
    }
}
