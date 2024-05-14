<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Entities\User;


// Evalform controller is the main controller used, it is responsible for all the methods involved in this web application.
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


    /** 
     * The index function is the landing page of the website.
     * The cards are taken from the global array above
     * 
     * @return view - The function will return a view and the data for the page
     */ 
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


    /**
     * This viewSurvey function is the page which displays the user's surveys they currently have.
     * 
     * @return view - The function will return a view and the data for the page
     *  */ 
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


    /**
     * The admin function is the main function used for the admin view on the website
     * 
     * @return view - The function will return a view and the data for the page
     *  */ 
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
            session()->setFlashdata('error', 'Users cannot access the admin page.');
            return redirect()->back(); 
        }

        // Shield model
        $model = auth()->getProvider();

        // Fetch search query
        $search = $this->request->getGet('search');

        $model
            ->select('users.id, users.username, auth_groups_users.group, auth_identities.secret, users.status, users.updated_at')
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'inner')
            ->join('auth_identities', 'users.id = auth_identities.user_id', 'inner');

        $searchableColumns = ['users.id', 'users.username', 'auth_groups_users.group', 'auth_identities.secret', 'users.status', 'users.updated_at'];

        // Apply search filter if search query is provided
        if (!empty($search)) {

            foreach ($searchableColumns as $column) {
                $model->orLike($column, $search);
            }
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


    /**
     * Login page using shield
     * 
     * @return view - The function will return the login view
     *  */ 
    public function login()
    {
        return view('login');
    }


    /**
     * Register page using shield
     * 
     * @return view - The function will return the register view
     *  */ 
    public function register()
    {
        return view('register');
    }


    /**
     * This function will be accessed when the user clicks on change status on the admin page
     * 
     * @param int $id - The user id that status is being changed
     * 
     * @return view - The function will return a view and the data for the page
     *  */ 
    public function changeStatus($id)
    {
        $model = auth()->getProvider();

        $user = $model->findById($id);

        // Determine whether currently active or not
        if ($user->isBanned()) {
            $user->unBan();
        } else {
            $user->ban('This user is currently archived.');
        } 

        return redirect()->back();
    }


    /**
     * This function is used to add a user to the users table. 
     * Its main challenge is validating the new user. It does so by checking if the username and email are unique
     * It will raise an error and display it if not valid, otherwise, a confirmation message will be displayed to the admin
     * 
     * @return view - The function will return back to the admin page using the back command
     *  */
    public function adduser()
    {
        $users = auth()->getProvider();

        $fields = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        // Check if all fields are filled
        foreach ($fields as $field => $value) {
            if (empty($value)) {
                session()->setFlashdata('error', 'All fields are required to create a user.');
                return redirect()->back()->withInput();
            }
        }

        // Check uniqueness
        $usernameExists = $users->where('username', $fields['username'])
                        ->countAllResults() > 0;

        $emailExists = $users->where('secret', $fields['email'])
                        ->join('auth_identities', 'users.id = auth_identities.user_id', 'inner')
                        ->countAllResults() > 0;

        // Display specific error messages if the data is not correct
        if ($usernameExists) {
            session()->setFlashdata('error', 'The username is already taken.');
            return redirect()->back()->withInput();
        }

        if ($emailExists) {
            session()->setFlashdata('error', 'The email address is already in use.');
            return redirect()->back()->withInput();
        }

        // Create and save the user
        $user = new User($fields);
        if (!$users->save($user)) {
            // Handle other validation errors
            session()->setFlashdata('error', 'There was an error creating the user.');
            return redirect()->back()->withInput();
        }

        // Get the newly created user's ID and perform additional actions
        $user = $users->findById($users->getInsertID());
        $users->addToDefaultGroup($user);
        $user->activate();

        session()->setFlashdata('success', 'User created successfully!');
        return redirect()->back();
    }


    /**
     * This function is used to edit a user in the users table. 
     * Its main challenge is validating the changes to the user. It does so by checking if the username and email are unique
     * It will raise an error and display it if not valid, otherwise, a confirmation message will be displayed to the admin
     * 
     * @return view - The function will return back to the admin page using the back command
     *  */
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

        // Check whether the username and email are unique
        $usernameExists = $users->where('username', $fields['username'])
                       ->countAllResults() > 1;

        $emailExists = $users->where('secret', $fields['email'])
                     ->join('auth_identities', 'users.id = auth_identities.user_id', 'inner')
                     ->countAllResults() > 1;

        // Display specific error messages if the data is not correct
        if ($usernameExists) {
            session()->setFlashdata('error', 'The username is already taken.');
            return redirect()->back()->withInput();
        }

        if ($emailExists) {
            session()->setFlashdata('error', 'The email address is already in use.');
            return redirect()->back()->withInput();
        }

        // If username and email are unique then save the data
        if (!$user->fill($fields) || !$users->save($user)) {
            
            // Handle other validation errors
            session()->setFlashdata('error', 'There was an error updating the user.');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'User updated successfully!');

        return redirect()->back(); 
    }


    /** 
     * The deleteSurvey function will use the survey model to delete a survey from the database
     * 
     * @return view - This function will return to the view surveys page.
     *  */ 
    public function deleteSurvey()
    {
        $model = new \App\Models\SurveyModel();
        
        $id = $this->request->getPost();
        
        $model->delete($id);

        return redirect()->back();
    }


    /**
     * The changeSurveyTitle function uses the survey model to change the title of a given survey
     * 
     * @return view - This function will return to the view surveys page.
     *  */ 
    public function changeSurveyTitle()
    {   
        $surveys = new \App\Models\SurveyModel();

        $survey = $this->request->getPost();

        $surveys->save($survey);

        return redirect()->back(); 
        
    }


    /**
     * The surveyViewer function is utilised across numerous methods in this controller.
     * It is used to get the questions and options for each question for the required survey.
     * 
     * @param int $id - The id of the survey that is being displayed
     * 
     * @return array - The survey data (questions and options for each question in the given survey)
     *  */ 
    private function surveyViewer($id)
    {   
        // Access all the relevant tables
        $surveys = new \App\Models\SurveyModel();
        $questions = new \App\Models\QuestionsModel();
        $options = new \App\Models\OptionsModel();

        $userId = auth()->user()->id;

        // This section will validate whether the survey shown belongs to the user
        $validSurveys = $surveys
                ->select('surveys.survey_id')
                ->where('surveys.user_id', $userId)
                ->where('surveys.survey_id', $id)
                ->first();

        // If survey is invalid then return a false validation
        if (is_null($validSurveys)) {
            $data['surveyValid'] = false;
            return $data;
        }

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
            'surveyValid' => true,
            'id' => $id,
            'title' => $survey['title'],
            'questions' => $surveyQuestions,
            'options' => $optionsByQuestion
        ];

        return $data;
    }


    /**
     * This function gets the data from surveyViewer and returns it to the survey view
     * 
     * @param int $id - The id of the survey that is being displayed 
     * 
     * @return view - The function will return a view and the data for the page
     *  */ 
    public function viewSurvey($id)
    {
        $data = $this->surveyViewer($id);

        if (!$data['surveyValid']) {
            return redirect()->back();
        }

        $user = auth()->user();
        
        // re-direct user if they are not permitted
        if (!is_null($user) && $user->inGroup('admin')) {
            return redirect()->back();
        }

        return view('survey', $data);
    }


    /**
     * This function gets the data from surveyViewer and returns it to the respondent survey view
     * 
     * @param int $id - The id of the survey that is being displayed 
     * 
     * @return view - The function will return a view and the data for the page
     *  */ 
    public function respondentSurvey($id)
    {   
        $data = $this->surveyViewer($id);

        $user = auth()->user();
        
        if (!is_null($user)) {
            return redirect()->back();
        }
        
        // A respondent is not a user so this data is removed 
        unset($data['userType']);

        return view('respondentSurvey', $data);
    }


    /**
     * This function returns a QR code based off a get request to the QR code view
     * 
     * @param $id - The id of the survey that the QR code is being generated for
     * 
     * @return view - The function will return a view and the data for the page
     *  */ 
    public function getQRCodes($id)
    {
        
        $url = 'https://infs3202-42fc98bb.uqcloud.net/evalform/respondent-survey/' . $id;

        $data['url'] = $url;

        $user = auth()->user();
        
        // re-direct user if they are not permitted
        if (!is_null($user) && $user->inGroup('admin')) {
            return redirect()->back();
        }
        return view('qrcode', $data);
    }


    /**
     * This function will process all the responses submitted by the respondent
     * It then updates the tables in the database
     * 
     * @param int $id - the id of the survey that the respondent has just completed
     * 
     * @return view - A success page that informs the responent they have been successful
     *  */ 
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


    /**
     * This function returns the viewResponses view and also returns the respondent data to the view
     * This function uses the surveyViewer method to display the questions and then returns the responses from the responses model
     * 
     * @param int $id - the id of the survey that is being displayed on the page
     * 
     * @return view - The function will return a view and the data for the page
     *  */ 
    public function viewResponses($id)
    {

        // Get the data from the surveyViewer function in order to display the quesitons
        $data = $this->surveyViewer($id);

        // Access the relevant tables
        $responses = new \App\Models\ResponsesModel();
        $questionsModel = new \App\Models\QuestionsModel();

        if (!$data['surveyValid']) {
            return redirect()->back();
        }

        // Pass all the responses to the view so they can be sorted depending on the question
        $allResponses = $responses->findAll();
        $data['responses'] = $allResponses;

        $user = auth()->user();
        
        // re-direct user if they are not permitted
        if (!is_null($user) && $user->inGroup('admin')) {
            return redirect()->back();
        }


        return view('viewResponses', $data);
    }


    /**
     * The function is what is responsible for exporting the responses for a given survey
     * 
     * @param int $id - the id of the survey which the results want to be exported
     * 
     * @return fputcsv - A CSV file is downloaded which contains the data and time in the title. It contains the data for the survey.
     *  */ 
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


    /**
     * This function uses the surveyViewer method to display the survey on the edit survey view
     * 
     * @param int $id - The id of the survey that is being displayed on the edit survey page
     * 
     * @return view - The function will return a view and the data for the page
     *  */ 
    public function editSurvey($id)
    {

        $data = $this->surveyViewer($id);

        $user = auth()->user();

        if (!$data['surveyValid']) {
            return redirect()->back();
        }

        // re-direct user if they are not permitted
        if (!is_null($user) && $user->inGroup('admin')) {
            return redirect()->back();
        }

        return view('editSurvey', $data);
    }


    /**
     * This function gets the title of the new survey and inserts the new survey into the table
     * This function also automatically re-directs the user to edit the new survey they have created.
     * 
     * @return view - This function will go to the edit survey page for the specific survey they have just created
     *  */ 
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


    /**
     * This function allows for a question to be added on the edit survey page
     * 
     * @param int $id - The id of the survey that the new question is being added to
     * 
     * @return view - This function will  re-direct back to the edit survey view that is was already on prior to the post request
     *  */ 
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


    /**
     * This function accesses the questions table and will delete the question if the delete button is clicked
     * 
     * @param int $id - the id of the survey that the question is being deleted from
     * 
     * @return view - This function will  re-direct back to the edit survey view that is was already on prior to the post request
     *  */ 
    public function deleteQuestion($id)
    {

        $questionId = $this->request->getPost('question_id');  

        // Delete question from table
        $model = new \App\Models\QuestionsModel();
        $model->delete($questionId);

        return redirect()->to('view-surveys/' . $id . '/edit-survey');
    }
}


