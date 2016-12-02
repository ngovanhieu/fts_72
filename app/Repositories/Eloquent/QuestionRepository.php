<?php  

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use Illuminate\Container\Container as App;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Input;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    /**
     * @var
     */
    protected $auth;

    /**
     * Create contracts instance.
     *
     * @param  Auth  $auth
     * @return void
     */
    public function __construct(App $app, Auth $auth)
    {   
        parent::__construct($app);
        $this->auth = $auth;
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Question';
    }
    
    /**
     * Store a new question in repository
     *
     * @throws Exception
     *
     * @param array $input
     *
     * @return mixed
     */
    public function storeQuestion(array $input)
    {   
        $data['question'] = [
            'user_id' => $this->auth->user()->id,
            'subject_id' => $input['subject'],
            'content' => $input['content'],
            'status' => $input['active'],
            'type' => $input['type'],
        ];

        return $this->model->create($data['question'])
            ->systemAnswers()->createMany($input['answer']);
    }

    /**
     * Store a new question in repository
     *
     * @throws Exception
     *
     * @param array $input
     *
     * @return mixed
     */

    public function createSuggestQuestion(array $input)
    {
        $data['suggest_question'] = [
            'user_id' => $this->auth->user()->id,
            'subject_id' => $input['subject'],
            'content' => $input['content'],
            'status' => config('question.status.inactive'),
            'type' => $input['type'],
        ];
 
        return $this->model->create($data['suggest_question'])
            ->systemAnswers()->createMany($input['answer']);
    }

    public function viewListSuggestQuestion($column, $option)
    {
        $data = $this->model->where($column, $option)->with('subject')
            ->paginate(config('repository.pagination.limit'));

        return $data;
    }

    public function showSuggestQuestion($id, $columns = ['*'])
    {
        return $this->model->with('systemAnswers')->findOrFail($id, $columns);
    }

    public function updateQuestion(array $input, $id, $active)
    {
        $question = $this->model->findOrFail($id);

        if (is_null($question->results)) {
            return false;
        }

        $data['question'] = [
            'subject_id' => $input['subject'],
            'content' => $input['content'],
            'status' => $active,
            'type' => $input['type'],
        ];

        $question->forceFill($data['question'])->save();
        $question->systemAnswers()->delete();
        $question->systemAnswers()->createMany($input['answer']);

        return $this;
    }

    public function delete($id)
    {
        $question =  $this->model->findOrFail($id);

        if (count($question->results)) {
            return false;
        }

        return $this->model->destroy($id);
    }

    public function deleteSuggesQuestion($id)
    {
        $suggestQuestion = $this->model->findOrFail($id);
        $suggestQuestion->destroy($id);
        $suggestQuestion->systemAnswers()->delete();

        return $this;
    }

    public function searchQuestionFilter($data)
    {
        $query = $this->model->search($data['key-word']);

        if ($data['subject_id'] != '') {
            $query->where('subject_id', $data['subject_id']);
        }

        if ($data['status'] != '') {
            $query->where('status', $data['status']);
        }

        $result = $query->paginate();

        return $result;
    }
}
