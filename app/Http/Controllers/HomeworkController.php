<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FocusArea;
use App\Models\LessonSubject;
use App\Models\HomeWork;
use App\Models\HomeWorkDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class HomeworkController extends Controller
{
    public function getHomework()
    {
		$homeworks  = HomeWork::all();
        return view('admin.homework.index', compact('homeworks'));
    }

    public function addHomework(Request $request)
    {
        if(isset($request->focus_id) &&isset($request->lesson_id) ){
            $homework   = '';
            $focusID    = $request->focus_id;
            $lessonID   = $request->lesson_id;
            return view('admin.homework.addhomework', compact('focusID', 'lessonID'));
        }else{
            $homework = new HomeWork();
            $homework->focusarea_id      = $request->focusarea_id;
            $homework->lesson_id         = $request->lesson_id;
            $homework->name              = $request->name;
            $homework->instructions_text = $request->instructions_text;
            $homework->save();
            $homeworkId = $homework->id;
            // dd($homeworkId);
            //$homeworkId = 2;
            foreach ($request->question as $question) {
                // dd($question);
                $final_answer = '';
                $answers = json_encode($question['answer']);
                if(isset($question['final_answer']))
                    $final_answer = $question['final_answer'];
                HomeWorkDetail::create([
                    'homework_id'   => $homeworkId,
                    'question'      => $question['name'],
                    'answer'        => $answers,
                    'final_answer'  => $final_answer,
                ]);
                //dd('Done');
            }
            return redirect()->route('admin.lessonsubjects')->with('success','HomeWork Added Successfully.');
        }
    }
    
    public function editHomework($myID)
    {
        $homeworks = HomeWork::findorFail($myID);
        return view('admin.homework.edithomework', compact('homeworks'));
    }

    public function updateHomework(Request $request)
    {
        // dd($request->all());
        $homework  = HomeWork::findorFail($request->homeworkid);
        $homework->name = $request->name;
        if(isset($request->instructions_text))
            $homework->instructions_text = $request->instructions_text;
        $homework->save();
        foreach ($request->question as $question) {
            $final_answer = '';
            $answers = json_encode($question['answer']);
            if(isset($question['final_answer']))
                $final_answer = $question['final_answer'];
            if(isset($question['id'])){
                $homework  = HomeWorkDetail::findorFail($question['id']);
                $homework->question     = $question['name'];
                $homework->answer       = $answers;
                $homework->final_answer = $final_answer;
                $homework->save();
            }else{
                HomeWorkDetail::create([
                    'homework_id'   => $request->homeworkid,
                    'question'      => $question['name'],
                    'answer'        => $answers,
                    'final_answer'  => $final_answer,
                ]);
                //dd('Done');
            }
        }
        return back();
    }

    public function delHomework($myID){
        //dd($myID);
        $rec = HomeWorkDetail::find($myID);
        HomeWorkDetail::where("id", $rec->id)->delete();
        return back();
    }
}