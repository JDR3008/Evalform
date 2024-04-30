<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Entities\User;

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
        $user = auth()->user();
        
        if (auth()->loggedIn()) {
            $data['name'] = auth()->user()->username;
        }

        if (!is_null($user) && $user->inGroup('admin')) {
            return redirect()->back();
        }
        
        $data['cards'] = self::CARDS;
        return view('index', $data);
    }

    public function viewSurveys()
    {
        $user = auth()->user();
        $userId = $user->id;

        if (auth()->loggedIn()) {
            $data['name'] = auth()->user()->username;
        }

        if (!is_null($user) && $user->inGroup('admin')) {
            return redirect()->back();
        }

        $model = new \App\Models\SurveyModel();

        $surveys = $model->findAll();

        $data['surveys'] = $model
            ->orderBy('updated_at','DESC')
            ->where('user_id', $userId)
            ->findAll();

        return view('viewSurveys', $data);
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
            return redirect()->back();
        }

        if ($user->inGroup('user')) {
            session()->setFlashdata('error', 'You do not have the required permissions.');
            return redirect()->back(); 
        }

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

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function changeStatus($id)
    {
        $model = auth()->getProvider();

        $user = $model->findById($id);

        if ($user->active) {
            $user->deactivate();
        } else {
            $user->activate();
        } 

        return redirect()->back();
    }
    
    public function adduser()
    {
        $users = auth()->getProvider();

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

    public function edituser()
    {
        $users = auth()->getProvider();

        $id = $this->request->getPost('id');

        $user = $users->findById($id);

        $fields = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        if (!empty($this->request->getPost('password'))) {
            $fields["password"] = $this->request->getPost('password');
        }

        $user->fill($fields);

        $users->save($user);

        return redirect()->back(); 


    }

    public function deleteSurvey($id)
    {
        $model = new \App\Models\SurveyModel();
        $model->delete($id);

        return redirect()->back();
    }

    public function changeSurveyTitle()
    {   
        $surveys = new \App\Models\SurveyModel();

        $survey = $this->request->getPost();

        $surveys->save($survey);

        return redirect()->back(); 
        
    }

    public function viewSurvey($id)
    {
        $data = $this->surveyViewer($id);

        return view('survey', $data);
    }

    public function respondentSurvey($id)
    {
        $data = $this->surveyViewer($id);
        unset($data['name']);

        return view('respondentSurvey', $data);
    }

    private function surveyViewer($id)
    {
        // $userId = auth()->user()->id;
        $surveys = new \App\Models\SurveyModel();
        $questions = new \App\Models\QuestionsModel();
        $options = new \App\Models\OptionsModel();

        $survey = $surveys->find($id);

        $surveyQuestions = $questions
        ->where('survey_id', $id)->findAll();

        $questionIds = array_column($surveyQuestions, 'question_id');

        $optionsByQuestion = []; 
        foreach ($questionIds as $questionId) {
            $optionsByQuestion[$questionId] = $options
                                    ->where('question_id', $questionId)
                                    ->findAll();
        }

        $data = [
            'name' => "filler",
            'id' => $id,
            'title' => $survey['title'],
            'questions' => $surveyQuestions,
            'options' => $optionsByQuestion
        ];

        return $data;
    }

    public function getQRCodes($id)
    {
        
        $url = 'https://infs3202-42fc98bb.uqcloud.net/evalform/respondent-survey/' . $id;

        $data['url'] = $url;

        return view('qrcode', $data);
    }

    public function submitResponses($id)
    {

        $responses = new \App\Models\ResponsesModel();
        $surveyModel = new \App\Models\SurveyModel();
        $questionsModel = new \App\Models\QuestionsModel();

        // Find the survey (you might need to adjust if your model's methods are different)
        $survey = $surveyModel->find($id);

        // Load questions for this survey
        $questions = $questionsModel->where('survey_id', $survey['survey_id'])->findAll();

        $postData = $this->request->getPost(); 

        for ($i = 0; $i < count($questions); $i++) {
            $responseText = null;

            if (isset($postData['question_' . ($i + 1)])) { 
                $responseText = $postData['question_' . ($i + 1)];  
            } elseif (isset($postData['text_answer_' . ($i + 1)])) { 
                $responseText = $postData['text_answer_' . ($i + 1)]; 
            }

            if ($responseText !== null) {
                $responses->insert([ 
                    'question_id' => $questions[$i]['question_id'], 
                    'response' => $responseText 
                ]);
            }
        }


        return view('success');
    }
}


