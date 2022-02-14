<?php

namespace App\Http\Controllers;

use App\Events\ChatMessage;
use App\Events\Support;
use App\Models\Chat;
use App\Models\CommunityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public static function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function sendNotification($title,$body,$tokens,$platform){


        if($platform =="android"){
            $SERVER_API_KEY = env("FIREBASE_ANDROID_APIKEY");
        }


        $data = [
            "registration_ids" => $tokens,
            "notification" => [
                "title" =>$title,
                "body" => $body,
            ],

        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_exec($ch);

    }
    public function login(Request $req){
        $validator = Validator::make($req->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:2',
        ]);
        if ($validator->fails())
        {
            return response( )->json(['errors'=>$validator->errors()->all()]);
        }
        $user = User::where('username', $req->username)->first();

        if ($user) {
            if (Hash::check($req->password, $user->password)) {

                        DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();
                        $token = $user->createToken('Api Login '.$req->username)->accessToken;


                    $response = ['token' => $token,'user'=>$user];

                return response()->json($response);
            } else {
                $response = ["error" => "password"];

                return response()->json($response);
            }
        } else {
            $response = ["error" =>'not_found'];

            return response()->json($response);
        }
    }
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    public function makeCommunityLog(Request $req){
        $req->validate([
            'description'=>'required',
            'icon'=>'required',
            'type'=>'required',
            'status_text'=>'required',
            'status_color'=>'required',

        ]);
        $user = $req->user();


        $now = Carbon::now();
        $getLastLog = CommunityLog::where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
        if($req->type =="going_location"){
            $going = CommunityLog::where('type','going_location')->where('going_id',$req->going_id)->orderBy('id','desc')->where('user_id',$user->id)->first();
            if($going){
                $cancel = CommunityLog::where('type','cancelled')->where('going_id',$going->going_id)->where('user_id',$user->id)->first();
                $arrived = CommunityLog::where('type','arrived')->where('going_id',$going->going_id)->where('user_id',$user->id)->first();
                if(!$cancel){
                    if(!$arrived) return response(['error'=>'Gitmekte olduğunuz bir bildirim varken, başka bir bildirim yapamazsınız.']);
                    if($arrived) return response(['error'=>'Varmış olduğunuz bildirime bir daha gidemezsiniz']);
                }else{
                    return response(['error'=>'İptal ettiğiniz bildirime bir daha gidemezsiniz.']);
                }

            }

        }
        if($getLastLog){
            $lastLog=Carbon::parse($getLastLog->created_at);
            $diff  =$lastLog->diffInMinutes($now,false);
            if($req->type=="going_location" || $req->type=="arrived" || $req->type=="cancelled")$diff=10;
            if($diff>2){
                $model = new CommunityLog();
                if($req->location){
                    $pos = json_encode($req->location);
                    $model->preview_link="https://static-maps.yandex.ru/1.x/?lang=tr-TR&ll=".$req->location["coords"]["longitude"].",".$req->location["coords"]["latitude"]."&z=16&l=map,skl&size=600,300&pt=".$req->location["coords"]["longitude"].",".$req->location["coords"]["latitude"].",pm2rdl1";
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://geocode-maps.yandex.ru/1.x?geocode='.$req->location["coords"]["longitude"].','.$req->location["coords"]["latitude"].'&apikey='.env('YANDEX_GEOCODERAPIKEY').'&lang=tr_TR&format=json');
                    curl_setopt($ch, CURLOPT_POST, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $data = json_decode(curl_exec($ch),true);
                    $model->formatted_adress=$data["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["metaDataProperty"]["GeocoderMetaData"]["text"];
                }
                if($req->going_id)$model->going_id=$req->going_id;

                $model->icon=$req->icon;
                $model->title=Auth::user()->name_surname;
                $model->description=$req->description;
                $model->type=$req->type;
                $model->status_text=$req->status_text;
                $model->status_color=$req->status_color;
                $model->color_status=$req->color_status;
                $model->location=json_encode($req->location);
                $model->user_id=Auth::user()->id;
                $model->color=$req->color;
                $model->save();

                foreach(User::whereNotNull('notif_token')->where('id','!=',Auth::id())->get() as $item){
                       \App\Http\Controllers\ApiController::sendNotification($user->name_surname." ".$req->description,'Daha fazla bilgi için uygulamaya bakın.',[$item->notif_token],$item->notif_platform);

                }

                try{
                    broadcast(new Support($model));
                }catch(\Exception $exception){}
                return response()->json(['success'=>true,'diff'=>$diff]);
            }else{
                return response()->json(['error'=>'2 Dakikada bir bildirim yapabilirsiniz.']);
            }
        }else{
            $model = new CommunityLog();
            if($req->going_id)$model->going_id=$req->going_id;
          if($req->location){
                $pos = json_encode($req->location);
              $model->preview_link="https://static-maps.yandex.ru/1.x/?lang=tr-TR&ll=".$req->location["coords"]["longitude"].",".$req->location["coords"]["latitude"]."&z=16&l=map,skl&size=600,300&pt=".$req->location["coords"]["longitude"].",".$req->location["coords"]["latitude"].",pm2rdl1";
              $ch = curl_init();

              curl_setopt($ch, CURLOPT_URL, 'https://geocode-maps.yandex.ru/1.x?geocode='.$req->location["coords"]["longitude"].','.$req->location["coords"]["latitude"].'&apikey='.env('YANDEX_GEOCODERAPIKEY').'&lang=tr_TR&format=json');
              curl_setopt($ch, CURLOPT_POST, false);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $data = json_decode(curl_exec($ch),true);
              $model->formatted_adress=$data["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["metaDataProperty"]["GeocoderMetaData"]["text"];

            }
            $model->icon=$req->icon;
            $model->title=Auth::user()->name_surname;
            $model->description=$req->description;
            $model->type=$req->type;
            $model->status_text=$req->status_text;
            $model->status_color=$req->status_color;
            $model->color_status=$req->color_status;
            $model->location=json_encode($req->location);
            $model->user_id=Auth::user()->id;
            $model->color=$req->color;
            $model->save();
            foreach(User::whereNotNull('notif_token')->where('id','!=',Auth::id())->get() as $item){
                \App\Http\Controllers\ApiController::sendNotification($user->name_surname." ".$req->description,'Daha fazla bilgi için uygulamaya bakın.',[$item->notif_token],$item->notif_platform);

            }
            try{
                broadcast(new Support($model));
            }catch(\Exception $exception){}

            return response()->json(['success'=>true]);
        }
    }
    public function get_CommunityList(Request $req){
        return CommunityLog::orderBy('id','desc')->limit(5)->get();
    }
    public function continue_CommunityList(Request $req){
        return CommunityLog::where('id','<',$req->id)->limit(5)->get();
    }
    public function getCurrentGoing(Request $req){
        $current = CommunityLog::where('user_id',$req->user()->id)->where('type','going_location')->orderBy('id','desc')->first();
        $going = CommunityLog::where('id',$current->going_id)->first();
        $cancelled =  CommunityLog::where('user_id',$req->user()->id)->where('type','cancelled')->where('going_id',$current->going_id)->orderBy('id','desc')->first();
        $arrived =  CommunityLog::where('user_id',$req->user()->id)->where('type','arrived')->where('going_id',$current->going_id)->orderBy('id','desc')->first();
        if($cancelled || $arrived){
            return response(['cancelled'=>true]);
        }
        return response(['current'=>$current,'going'=>$going]);
    }
    public function setNotificationToken(Request $req){

        User::where('id',$req->user()->id)->update([
            'notif_token'=>$req->token,
            'notif_platform'=>$req->platform
        ]);
    }
    public function changePassword(Request $req){
        $req->validate([
            'password'=>'min:4|required'
        ]);
        User::where('id',$req->user()->id)->update([
            'password'=>Hash::make($req->password),
        ]);
    }
    public function updateProfile(Request $req){
        $req->validate([
            'name_surname'=>'required',
        ]);
        User::where('id',$req->user()->id)->update([
            'name_surname'=>$req->name_surname,
            'phone_number'=>$req->phone_number
        ]);
        return response(['user'=>$req->user()]);
    }
    public function getFirstChat(){
        return Chat::orderBy('id','desc')->limit(10)->get();
    }
    public function getMoreChatList(Request $req){

        return Chat::where('id','<',$req->last)->orderBy('id','desc')->limit(10)->get();
    }
    public function chatMessage(Request $req){

        Chat::insert([
            'message'=>$req->message,
            'from_id'=>json_encode(
                [
                    'name_surname'=>Auth::user()->name_surname,
                    'phone_number'=>Auth::user()->phone_number,
                    'id'=>Auth::user()->id
                ]
            ),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        try{
            broadcast(new ChatMessage(json_encode([
                'name_surname'=>Auth::user()->name_surname,
                'phone_number'=>Auth::user()->phone_number,
                'id'=>Auth::user()->id
            ]),$req->message));
        }catch (\Exception $e){}


    }
}
