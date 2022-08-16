Hi {{ $data['first_name'] }},<br /><br />
Your business English lesson has been scheduled.<br /><br />
Lesson Focus Area:<br />
{{ $data['focus_name'] }}<br /><br />
Teacher:<br />
{{ $data['teacher'] }}<br /><br />
Teacher Email:<br />
<a href="mailto:{{ $data['teachermail'] }}">{{ $data['teachermail'] }}</a><br /><br />
Lesson Date/Time:<br />
{{ $data['time_data'] }} (Israel Time)<br /><br />
Location:<br />
<a href="{{ $data['zoom_link'] }}" target="_blank">Click here to join the lesson</a>.<br /><br />
Much love,<br />
{{ $data['teacher'] }}<br /><br />