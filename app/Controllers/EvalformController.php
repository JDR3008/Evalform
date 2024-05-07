<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Entities\User;

class EvalformController extends BaseController
{
    // These are the cards that are to be displayed on the landing page of the website
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


    // The index function is the landing page of the website.
    // The cards are taken from the global array above
    public function index()
    {
        // assign current user using shield
        $user = auth()->user();
        
        // Check if user is logged in
        if (auth()->loggedIn()) {
            $data['name'] = auth()->user()->username;
            $data['userType'] = 'user';
        }

        // re-direct user if they are not permitted
        if (!is_null($user) && $user->inGroup('admin')) {
            return redirect()->back();
        }
        
        // Assign cards to data
        $data['cards'] = self::CARDS;
        return view('index', $data);
    }


    // This viewSurvey function is the page which displays the user's surveys they currently have.
    public function viewSurveys()
    {
        // assign current user using shield
        $user = auth()->user();
        $userId = $user->id;

        // Check if user is logged in
        if (auth()->loggedIn()) {
            $data['name'] = auth()->user()->username;
            $data['userType'] = 'user';
        }

        // re-direct user if they are not permitted
        if (!is_null($user) && $user->inGroup('admin')) {
            return redirect()->back();
        }

        $model = new \App\Models\SurveyModel();

        $surveys = $model->findAll();

        // Assign relevant values and return them
        $data['surveys'] = $model
            ->orderBy('updated_at','DESC')
            ->where('user_id', $userId)
            ->findAll();

        return view('viewSurveys', $data);
    }

    // The admin function is the main function used for the admin view on the website
    public function admin()
    {
        $user = auth()->user();
        $data['cards'] = self::CARDS;

        // Check if user is logged in
        if (auth()->loggedIn()) {
            $data['name'] = auth()->user()->username;
            $data['userType'] = 'admin';
        }


        if (!auth()->loggedIn()) {
            return redirect()->back();
        }

        // If a user tries to access admin page, deny access
        if ($user->inGroup('user')) {
            session()->setFlashdata('error', 'You do not have the required permissions.');
            return redirect()->back(); 
        }

        // Shield model
        $model = auth()->getProvider();

        // Fetch search query
        $search = $this->request->getGet('search');

        $model
            ->select('users.id, users.username, auth_groups_users.group, auth_identities.secret, users.active, users.updated_at')
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'inner')
            ->join('auth_identities', 'users.id = auth_identities.user_id', 'inner');

        $searchableColumns = ['users.id', 'users.username', 'auth_groups_users.group', 'auth_identities.secret', 'users.active', 'users.updated_at'];

        // Apply search filter if search query is provided
        if (!empty($search)) {
            $conditions = [];

            foreach ($searchableColumns as $column) {
                $conditions[] = $column . " LIKE '%$search%'";
            }

            $whereClause = implode(' OR ', $conditions);

            $model->where($whereClause);
        }

        // Paginate the results
        $perPage = 6; // Maximum results per page

        // Fetch paginated users
        $users = $model->paginate($perPage);

        // Pass paginated users and pager to the view
        $data['users'] = $users;
        $data['pager'] = $model->pager;
        

        return view('admin', $data);
    }

    // Login page using shield
    public function login()
    {
        return view('login');
    }

    // Register page using shield
    public function register()
    {
        return view('register');
    }

    // This function will be accessed when the user clicks on change status on the admin page
    public function changeStatus($id)
    {
        $model = auth()->getProvider();

        $user = $model->findById($id);

        // Determine whether currently active or not
        if ($user->active) {
            $user->deactivate();
        } else {
            $user->activate();
        } 

        return redirect()->back();
    }
    
    // This function is responsible for being able to add a user to the site from the admin page
    public function adduser()
    {
        $users = auth()->getProvider();

        // Create new user using shield and post request from view
        $user = new User([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);
        $users->save($user);

        $user = $users->findById($users->getInsertID());

        $users->addToDefaultGroup($user);
        $user->activate();

        return redirect()->back();   
    }

    // This function is responsible for being able to edit a user to the site from the admin page
    public function edituser()
    {
        $users = auth()->getProvider();

        $id = $this->request->getPost('id');

        $user = $users->findById($id);

        // Edit a user using shield and the post request from view
        $fields = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        // This section checks if the user has changed their password or not (since it is not displayed on the modal)
        if (!empty($this->request->getPost('password'))) {
            $fields["password"] = $this->request->getPost('password');
        }

        $user->fill($fields);

        $users->save($user);

        return redirect()->back(); 
    }

    // The deleteSurvey function will use shield to delete a user from the user table
    public function deleteSurvey($id)
    {
        $model = new \App\Models\SurveyModel();
        $model->delete($id);

        return redirect()->back();
    }

    // The changeSurveyTitle function uses the survey model to change the title of a given survey
    public function changeSurveyTitle()
    {   
        $surveys = new \App\Models\SurveyModel();

        $survey = $this->request->getPost();

        $surveys->save($survey);

        return redirect()->back(); 
        
    }

    // The surveyViewer function is utilised across numerous methods in this controller.
    // It is used to get the questions and options for each question for the required survey.
    private function surveyViewer($id)
    {
        // Access all the relevant tables
        $surveys = new \App\Models\SurveyModel();
        $questions = new \App\Models\QuestionsModel();
        $options = new \App\Models\OptionsModel();

        $survey = $surveys->find($id);

        // Find all the questions that are in the survey
        $surveyQuestions = $questions
        ->where('survey_id', $id)->findAll();

        $questionIds = array_column($surveyQuestions, 'question_id');

        // Find all the options for the quesations that are apart of the survey
        $optionsByQuestion = []; 
        foreach ($questionIds as $questionId) {
            $optionsByQuestion[$questionId] = $options
                                    ->where('question_id', $questionId)
                                    ->findAll();
        }

        // Return the relevant data
        $data = [
            'userType' => "user",
            'id' => $id,
            'title' => $survey['title'],
            'questions' => $surveyQuestions,
            'options' => $optionsByQuestion
        ];

        return $data;
    }


    // This function gets the data from surveyViewer and returns it to the survey view
    public function viewSurvey($id)
    {
        $data = $this->surveyViewer($id);

        return view('survey', $data);
    }

    // This function gets the data from surveyViewer and returns it to the survey view
    public function respondentSurvey($id)
    {   
        $data = $this->surveyViewer($id);
        
        // A respondent is not a user so this data is removed 
        unset($data['userType']);

        return view('respondentSurvey', $data);
    }

    // This function returns a QR code based off a get request to the QR code view
    public function getQRCodes($id)
    {
        
        $url = 'https://infs3202-42fc98bb.uqcloud.net/evalform/respondent-survey/' . $id;

        $data['url'] = $url;

        return view('qrcode', $data);
    }

    // This function will process all the responses submitted by the respondent
    // It then updates the tables in the database
    public function submitResponses($id)
    {

        // Access all the relevant tables in the database
        $responses = new \App\Models\ResponsesModel();
        $surveys = new \App\Models\SurveyModel();
        $questionsModel = new \App\Models\QuestionsModel();

        // Find the survey
        $survey = $surveys->find($id);

        // Load questions for this survey
        $questions = $questionsModel->where('survey_id', $survey['survey_id'])->findAll();

        $postData = $this->request->getPost(); 


        // Check whether the response is null or not. If there is data, it will then add it to the responses table
        for ($i = 0; $i < count($questions); $i++) {
            $responseText = null;

            if (isset($postData['question_' . ($i + 1)])) { 
                $responseText = $postData['question_' . ($i + 1)];  
            } elseif (isset($postData['text_answer_' . ($i + 1)])) { 
                $responseText = $postData['text_answer_' . ($i + 1)]; 
            }

            if ($responseText !== null && !empty($responseText)) {
                $responses->insert([ 
                    'question_id' => $questions[$i]['question_id'], 
                    'response' => $responseText 
                ]);
            }
        }

        // Return a success page after submit responses is clicked
        return view('success');
    }


    // This function returns the viewResponses view and also returns the respondent data to the view
    public function viewResponses($id)
    {

        // Get the data from the surveyViewer function in order to display the quesitons
        $data = $this->surveyViewer($id);

        // Access the relevant tables
        $responses = new \App\Models\ResponsesModel();
        $questionsModel = new \App\Models\QuestionsModel();

        // Pass all the responses to the view so they can be sorted depending on the question
        $allResponses = $responses->findAll();
        $data['responses'] = $allResponses;


        return view('viewResponses', $data);
    }


    // The function is what is responsible for exporting the responses for a given survey
    public function exportResponses($id)
    {
        // Access the relevant tables
        $responses = new \App\Models\ResponsesModel();
        $questionsModel = new \App\Models\QuestionsModel();


        $questions = $questionsModel->where('survey_id', $id)->findAll();
        $questionIds = array_column($questions, 'question_id'); 
        $responses = $responses->whereIn('question_id', $questionIds)->findAll();


        // Convert the data in the tables into a .csv file. This file is then downloaded when the button is clicked.
        header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=responses-' . date("Y-m-d-h-i-s") . '.csv');
        $output = fopen('php://output', 'w');

        fputcsv($output, array('Id', 'Question ID', 'Response'));

        foreach ($responses as $response) {
            $response_row = [
                $response['response_id'],
                $response['question_id'],
                $response['response']
            ];

            fputcsv($output, $response_row);
        }
    }

    // This function uses the surveyViewer method to display the survey on the edit survey view
    public function editSurvey($id)
    {

        $data = $this->surveyViewer($id);

        return view('editSurvey', $data);
    }

    // This function gets the title of the new survey and inserts the new survey into the table
    // This function also automatically re-directs the user to edit the new survey they have created.
    public function createSurvey()
    {
        $surveys = new \App\Models\SurveyModel();

        $userId = auth()->user()->id;
        $title = $this->request->getPost('title');

        $data = [
            'user_id' => $userId,
            'title' => $title
        ];

        $surveys->insert($data);

        return redirect()->to('view-surveys/' . $surveys->getInsertID() . '/edit-survey');  
    }


    // This function allows for a question to be added on the edit survey page
    public function addQuestion($id)
    {   

        // Access the relevant tables
        $questions = new \App\Models\QuestionsModel();
        $options = new \App\Models\OptionsModel();

        $question = $this->request->getPost('question');

        // Get the data about the new question
        $questionData = [
            'survey_id' => $id,
            'question' => $question
        ];

        // Insert into the question table
        $questions->insert($questionData);


        // This section of the function checks if the new question has multiple choice answers or not
        // If it does not, it is ignored, if it does, it will insert them into the options table
        for ($i = 0; $i < 4; $i++) {
            if (!empty($this->request->getPost('option' . ($i + 1)))) {
                $optionsData['question_id'] = $questions->getInsertID();
                $optionsData["option_text"] = $this->request->getPost('option' . ($i + 1));
                $options->insert($optionsData);
            }
        }
        
        return redirect()->to('view-surveys/' . $id . '/edit-survey');
    }


    // This function accesses the questions table and will delete the question if the delete button is clicked
    public function deleteQuestion($id)
    {

        $questionId = $this->request->getPost('question_id');  

        // Delete question from table
        $model = new \App\Models\QuestionsModel();
        $model->delete($questionId);

        return redirect()->to('view-surveys/' . $id . '/edit-survey');
    }


}


