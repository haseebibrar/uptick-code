<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FocusArea;
use App\Models\Teacher;
use App\Models\Event;
use App\Models\TeacherTimeTable;
use App\Models\FocusAreaTeacher;
use App\Models\LessonSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Redirect,Response;
use DateTimeZone;
use DateTime;
use DB;

class TeacherController extends Controller
{
    public function index()
    {
        // dd(Auth::user());
        //dd('Test');
        $teacherID  = Auth::user()->id;
        $myTimeZone = Auth::user()->time_zone;
        $myTime     = $this->get_times();
        $sunData    = array();
        $monData    = array();
        $tueData    = array();
        $wedData    = array();
        $thuData    = array();
        $friData    = array();
        $satData    = array();
        $timetable  = TeacherTimeTable::where('teacher_id', '=', $teacherID)->get();
        if(!empty($timetable)){
            foreach($timetable as $myData){
                $time       = json_decode($myData['availabletime'], true);
                $myDay      = $myData['availableday'];
                $counter    = 0;
                // dd($myDay);
                foreach($time as $data){
                    if($myDay === "sun"){
                        $sunData[$counter][1] = $this->get_times($data[1]);
                        $sunData[$counter][2] = $this->get_times($data[2]);
                    }
                    if($myDay === "mon"){
                        $monData[$counter][1] = $this->get_times($data[1]);
                        $monData[$counter][2] = $this->get_times($data[2]);
                    }
                    if($myDay === "tue"){
                        $tueData[$counter][1] = $this->get_times($data[1]);
                        $tueData[$counter][2] = $this->get_times($data[2]);
                    }
                    if($myDay === "wed"){
                        $wedData[$counter][1] = $this->get_times($data[1]);
                        $wedData[$counter][2] = $this->get_times($data[2]);
                    }
                    if($myDay === "thu"){
                        $thuData[$counter][1] = $this->get_times($data[1]);
                        $thuData[$counter][2] = $this->get_times($data[2]);
                    }
                    if($myDay === "fri"){
                        $friData[$counter][1] = $this->get_times($data[1]);
                        $friData[$counter][2] = $this->get_times($data[2]);
                    }
                    if($myDay === "sat"){
                        $satData[$counter][1] = $this->get_times($data[1]);
                        $satData[$counter][2] = $this->get_times($data[2]);
                    }
                    //dd($data[1]);
                    $counter++;
                }
                // dd($tueData);
            }
        }
        $timeList = $this->tz_list();
        return view('teacher.index', compact('myTimeZone', 'timeList' ,'teacherID', 'myTime', 'sunData', 'monData', 'tueData', 'wedData', 'thuData', 'friData', 'satData'));
    }

    public function tz_list() 
    {
        $zones_array = array();
        $timestamp = time();
        $dummy_datetime_object = new DateTime();
        foreach(timezone_identifiers_list() as $key => $zone) {
          date_default_timezone_set($zone);
          $zones_array[$key]['zone'] = $zone;
          $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
      
          $tz = new DateTimeZone($zone);
          $zones_array[$key]['offset'] = $tz->getOffset($dummy_datetime_object);
        }
        return $zones_array;
    }

    public function get_times ($default = '', $interval = '+60 minutes')
    {
        $output = '';
        $current= strtotime('09:00');
        $end    = strtotime('21:00');
        while ($current <= $end) {
            $time = date('H:i', $current);
            $sel = ($time == $default) ? ' selected' : '';
            $output .= "<option value=\"{$time}\"{$sel}>" . date('h.i A', $current) .'</option>';
            $current = strtotime($interval, $current);
        }
        return $output;
    }

    public function updateTime(Request $request)
    {
        //dd(Auth::user()->id);
        // dd($request->all());
        $teacherID  = Auth::user()->id;
        $teacherData= Teacher::where('id', '=', $teacherID)->first();
        $teacherData->time_zone = $request->time_zone;
        $teacherData->save();
        $mySunCheck = $this->saveData($request->suncheck[0], $teacherID, 'sun');
        $myMonCheck = $this->saveData($request->moncheck[0], $teacherID, 'mon');
        $myTueCheck = $this->saveData($request->tuecheck[0], $teacherID, 'tue');
        $myWedCheck = $this->saveData($request->wedcheck[0], $teacherID, 'wed');
        $myThuCheck = $this->saveData($request->thucheck[0], $teacherID, 'thu');
        $myFriCheck = $this->saveData($request->fricheck[0], $teacherID, 'fri');
        $mySatCheck = $this->saveData($request->satcheck[0], $teacherID, 'sat');
        return redirect()->route('teachers')->with('success','Availabilty Updated Successfully.'); 
    }

    public function saveData($myData, $teacherID, $myDay)
    {
        if(isset($myData['name'])){
            $times = json_encode($myData['time']);
            $checkData = TeacherTimeTable::where('teacher_id', '=', $teacherID)->where('availableday', '=', $myDay)->first();
            if(!empty($checkData)){
                $checkData->availabletime = $times;
                $checkData->save();
            }else{
                TeacherTimeTable::create([
                    'teacher_id'    => $teacherID,
                    'availableday'  => $myData['name'],
                    'availabletime' => $times,
                ]);
            }
        }else{
            $checkData = TeacherTimeTable::where('teacher_id', '=', $teacherID)->where('availableday', '=', $myDay)->first();
            // dd($checkData->id);
            if(!empty($checkData))
                TeacherTimeTable::where('id',$checkData->id)->delete();
        }
    }

    public function openLessons()
    {
        $teacherID  = Auth::user()->id;
        $openLessons =  DB::table('events')->where('events.teacher_id', '=', $teacherID)->where('events.status', '<>', 'canceled')
                        ->join('focus_areas', 'focus_areas.id', '=', 'events.focusarea_id')
                        ->join('users', 'users.id', '=', 'events.student_id')
                        ->get(['events.*', 'focus_areas.name as focusarea', 'users.name as student', 'users.image as studentimage']);
        $countLessons= count($openLessons);
        return view('teacher.pastfuture', compact('openLessons', 'countLessons'));
    }

    public function lessonsMaterial()
    {
        $teacherID  = Auth::user()->id;
        $focusareas = FocusAreaTeacher::where('teacher_id', '=', $teacherID)
                        ->join('focus_areas', 'focus_areas.id', '=', 'focus_area_teachers.focusarea_id')
                        ->join('lesson_subjects', 'lesson_subjects.id', '=', 'focus_area_teachers.lesson_id')
                        ->get(['focus_area_teachers.*', 'focus_areas.name as focusarea', 'lesson_subjects.name as lesson']);
        return view('teacher.focusareas.index', compact('focusareas')); 
    }

    public function lessonMaterial(Request $request)
    {
        // dd($request->all());
        $eventID    = $request->event_id;
        $focusID    = $request->focus_id;
        $focusName  = $request->focus_name;
        $lessonUrl  = '';
        $lessonID   = 0;
        $kajabiUrl  = '';
        $lessonSubs = LessonSubject::where('focusarea_id', '=', $focusID)->get();
        $event      = Event::where('id', '=', $eventID)->first();
        if(!empty($event)){
            $lessonUrl  = $event->lesson_url;
            $lessonID   = $event->lesson_id;
            $kajabiUrl  = $event->kajabi_url;
        }
        return view('teacher.focusareas.addfocusarea', compact('eventID', 'focusID', 'focusName', 'lessonSubs', 'lessonUrl', 'kajabiUrl', 'lessonID'));
    }

    public function addLessonMaterial(Request $request)
    {    
        // dd($request->all());
        //$teacherID  = Auth::user()->id;
        $event = Event::where('id', '=', $request->event_id)->first();
        $event->lesson_id = $request->lesson_id;
        $event->lesson_url= $request->embeded_url;
        $event->kajabi_url= $request->kajabi_url;
        $event->teacher_complete= 1;
        $event->save();
        return redirect()->route('openlesson')->with('success','Lesson Material Added Successfully.');
    }

    public function cancelLesson($myID){
        $bookData = Event::where('id', '=', $myID)->first();
        $bookData->class_name       = 'canceledEvent';
        $bookData->teacher_cancel   = 1;
        $bookData->status           = 'canceled';
        $bookData->save();
        return redirect()->route('openlesson')->with('success','Lesson Canceled Successfully.');
    }

    public function editFocusarea($myID)
    {
        $focusareateacher   = FocusAreaTeacher::findorFail($myID);
        $focusareas         = FocusArea::where('id', '=', $focusareateacher->focusarea_id)->first();
        $lessons            = LessonSubject::where('focusarea_id', '=', $focusareateacher->focusarea_id)->get();
        return view('teacher.focusareas.editfocusarea', compact('focusareateacher', 'focusareas', 'lessons'));
    }

    public function updateFocusarea(Request $request)
    {
        // dd($request->all());
        $focusarea                  = FocusAreaTeacher::findorFail($request->id);
        $focusarea->focusarea_id    = $request->focusarea_id;
        $focusarea->lesson_id       = $request->lesson_id;
        $focusarea->embeded_url     = $request->embeded_url;
        $focusarea->save();
        return redirect()->route('teacher.focusareas')->with('success','Record Updated Successfully.');
    }

    public function delFocusarea($myID)
    {
        FocusAreaTeacher::where("id", $myID)->delete();
        return redirect()->route('teacher.focusareas')->with('success','Record Deleted Successfully.');
    }

    public function getLessons(Request $request)
    {
        //dd($request->all());
        $focusareas = LessonSubject::where('focusarea_id', '=', $request->myFocusID)->get();
        $output = '';
        foreach ($focusareas as $focusarea) {
            $output .= '<option value="'.$focusarea['id'].'">'.$focusarea['name'].'</option>';
        }
        return $output;
    }

    public function getCalEvents(Request $request)
    {
        // dd($request->start);
        if($request->start) 
        {
            $teacherID  = Auth::user()->id;
            $start  = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end    = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
            //$data   = Event::where('teacher_id', '=', $teacherID)->whereDate('start', '>=', $start)->whereDate('end', '<=', $end)->get(['id', 'title','class_name as className','start','end']);
            $data   = DB::table('events')->where('events.teacher_id', '=', $teacherID)->whereDate('events.start', '>=', $start)->whereDate('events.end', '<=', $end)
                            ->join('focus_areas', 'focus_areas.id', '=', 'events.focusarea_id')
                            ->join('users', 'users.id', '=', 'events.student_id')
                            ->get(['events.id', 'events.start', 'events.end', 'events.class_name as className', 'focus_areas.name as title', 'users.name as description']);
            
            // $focusareas = Event::where('teacher_id', '=', $teacherID)->whereDate('start', '>=', $start)->whereDate('end', '<=', $end)
            //                 ->join('focus_areas', 'focus_areas.id', '=', 'focus_area_teachers.focusarea_id')
            //                 ->join('lesson_subjects', 'lesson_subjects.id', '=', 'focus_area_teachers.lesson_id')
            //                 ->get(['focus_area_teachers.*', 'focus_areas.name as focusarea', 'lesson_subjects.name as lesson']);
            // dd(response()->json($data));
            return response()->json($data);
        }
    }

    public function create(Request $request)
    {
        dd($request->all());
        $insertArr = [ 'title' => $request->title,
                       'start' => $request->start,
                       'end' => $request->end
                    ];
        $event = Event::insert($insertArr);   
        return Response::json($event);
    }
 
    public function update(Request $request)
    {   
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Event::where($where)->update($updateArr);
 
        return Response::json($event);
    }
 
    public function eventDelete(Request $request)
    {
        //dd($request->all());
        $event = Event::where('id',$request->id)->delete();
        return Response::json($event);
    }
}