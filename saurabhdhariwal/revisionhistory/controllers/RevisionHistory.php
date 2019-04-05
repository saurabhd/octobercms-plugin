<?php namespace SaurabhDhariwal\Revisionhistory\Controllers;

use Backend;
use BackendMenu;
use Backend\Classes\Controller;
use Artisan;
use Schema;
use Flash;
use ValidationException;
use Input;
use Illuminate\Http\Request;
use Redirect;
use Session;
use System\Models\Revision;

/**
 * Revision History Back-end Controller
 */
class RevisionHistory extends Controller
{

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Saurabhdhariwal.Revisionhistory', 'revisionhistory', 'revisionhistory');
    }

    public function revisionDetails($id,$modelName){
        return Redirect::to('/backend/saurabhdhariwal/revisionhistory/revisionhistory/revisions/?id='.$id.'&modelName='.$modelName);
    }

    public function revisions(){
        
        $id = \Request::get('id');
        $previous_url = url()->previous().'/update/'.$id;
        
        
        $modelName = \Request::get('modelName');
        

        $this->addCss('/plugins/saurabhdhariwal/revisionhistory/assets/css/style.css');
        $rsltModelData = $modelName::find($id);
         $this->vars['history'] = $rsltModelData->revision_history;
      
         
         $this->vars['record_id'] = $id;
         $this->vars['model_name'] = str_replace('\\', '/', $modelName);
        $record_history = array();
        $fieldwise_history = array();

        foreach ($this->vars['history']->reverse() as $record) {
            
            $date_time = $record['created_at'];
            $created_at = $date_time->format('Ymdhis');
            $field = $record['field'];
            $record_history[$created_at]['timestamp'] = $created_at;
            $record_history[$created_at]['created_at'] = $date_time->format('Y-m-d h:i:s');
            $record_history[$created_at]['username'] = $record->user->first_name . ' ' . $record->user->last_name;
            
            $record_history[$created_at]['fields'][$field]['id'] = $record->id;
            $record_history[$created_at]['fields'][$field]['name'] = $field;
            $record_history[$created_at]['fields'][$field]['diff'] = $record->getDiff();

            $fieldwise_history[$field][$created_at]['id'] = $record->id;
            $fieldwise_history[$field][$created_at]['name'] = $field;
            $fieldwise_history[$field][$created_at]['diff'] = $record->getDiff();

            $fieldwise_history[$field][$created_at]['timestamp'] = $created_at;
            $fieldwise_history[$field][$created_at]['created_at'] = $date_time->format('Y-m-d h:i:s');
            $fieldwise_history[$field][$created_at]['username'] = $record->user->first_name . ' ' . $record->user->last_name;
        }
        
        $this->vars['record_history'] = $record_history;
        $this->vars['previous_url'] = $previous_url;
        $this->vars['fieldwise_history'] = $fieldwise_history;
       

    }

    public function onRevertHistory(){
        $previous_url = Input::get('previous_url');
        
        $revision_id = Input::get('revision_id');
        $record_id  = Input::get('record_id');
        $model_name = str_replace('/', '\\', Input::get('model_name'));
        
        $record = $model_name::find($record_id);
        $history = Revision::find($revision_id); 
        $field = $history->field;
        $record->$field = $history->old_value;
        $record->save();
        Flash::success("The section has been update to its selected previous version");
        // return Redirect::to('/backend/saurabhdhariwal/revisionhistory/revisionhistory/revisions/?id='.$record_id.'&modelName='.$model_name);
        return Redirect::to($previous_url);
        
    }

    //
    // AJAX handlers
    //
    public function onRecordRevertHistory(){    
        $previous_url = Input::get('previous_url');
       
        $revision_ids = Input::get('revision_ids');
        $record_id = Input::get('record_id');
        $model_name = str_replace('/', '\\', Input::get('model_name'));
        

        $record = $model_name::find($record_id);
        $revision_ids = rtrim($revision_ids, ",");
        $arrRevisionIds = explode(",", $revision_ids);
        foreach ($arrRevisionIds as $index => $revision_id) {
            # code...
            $history = Revision::find($revision_id); 
            $field = $history->field;
            $record->$field = $history->old_value;
        }
        $record->save();
        Flash::success("The section has been update to its selected previous version");
        // return Redirect::to('/backend/saurabhdhariwal/revisionhistory/revisionhistory/revisions/?id='.$record_id.'&modelName='.$model_name);
        return Redirect::to($previous_url);
    }

    public function index(){
        

    }
}