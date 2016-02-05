<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Settings\Company;
use App\User;
use App\Model\helpdesk\Ticket\Ticket_Collaborator;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use Auth;
use Mail;
use Input;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Settings\Alert;

/**
 * -----------------------------------------------------------------------------
 * Ticket Controller
 * -----------------------------------------------------------------------------
 * 
 * 
 * @author Vijay Sebastian <vijay.sebastian@ladybirdweb.com>
 * @copyright (c) 2016, Ladybird Web Solution
 * @name Faveo HELPDESK
 * @version v1
 * 
 * 
 */

class TicketController extends Controller {

    /**
     * Create Ticket
     * @param type $user_id
     * @param type $subject
     * @param type $body
     * @param type $helptopic
     * @param type $sla
     * @param type $priority
     * @return type string
     */
    public function create_ticket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $form_data, $attach = '') {
        try {
            $max_number = Tickets::whereRaw('id = (select max(`id`) from tickets)')->first();
            if ($max_number == null) {
                $ticket_number = "AAAA-9999-9999999";
            } else {
                foreach ($max_number as $number) {
                    $ticket_number = $max_number->ticket_number;
                }
            }
            $ticket = new Tickets;
            $ticket->ticket_number = $this->ticket_number($ticket_number);
            $ticket->user_id = $user_id;
            $ticket->dept_id = $dept;
            $ticket->help_topic_id = $helptopic;
            $ticket->sla = $sla;
            $ticket->assigned_to = $assignto;
            $ticket->status = '1';
            $ticket->priority_id = $priority;
            $ticket->source = $source;
            $ticket->save();
            $ticket_number = $ticket->ticket_number;
            $id = $ticket->id;
            if ($form_data != null) {
                $help_topic = Help_topic::where('id', '=', $helptopic)->first();
                $forms = Fields::where('forms_id', '=', $help_topic->custom_form)->get();
                foreach ($form_data as $key => $form_details) {
                    foreach ($forms as $from) {
                        if ($from->name == $key) {
                            $form_value = new Ticket_Form_Data;
                            $form_value->ticket_id = $id;
                            $form_value->title = $from->label;
                            $form_value->content = $form_details;
                            $form_value->save();
                        }
                    }
                }
            }



            $this->store_collaborators($headers, $id);

            $thread = $this->ticket_thread($subject, $body, $id, $user_id);
            if (!empty($attach)) {
                $this->attach($thread, $attach);
            }
            return $thread;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * store_collaborators
     * @param type $headers 
     * @return type
     */
    public function store_collaborators($headers, $id) {
        try {
            $company = $this->company();
            if (isset($headers)) {
                foreach ($headers as $email => $name) {
                    $name = $name;
                    $email = $email;
                    if ($this->check_email($email) == false) {
                        $create_user = new User;
                        $create_user->user_name = $name;
                        $create_user->email = $email;
                        $create_user->active = 1;
                        $create_user->role = "user";
                        $password = $this->generateRandomString();
                        $create_user->password = Hash::make($password);
                        $create_user->save();
                        $user_id = $create_user->id;
                        Mail::send('emails.pass', ['password' => $password, 'name' => $name, 'from' => $company, 'emailadd' => $email], function ($message) use ($email, $name) {
                            $message->to($email, $name)->subject('password');
                        });
                    } else {
                        $user = $this->check_email($email);
                        $user_id = $user->id;
                    }
                    $collaborator_store = new Ticket_Collaborator;
                    $collaborator_store->isactive = 1;
                    $collaborator_store->ticket_id = $id;
                    $collaborator_store->user_id = $user_id;
                    $collaborator_store->role = "ccc";
                    $collaborator_store->save();
                }
            }
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Generate Ticket Thread
     * @param type $subject
     * @param type $body
     * @param type $id
     * @param type $user_id
     * @return type
     */
    public function ticket_thread($subject, $body, $id, $user_id) {
        try {
            $thread = new Ticket_Thread;
            $thread->user_id = $user_id;
            $thread->ticket_id = $id;
            $thread->poster = 'client';
            $thread->title = $subject;
            $thread->body = $body;
            $thread->save();
            return $thread->id;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Generates Ticket Number
     * @param type $ticket_number
     * @return type integer
     */
    public function ticket_number($ticket_number) {
        try {
            $number = $ticket_number;
            $number = explode('-', $number);
            $number1 = $number[0];
            if ($number1 == 'ZZZZ') {
                $number1 = 'AAAA';
            }
            $number2 = $number[1];
            if ($number2 == '9999') {
                $number2 = '0000';
            }
            $number3 = $number[2];
            if ($number3 == '9999999') {
                $number3 = '0000000';
            }
            $number1++;
            $number2++;
            $number3++;
            $number2 = sprintf('%04s', $number2);
            $number3 = sprintf('%07s', $number3);
            $array = array($number1, $number2, $number3);
            $number = implode('-', $array);
            return $number;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Generate a random string for password
     * @param type $length
     * @return type string
     */
    public function generateRandomString($length = 10) {
        try {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Replying a ticket
     * @param type Ticket_Thread $thread
     * @param type TicketRequest $request
     * @return type bool
     */
    public function reply($thread, $request, $ta, $attach = '') {
        try {

            $check_attachment = null;
            $eventthread = $thread->where('ticket_id', $request->input('ticket_ID'))->first();
            $eventuserid = $eventthread->user_id;
            $emailadd = User::where('id', $eventuserid)->first()->email;
            $source = $eventthread->source;
            $form_data = $request->except('ReplyContent', 'ticket_ID', 'attachment');
            \Event::fire(new \App\Events\ClientTicketFormPost($form_data, $emailadd, $source));
            $reply_content = $request->input('ReplyContent');
            $thread->ticket_id = $request->input('ticket_ID');
            $thread->poster = 'support';
            $thread->body = $request->input('ReplyContent');
            $thread->user_id = Auth::user()->id;
            $ticket_id = $request->input('ticket_ID');
            $tickets = Tickets::where('id', '=', $ticket_id)->first();
            $tickets->isanswered = '1';
            $tickets->save();

            $ticket_user = User::where('id', '=', $tickets->user_id)->first();

            if ($tickets->assigned_to == 0) {
                $tickets->assigned_to = Auth::user()->id;
                $tickets->save();
                $thread2 = New Ticket_Thread;
                $thread2->ticket_id = $thread->ticket_id;
                $thread2->user_id = Auth::user()->id;
                $thread2->is_internal = 1;
                $thread2->body = "This Ticket have been assigned to " . Auth::user()->first_name . " " . Auth::user()->last_name;
                $thread2->save();
            }
            if ($tickets->status > 1) {
                $tickets->status = '1';
                $tickets->isanswered = '1';
                $tickets->save();
            }
            $thread->save();


            if (!empty($attach)) {
                $check_attachment = $this->attach($thread->id, $attach);
            }

            $thread1 = Ticket_Thread::where('ticket_id', '=', $ticket_id)->first();
            $ticket_subject = $thread1->title;
            $user_id = $tickets->user_id;
            $user = User::where('id', '=', $user_id)->first();
            $email = $user->email;
            $user_name = $user->user_name;
            $ticket_number = $tickets->ticket_number;
            $company = $this->company();
            $username = $ticket_user->user_name;
            if (!empty(Auth::user()->agent_sign)) {
                $agentsign = Auth::user()->agent_sign;
            } else {
                $agentsign = null;
            }
            \Event::fire(new \App\Events\FaveoAfterReply($reply_content, $user->phone_number, $request, $tickets));

            Mail::send(array('html' => 'emails.ticket_re-reply'), ['content' => $reply_content, 'ticket_number' => $ticket_number, 'From' => $company, 'name' => $username, 'Agent_Signature' => $agentsign], function ($message) use ($email, $user_name, $ticket_number, $ticket_subject, $check_attachment) {
                $message->to($email, $user_name)->subject($ticket_subject . '[#' . $ticket_number . ']');
                // if(isset($attachments)){
//                if ($check_attachment == 1) {
//                    $size = count($attach);
//                    for ($i = 0; $i < $size; $i++) {
//                        $message->attach($attachments[$i]->getRealPath(), ['as' => $attachments[$i]->getClientOriginalName(), 'mime' => $attachments[$i]->getClientOriginalExtension()]);
//                    }
//                }
            }, true);


            $collaborators = Ticket_Collaborator::where('ticket_id', '=', $ticket_id)->get();
            foreach ($collaborators as $collaborator) {
                //mail to collaborators
                $collab_user_id = $collaborator->user_id;
                $user_id_collab = User::where('id', '=', $collab_user_id)->first();
                $collab_email = $user_id_collab->email;
                if ($user_id_collab->role == "user") {
                    $collab_user_name = $user_id_collab->user_name;
                } else {
                    $collab_user_name = $user_id_collab->first_name . " " . $user_id_collab->last_name;
                }
                Mail::send('emails.ticket_re-reply', ['content' => $reply_content, 'ticket_number' => $ticket_number, 'From' => $company, 'name' => $collab_user_name, 'Agent_Signature' => $agentsign], function ($message) use ($collab_email, $collab_user_name, $ticket_number, $ticket_subject, $check_attachment) {
                    $message->to($collab_email, $collab_user_name)->subject($ticket_subject . '[#' . $ticket_number . ']');
//                    if ($check_attachment == 1) {
//                        $size = sizeOf($attachments);
//                        for ($i = 0; $i < $size; $i++) {
//                            $message->attach($attachments[$i]->getRealPath(), ['as' => $attachments[$i]->getClientOriginalName(), 'mime' => $attachments[$i]->getClientOriginalExtension()]);
//                        }
//                    }
                }, true);
            }
            return $thread;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * company
     * @return type
     */
    public function company() {
        try {
            $company = Company::Where('id', '=', '1')->first();
            if ($company->company_name == null) {
                $company = "Support Center";
            } else {
                $company = $company->company_name;
            }
            return $company;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Ticket edit and save ticket data
     * @param type $ticket_id
     * @param type Ticket_Thread $thread
     * @return type bool
     */
    public function ticket_edit_post($ticket_id, $thread, $ticket) {
        try {

            $ticket = $ticket->where('id', '=', $ticket_id)->first();

            $ticket->sla = Input::get("sla_plan");
            $ticket->help_topic_id = Input::get("help_topic");
            $ticket->source = Input::get("ticket_source");
            $ticket->priority_id = Input::get("ticket_priority");
            $ticket->save();

            $threads = $thread->where('ticket_id', '=', $ticket_id)->first();
            $threads->title = Input::get("subject");
            $threads->save();
            return $threads;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * function to assign ticket
     * @param type $id
     * @return type bool
     */
    public function assign($id) {
        try {
            $UserEmail = Input::get('user');
            //dd($id);
            // $UserEmail = 'sujitprasad12@yahoo.in';
            $user = User::where('email', '=', $UserEmail)->first();
            $user_id = $user->id;
            $ticket = Tickets::where('id', '=', $id)->first();
            $ticket_number = $ticket->ticket_number;
            $ticket->assigned_to = $user_id;
            $ticket->save();
            $ticket_thread = Ticket_Thread::where('ticket_id', '=', $id)->first();
            $ticket_subject = $ticket_thread->title;
            $thread = New Ticket_Thread;
            $thread->ticket_id = $ticket->id;
            $thread->user_id = Auth::user()->id;
            $thread->is_internal = 1;
            $thread->body = "This Ticket has been assigned to " . $user->first_name . " " . $user->last_name;
            $thread->save();

            $company = $this->company();
            $system = $this->system();

            $agent = $user->first_name;
            $agent_email = $user->email;

            $master = Auth::user()->first_name . " " . Auth::user()->last_name;
            if (Alert::first()->internal_status == 1 || Alert::first()->internal_assigned_agent == 1) {
                // ticket assigned send mail
                Mail::send('emails.Ticket_assign', ['agent' => $agent, 'ticket_number' => $ticket_number, 'from' => $company, 'master' => $master, 'system' => $system], function ($message) use ($agent_email, $agent, $ticket_number, $ticket_subject) {
                    $message->to($agent_email, $agent)->subject($ticket_subject . '[#' . $ticket_number . ']');
                });
            }

            return 1;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to delete ticket
     * @param type $id
     * @param type Tickets $ticket
     * @return type string
     */
    public function delete($ids, $ticket) {

        try {
            foreach ($ids as $id) {
                $ticket_delete = $ticket->where('id', '=', $id)->first();
                if ($ticket_delete) {
                    if ($ticket_delete->status == 5) {
                        $ticket_delete->delete();
                        $ticket_threads = Ticket_Thread::where('ticket_id', '=', $id)->get();
                        if ($ticket_threads) {
                            foreach ($ticket_threads as $ticket_thread) {
                                if ($ticket_thread) {
                                    $ticket_thread->delete();
                                }
                            }
                        }
                        $ticket_attachments = Ticket_attachments::where('thread_id', '=', $id)->get();
                        if ($ticket_attachments) {
                            foreach ($ticket_attachments as $ticket_attachment) {
                                if ($ticket_attachment) {
                                    $ticket_attachment->delete();
                                }
                            }
                        }
                    } else {
                        $ticket_delete->is_deleted = 0;
                        $ticket_delete->status = 5;
                        $ticket_delete->save();
                        $ticket_status_message = Ticket_Status::where('id', '=', $ticket_delete->status)->first();
                        $thread = New Ticket_Thread;
                        $thread->ticket_id = $ticket_delete->id;
                        $thread->user_id = Auth::user()->id;
                        $thread->is_internal = 1;
                        $thread->body = $ticket_status_message->message . " " . Auth::user()->first_name . " " . Auth::user()->last_name;
                        $thread->save();
                    }
                } else {
                    return "ticket not found";
                }
            }
            return "your tickets has been deleted";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * check email for dublicate entry
     * @param type $email
     * @return type bool
     */
    public function check_email($email) {
        try {
            $check = User::where('email', '=', $email)->first();
            if ($check == true) {
                return $check;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * system
     * @return type
     */
    public function system() {
        try {
            $system = System::Where('id', '=', '1')->first();
            if ($system->name == null) {
                $system = "Support Center";
            } else {
                $system = $system->name;
            }
            return $system;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Create Attachment
     * @param type $thread
     * @param type $attach
     * @return int
     */
    public function attach($thread, $attach) {
        try {
            $ta = new Ticket_attachments();
            foreach ($attach as $file) {
                $ta->create(['thread_id' => $thread, 'name' => $file['name'], 'size' => $file['size'], 'type' => $file['type'], 'file' => $file['file'], 'poster' => 'ATTACHMENT']);
            }
            $ta->create(['thread_id' => $thread, 'name' => $name, 'size' => $size, 'type' => $type, 'file' => $file, 'poster' => 'ATTACHMENT']);
            return 1;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
