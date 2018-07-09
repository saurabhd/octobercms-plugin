<?php 

namespace SaurabhDhariwal\Comments\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSaurabhdhariwalCommentsPosts3 extends Migration
{
    public function up()
    {
        Schema::table('saurabhdhariwal_comments_posts', function($table)
        {
            $table->dropColumn('post_id');
        });
    }
    
    public function down()
    {
        Schema::table('saurabhdhariwal_comments_posts', function($table)
        {
            $table->integer('post_id')->nullable();
        });
    }
}
