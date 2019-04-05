<?php namespace SaurabhDhariwal\Revisionhistory\Models;
 
use SaurabhDhariwal\Revisionhistory\Controllers\RevisionHistory as RevisionHistoryController; 

use Model;

/**
 * RevisionHistory Model
 */
class RevisionHistory extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'saurabhdhariwal_revisionhistory_configuration';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    
}
