<?php namespace App\Controllers;

use CodeIgniter\Controller;

class EvalformController extends BaseController
{

    const CARDS = array(
        array(
            'title' => 'Create Surveys',
            'text' => 'Choose from a variety of question types to generate your specific survey.'
        ),
        array(
            'title' => 'Visualise Your Responses',
            'text' => 'EvalForm does all the hard work for you by producing simple charts for your responses.'
        ),
        array(
            'title' => 'Export Your Responses',
            'text' => 'Say goodbye to having to manually export data, EvalForm does it for you!'
        )
    );

    public function __construct()
    {
        // Load the URL helper, it will be useful in the next steps
        // Adding this within the __construct() function will make it 
        // available to all views in the ResumeController
        helper('url'); 
    }

    public function index()
    {  
        if (auth()->loggedIn()) {
            $data['name'] = auth()->user()->username;
        }
        
        $data['cards'] = self::CARDS;
        return view('index', $data);
    }

    public function viewSurveys()
    {
        return view('viewSurveys');
    }

    public function createSurvey()
    {
        return view('createSurvey');
    }

    public function admin()
    {

        $user = auth()->user();
        $data['cards'] = self::CARDS;
        
        if (auth()->loggedIn()) {
            $data['name'] = auth()->user()->username;
        }

        if (!auth()->loggedIn()) {
            return view('login');
        }

        if ($user->inGroup('user')) {
            session()->setFlashdata('error', 'You do not have the required permissions.');
            return redirect()->back(); // Or redirect to another suitable page  
            // return view('index', $data);
        }

        return view('admin');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function landing()
    {

        $cards = array(
            array(
                'title' => 'Create Surveys',
                'text' => 'Choose from a variety of question types to generate your specific survey.'
            ),
            array(
                'title' => 'Visualise Your Responses',
                'text' => 'EvalForm does all the hard work for you by producing simple charts for your responses.'
            ),
            array(
                'title' => 'Export Your Responses',
                'text' => 'Say goodbye to having to manually export data, EvalForm does it for you!'
            )
        );

        $data['cards'] = $cards;
        return view('landing', $data);
    }
}


