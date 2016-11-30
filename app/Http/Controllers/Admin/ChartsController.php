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
        $this->viewData['chart'] = $chart;

        return view('admin.chart.index', compact('chart'), $this->viewData);
    }
}
