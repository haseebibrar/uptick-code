<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\PropertyTypes\TextPropertyType;
use Swift_Mime_ContentEncoder_PlainContentEncoder;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $filename;
    // public $icsname;
    // public function __construct($data, $filename, $icsname)
    public function __construct($data, $filename)
    {
        $this->data     = $data;
        $this->filename = $filename;
        // $this->icsname  = $icsname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(isset($this->data['icslink'])){
            // dd($_SERVER["DOCUMENT_ROOT"]);
            $filename           = $_SERVER["DOCUMENT_ROOT"].'/images/users/invite.ics';
            $meeting_duration   = (3600); // 1 hour
            $meetingstamp       = strtotime($this->data['starttime']." UTC");
            $dtstart            = gmdate('Ymd\THis\Z', $meetingstamp);
            $dtend              = gmdate('Ymd\THis\Z', $meetingstamp + $meeting_duration);
            $uid                = date('Ymd').'T'.date('His').'-'.rand().'@uptick.co.il';
            $description        = strip_tags('Uptick Lesson');
            $organizer          = "CN=Organizer name:".$this->data['teachermail'];
            $location           = $this->data['zoom_link'];

            logger('data',[
                'dtstart'       => $dtstart,
                'dtend'         => $dtend,
                'organizer'     => $organizer,
                'location'      => $location,
                'description'   => $description
            ]);

            // $mail = implode('\r\n', $mail);
            $attendee = isset($this->data['attendee']) ? $this->data['attendee'] : '';
            logger('this', ['this' => $this->to[0]['address']]);
            $mail = Calendar::create('Uptick Lesson')
                    ->event(Event::create('Uptick Lesson with '.$this->data['teacher'])
                        ->startsAt(new \DateTime($this->data['starttime']))
                        ->endsAt(new \DateTime($this->data['endtime']))
                        ->organizer($this->data['teachermail'], $this->data['teacher'])
                        ->description('Uptick Lesson with '.$this->data['teacher'].' Joining Link: '.$this->data['zoom_link'])
                        ->attendee($this->data['teachermail'])
                    )
                    ->appendProperty(TextPropertyType::create('METHOD', 'REQUEST'))
                    ->get();

            $mail = \Str::replace('VEvent', 'VEVENT', $mail);
            file_put_contents($filename, $mail);

            $this->view('emails.'.$this->filename);
            $this->withSwiftMessage(function ($message) use ($filename) {
                /*
                 Content-Type: text/calendar; charset="UTF-8"; method=REQUEST
                 Content-Transfer-Encoding: 7bit
                > no content disposition
                 */
                $attachment = \Swift_Attachment::fromPath($filename, 'text/calendar');
                $encoder = new Swift_Mime_ContentEncoder_PlainContentEncoder('7bit');
                $attachment->setEncoder($encoder);
                $headers = $attachment->getHeaders();
                $headers->remove('Content-Type');
                $headers->remove('Content-Disposition');
                $headers->addTextHeader('Content-Type', 'text/calendar; charset="UTF-8"; method=REQUEST');
                $message->attach($attachment);

                /*
                 Content-Type: application/ics; name="invite.ics"
                 Content-Disposition: attachment; filename="invite.ics"
                 Content-Transfer-Encoding: base64
                 */
                $attachment = \Swift_Attachment::fromPath($filename, 'application/ics');
                $message->attach($attachment);
            });

            return $this;
        }else if(isset($this->data['subject'])){
            $this->subject($this->data['subject'])->view('emails.'.$this->filename)->with('data', $this->data);
            return $this;
        }else
            return $this->view('emails.'.$this->filename)->with('data', $this->data);
    }
}
