<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Ticket;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function send_email($name , $email , $body)
	{
		$to_name = $name;
		$to_email = $email;
		$data = array('name'=>"Dear ".$name, "body" => $body);
    
		Mail::send('emails.test', $data, function($message) use ($to_name, $to_email) {
			$message->to($to_email, $to_name)
            ->subject('Ticket System');
            $message->from('tecsee@gmail.com', 'Tecsee');
		});
	}

	 
	public function dashboard($locale,$id){
		$assigned_tickets = Ticket::where('user_assigned_id', Auth::user()->id)->get();
		$owned_tickets = Ticket::where('user_id', Auth::user()->id)->get();
		$added_tickets_by_me = Ticket::where('added_by', Auth::user()->id)->where('user_id','!=',Auth::user()->id)->get();

		$admins = User::where(function ($query) {
               $query->where('super_admin', '=', 1)
                     ->orWhere('admin', '=', 1);
           })
           ->get();	

		$users = User::where(['super_admin'=>0 , 'admin'=>0])->orWhere(['admin'=>1])->get();		
		return view('tickets.dashboard')->with('admins',$admins)->with('users',$users)->with('added_tickets_by_me',$added_tickets_by_me)
			->with('assigned_tickets',$assigned_tickets)->with('owned_tickets',$owned_tickets);
	}		
	public function search($locale,Request $request){
		$tickets = Ticket::where('id','>',0)->where(function($qry) use ($request){

			if($request->user_id != ''){
				$qry->orwhere('user_id',$request->user_id);
			}
			if($request->start_date != ''){
				$qry->orwhere('start_date',$request->start_date);
			}
			if($request->end_date != ''){
				$qry->orwhere('end_date',$request->end_date);
			}
			if($request->user_assigned_id != ''){
				$qry->orwhere('user_assigned_id',$request->user_assigned_id);
			}
		})->get();
			
        return view('tickets.search')->with('tickets',$tickets);
	}
    public function index()
    {
        return view('tickets.index')->with('tickets',Ticket::all());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$admins = User::where('id', '!=', NULL)
           ->where(function ($query) {
               $query->where('super_admin', '=', 1)
                     ->orWhere('admin', '=', 1);
           })
           ->get();	
		if(Auth::user()->is_owner()){
			$users = User::where(['id'=>Auth::user()->id])->get();
		}else{
			$users = User::where(['super_admin'=>0 , 'admin'=>0])->orWhere(['admin'=>1])->orWhere(['super_admin'=>1])->get();
		}
		// }else{
			// $users = User::where(['super_admin'=>0 , 'admin'=>0])->orWhere(['admin'=>1])->get();

		// }		
        return view('tickets.create')->with('users',$users)->with('admins',$admins);
		
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($locale,Request $request)
    {
       $this->validate($request,[
			'user_id' => 'required|integer',
            'ticket_no' => 'required|unique:tickets,ticket_no|max:20|string',
			'start_date' => 'required|date_format:Y-m-d',
			'end_date' => 'required|date_format:Y-m-d|after:start_date',
			'user_assigned_id'=>'different:user_id'
        ]
		// [
		// 'user_assigned_id.different'=>'User Assigned and Owner must be Different'
		// ]
		);
		
		$ticket = Ticket::create($request->all());
		$ticket->added_by = Auth::user()->id;
		$ticket->save();
		if(!empty($request->user_assigned_id)){
			$ticket->user_assigned_id=$request->user_assigned_id;
			$ticket->save();
			$admin = User::where('id',$request->user_assigned_id)->first();
			$body = "New Ticket is assigned to you  Ticket No".$request->ticket_no;
			$this->send_email($admin->name , $admin->email , $body);
		}
		Session::flash('success', 'New Ticket has been created');
		return redirect()->back();		
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($locale,$id)
    {
		$admins = User::where('id', '!=', NULL)
           ->where(function ($query) {
               $query->where('super_admin', '=', 1)
                     ->orWhere('admin', '=', 1);
           })
           ->get();		
		if(Auth::user()->is_owner()){
			$users = User::where(['id'=>Auth::user()->id])->get();
		}else{
			$users = User::where(['super_admin'=>0 , 'admin'=>0])->orWhere(['admin'=>1])->orWhere(['super_admin'=>1])->get();
		}			
        return view('tickets.edit')->with('ticket',Ticket::find($id))->with('users',$users)->with('admins',$admins);;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($locale,Request $request, $id)
    {
        $this->validate($request,[
			'user_id' => 'required|integer',
            'ticket_no' => 'required|unique:tickets,id,'.$id.',ticket_no|max:20|string',
			'start_date' => 'required|date_format:Y-m-d',
			'end_date' => 'required|date_format:Y-m-d|after:start_date',
			'user_assigned_id'=>'different:user_id'
        ]
		// [
		// 'user_assigned_id.different'=>'User Assigned and Owner must be Different'
		// ]
		);
		$ticket = Ticket::find($id);
		$ticket->user_id=$request->user_id;
        $ticket->ticket_no=$request->ticket_no;
		$ticket->start_date = $request->start_date;
		$ticket->end_date = $request->end_date;
		$ticket->description = $request->description;
		if(!empty($request->user_assigned_id)){
			$ticket->user_assigned_id=$request->user_assigned_id;			
		}		
		$ticket->save();	
		Session::flash('success', ' Ticket has been updated');

        return redirect()->back()->withInput();		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($locale,$id)
    {
        $ticket = Ticket::find($id);
		$ticket->delete();
		Session::flash('success', 'Ticket Has Been Deleted');
		return redirect()->back();		
    }
	
    public function open($locale,$id)
    {
        $ticket = Ticket::find($id);
        $ticket->status = 1;
        $ticket->save();
		$ticket = Ticket::where('id',$id)->first();
		$body = 'your Ticket '.$ticket->ticket_no.' is opened  ' ;
		$this->send_email($ticket->user->name , $ticket->user->email , $body);
				
		Session::flash('success', 'Ticket Has Been Opened');
		return redirect()->back();		
    }

    public function close($locale,$id)
    {
        $ticket = Ticket::find($id);
        $ticket->status =0;
        $ticket->save();
		$ticket = Ticket::where('id',$id)->first();		
		$body = 'your Ticket '.$ticket->ticket_no.' is Closed  ' ;
		$this->send_email($ticket->user->name , $ticket->user->email , $body);
		Session::flash('success', 'Ticket Has Been Closed');
		return redirect()->back();		
    }	
    public function reopen($locale,Request $request,$id)
    {
        $this->validate($request,[
			'today_date' => 'required|date',
			'reopen_end_date' => 'required|date_format:Y-m-d|after:today_date',
        ]
		// [
		// 'reopen_end_date.after'=>'End Date Must be larger than '.$request->end_date_old
		// ]
		);
		$ticket = Ticket::find($id);
		$ticket->end_date = $request->reopen_end_date;		
        $ticket->status = 2;
        $ticket->save();
		$ticket = Ticket::where('id',$id)->first();
		$body = 'your Ticket '.$ticket->ticket_no.' is Reopened  ' ;
		$this->send_email($ticket->user->name , $ticket->user->email , $body);
		Session::flash('success', 'Ticket Has Been Reopened');		
		

        return redirect()->back()->withInput();				
    }

    public function mytickets($locale,$id)
    {
		$tickets = Ticket::where('user_id', Auth::user()->id)->get();		
        return view('tickets.mytickets')->with('tickets',$tickets);

    }

    public function assignedtickets($locale,$id)
    {
		$tickets = Ticket::where('user_assigned_id', Auth::user()->id)->get();		
        return view('tickets.assignedtickets')->with('tickets',$tickets);

    }	
	
	
	///////////////////////////OWNER//////////////////////
	 public function addticket()
    {
		
		$admins = User::where('id', '!=', Auth::user()->id)
           ->where(function ($query) {
               $query->where('super_admin', '=', 1)
                     ->orWhere('admin', '=', 1);
           })
           ->get();	
		if(Auth::user()->is_owner()){
			$users = User::where(['id'=>Auth::user()->id])->get();
		}else{
			$users = User::where(['super_admin'=>0 , 'admin'=>0])->orWhere(['admin'=>1])->get();
		}			
        return view('tickets.addticket')->with('users',$users)->with('admins',$admins);
		
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save($locale,Request $request)
    {
       $this->validate($request,[
			'user_id' => 'required|integer',
            'ticket_no' => 'required|unique:tickets,ticket_no|max:20|string',
			'start_date' => 'required|date',
			'end_date' => 'required|date|after:start_date',
        ]);
		
		$ticket = Ticket::create($request->all());
		if(!empty($request->user_assigned_id)){
			$ticket->user_assigned_id=$request->user_assigned_id;
			$ticket->save();
			$admin = User::where('id',$request->user_assigned_id)->first();
			$body = "New Ticket is assigned to you  Ticket No".$request->ticket_no;
			$this->send_email($admin->name , $admin->email , $body);
		}
		Session::flash('success', 'New Ticket has been created');

		return redirect()->back();		
	}
	
 public function change($locale,$id)
    {
		$admins = User::where('id', '!=', Auth::user()->id)
           ->where(function ($query) {
               $query->where('super_admin', '=', 1)
                     ->orWhere('admin', '=', 1);
           })
           ->get();		
		if(Auth::user()->is_owner()){
			$users = User::where(['id'=>Auth::user()->id])->get();
		}else{
			$users = User::where(['super_admin'=>0 , 'admin'=>0])->orWhere(['admin'=>1])->get();
		}			
        return view('tickets.change')->with('ticket',Ticket::find($id))->with('users',$users)->with('admins',$admins);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function savechange($locale,Request $request, $id)
    {
        $this->validate($request,[
			'user_id' => 'required|integer',
            'ticket_no' => 'required|unique:tickets,id,'.$id.',ticket_no|max:20|string',
			'start_date' => 'required|date',
			'end_date' => 'required|date|after:start_date',
        ]);
		$ticket = Ticket::find($id);
		$ticket->user_id=$request->user_id;
        $ticket->ticket_no=$request->ticket_no;
		$ticket->start_date = $request->start_date;
		$ticket->end_date = $request->end_date;
		$ticket->description = $request->description;
		if(!empty($request->user_assigned_id)){
			$ticket->user_assigned_id=$request->user_assigned_id;			
		}		
		$ticket->save();	
		Session::flash('success', ' Ticket has been updated');

        return redirect()->back()->withInput();		
    }
    public function ownertickets($locale,$id)
    {
		$tickets = Ticket::where('user_id', Auth::user()->id)->get();		
        return view('tickets.ownertickets')->with('tickets',$tickets);

    }	
    public function destroyownerticket($locale,$id)
    {
        $ticket = Ticket::find($id);
		$ticket->delete();
		Session::flash('success', 'Ticket Has Been Deleted');
        return redirect()->back()->withInput();		
    }	

}
