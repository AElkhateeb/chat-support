<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Events\NewMessage;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Customer;
use App\Models\Reply;
use App\Models\Users\BootAdmin;
use App\Models\Users\SupportAdmin;


class ChatBotController extends Controller
{
    public function listenToReplies(Request $request)
    {
        $from = $request->input('From');
        $body = $request->input('Body');
       // $this->sendWhatsAppMessage($body, $from);
       // $data=array();
        $customer=$this->isNewCustomer($from,$body);
        //$tt=json_encode($customer);
        $reply=$this->getBootAnswer($customer,$body);
        if(is_array($reply)){
            $tt=json_encode($reply);
        }else{
            $tt=$reply;
        }
       if($customer['result']=='NewCustomer'|| $customer['result']=='BootCustomer'){
         
            $done1 =$this->createNewMessage($customer,$tt);
            $done2 =$this->createNewMessage($customer,$tt,1);
            $this->sendWhatsAppMessage($tt, $from);
        }
        
            
       // $tt=json_encode($customer);
        
        //$this->sendWhatsAppMessage($reply, $from);
    }

    /**
     * Sends a WhatsApp message  to user using
     * @param string $message Body of sms
     * @param string $recipient Number of recipient
     */
    public function createWhatsAppMessage(array $customer, string $body){
            $support=SupportAdmin::where('id',$customer[1]['sender_id'])->first();
            $sanitized['dir']= 0;
            $sanitized['from']=getenv('TWILIO_WHATSAPP_NUMBER');
            $sanitized['to'] =$customer[0]['id'];//$request->get('to');
            $sanitized['segments'] =1;
            $sanitized['status'] ='sending';
            $sanitized['media'] ='NO';
            $sanitized['sender_type']='App\Models\Users\SupportAdmin';
            $sanitized['sender_id'] = $customer[1]['sender_id'];
            $sanitized['chat_id'] = $customer[1]['id'];
            $sanitized['customer_id'] =$customer[1]['customer_id'];
            $sanitized['customer_type'] ='App\Models\Customer';
            $sanitized['body'] =$body;
            $sanitized['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $sanitized['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $messages = Message::create($sanitized);
            $eventNewMessage=[
            'customer_id' =>$customer[1]['customer_id'],
            'customer_type' => 'App\Models\Customer',
            'customer_name' => $customer[0]['name'] ,
            'phone' => $customer[0]['phone'] ,
            'body' => $body,
            'dir' => 0,
            'sender_id' => $customer[1]['sender_id'],
            'sender_type' => $customer[1]['sender_type'],
            'sender_name' =>$support['full_name'],
            'img' =>  'https://ptetutorials.com/images/user-profile.png',
            'chat_id' =>$customer[1]['id']
        ];
        event(new NewMessage($eventNewMessage));
        /*
        send message to support
                getdata
                create message
                fire event

        */
    }
    
    public function getAvailable(string $department){
    /////////here
      $support=SupportAdmin::where([
            'department'=>$department,
            'forbidden'=>1,
        ])->get();
            if(!empty($support)){
                 return $support->map(function ($user) { 
                     return  $user->only(['id','full_name','chats_count']);
                    
                });
            }else{
                return 'No one is available Now';
            }
      
    /////////here
    }
    public function getBootAnswer(array $customer,string $body ){

         $locale=$this->getCustomerLang($body);
         
      switch($customer['result']){
            case 'NewCustomer':    
                        $this->updateNewChat(
                            $customer[1]['id'],
                            $customer[2]['boot_replay'][0]['income_replay']['pattern_id'],
                            $body,
                            'App\Models\Users\BootAdmin'
                        );
                        return $customer[2]['boot_replay'][0]['income_replay']['replay'];
                        break;
            case 'BootCustomer':
                     $income=[];
                        
                if($customer[2]['stuff']=='Identify'){
                       switch($customer[2]['pattern']){
                            case 'NewCustomer':
                                        $this->updateNewChat(
                                            $customer[1]['id'],
                                            $customer[2]['boot_replay'][0]['income_replay']['pattern_id'],
                                            $body,
                                            'App\Models\Users\BootAdmin'
                                        );
                                        $getBootAnswer=$customer[2]['boot_replay'][0]['income_replay']['replay'];
                                     break;
                            case 'NoLang':
                                $cu= Customer::where('id',$customer[0]['id'])
                                ->update(['name'=>$body,'lang'=>$locale]);
                                $getBootAnswer=$body.', '.$customer[2]['boot_replay'][0]['income_replay']['replay'];
                                $this->updateNewChat(
                                            $customer[1]['id'],
                                            $customer[2]['boot_replay'][0]['income_replay']['pattern_id'],
                                            $body,
                                            'App\Models\Users\BootAdmin'
                                        );
                                break;
                            case 'NoName':
                                if(strtoupper($body)=='YES'||$body=='نعم'){
                                    $getBootAnswer=$getBootAnswer=$customer[2]['boot_replay'][0]['income_replay']['replay'];
                                    $this->updateNewChat(
                                            $customer[1]['id'],
                                            $customer[2]['boot_replay'][0]['income_replay']['pattern_id'],
                                            $body,
                                            'App\Models\Users\BootAdmin'
                                        );
                                }
                                elseif(strtoupper($body)=='NO'||$body=='لا'){
                                    $cu= Customer::where('id',$customer[0]['id'])->update(['name'=>$customer[0]['phone'],'lang'=>$locale]);
                                        //$getBootAnswer=$bootAnswer[0]['replies'][0]['replay'];
                                        $this->updateNewChat(
                                            $customer[1]['id'],
                                            $customer[2]['previous'],
                                            $body,
                                            'App\Models\Users\BootAdmin'
                                        );
                                        $getReply=Reply::where('pattern_id',$customer[2]['previous'])->first();
                                        $getBootAnswer=$getReply['replay'];
                                }else{
                                    $getBootAnswer= $customer[2]['last_replay'][0]['replay'];
                                }
                                break;
                                
                        default:
                                $getBootAnswer=$next;
                                break;
                        }
                        return $getBootAnswer;
                    }elseif($customer[2]['stuff']=='welcome'){
                        if($customer[0]['opened']){
                            $getBootAnswer="";
                            //foreach($customer[2]['boot_replay'] as $comers){
                            for ($x = 0; $x < count($customer[2]['boot_replay']); $x++) {
                                if($customer[2]['boot_replay'][$x]['income']==strtolower($body)){
                                    $getBootAnswer=$customer[2]['boot_replay'][$x]['income_replay']['replay'];
                                    $this->updateNewChat(
                                            $customer[1]['id'],
                                            $customer[2]['boot_replay'][$x]['income_replay']['pattern_id'],
                                            $body,
                                            'App\Models\Users\BootAdmin'
                                        );
                                }
                            }
                        }else{
                             $getBootAnswer= $customer[2]['last_replay'][0]['replay'];
                             $customer=Customer::where('id',$customer[0]['id'])
                                ->update(['opened'=>1]);
                        }
                        if($getBootAnswer==""){
                            $getBootAnswer= $customer[2]['last_replay'][0]['replay'];
                        }
                    }else{
                        $getBootAnswer="";
                       // $getBootAnswer=$customer;
                        if($customer[2]['checked']){
                            //$getBootAnswer=$customer;
                                
                                $min=10;
                                $support=$this->getAvailable($customer[2]['stuff']);
                                //$getBootAnswer=$support;
                                foreach ( $support as $key=>$value) {
                                    if($min>=$value['chats_count']){
                                            $min=$value['chats_count'];
                                            $minName=$value['full_name'];
                                            $minId=$value['id'];
                                    }
                                            
                                        
                                 }
                                // $getBootAnswer=array('result' =>'NewCustomer',$min,$minName,$minId);
                                for ($x = 0; $x < count($customer[2]['boot_replay']); $x++) {
                                    $getBootAnswer=$customer[0]['name'].', '.$minName.' '.$customer[2]['boot_replay'][$x]['income_replay']['replay'];

                                }

                                 $eventNewMessage=[
                                            'customer_id' =>$customer[1]['customer_id'],
                                            'customer_type' => 'App\Models\Customer',
                                            'customer_name' => $customer[0]['name'] ,
                                            'phone' => $customer[0]['phone'] ,
                                            'body' => $body,
                                            'dir' => 0,
                                            'sender_id' => $minId,
                                            'sender_type' => 'App\Models\Users\SupportAdmin',
                                            'sender_name' =>$minName,
                                            'img' =>  'https://ptetutorials.com/images/user-profile.png',
                                            'chat_id' =>$customer[1]['id']
                                        ];
                                        event(new NewMessage($eventNewMessage));
                                
                                    $this->updateNewChat(
                                            $customer[1]['id'],
                                            $minId,
                                            $body,
                                            'App\Models\Users\SupportAdmin'
                                        );
                        }else{
                            for ($x = 0; $x < count($customer[2]['boot_replay']); $x++) {
                                if($customer[2]['boot_replay'][$x]['income']==strtolower($body)){
                                    $getBootAnswer=$customer[2]['boot_replay'][$x]['income_replay']['replay'];
                                    $this->updateNewChat(
                                            $customer[1]['id'],
                                            $customer[2]['boot_replay'][$x]['income_replay']['pattern_id'],
                                            $body,
                                            'App\Models\Users\BootAdmin'
                                        );
                                }
                            }
                        }
                         
                        if($getBootAnswer==""){
                            $getBootAnswer= $customer[2]['last_replay'][0]['replay'];
                        }
                    }
                    if($getBootAnswer==""){
                            $getBootAnswer= $customer[2]['last_replay'][0]['replay'];
                        }
                    return $getBootAnswer;
                    break;
            case "ChatCustomer":
                        $this->createWhatsAppMessage($customer, $body);
                         break;
            
        }
        //return $customer;
    } 
    public function isHaveName(array $customer,string $body ){
        
    }
    public function createNewMessage(array $customer,string $boot,$dir=0){
        $newMessage['dir']= $dir;
        $newMessage['from'] =getenv('TWILIO_WHATSAPP_NUMBER');
        $newMessage['to'] =$customer[0]['phone'];
        $newMessage['segments'] =1;
        $newMessage['status'] ='sending';
        $newMessage['media'] ='NO';
        $newMessage['sender_type'] =$customer[1]['sender_type'];
        $newMessage['sender_id'] = $customer[1]['sender_id'];
        $newMessage['chat_id'] =$customer[1]['id'];
        $newMessage['customer_id'] =$customer[0]['id'];
        $newMessage['customer_type'] =$customer[1]['customer_type'];
        $newMessage['body'] =($dir==0)? $customer[1]['body']:$boot;
        // Store the Message
        $message = Message::create($newMessage);
        return $message;
    }


   public function updateNewChat($id=1, $sender=1 ,string $body, string $type){
            
           $ch=Chat::where('id',$id)
           ->update([
                    'body'=>$body,
                'sender_id'=>$sender,
                'sender_type'=>$type,
                 ]);
         return $ch;
    }
    
    public function isNewCustomer(string $recipient,string $body){
        $isNewCustomer=array();
        $from=str_replace('whatsapp:','',$recipient);
        $customer= Customer::where('phone',$from)->first();
        $locale=$this->getCustomerLang($body);
        app()->setLocale($locale);
        if(empty($customer)){ 
            $newCustomer['phone']= $from;
            $newCustomer['name']= $from;
            $newCustomer['opened']= 1;
            $newCustomer['lang']= $locale;
            $newCustomer['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $newCustomer['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $customer = Customer::create($newCustomer);
          //  $customer->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url']);
            $getBoot= BootAdmin::where('pattern','NewCustomer')->with('replies')->first();
            $getBoot->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url','incomes','replies']);
            $newChat['customer_type']= 'App\Models\Customer';
            $newChat['customer_id']= $customer['id'];
            $newChat['sender_type']='App\Models\Users\BootAdmin';
            $newChat['sender_id'] = $getBoot['id'];
            $newChat['body']= $body;
            $newChat['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $newChat['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $chat =Chat::create($newChat);
          //  $chat->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url']);
            $isNewCustomer = array('result' =>'NewCustomer',$customer,$chat,$getBoot);
        }else{
            $customer->lang=$locale;
            $customer->save();
            $customer->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url']);
            $getChat=  Chat::where([
                        'customer_id' => $customer['id'],
                        'customer_type' => 'App\Models\Customer',
                    ])->first();
             if(empty($getChat)){
                $getBoot= BootAdmin::where('pattern','NewCustomer')->with('replies')->first();
                $newChat['customer_type']= 'App\Models\Customer';
                $newChat['customer_id']= $customer['id'];
                $newChat['sender_type']='App\Models\Users\BootAdmin';
                $newChat['sender_id'] = $getBoot['id'];
                $newChat['body']= $body;
                $newChat['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
                $newChat['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
                $getChat =Chat::create($newChat);
             }else{
                $getChat->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url']);
             }
            
            if($getChat['sender_type']=='App\Models\Users\BootAdmin'|| $customer['opened']== 0){
               $getBoot= BootAdmin::where('id',$getChat['sender_id'])->first();
                $getBoot->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url','incomes','replies']);
                $isNewCustomer = array('result' =>'BootCustomer',$customer,$getChat,$getBoot);
            }else{
                $getChat->makeHidden(['opened_chat']);
                $isNewCustomer = array('result' =>'ChatCustomer',$customer,$getChat);
            }
             
        }
        return $isNewCustomer;

    }
    public function getCustomerLang(string $message)
    {
      
       $en=array('a','b', 'c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','s','w','x','y','z', );
        $lang=str_split($message,1);
      //  return $lang[0];
       if(count($lang)>1){
        if(in_array(strtolower($lang[0]), $en)||in_array(strtolower($lang[1]), $en)){
            return 'en';
       }else{
            return 'ar';
       }
   }else{
    if(in_array(strtolower($lang[0]), $en)){
            return 'en';
       }else{
            return 'ar';
       }
   }
       

    }
    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");

        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }
}
