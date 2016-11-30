<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use DB;
use App\Models\Exam;
use App\Models\Question;

class ChartsController extends BaseController
{
    public function __construct() {
        $this->viewData['title'] = trans('admin/chart.chart');
    }

    public function index()
    {
        $chart = new Lavacharts;
        $exams = $chart->DataTable();
        $data['exams_result'] = Exam::select(DB::raw('count(*) as exam_count'), 'score')
            ->groupBy('score')
            ->get();
        $exams->addStringColumn('Exam')->addNumberColumn('Exam');

        foreach ($data['exams_result'] as $key => $value) {
            $exams->addRow([$value->score, $value->exam_count]);
        }

        $chart->AreaChart('Exams', $exams, [
            'title' => trans('admin/chart.chart-exam-of-score')
        ]);
        
        //make chart total question of one subject
        $subjectQuestion  = $chart->DataTable();
        $totalQuestion['question'] = Question::select(DB::raw('count(*) as question'), 'subject_id')
            ->where('status', '=' , config('question.status.active'))
            ->groupBy('subject_id')
            ->with('subject')
            ->get();

        $subjectQuestion->addStringColumn('Subject')->addNumberColumn('Question');

        foreach ($totalQuestion['question'] as $key => $value) {
            $subjectQuestion->addRow([$value->subject->name,  $value->question]);
        }

        $chart->BarChart('Subject', $subjectQuestion, [
            'title' => trans('admin/chart.chart-question-of-subject')
        ]);

        $totalQuestionSubject = $chart->DataTable();


        $allQuestion = DB::select('SELECT subjects.name, A.subject_id, sum(A.status_active) as active, sum(A.status_inactive) as inactive FROM ( SELECT B.subject_id, IF(B.status=1,1,0) AS `status_active`, IF(B.status=0,1,0) AS `status_inactive` FROM `questions` AS B WHERE B.deleted_at is null) AS A INNER JOIN subjects ON A.subject_id = subjects.id group by A.subject_id');

        $totalQuestionSubject->addStringColumn('Subject')
                 ->addNumberColumn('Active')
                 ->addNumberColumn('Inactive');

                 foreach ($allQuestion as $key => $item) {
                    $totalQuestionSubject->addRow([$item->name, $item->active, $item->inactive]);
                 }

        $chart->ColumnChart('Finances', $totalQuestionSubject, [
            'title' => 'Active And Inactive Question',
        ]);

        $this->viewData['chart'] = $chart;

        return view('admin.chart.index', compact('chart'), $this->viewData);
    }
}
