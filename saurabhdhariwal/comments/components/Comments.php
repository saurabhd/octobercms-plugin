<?php

namespace SaurabhDhariwal\Comments\Components;

//use Backend\Controllers\Auth;
use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Request;
use SaurabhDhariwal\Comments\Models\Settings;
use Validator;
use Auth;
use SaurabhDhariwal\Comments\Models\Comments as CommentsModel;

/**
 * Class Comments
 * @package SaurabhDhariwal\Comments\Components
 */
class Comments extends ComponentBase
{

    /**
     * @var The current url path without domain
     */
    public $url;
    /**
     * @var The list comments from database for current page
     */
    public $posts;
    /**
     * @var number comments for page
     */
    public $count;

    /**
     * @return array
     */
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->url = mb_strtolower(Request::path());
    }

    public function componentDetails()
    {
        return [
            'name' => 'Comments',
            'description' => 'Displays a list of comments on the page.'
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function settings()
    {
        return [
            'allow_guest' => Settings::get('allow_guest', false),
            'recaptcha_enabled' => Settings::get('recaptcha_enabled', false),
            'site_key' => Settings::get('site_key', false)

        ];

    }

    /**
     *
     */
    public function onRun()
    {
        parent::onRun(); // TODO: Change the autogenerated stub
        $this->addCss('/plugins/saurabhdhariwal/comments/assets/css/comments.css');
        $this->addJs('/plugins/saurabhdhariwal/comments/assets/js/comments.js');
        if (Settings::get('recaptcha_enabled')) {
            $this->addJs('https://www.google.com/recaptcha/api.js');
        }
        $this->posts = $this->page['posts'] = $this->listPosts();       
    }

    /**
     * @return array
     */
    public function onSaveCommentButton()
    {

        if (!Auth::check()) { // A user is NOT logged in
            $formValidation['email'] = 'required|email';
            $formValidation['author'] = 'required|alpha|min:2|max:25';
            $formValidation['content'] = 'required|min:2|max:500';
        }else{  // A user is logged in
            // no need to check email or author 
            // form.htm only shows comment field when user is logged in
            $formValidation['content'] = 'required|min:2|max:500';
        }

        $validator = Validator::make(post(), $formValidation);


        // check Validator
        if ($validator->fails()) {
            return [
                'message' => $validator->messages()
            ];
        }

        // check ReCaptcha
        if (Settings::get('recaptcha_enabled')) {
            $check = $this->checkCaptcha();
            if ($check['success'] != true) {
                return ['message' => ['captcha' => ['invalid Captcha']]];
            }
        }

        return $this->saveComment();

    }

    /**
     * @return array
     */
    public function saveComment()
    {
        $model = new CommentsModel();
        $model->content = strip_tags(post('content'));
        $model->url = $this->url;
        $parent_id = post('parent_id');
        if(is_numeric($parent_id)){
            $model->parent_id = $parent_id; 
        }

        if (Settings::get('allow_guest')) {
            $model->author = post('author');
            $model->email = post('email');
        } else {
			if (Auth::check()) {
				$user = Auth::getUser();

				$model->author = $user->username;
				$model->email = $user->email;
				$model->user_id = $user->id;
			} else {
				$model->author = null;
				$model->email = null;
			}
        }
        
        $model->status = Settings::get('status', 1);
        if ($model->save() && $model->status == 1) {
            return ['content' => $this->renderPartial('@list.htm', ['posts' => [$model]])];
        }
    }

    /**
     * @return array
     */
    protected function listPosts()
    {
        $comments = CommentsModel::where(['url' => $this->url, 'status' => CommentsModel::STATUS_APPROVED])->get();
        $this->count = count($comments);
        return $this->buildTree($comments);
    }


    /**
     * @param $elements
     * @param int $parentId
     * @return array
     */
    public function buildTree($elements, $parentId = 0)
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->id);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element->id] = $element;
//                unset($elements[$element->id]);
            }
        }
        return $branch;
    }

    /**
     * @return mixed
     */
    public function checkCaptcha()
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $secret = Settings::get('secret_key');
        $response = post('g-recaptcha-response');
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $q = [
            'secret' => $secret,
            'response' => $response,
            'remoteip' => $remoteip
        ];
        $response = file_get_contents($url . '?' . http_build_query($q));
        return json_decode($response, true);
    }

}
