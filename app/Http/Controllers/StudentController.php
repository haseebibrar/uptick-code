<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FocusArea;
use App\Models\Teacher;
use App\Models\Event;
use App\Models\User;
use App\Models\HomeWork;
use App\Models\HomeWorkDetail;
use App\Models\HomeWorkDetailsStudent;
use App\Models\FocusAreaTeacher;
use App\Models\TeacherTimeTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Redirect,Response;
use DB;
use DateTimeZone;
use DateTime;
use Mail;
use App\Mail\NotifyMail;
use Spatie\CalendarLinks\Link;

class StudentController extends Controller
{
    public function index()
    {
        $studentID  = Auth::user()->id;
        $teachers   = Teacher::all();
        $focusareas = FocusArea::all();
        // $curDate    = date('Y-m-d H:i:s');
        $tz         = 'Asia/Jerusalem';
        $timestamp  = time();
        $dt         = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
        $curDate    = $dt->format('Y-m-d H:i:s');
        // dd($studentID);
        $student    =  DB::table('events')->where('events.student_id', '=', $studentID)->where('events.status', '<>', 'canceled')
                        ->where('lesson_rating', '=', 0)->where('events.end', '<', $curDate)
                        ->join('focus_areas', 'focus_areas.id', '=', 'events.focusarea_id')
                        ->join('teachers', 'teachers.id', '=', 'events.teacher_id')
                        ->first(['events.*', 'focus_areas.name as focusarea', 'teachers.name as teacher']);
        // $student    = Event::where('student_id', '=', $studentID)
        //                 ->where('status', '<>', 'canceled')
        //                 ->where('lesson_rating', '=', null)->first();
        // dd($student);
        if(!empty($student)){
            // $eventID    = $student->id;
            return view('student.review', compact('student', 'studentID'));
        }else
            return view('student.index', compact('teachers', 'focusareas', 'studentID'));
    }

    public function submitReview(Request $request)
    {
        // dd($request->all());
        $eventData = Event::where('id', '=', $request->event_id)->first();
        $eventData->lesson_review = $request->review;
        $eventData->lesson_rating = $request->rating;
        $eventData->save();
        return redirect('/home')->with('success','Thanks for your feedback.');
    }

    public function getTeachers(Request $request)
    {
        $myData     = '';
        $myDay      = strtolower($request->myDay);
        $myTime     = date('h:i a', strtotime($request->myTime));
        // $teachers   = FocusAreaTeacher::where('focusarea_id', '=', $request->myFocusID)->get();
        $teachers   = Teacher::all();
        // dd($request->all());
        // dd($myTime);
        // date('H:i', $current);
        if($teachers->isNotEmpty()){
            // dd($teacher);
            $foundData = 'no';
            foreach($teachers as $teacher){
                $foundDay = 'no';
                // dd($teacher->teacher->timetable);
                $timetable = $teacher->timetable;
                foreach($timetable as $myday){
                    if($myday['availableday'] === $myDay){
                        $time  = json_decode($myday['availabletime'], true);
                        foreach($time as $data){
                            $start_time = date('h:i a', strtotime($data[1]));
                            $end_time   = date('h:i a', strtotime($data[2]));
                            //dd($myTime.' || '.$start_time.' || '.$end_time);
                            if (strtotime($myTime) >= strtotime($start_time) && strtotime($myTime) < strtotime($end_time)){
                                //dd($myTime);
                                $foundDay = 'yes';
                                break;
                            }
                        }
                    }
                }
                //dd($foundDay);
                if($foundDay === "yes"){
                    $myImage    = '';
                    $foundData  = 'yes';
                    if(!empty($teacher->image))
                        $myImage = asset('images/users/'.$teacher->image);
                    
                    $myData .= '<tr>
                                <td class="align-middle">'.($myImage === "" ? "" : '<img class="rounded-circle imgmr-1" style="width:35px; height:35px;" src="'.$myImage.'" alt="'.$teacher->name.'" title="'.$teacher->name.'" />').'</td>
                                <td class="align-middle">'.$teacher->name.'</td>
                                <td class="text-nowrap align-middle"><a href="javascript:void(0)" data-name="'.$teacher->name.'" data-focus="'.$request->myFocusID.'" data-id="'.$teacher->id.'" class="btn btnSchedule">Schedule</a></td>
                            </tr>';
                }
            }
            // dd($foundData);
            if($foundData === "no")
                $myData = '<td colspan="3" class="text-center">No available teachers!</td>';
        }else{
            $myData = '<td colspan="3" class="text-center">No available teachers!</td>';
        }
        return $myData;
        //dd($teachers);
    }

    public function getTeachersDetail(Request $request)
    {
        // dd($request->all());
        $myDay          = strtolower($request->myDay);
        $myTeacherID    = $request->myTeacherID;
        $myFocusID      = $request->myFocusID;
        $myStart        = date('H:i', strtotime($request->myStart));
        $myEnd          = date('H:i', strtotime($request->myEnd));
        $startOptions   = '';
        $endOptions     = '';
        $timetable      = TeacherTimeTable::where('teacher_id', '=', $myTeacherID)->where('availableday', '=', $myDay)->first();
        if(!empty($timetable)){
            $time           = json_decode($timetable['availabletime'], true);
            $timeData       = array();
            $counter        = 0;
            foreach($time as $data){
                $timeData[$counter][1] = $this->getTimes($myStart, $data[1], $data[2]);
                $timeData[$counter][2] = $this->getTimes($myEnd, $data[1], $data[2]);
                $counter++;
            }

            foreach($timeData as $myTime){
                $startOptions .= $myTime[1];
                $endOptions .= $myTime[2];
            }
            $myData = '<div class="col-md-3"><select name="starttime" class="startTime form-control">'.$startOptions.'</select></div><div class="col-md-1 text-center"> - </div><div class="col-md-3"><select name="endtime" class="endTime form-control">'.$endOptions.'</select></div></div>';
        }else{
            $myData = '1';
        }
            // dd($myData);
        return $myData;
    }

    public function pastLessosns()
    {
        $compCount  = 0;
        $futCount   = 0;
        $curDate    = date('Y-m-d H:i:s');
        $studentID  = Auth::user()->id;
        $compEvents = DB::table('events')->where('events.student_id', '=', $studentID)->where('events.status', '<>', 'canceled')->whereDate('events.start', '<', $curDate)
                        ->join('focus_areas', 'focus_areas.id', '=', 'events.focusarea_id')
                        ->leftJoin('home_works', 'home_works.lesson_id', '=', 'events.lesson_id')
                        ->leftJoin('lesson_subjects', 'lesson_subjects.id', '=', 'events.lesson_id')
                        ->join('teachers', 'teachers.id', '=', 'events.teacher_id')
                        ->get(['events.*', 'focus_areas.name as focusarea', 'teachers.name as teacher', 'teachers.image as teacherimage', 'home_works.id as homeworkid', 'lesson_subjects.pdf_data', 'lesson_subjects.pdf_data_sec']);
        $compCount  = count($compEvents);
        // dd($compEvents);
        $futureEvents = DB::table('events')->where('events.student_id', '=', $studentID)->where('events.status', '<>', 'canceled')->whereDate('events.start', '>=', $curDate)
                            ->join('focus_areas', 'focus_areas.id', '=', 'events.focusarea_id')
                            ->join('teachers', 'teachers.id', '=', 'events.teacher_id')
                            ->leftJoin('lesson_subjects', 'lesson_subjects.id', '=', 'events.lesson_id')
                            ->get(['events.*', 'focus_areas.name as focusarea', 'teachers.name as teacher', 'teachers.zoom_link', 'teachers.expertise', 'teachers.image as teacherimage', 'lesson_subjects.pdf_data', 'lesson_subjects.pdf_data_sec']);
        $futCount     = count($futureEvents);
        return view('student.pastfuture', compact('compEvents', 'futureEvents', 'compCount', 'futCount', 'studentID'));
    }

    public function studentHomework($myID)
    {
        $instruct   = '';
        $homework_id= $myID;
        $studentID  = Auth::user()->id;
        $homeWork   = HomeWork::where('id', '=', $myID)->first();
        $instruct   = $homeWork->instructions_text;
        $myHomeWork = DB::table('home_work_details')->where('home_work_details.homework_id', '=', $myID)
                            ->leftJoin('home_work_details_students', function($join){
                                $join->where('home_work_details_students.student_id', '=', Auth::user()->id);
                                $join->on('home_work_details_students.homework_id', '=', 'home_work_details.homework_id');
                                $join->on('home_work_details_students.question_id', '=', 'home_work_details.id');
                            })
                            ->orderBy('home_work_details.id')
                            ->get(['home_work_details.*', 'home_work_details_students.id as student_homeworkid', 'home_work_details_students.question_id', 'home_work_details_students.answer_name']);
        // dd($myHomeWork);
        return view('student.homework', compact('myHomeWork', 'instruct', 'homework_id', 'studentID'));
    }

    public function saveHomeWork(Request $request)
    {
        // dd($request->question);
        if(isset($request->question)){
            foreach ($request->question as $key => $value) {//homework_id
                // dd($value);
                $homework  = HomeWorkDetailsStudent::where('homework_id', '=', $request->homework_id)->where('student_id', '=', $request->student_id)->where('question_id', '=', $key)->first();
                if(!empty($homework)){
                    $homework->homework_id  = $request->homework_id;
                    $homework->student_id   = $request->student_id;
                    $homework->question_id  = $key;
                    $homework->answer_name  = $value;
                    $homework->save();
                }else{
                    //dd($request->key);
                    HomeWorkDetailsStudent::create([
                        'homework_id'   => $request->homework_id,
                        'student_id'    => $request->student_id,
                        'question_id'   => $key,
                        'answer_name'   => $value,
                    ]);
                }
            }
        }
        return back();
    }

    public function getCalEvents(Request $request)
    {
        // dd($request->start);
        if($request->start) 
        {
            //dd('testing');
            $studentID  = Auth::user()->id;
            $start  = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end    = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
            $data   = DB::table('events')->where('events.student_id', '=', $studentID)->where('events.status', '<>', 'canceled')->whereDate('events.start', '>=', $start)->whereDate('events.end', '<=', $end)
                            ->join('focus_areas', 'focus_areas.id', '=', 'events.focusarea_id')
                            ->join('teachers', 'teachers.id', '=', 'events.teacher_id')
                            ->get(['events.id', 'events.start', 'events.end', 'events.class_name as className', 'focus_areas.name as title', 'teachers.name as description']);
            // $data   = Event::where('student_id', '=', $studentID)->whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','teacher_id','start', 'end']);
            //return $data;
            return response()->json($data);
        }
    }

    public function getClickData(Request $request)
    {
        // dd(Auth::user());
        if(Auth::user()->remaining_hours > 0){
            $strDate    = substr($request->start,4,20);
            $endDate    = substr($request->end,4,20);
            $myDateFull = substr($request->start,4,11);
            $myDay      = date('D', strtotime($strDate));
            $myDate     = date('Y-m-d', strtotime($strDate));
            $myStart    = date('Y-m-d H:i:s', strtotime($strDate));
            $myEnd      = date('Y-m-d H:i:s', strtotime($endDate));
            $datedata = $myDay.'--'.$myDate.'--'.$myStart.'--'.$myEnd.'--'.$myDateFull;
            return $datedata;
        }else{
            return '1';
        }
    }

    public function showCalEdit(Request $request)
    {
        // $eventData = Event::where('id', '=', $request->myEventID)->first();
        $data   = DB::table('events')->where('events.id', '=', $request->myEventID)
                            ->join('focus_areas', 'focus_areas.id', '=', 'events.focusarea_id')
                            ->join('teachers', 'teachers.id', '=', 'events.teacher_id')
                            ->first(['events.id', 'events.start', 'events.end', 'focus_areas.name as title', 'focus_areas.id as focusid', 'teachers.name as teachername', 'teachers.id as teacherid', 'teachers.zoom_link']);
        $strDate            = $data->start;
        $data->starttime    = date('Y-m-d H:i:s', strtotime($strDate));
        $data->endtime      = date('Y-m-d H:i:s', strtotime($data->end));
        $data->full         = date('M d Y', strtotime($strDate));
        $data->start        = date('l, F, d h:i', strtotime($strDate));
        $data->end          = date('h:i a', strtotime($data->end));
        // dd($data);
        return $data;
    }

    public function getCalEdit(Request $request)
    {
        $eventData      = Event::where('id', '=', $request->myEventID)->first();
        $myDay          = strtolower(date('D', strtotime($eventData->start)));
        $myTeacherID    = $eventData->teacher_id;
        $myFocusID      = $eventData->focusarea_id;
        $myStart        = date('H:i', strtotime($eventData->start));
        $myEnd          = date('H:i', strtotime($eventData->end));
        $startOptions   = '';
        $endOptions     = '';
        // return $myTeacherID;
        $timetable      = TeacherTimeTable::where('teacher_id', '=', $myTeacherID)->where('availableday', '=', $myDay)->first();
        if(!empty($timetable)){
            $time           = json_decode($timetable['availabletime'], true);
            $timeData       = array();
            $counter        = 0;
            foreach($time as $data){
                $timeData[$counter][1] = $this->getTimes($myStart, $data[1], $data[2]);
                $timeData[$counter][2] = $this->getTimes($myEnd, $data[1], $data[2]);
                $counter++;
            }

            foreach($timeData as $myTime){
                $startOptions .= $myTime[1];
                $endOptions .= $myTime[2];
            }
            $myData = '<div class="col-md-3"><select name="starttime" class="startTime form-control">'.$startOptions.'</select></div><div class="col-md-1 text-center"> - </div><div class="col-md-3"><select name="endtime" class="endTime form-control">'.$endOptions.'</select></div></div>';
        }else{
            $myData = '1';
        }
            // dd($myData);
        return $myData;
    }

    public function saveEvent(Request $request)
    {
        $studentID  = Auth::user()->id;
        $emailStude = Auth::user()->email;
        $teacherDt  = Teacher::where('id', '=', $request->teacher_id)->first();
        $student    = User::where('id', '=', $studentID)->first();
        $focusname  = FocusArea::where('id', '=', $request->focusarea_id)->first();
        $myHours    = intval($student->remaining_hours) - 1;
        $myUsedHour = intval($student->used_hours) + 1;
        $student->remaining_hours   = $myHours;
        $student->used_hours        = $myUsedHour;
        // $student->save();
        $starttime  = new DateTime($request->event_date.' '.$request->starttime.':00');
        $endtime    = new DateTime($request->event_date.' '.$request->endtime.':00');
        $myStart    = $request->event_date.' '.$request->starttime.':00';
        $myEnd      = $request->event_date.' '.$request->endtime.':00';
        $timeData   = date('H:i a l, d F, Y', strtotime($myEnd));
        $timeDataSub= date('l, d F, Y H:i a', strtotime($myStart));
        $timeDataEnd= date('H:i a', strtotime($myEnd));
        $myStartMail= date('H:i a', strtotime($myStart));
        // dd($timeDataSub.' || '.$timeDataEnd);
        $mySubject  = 'Invitation: '.$student->name.' and '.$teacherDt->name.' @ '.$timeDataSub.' - '.$timeDataEnd.' (EDT) - UPTICK';
        // dd($mySubject);
        Event::create([
            'focusarea_id'  => $request->focusarea_id,
            'teacher_id'    => $request->teacher_id,
            'lesson_id'     => $request->lesson_id,
            'student_id'    => $request->student_id,
            'title'         => '',
            'start'         => $starttime,
            'end'           => $endtime,
            'class_name'    => 'scheduledEvent'
        ]);
        $emailData = [
            'first_name'    => $student->name, 
            'zoom_link'     => $teacherDt->zoom_link,
            'teacher'       => $teacherDt->name,
            'teachermail'   => $teacherDt->email,
            'icslink'       => 'yes',
            'starttime'     => $myStart,
            'endtime'       => $myEnd,
            'attendee'      => $emailStude,
            'time_data'     => $myStartMail.' - '.$timeData,
            'focus_name'    => $focusname->name,
            'subject'       => $mySubject
        ];
        // Mail::to($emailStude)->send(new NotifyMail($emailData, 'eventbook'));
        return redirect('/home')->with('success','Booked Successfully.');
    }

    public function editEvent(Request $request)
    {
        // dd($request->all());
        $starttime  = new DateTime($request->edit_event_date.' '.$request->starttime.':00');
        $endtime    = new DateTime($request->edit_event_date.' '.$request->endtime.':00');
        $where      = array('id' => $request->eventeditid);
        $updateArr  = ['start' => $starttime, 'end' => $endtime];
        $event      = Event::where($where)->update($updateArr);
        return redirect('/home')->with('success','Updated Successfully.');
    }

    public function downloadLesson(Request $request)
    {
        // dd($request->all());
        if($request->myFileNum === "1")
            $updateArr  = ['file_downloaded' => 1];
        if($request->myFileNum === "2")
            $updateArr  = ['file_sec_down' => 1];
        $where      = array('id' => $request->myEventID);
        // $updateArr  = ['file_downloaded' => 1];
        $event      = Event::where($where)->update($updateArr);
        return 1;
    }
 
    public function update(Request $request)
    {   
        $where      = array('id' => $request->id);
        $updateArr  = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event      = Event::where($where)->update($updateArr);
 
        return Response::json($event);
    }
 
    public function eventDelete(Request $request)
    {
        $bookData = Event::where('id', '=', $request->myEventID)->first();
        $myTime = strtotime($bookData->start);
        if($myTime > time() + 86400){
            $bookData->status       = 'canceled';
            $bookData->class_name   = 'canceledEvent';
            $bookData->save();
            $studentID  = Auth::user()->id;
            $student    = User::where('id', '=', $studentID)->first();
            $myHours    = intval($student->remaining_hours) + 1;
            $myUsedHour = intval($student->used_hours) - 1;
            $student->remaining_hours   = $myHours;
            $student->used_hours        = $myUsedHour;
            $student->save();
        }else{
            if($request->myLessHour === '1'){
                $bookData->class_name   = 'canceledEventTwo';
                $bookData->status = 'canceled';
                $bookData->save();
            }else
                return 'No';
        }
        return 'Done';
        //dd($request->all());
        // $event = Event::where('id',$request->id)->delete();
        // return Response::json($event);
    }

    public function getTimes ($default = '', $startTime, $endTime, $interval = '+15 minutes')
    {
        $output     = '';
        $current    = strtotime('07:00');
        $end        = strtotime('23:00');
        $start_time = strtotime($startTime);
        $end_time   = strtotime($endTime);
        while ($current <= $end) {
            $time   = date('H:i', $current);
            if ($current >= $start_time && $current <= $end_time){
                $sel = ($time == $default) ? ' selected' : '';
                $output .= "<option value=\"{$time}\"{$sel}>" . date('h.i A', $current) .'</option>';
            }
            $current = strtotime($interval, $current);
        }
        return $output;
    }
}