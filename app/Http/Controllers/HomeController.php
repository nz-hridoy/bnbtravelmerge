<?php
namespace App\Http\Controllers;

use App\ContactUs;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Helpers\Common;
use App\Http\Controllers\Controller;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Cache;


use View, Auth, App, Session, Route;

use App\Models\{
    Currency,
    Properties,
    Page,
    Settings,
    StartingCities,
    Testimonials,
    language,
    Admin,
    SettingTextWidget,
    User,
    UsersVerification,
    Wallet
};


require base_path() . '/vendor/autoload.php';

class HomeController extends Controller
{
    private $helper;
    
    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index()
    {
        $data['starting_cities'] = StartingCities::limit(4)->get();
        $data['properties']          = Properties::recommendedHome();
        $data['testimonials']        = Testimonials::getAll();
        $sessionLanguage             = Session::get('language');
        $language                    = Settings::where(['name' => 'default_language', 'type' => 'general'])->first();
        
        $languageDetails             = language::where(['id' => $language->value])->first();

        if (!($sessionLanguage)) {
            Session::pull('language');
            Session::put('language', $languageDetails->short_name);
            App::setLocale($languageDetails->short_name);
        }

        $pref = Settings::getAll();

        $prefer = [];

        if (!empty($pref)) {
            foreach ($pref as $value) {
                $prefer[$value->name] = $value->value;
            }
            Session::put($prefer);
        }

        $setting = SettingTextWidget::where('id', 1)->first();

        return view('home.home', $data, compact('setting')); 
    }

    public function sendVerificationCode()
    {
        $code = rand(100000,999999);

        $user = User::where('id', Auth::user()->id)->first();
        $user->verification_code = $code;
        
        if($user->save()){
            $twilio_number = Settings::where('type', 'twilio')->where('name','formatted_phone')->first()->value;
            $twilio_sid = Settings::where('type', 'twilio')->where('name','twilio_sid')->first()->value;
            $twilio_token = Settings::where('type', 'twilio')->where('name','twilio_token')->first()->value;

            $to = Auth::user()->formatted_phone;
            $from = $twilio_number;
            $message = 'Your verification code is: '.$code;
            //open connection

            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $twilio_sid.':'.$twilio_token);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_URL, sprintf('https://api.twilio.com/2010-04-01/Accounts/'.$twilio_sid.'/Messages.json', $twilio_sid));
            curl_setopt($ch, CURLOPT_POST, 3);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'To='.$to.'&From='.$from.'&Body='.$message);

            // execute post
            $result = curl_exec($ch);
            $result = json_decode($result);

            // close connection
            curl_close($ch);

            $result = '1';
        }

        return $result;
        
    }

    public function submitVerificationCode(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        
        if($user->verification_code == $request->code){
            $user_verification = UsersVerification::where('user_id', Auth::user()->id)->first();
            $user_verification->phone = 'yes';
            $user_verification->save();

            $result = '1';

            $this->helper->one_time_message('success', trans('Phone number verified successfully'));
        }
        else{
            $result = '2';
        }

        return $result;
    }
    

    public function phpinfo()
    {
        echo phpinfo();
    }

    public function login()
    {
        return view('home.login');
    }

    public function setSession(Request $request)
    {
        if ($request->currency) {
            Session::put('currency', $request->currency);
            $symbol = Currency::code_to_symbol($request->currency);
            Session::put('symbol', $symbol);
        } elseif ($request->language) {
            Session::put('language', $request->language);
            $name = language::name($request->language);
            Session::put('language_name', $name);
            App::setLocale($request->language);
        }
    }

    public function cancellation_policies()
    {
        return view('home.cancellation_policies');
    }

    public function staticPages(Request $request)
    {
        $pages          = Page::where(['url'=>$request->name, 'status'=>'Active']);
        if (!$pages->count()) {
            abort('404');
        }
        $pages           = $pages->first();
        $data['content'] = str_replace(['SITE_NAME', 'SITE_URL'], [SITE_NAME, url('/')], $pages->content);
        $data['title']   = $pages->url;
        $data['url']     = url('/').'/';
        $data['img']     = $data['url'].'public/images/2222hotel_room2.jpg';

        return view('home.static_pages', $data);
    }


   

    public function walletUser(Request $request){

        $users = User::all();
        $wallet = Wallet::all();


        if (!$users->isEmpty() && $wallet->isEmpty() ) {
            foreach ($users as $key => $user) {

                Wallet::create([
                    'user_id' => $user->id,
                    'currency_id' => 1,
                    'balance' => 0,
                    'is_active' => 0
                ]);
            }
        }

        return redirect('/');

    }


    public function contactUs()
    {
        return view('contact.contact-us');
    }

    public function sendContactusMessage(Request $request)
    {

        $message = new ContactUs();

        $message->full_name = $request->get('full_name');
        $message->email = $request->get('email');
        $message->subject = $request->get('subject');
        $message->message = $request->get('message');
        $message->save();

        session()->flash('success','Your message sent successfully');
        return redirect()->back();
    }
    
}
