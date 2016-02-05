<?php

"%smtplink%";

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

$router->get('getmail/{token}', 'Auth\AuthController@getMail');

/*
|-------------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------------
| These routes are the API calls.
|
 */
// Route::group(['prefix' => 'api'], function () {

// 	Route::get('/database-config',['as'=>'database-config','uses'=>'Api\v1\InstallerApiController@config_database']);
// 	Route::get('/system-config',['as'=>'database-config','uses'=>'Api\v1\InstallerApiController@config_system']);
	
// });



/*
|-------------------------------------------------------------------------------
| Admin Routes
|-------------------------------------------------------------------------------
| Here is defining entire routes for the Admin Panel
|
 */
Route::group(['middleware' => 'roles', 'middleware' => 'auth'], function () {
	// resource is a function to process create,edit,read and delete
	Route::resource('groups', 'Admin\helpdesk\GroupController'); // for group module, for CRUD

	Route::resource('departments', 'Admin\helpdesk\DepartmentController'); // for departments module, for CRUD

	Route::resource('teams', 'Admin\helpdesk\TeamController'); // in teams module, for CRUD

	Route::resource('agents', 'Admin\helpdesk\AgentController'); // in agents module, for CRUD

	Route::resource('emails', 'Admin\helpdesk\EmailsController'); // in emails module, for CRUD

	Route::resource('banlist', 'Admin\helpdesk\BanlistController'); // in banlist module, for CRUD

	Route::resource('template', 'Admin\helpdesk\TemplateController'); // in template module, for CRUD

	Route::get('getdiagno', 'Admin\helpdesk\TemplateController@formDiagno'); // for getting form for diagnostic

	Route::post('postdiagno', 'Admin\helpdesk\TemplateController@postDiagno'); // for getting form for diagnostic

	Route::resource('helptopic', 'Admin\helpdesk\HelptopicController'); // in helptopics module, for CRUD

	Route::resource('sla', 'Admin\helpdesk\SlaController'); // in SLA Plan module, for CRUD

	Route::resource('forms','Admin\helpdesk\FormController');

	Route::get('delete-forms/{id}',['as'=>'forms.delete','uses'=>'Admin\helpdesk\FormController@delete']);

	//$router->model('id','getcompany');

	Route::get('agent-profile-page/{id}',['as'=>'agent.profile.page','uses'=>'Admin\helpdesk\AgentController@agent_profile']);

	Route::get('getcompany', 'Admin\helpdesk\SettingsController@getcompany'); // direct to company setting page

	Route::patch('postcompany/{id}', 'Admin\helpdesk\SettingsController@postcompany'); // Updating the Company table with requests

	Route::get('getsystem', 'Admin\helpdesk\SettingsController@getsystem'); // direct to system setting page

	Route::patch('postsystem/{id}', 'Admin\helpdesk\SettingsController@postsystem'); // Updating the System table with requests

	Route::get('getticket', 'Admin\helpdesk\SettingsController@getticket'); // direct to ticket setting page

	Route::patch('postticket/{id}', 'Admin\helpdesk\SettingsController@postticket'); // Updating the Ticket table with requests

	Route::get('getemail', 'Admin\helpdesk\SettingsController@getemail'); // direct to email setting page

	Route::patch('postemail/{id}', 'Admin\helpdesk\SettingsController@postemail'); // Updating the Email table with requests

	// Route::get('getaccess', 'Admin\helpdesk\SettingsController@getaccess'); // direct to access setting page

	// Route::patch('postaccess/{id}', 'Admin\helpdesk\SettingsController@postaccess'); // Updating the Access table with requests

	Route::get('getresponder', 'Admin\helpdesk\SettingsController@getresponder'); // direct to responder setting page

	Route::patch('postresponder/{id}', 'Admin\helpdesk\SettingsController@postresponder'); // Updating the Responder table with requests

	Route::get('getalert', 'Admin\helpdesk\SettingsController@getalert'); // direct to alert setting page

	Route::patch('postalert/{id}', 'Admin\helpdesk\SettingsController@postalert'); // Updating the Alert table with requests

	Route::get('admin-profile', 'Admin\helpdesk\ProfileController@getProfile');	/*  User profile edit get  */
	
	Route::get('admin-profile-edit', 'Admin\helpdesk\ProfileController@getProfileedit');/*  Admin profile get  */
	
	Route::patch('admin-profile', 'Admin\helpdesk\ProfileController@postProfileedit');/* Admin Profile Post */

	Route::patch('admin-profile-password', 'Admin\helpdesk\ProfileController@postProfilePassword');/*  Admin Profile Password Post */
	
	Route::get('widgets', 'Common\SettingsController@widgets');/* get the create footer page for admin */	

	Route::get('list-widget', 'Common\SettingsController@list_widget');/* get the list widget page for admin */

	Route::post('edit-widget/{id}', 'Common\SettingsController@edit_widget');/* get the create footer page for admin */

	Route::get('social-buttons', 'Common\SettingsController@social_buttons');/* get the create footer page for admin */	

	Route::get('list-social-buttons', 'Common\SettingsController@list_social_buttons');/* get the list widget page for admin */

	Route::post('edit-widget/{id}', 'Common\SettingsController@edit_social_buttons');/* get the create footer page for admin */	
	
	Route::get('getsmtp',['as'=>'getsmtp','uses'=>'Common\SettingsController@getsmtp']);	/* get the create footer page for admin */
	
	Route::patch('post-smtp',['as'=>'post_smtp','uses'=>'Common\SettingsController@postsmtp']);	/* post footer to insert to database */

	Route::get('version-check',['as'=>'version-check','uses'=>'Common\SettingsController@version_check']);	/* Check version  */

	Route::post('post-version-check',['as'=>'post-version-check','uses'=>'Common\SettingsController@post_version_check']);	/* post Check version */	

	Route::get('checkUpdate',['as'=>'checkupdate','uses'=>'Common\SettingsController@getupdate']);	/* get Check update */	

	Route::get('admin', array('as'=>'setting', 'uses'=>'Admin\helpdesk\SettingsController@settings'));

	    Route::get('plugins',['as'=>'plugins','uses'=>'Common\SettingsController@Plugins']);
        
        Route::get('getplugin', array('as'=>'get.plugin', 'uses'=>'Common\SettingsController@GetPlugin'));
        
        Route::post('post-plugin',['as'=>'post.plugin','uses'=>'Common\SettingsController@PostPlugins']);
        
        Route::get('getconfig', array('as'=>'get.config', 'uses'=>'Common\SettingsController@fetchConfig'));
        
        Route::get('plugin/delete/{slug}', array('as'=>'delete.plugin', 'uses'=>'Common\SettingsController@DeletePlugin'));
        
        Route::get('plugin/status/{slug}', array('as'=>'status.plugin', 'uses'=>'Common\SettingsController@StatusPlugin'));

	   	//Routes for showing language table and switching language
		Route::get('languages',['as'=>'LanguageController','uses'=>'Admin\helpdesk\LanguageController@index']);
		
		Route::get('get-languages', array('as'=>'getAllLanguages', 'uses'=>'Admin\helpdesk\LanguageController@getLanguages'));
		
		Route::get('change-language/{lang}', ['as'=>'lang.switch', 'uses'=>'Admin\helpdesk\LanguageController@switchLanguage']);

		//Route for download language template package
		Route::get('/download-template', array('as' => 'download', 'uses' => 'Admin\helpdesk\LanguageController@download'));

		//Routes for language file upload form-----------You may want to use csrf protection for these route--------------
		Route::post('language/add', 'Admin\helpdesk\LanguageController@postForm');
		Route::get('language/add',array('as'=>'add-language','uses'=>'Admin\helpdesk\LanguageController@getForm'));

		//Routes for  delete language package
 		Route::get('delete-language/{lang}', ['as'=>'lang.delete', 'uses'=>'Admin\helpdesk\LanguageController@deleteLanguage']);

});

/*
|------------------------------------------------------------------
|Agent Routes
|--------------------------------------------------------------------
| Here defining entire Agent Panel routers
|
|
 */
Route::group(['middleware' => 'role.agent', 'middleware' => 'auth'], function () {

	Route::get('agen1', 'Agent\helpdesk\DashboardController@ChartData');

	Route::post('chart-range', ['as' => 'post.chart', 'uses' => 'Agent\helpdesk\DashboardController@ChartData']);

	Route::resource('user', 'Agent\helpdesk\UserController');	/* User router is used to control the CRUD of user */

	Route::get('user-list', ['as' => 'user.list' , 'uses' => 'Agent\helpdesk\UserController@user_list']);

	// Route::get('user/delete/{id}', ['as' => 'user.delete' , 'uses' => 'Agent\helpdesk\UserController@destroy']);

	Route::resource('organizations', 'Agent\helpdesk\OrganizationController');	/* organization router used to deal CRUD function of organization */

	Route::get('org-list',['as' => 'org.list' , 'uses' => 'Agent\helpdesk\OrganizationController@org_list']);

	Route::get('org/delete/{id}', ['as' => 'org.delete' , 'uses' => 'Agent\helpdesk\OrganizationController@destroy']);

	Route::get('profile',['as'=>'profile' , 'uses'=> 'Agent\helpdesk\UserController@getProfile']);	/*  User profile get  */

	Route::get('profile-edit', ['as'=>'agent-profile-edit','uses'=>'Agent\helpdesk\UserController@getProfileedit']);	/*  User profile edit get  */

	Route::patch('agent-profile',['as'=>'agent-profile','uses'=> 'Agent\helpdesk\UserController@postProfileedit']);	/* User Profile Post */

	Route::patch('agent-profile-password/{id}', 'Agent\helpdesk\UserController@postProfilePassword');	/*  Profile Password Post */

	Route::get('canned/list',['as'=>'canned.list','uses'=>'Agent\helpdesk\CannedController@index']);	/* Canned list */

	Route::get('canned/create',['as'=>'canned.create','uses'=>'Agent\helpdesk\CannedController@create']);	/* Canned create */

	Route::patch('canned/store',['as'=>'canned.store','uses'=>'Agent\helpdesk\CannedController@store']);	/* Canned store */

	Route::get('canned/edit/{id}',['as'=>'canned.edit','uses'=>'Agent\helpdesk\CannedController@edit']);	/* Canned edit */

	Route::patch('canned/update/{id}',['as'=>'canned.update','uses'=>'Agent\helpdesk\CannedController@update']);	/* Canned update */

	Route::get('canned/show/{id}',['as'=>'canned.show','uses'=>'Agent\helpdesk\CannedController@show']);	/* Canned show */

	Route::delete('canned/destroy/{id}',['as'=>'canned.destroy','uses'=>'Agent\helpdesk\CannedController@destroy']);	/* Canned delete */

	Route::get('/test', ['as' => 'thr', 'uses' => 'Agent\helpdesk\MailController@fetchdata']);	/*  Fetch Emails */

	Route::get('/ticket', ['as' => 'ticket', 'uses' => 'Agent\helpdesk\TicketController@ticket_list']);	/*  Get Ticket */

	Route::get('/ticket/inbox', ['as' => 'inbox.ticket', 'uses' => 'Agent\helpdesk\TicketController@inbox_ticket_list']);	/*  Get Inbox Ticket */

	Route::get('/ticket/get-inbox', ['as' => 'get.inbox.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_inbox']);  /* Get tickets in datatable */

	Route::get('/ticket/open', ['as' => 'open.ticket', 'uses' => 'Agent\helpdesk\TicketController@open_ticket_list']);	/*  Get Open Ticket */

	Route::get('/ticket/get-open', ['as' => 'get.open.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_open']);  /* Get tickets in datatable */

	Route::get('/ticket/answered', ['as' => 'answered.ticket', 'uses' => 'Agent\helpdesk\TicketController@answered_ticket_list']);	/*  Get Answered Ticket */

	Route::get('/ticket/get-answered', ['as' => 'get.answered.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_answered']);  /* Get tickets in datatable */

	Route::get('/ticket/myticket', ['as' => 'myticket.ticket', 'uses' => 'Agent\helpdesk\TicketController@myticket_ticket_list']);	/*  Get Tickets Assigned to logged user */

	Route::get('/ticket/get-myticket', ['as' => 'get.myticket.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_myticket']);  /* Get tickets in datatable */

	Route::get('/ticket/overdue', ['as' => 'overdue.ticket', 'uses' => 'Agent\helpdesk\TicketController@overdue_ticket_list']);	/*  Get Overdue Ticket */

	Route::get('/ticket/closed', ['as' => 'closed.ticket', 'uses' => 'Agent\helpdesk\TicketController@closed_ticket_list']);	/*  Get Closed Ticket */

	Route::get('/ticket/get-closed', ['as' => 'get.closed.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_closed']);  /* Get tickets in datatable */

	Route::get('/ticket/assigned', ['as' => 'assigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@assigned_ticket_list']);	/*  Get Assigned Ticket */

	Route::get('/ticket/get-assigned', ['as' => 'get.assigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_assigned']);  /* Get tickets in datatable */

	Route::get('/newticket', ['as' => 'newticket', 'uses' => 'Agent\helpdesk\TicketController@newticket']);	/*  Get Create New Ticket */

	Route::post('/newticket/post', ['as' => 'post.newticket', 'uses' => 'Agent\helpdesk\TicketController@post_newticket']);	/*  Post Create New Ticket */

	Route::get('/thread/{id}', ['as' => 'ticket.thread', 'uses' => 'Agent\helpdesk\TicketController@thread']);	/*  Get Thread by ID */

	Route::patch('/thread/reply/{id}', ['as' => 'ticket.reply', 'uses' => 'Agent\helpdesk\TicketController@reply']);	/*  Patch Thread Reply */

	Route::patch('/internal/note/{id}', ['as' => 'Internal.note', 'uses' => 'Agent\helpdesk\TicketController@InternalNote']);	/*  Patch Internal Note */

	Route::patch('/ticket/assign/{id}', ['as' => 'assign.ticket', 'uses' => 'Agent\helpdesk\TicketController@assign']);	/*  Patch Ticket assigned to whom */

	Route::patch('/ticket/post/edit/{id}', ['as' => 'ticket.post.edit', 'uses' => 'Agent\helpdesk\TicketController@ticket_edit_post']);	/*  Patchi Ticket Edit */

	Route::get('/ticket/print/{id}', ['as' => 'ticket.print', 'uses' => 'Agent\helpdesk\TicketController@ticket_print']);	/*  Get Print Ticket */

	Route::get('/ticket/close/{id}', ['as' => 'ticket.close', 'uses' => 'Agent\helpdesk\TicketController@close']);	/*  Get Ticket Close */

	Route::get('/ticket/resolve/{id}', ['as' => 'ticket.resolve', 'uses' => 'Agent\helpdesk\TicketController@resolve']);	/*  Get ticket Resolve */

	Route::get('/ticket/open/{id}', ['as' => 'ticket.open', 'uses' => 'Agent\helpdesk\TicketController@open']);	/*  Get Ticket Open */

	Route::get('/ticket/delete/{id}', ['as' => 'ticket.delete', 'uses' => 'Agent\helpdesk\TicketController@delete']);	/*  Get Ticket Delete */

	Route::get('/email/ban/{id}', ['as' => 'ban.email', 'uses' => 'Agent\helpdesk\TicketController@ban']);	/*  Get Ban Email */

	Route::get('/ticket/surrender/{id}', ['as' => 'ticket.surrender', 'uses' => 'Agent\helpdesk\TicketController@surrender']);	/*  Get Ticket Surrender */

	Route::get('/aaaa', 'Client\helpdesk\GuestController@ticket_number');

	Route::get('trash', 'Agent\helpdesk\TicketController@trash');	/* To show Deleted Tickets */

	Route::get('/ticket/trash', ['as' => 'get.trash.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_trash']);  /* Get tickets in datatable */

	Route::get('unassigned', 'Agent\helpdesk\TicketController@unassigned');	/* To show Unassigned Tickets */

	Route::get('/ticket/unassigned', ['as' => 'get.unassigned.ticket', 'uses' => 'Agent\helpdesk\TicketController@get_unassigned']);  /* Get tickets in datatable */

	Route::get('dashboard', 'Agent\helpdesk\DashboardController@index');	/* To show dashboard pages */
    
    Route::get('agen', 'Agent\helpdesk\DashboardController@ChartData');	

	Route::get('image/{id}', ['as'=>'image', 'uses'=>'Agent\helpdesk\MailController@get_data']);	/* get image */	

	Route::get('thread/auto/{id}', 'Agent\helpdesk\TicketController@autosearch');

	Route::get('auto', 'Agent\helpdesk\TicketController@autosearch2');

	Route::patch('search-user', 'Agent\helpdesk\TicketController@usersearch');
	
	Route::patch('add-user', 'Agent\helpdesk\TicketController@useradd');
	
	Route::post('remove-user', 'Agent\helpdesk\TicketController@userremove');

	Route::post('select_all', ['as'=>'select_all' ,'uses'=>'Agent\helpdesk\TicketController@select_all']);

	Route::post('canned/{id}', 'Agent\helpdesk\CannedController@get_canned');
	
	// Route::get('message' , 'MessageController@show');

	Route::post('lock',['as'=>'lock' , 'uses'=>'Agent\helpdesk\TicketController@lock']);

	Route::patch('user-org-assign/{id}', ['as'=>'user.assign.org',	'uses'=>'Agent\helpdesk\UserController@UserAssignOrg']);

	Route::patch('/user-org/{id}','Agent\helpdesk\UserController@User_Create_Org');

	Route::patch('/head-org/{id}','Agent\helpdesk\OrganizationController@Head_Org');
	
	// Department ticket

	Route::get('/{dept}/open',['as'=>'dept.open.ticket','uses'=>'Agent\helpdesk\TicketController@deptopen']);	// Open

	Route::get('/{dept}/inprogress',['as'=>'dept.inprogress.ticket','uses'=>'Agent\helpdesk\TicketController@deptinprogress']);	// Inprogress

	Route::get('/{dept}/closed',['as'=>'dept.closed.ticket','uses'=>'Agent\helpdesk\TicketController@deptclose']);	// Closed
	
});

/*
|------------------------------------------------------------------
|Guest Routes
|--------------------------------------------------------------------
| Here defining Guest User's routes
|
|
*/
// seasrch
Route::POST('tickets/search/', function() {
       $keyword = Illuminate\Support\Str::lower(Input::get('auto'));
       $models = App\Model\Ticket\Tickets::where('ticket_number', '=',$keyword)->orderby('ticket_number')->take(10)->skip(0)->get();
    $count = count($models);
    return Illuminate\Support\Facades\Redirect::back()->with("contents", $models)->with("counts", $count);
    
});
Route::any('getdata', function() {

   $term = Illuminate\Support\Str::lower(Input::get('term'));
   $data = Illuminate\Support\Facades\DB::table("tickets")->distinct()->select('ticket_number')->where('ticket_number','LIKE',$term.'%')->groupBy('ticket_number')->take(10)->get();
   foreach($data as $v) {
   return [
       'value' => $v->ticket_number
   ];
   }
});


	Route::get('getform', ['as'=>'guest.getform' ,'uses'=> 'Client\helpdesk\FormController@getForm']);	/* get the form for create a ticket by guest user */

	Route::post('postform/{id}', 'Client\helpdesk\FormController@postForm');	/* post the AJAX form for create a ticket by guest user */

	Route::post('postedform', 'Client\helpdesk\FormController@postedForm');	/* post the form to store the value */

	Route::get('check', 'CheckController@getcheck');	//testing checkbox auto-populate

	Route::post('postcheck/{id}', 'CheckController@postcheck');

	Route::get('home', ['as'=>'home', 'uses'=>'Client\helpdesk\WelcomepageController@index']);	//guest layout

	Route::get('/', ['as'=>'/', 'uses'=>'Client\helpdesk\WelcomepageController@index']);

	Route::get('create-ticket',['as'=>'form','uses'=>'Client\helpdesk\FormController@getForm']);	//getform

	Route::get('mytickets/{id}', ['as' => 'ticketinfo', 'uses' => 'Client\helpdesk\GuestController@singleThread']);	//detail ticket information

	Route::post('checkmyticket', 'Client\helpdesk\GuestController@PostCheckTicket');	//ticket ckeck

	Route::get('check_ticket/{id}', ['as' => 'check_ticket', 'uses' => 'Client\helpdesk\GuestController@get_ticket_email']);	//detail ticket information

//testing ckeditor
//===================================================================================
Route::group(['middleware' => 'role.user', 'middleware' => 'auth'], function () {

	Route::get('client-profile', ['as'=>'client.profile', 'uses'=>'Client\helpdesk\GuestController@getProfile']);	/*  User profile get  */

    Route::get('mytickets', ['as' => 'ticket2', 'uses' => 'Client\helpdesk\GuestController@getMyticket']);

    Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@thread']);	/* Get my tickets */

	Route::patch('client-profile-edit', 'Client\helpdesk\GuestController@postProfile');	/* User Profile Post */

	Route::patch('client-profile-password', 'Client\helpdesk\GuestController@postProfilePassword');	/*  Profile Password Post */

	Route::post('post/reply/{id}',['as'=>'client.reply','uses'=>'Client\helpdesk\ClientTicketController@reply']);

});

//====================================================================================

	Route::get('checkticket', 'Client\helpdesk\ClientTicketController@getCheckTicket');	/* Check your Ticket */

	Route::get('myticket', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@getMyticket']);/* Get my tickets */

	Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@thread']);/* Get my tickets */

	Route::post('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket');/* post Check Ticket */

	Route::get('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket');

	Route::post('post-ticket-reply/{id}', 'Client\helpdesk\FormController@post_ticket_reply');


/* 404 page */
// Route::get('404', 'error\ErrorController@error404');

/*
 |============================================================ 
 |  Installer Routes
 |============================================================
 |  These routes are for installer 
 |
 */
	Route::get('/serial', ['as' => 'serialkey' ,'uses' => 'Installer\helpdesk\InstallController@serialkey']);
	Route::post('/CheckSerial/{id}', ['as' => 'CheckSerial', 'uses' => 'Installer\helpdesk\InstallController@PostSerialKey']);
	Route::get('/step1', ['as' => 'licence', 'uses' => 'Installer\helpdesk\InstallController@licence']);
	Route::post('/step1post', ['as' => 'postlicence', 'uses' => 'Installer\helpdesk\InstallController@licencecheck']);
	Route::get('/step2', ['as' => 'prerequisites', 'uses' => 'Installer\helpdesk\InstallController@prerequisites']);
	Route::post('/step2post', ['as' => 'postprerequisites', 'uses' => 'Installer\helpdesk\InstallController@prerequisitescheck']);
	// Route::get('/step3', ['as' => 'localization', 'uses' => 'Installer\helpdesk\InstallController@localization']);
	// Route::post('/step3post', ['as' => 'postlocalization', 'uses' => 'Installer\helpdesk\InstallController@localizationcheck']);
	Route::get('/step3', ['as' => 'configuration', 'uses' => 'Installer\helpdesk\InstallController@configuration']);
	Route::post('/step4post', ['as' => 'postconfiguration','uses' => 'Installer\helpdesk\InstallController@configurationcheck']);
	Route::get('/step4', ['as' => 'database', 'uses' => 'Installer\helpdesk\InstallController@database']);
	Route::get('/step5', ['as' => 'account','uses' => 'Installer\helpdesk\InstallController@account']);
	Route::post('/step6post', ['as' => 'postaccount', 'uses' => 'Installer\helpdesk\InstallController@accountcheck']);
	Route::get('/final', ['as' => 'final','uses' => 'Installer\helpdesk\InstallController@finalize']);
	Route::post('/finalpost', ['as' => 'postfinal','uses' => 'Installer\helpdesk\InstallController@finalcheck']);
	Route::post('/postconnection', ['as' => 'postconnection','uses' => 'Installer\helpdesk\InstallController@postconnection']);

/*
 |============================================================= 
 |  Cron Job links
 |=============================================================
 |	These links are for cron job execution
 |
 */ 
Route::get('readmails',['as' => 'readmails', 'uses' => 'Agent\helpdesk\MailController@readmails']);
Route::get('notification',['as' => 'notification', 'uses' => 'Agent\helpdesk\NotificationController@send_notification']);


/*
 |============================================================= 
 |  View all the Routes
 |=============================================================
 */ 
	Route::get('/aaa',function(){
		$routeCollection = Route::getRoutes();
	echo "<table style='width:100%'>";
	    echo "<tr>";
	        echo "<td width='10%'><h4>HTTP Method</h4></td>";
	        echo "<td width='10%'><h4>Route</h4></td>";
	        echo "<td width='10%'><h4>Url</h4></td>";
	        echo "<td width='80%'><h4>Corresponding Action</h4></td>";
	    echo "</tr>";
	    foreach ($routeCollection as $value) {
	        echo "<tr>";
	            echo "<td>" . $value->getMethods()[0] . "</td>";
	            echo "<td>" . $value->getName() . "</td>";
	            echo "<td>" . $value->getPath() . "</td>";
	            echo "<td>" . $value->getActionName() . "</td>";
	        echo "</tr>";
	    }
	echo "</table>";
	});

/*
 |============================================================= 
 |  Error Routes
 |=============================================================
 */ 
	Route::get('503',function(){ return view('errors.503');});
	Route::get('404',function(){return view('errors.404');});

/*
 |============================================================= 
 |  Test mail Routes
 |=============================================================
 */ 
	Route::get('testmail',function(){
		$e = "hello";
		Config::set('mail.host', 'smtp.gmail.com');
		\Mail::send('errors.report', array('e' => $e), function ($message) {
			$message->to('sujitprasad4567@gmail.com', 'sujit prasad')->subject('Error');
		});
	});




/*  For the crud of catogory  */
$router->resource('category', 'Agent\kb\CategoryController');
$router->get('category/delete/{id}', 'Agent\kb\CategoryController@destroy');
/*  For the crud of article  */
$router->resource('article', 'Agent\kb\ArticleController');
$router->get('article/delete/{id}', 'Agent\kb\ArticleController@destroy');
/* get settings */
$router->get('kb/settings', ['as'=>'settings' , 'uses'=> 'Agent\kb\SettingsController@settings']);
/* post settings */
$router->patch('postsettings/{id}', 'Agent\kb\SettingsController@postSettings');
//Route for administrater to access the comment
$router->get('comment',['as'=>'comment' , 'uses'=> 'Agent\kb\SettingsController@comment']);
/* Route to define the comment should Published */
$router->get('published/{id}',['as'=>'published' , 'uses'=>  'Agent\kb\SettingsController@publish']);
/* Route for deleting comments */
$router->delete('deleted/{id}', ['as'=>'deleted' , 'uses'=>'Agent\kb\SettingsController@delete']);
/* Route for Profile  */
// $router->get('profile', ['as' => 'profile', 'uses' => 'Agent\kb\SettingsController@getProfile']);
/* Profile Update */
// $router->patch('post-profile', ['as' => 'post-profile', 'uses' =>'Agent\kb\SettingsController@postProfile'] );
/* Profile password Update */
// $router->patch('post-profile-password/{id}',['as' => 'post-profile-password', 'uses' => 'Agent\kb\SettingsController@postProfilepassword']);
/* delete Logo */
$router->get('delete-logo/{id}',['as' => 'delete-logo', 'uses' =>  'Agent\kb\SettingsController@deleteLogo']);
/* delete Background */
$router->get('delete-background/{id}',['as' => 'delete-background', 'uses' =>  'Agent\kb\SettingsController@deleteBackground']);
$router->resource('page', 'Agent\kb\PageController');
$router->get('get-pages', ['as' => 'api.page', 'uses' => 'Agent\kb\PageController@getData']);
$router->get('page/delete/{id}',['as' => 'pagedelete', 'uses' =>'Agent\kb\PageController@destroy'] );
$router->get('comment/delete/{id}',['as' => 'commentdelete', 'uses' => 'Agent\kb\SettingsController@delete']);
$router->get('get-articles', ['as' => 'api.article', 'uses' => 'Agent\kb\ArticleController@getData']);
$router->get('get-categorys', ['as' => 'api.category', 'uses' => 'Agent\kb\CategoryController@getData']);
$router->get('get-comment', ['as' => 'api.comment', 'uses' => 'Agent\kb\SettingsController@getData']);
$router->get('test', 'ArticleController@test');

$router->post('image', 'Agent\kb\SettingsController@image');

$router->get('direct', function () {
	return view('direct');
});









// Route::get('/',['as'=>'home' , 'uses'=> 'client\kb\UserController@home'] );
/* post the comment from show page */
$router->post('postcomment/{slug}',['as'=>'postcomment' , 'uses'=>  'Client\kb\UserController@postComment']);
/* get the article list */
$router->get('article-list',['as'=>'article-list' , 'uses'=> 'Client\kb\UserController@getArticle']);
// /* get search values */
$router->get('search',['as'=>'search', 'uses'=> 'Client\kb\UserController@search']);
/* get the selected article */
$router->get('show/{slug}',['as'=>'show' , 'uses'=> 'Client\kb\UserController@show']);
$router->get('category-list', ['as'=>'category-list' , 'uses'=> 'Client\kb\UserController@getCategoryList']);
/* get the categories with article */
$router->get('category-list/{id}',['as'=>'categorylist' , 'uses'=>'Client\kb\UserController@getCategory']);
/* get the home page */
$router->get('knowledgebase',['as'=>'home' , 'uses'=> 'Client\kb\UserController@home']);
/* get the faq value to user */
// $router->get('faq',['as'=>'faq' , 'uses'=>'Client\kb\UserController@Faq'] );
/* get the cantact page to user */
$router->get('contact',['as'=>'contact' , 'uses'=> 'Client\kb\UserController@contact']);
/* post the cantact page to controller */
$router->post('post-contact',['as'=>'post-contact' , 'uses'=> 'Client\kb\UserController@postContact']);
//to get the value for page content
$router->get('pages/{name}', ['as' => 'pages', 'uses' =>'Client\kb\UserController@getPage']);
//profile
// $router->get('client-profile',['as' => 'client-profile', 'uses' => 'Client\kb\UserController@clientProfile']);
// Route::patch('client-profile-edit',['as' => 'client-profile-edit', 'uses' => 'Client\kb\UserController@postClientProfile']);
// Route::patch('client-profile-password/{id}',['as' => 'client-profile-password', 'uses' => 'Client\kb\UserController@postClientProfilePassword']);









Route::get('/inbox/data', ['as' => 'api.inbox', 'uses' => 'Agent\helpdesk\TicketController@get_inbox']);




Route::get('/report','HomeController@getreport');
Route::get('/reportdata','HomeController@pushdata');







/**
 * ================================================================================================
 * @version v1
 * @access public
 * @copyright (c) 2016, Ladybird web solution
 * @author Vijay Sebastian<vijay.sebastian@ladybirdweb.com>
 * @name Faveo
 */
Route::group(['prefix' => 'api/v1'], function() {
    Route::post('register', 'Api\v1\TokenAuthController@register');
    Route::post('authenticate', 'Api\v1\TokenAuthController@authenticate');
    Route::get('authenticate/user', 'Api\v1\TokenAuthController@getAuthenticatedUser');

    Route::get('/database-config',['as'=>'database-config','uses'=>'Api\v1\InstallerApiController@config_database']);
	Route::get('/system-config',['as'=>'database-config','uses'=>'Api\v1\InstallerApiController@config_system']);

    /**
     * Helpdesk
     */
    Route::group(['prefix' => 'helpdesk'], function() {

        Route::post('create', 'Api\v1\ApiController@CreateTicket');
        Route::post('reply', 'Api\v1\ApiController@TicketReply');
        Route::post('edit', 'Api\v1\ApiController@EditTicket');
        Route::post('delete', 'Api\v1\ApiController@DeleteTicket');
        Route::post('assign', 'Api\v1\ApiController@AssignTicket');

        Route::get('open', 'Api\v1\ApiController@OpenedTickets');
        Route::get('unassigned', 'Api\v1\ApiController@OpenedTickets');
        Route::get('closed', 'Api\v1\ApiController@CloseTickets');
        Route::get('agents', 'Api\v1\ApiController@GetAgents');
        Route::get('teams', 'Api\v1\ApiController@GetTeams');
        Route::get('customers', 'Api\v1\ApiController@GetCustomers');
        Route::get('customer', 'Api\v1\ApiController@GetCustomer');
        Route::get('ticket-search', 'Api\v1\ApiController@SearchTicket');
        Route::get('ticket-thread', 'Api\v1\ApiController@TicketThreads');
        Route::get('url', 'Api\v1\ApiController@CheckUrl');
        Route::get('check-url', 'Api\v1\ApiController@UrlResult');
        Route::get('api-key', 'Api\v1\ApiController@GenerateApiKey');
        Route::get('help-topic', 'Api\v1\ApiController@GetHelpTopic');
        Route::get('sla-plan', 'Api\v1\ApiController@GetSlaPlan');
        Route::get('priority', 'Api\v1\ApiController@GetPriority');
        Route::get('department', 'Api\v1\ApiController@GetDepartment');
        Route::get('tickets', 'Api\v1\ApiController@GetTickets');
        Route::get('inbox', 'Api\v1\ApiController@Inbox');
        Route::post('internal-note', 'Api\v1\ApiController@InternalNote');
        
    });

    /**
     * Testing Url
     */
    Route::get('create/user', 'Api\v1\TestController@CreateUser');
    Route::get('create/ticket', 'Api\v1\TestController@CreateTicket');
    Route::get('ticket/reply', 'Api\v1\TestController@TicketReply');
    Route::get('ticket/edit', 'Api\v1\TestController@EditTicket');
    Route::get('ticket/delete', 'Api\v1\TestController@DeleteTicket');

    Route::get('ticket/open', 'Api\v1\TestController@OpenedTickets');
    Route::get('ticket/unassigned', 'Api\v1\TestController@UnassignedTickets');
    Route::get('ticket/closed', 'Api\v1\TestController@CloseTickets');
    Route::get('ticket/assign', 'Api\v1\TestController@AssignTicket');
    Route::get('ticket/agents', 'Api\v1\TestController@GetAgents');
    Route::get('ticket/teams', 'Api\v1\TestController@GetTeams');
    Route::get('ticket/customers', 'Api\v1\TestController@GetCustomers');
    Route::get('ticket/customer', 'Api\v1\TestController@GetCustomer');
    Route::get('ticket/search', 'Api\v1\TestController@GetSearch');
    Route::get('ticket/thread', 'Api\v1\TestController@TicketThreads');
    Route::get('ticket/url', 'Api\v1\TestController@Url');
    Route::get('ticket/api', 'Api\v1\TestController@GenerateApiKey');
    Route::get('ticket/help-topic', 'Api\v1\TestController@GetHelpTopic');
    Route::get('ticket/sla-plan', 'Api\v1\TestController@GetSlaPlan');
    Route::get('ticket/priority', 'Api\v1\TestController@GetPriority');
    Route::get('ticket/department', 'Api\v1\TestController@GetDepartment');
    Route::get('ticket/tickets', 'Api\v1\TestController@GetTickets');
    Route::get('ticket/inbox', 'Api\v1\TestController@Inbox');
    Route::get('ticket/internal', 'Api\v1\TestController@InternalNote');
    
    Route::get('generate/token', 'Api\v1\TestController@GenerateToken');
    Route::get('get/user', 'Api\v1\TestController@GetAuthUser');
});
