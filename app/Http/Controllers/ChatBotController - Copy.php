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


class ChatBotController extends Controller
{
    public function listenToReplies(Request $request)
    {
        $from = $request->input('From');
        $body = $request->input('Body');
        $data=array();
        $customer=$this->isNewCstomer($from,$body);
       
        ///
        switch($customer['result']){
            case 'BootAdmin':
                switch($body){
                        case 'c':
                        case 'C':
                                //$tt='some one from customer service will connect you';
                                $tt=json_encode($customer);
                                $this->getAvailable($customer,'Support');
                                $this->sendWhatsAppMessage($tt, $from);
                                //$this->createWhatsAppMessage($tt, $from);
                                 break;
                         case 's':
                         case 'S':
                                $tt='some one from Sales will connect you';
                               // $tt=json_encode($customer);
                               // $this->getAvailable($customer,'sales');
                                $this->sendWhatsAppMessage($tt, $from);
                                //$this->createWhatsAppMessage($tt, $from);
                                break;
                        default:
                               // $tt= $this->createWhatsAppMessage($body,$from);
                                //$tt='hi,for customer type c for sales type s';
                               // $tt=$this->getBootAnswer($customer,$body); //json_encode($customer[0]);
                               // $tt=json_encode($this->getBootAnswer($customer,$body)); //json_encode($customer[0]);
                         $tt=json_encode($customer);
                                $this->sendWhatsAppMessage($tt, $from);
                                break;
                    } 
                //$tt=json_encode($customer);
                //$this->sendWhatsAppMessage($tt, $from);
                break;
            case 'ChatAdmin':
                //$tt='ChatAdmin';
                $tt=json_encode($customer);
                //$this->sendWhatsAppMessage($tt, $from);
                //$this->createWhatsAppMessage($tt, $from);
                break;
            case 'Closed':
                    $tt=json_encode($customer);
                    $this->sendWhatsAppMessage($tt, $from);
                    break;
            case 'HaveName':
                $tt=json_encode($customer);
                $this->sendWhatsAppMessage($tt, $from);
                //$this->createWhatsAppMessage($tt, $from);
                break;
            case 'NoName':
                $tt=json_encode($customer);
                $this->sendWhatsAppMessage($tt, $from);
                break;
            case 'NewCustomer':
                //$tt=json_encode($customer);
                //$this->sendWhatsAppMessage($tt, $from);
                $this->sendWhatsAppMessage($customer[0]['body'], $from);
                break;
            default:
                $tt=json_encode($customer);
                $this->sendWhatsAppMessage($tt, $from);
                break;
                //$tt= $this->createWhatsAppMessage($body,$from);
                    }
        $client = new \GuzzleHttp\Client();
       
        return;
    }

    /**
     * Sends a WhatsApp message  to user using
     * @param string $message Body of sms
     * @param string $recipient Number of recipient
     */
    public function createWhatsAppMessage(string $message, string $recipient){
        //$sanitized = $request->validated();
       // return 'New Client';
        $data=array();
        $from=str_replace('whatsapp:','',$recipient);
        $data= Message::with('sender')->with('customer')->where('to',$from)->first();
       //return $data;
         if(!empty($data)){
            $sanitized['dir']= 0;
            $sanitized['from']=getenv('TWILIO_WHATSAPP_NUMBER');
            $sanitized['to'] =$recipient;//$request->get('to');
            $sanitized['segments'] =1;
            $sanitized['status'] ='sending';
            $sanitized['media'] ='NO';
            $sanitized['sender_type']='App\Models\Users\CeoAdmin';
            $sanitized['sender_id'] = 1;
            $sanitized['chat_id'] = $chat= $data['chat_id'];
            $sanitized['customer_id'] =$data['customer_id'];
            $sanitized['customer_type'] ='App\Models\Customer';
            $sanitized['body'] =$message;
            $sanitized['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $sanitized['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
        }else{

            $newCustomer['phone']= $from;
            $newCustomer['name']= $from;
            $newCustomer['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $newCustomer['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));

            $customer = Customer::create($newCustomer);
            $newChat['customer_type']= 'App\Models\Customer';
            $newChat['customer_id']= $customer;
            $sanitized['sender_type']='App\Models\Users\CeoAdmin';
            $sanitized['sender_id'] = $customer;
            $newChat['body']= $message;
            $newChat['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $newChat['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));

            $chat = Chat::create($newChat);
            $sanitized['dir']= 0;
            $sanitized['from']=getenv('TWILIO_WHATSAPP_NUMBER');
            $sanitized['to'] =$from;//$request->get('to');
            $sanitized['segments'] =1;
            $sanitized['status'] ='sending';
            $sanitized['media'] ='NO';
            $sanitized['sender_type']='App\Models\Users\CeoAdmin';
            $sanitized['sender_id'] = 1;
            $sanitized['chat_id'] = $chat;
            $sanitized['customer_id'] =1;
            $sanitized['customer_type'] ='App\Models\Customer';
            $sanitized['body'] =$message;
            $sanitized['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $sanitized['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $data= Message::with('sender')->with('customer')->where('chat_id',$chat)->first();
        }
        
        // Store the Message
        $messages = Message::create($sanitized);
        Chat::where('id',$chat)->update(['body'=>$message]);
        
        $eventNewMessage=[
            'customer_id' =>$data['customer_id'],
            'customer_type' => $data['customer_type'],
            'customer_name' => ($data['customer_type']=='App\Models\Customer')? $data['customer']['name'] : $data['customer']['full_name'] ,
            'body' => $message,
            'dir' => 0,
            'sender_id' => $data['customer_type'],
            'sender_type' => $data['sender_type'],
            'sender_name' =>$data['sender']['full_name'],
            'img' =>  'https://ptetutorials.com/images/user-profile.png',
            'chat_id' =>$chat
        ];
        event(new NewMessage($eventNewMessage));
        return '7sal';


    }
    public function isNewCstomer(string $recipient,string $body){
        $from=str_replace('whatsapp:','',$recipient);

        $customer= Customer::where('phone',$from)->first();
        //$customer= BootAdmin::where('phone',$from)->first();


        if(!empty($customer)){

            if($customer['opened']){
                if($customer['phone']==$customer['name']){
                    $chat= Chat::where([
                        'customer_id' => $customer['id'],
                        'customer_type' => 'App\Models\Customer',
                    ])->first();
                    
                    //return json_encode($chat);
                    if($chat['sender_type']=='App\Models\Users\BootAdmin'){
                        // boot work
                        $isNewCstomer = array(
                            'result' =>'BootAdmin' ,$chat,$customer
                            );
                        return $isNewCstomer;
                   }else{
                        // have chat 
                        $isNewCstomer = array(
                            'result' =>'ChatAdmin' ,$chat
                            );
                        return $isNewCstomer;
                    }
                 
                }else{
                    $chat= Chat::where([
                        'customer_id' => $customer['id'],
                        'customer_type' => 'App\Models\Customer',
                    ])->first();
                    if($chat['sender_type']=='App\Models\Users\BootAdmin'){
                        // boot work
                        $isNewCstomer = array(
                            'result' =>'BootAdmin' ,$chat,$customer
                            );
                        return $isNewCstomer;
                   }elseif($chat['sender_type']=='App\Models\Users\CeoAdmin'){
                        // have chat 
                        $isNewCstomer = array(
                            'result' =>'ChatAdmin' ,$chat
                            );
                        return $isNewCstomer;
                    }else{
                        // have name no chat
                        $isNewCstomer = array(
                            'result' =>'HaveName' ,$customer
                            );
                        return $isNewCstomer;
                    }
                    
                }
            }else{
                // closed chat
                if($customer['phone']==$customer['name']){
                     $isNewCstomer = array(
                            'result' =>'NoName' ,$customer
                            );
                        return $isNewCstomer;
                }else{
                    $isNewCstomer = array(
                            'result' =>'Closed' ,$customer
                            );
                        return $isNewCstomer;
                }
                    
            }
               // }
        }else{
            $locale=$this->getCustomerLang($body);
            app()->setLocale($locale);
            $newCustomer['phone']= $from;
            $newCustomer['name']= $from;
            $newCustomer['opened']= 1;
            $newCustomer['lang']= $locale;
            $newCustomer['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $newCustomer['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));

            $reply=Reply::where('pattern_id',1)->get();
            $customer = Customer::create($newCustomer);
            $newChat['customer_type']= 'App\Models\Customer';
            $newChat['customer_id']= $customer['id'];
            $newChat['sender_type']='App\Models\Users\BootAdmin';
            $newChat['sender_id'] = 1;
            $newChat['body']= $reply[0]['replay'];
            $newChat['created_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));
            $newChat['updated_at']= date("Y-m-d h:i A", strtotime(Carbon::now()));

            $chat =Chat::create($newChat);
            
             $isNewCstomer = array(
                            'result' =>'NewCustomer' ,$chat, $customer
                            );
                        return $isNewCstomer;
               
        }

    }
    public function getAvailable(array $customer,string $user){
        /////////her















        ////here
    }
    public function getBootAnswer(array $customer,string $body ){
        if($customer[0]['sender_id']==1){
            if($body=='عربي'){
                $locale='ar';
            }elseif(strtoupper($body)=='ENGLISH'){
                $locale='en';
            }else{
                $locale=$this->getCustomerLang($body);
            }
           $cu= Customer::where('id',$customer[0]['customer_id'])->update(['lang'=>$locale]);
           //$cu= Chat::where('customer_id',$customer[0]['customer_id'])->update(['sender_id'=>2,]);
           app()->setLocale($locale);
           $getBootAnswer= BootAdmin::where('id',2)->with('replies')->get();
           $message=$getBootAnswer[0]['replies'][0]['replay'];
               $ch=Chat::where('customer_id',$customer[0]['customer_id'])->update(['body'=>$message,'sender_id'=>2]); 
                return $message;
        }elseif($customer[0]['sender_id']==2){
            $locale=$this->getCustomerLang($body);
            app()->setLocale($locale);
            if($customer[1]['phone']==$customer[1]['name']){
                $cu= Customer::where('id',$customer[0]['customer_id'])->update(['name'=>$body,'lang'=>$locale]);
                $getBootAnswer= BootAdmin::where('id',3)->with('replies')->get();
                $message=$body.', '.$getBootAnswer[0]['replies'][0]['replay'];
               $ch=Chat::where('id',$customer[0]['id'])->update(['body'=>$message,'sender_id'=>2]); 
                return $message;
            }else{
                $locale=$this->getCustomerLang($body);
                app()->setLocale($locale);
                if(strtoupper($body)=='YES'||$body=='نعم'){
                    $getBootAnswer= BootAdmin::where('id',4)->with('replies')->get();
                    $message=$body.', '.$getBootAnswer[0]['replies'][0]['replay'];
                    $ch=Chat::where('id',$customer[0]['id'])->update(['body'=>$message,'sender_id'=>4]); 
                return $message;
                }
                elseif(strtoupper($body)=='NO'||$body=='لا'){
                    $cu= Customer::where('id',$customer[0]['customer_id'])->update(['name'=>$customer[1]['phone'],'lang'=>$locale]);
                    $getBootAnswer= BootAdmin::where('id',2)->with('replies')->get();
                    $message=$getBootAnswer[0]['replies'][0]['replay'];
                    $ch=Chat::where('id',$customer[0]['id'])->update(['body'=>$message,'sender_id'=>2]); 
                return $message;
                }
                else{
                    $getBootAnswer= BootAdmin::where('id',3)->with('replies')->get();
                    $message=$customer[1]['name'].', '.$getBootAnswer[0]['replies'][0]['replay'];
                    $ch=Chat::where('id',$customer[0]['id'])->update(['body'=>$message,'sender_id'=>2]); 
                    return $message;
                }
            }
           // return json_encode($customer);
        }elseif($customer[0]['sender_id']>=4){
               $locale=$this->getCustomerLang($body);
               app()->setLocale($locale);
            //$getBootAnswer= BootAdmin::where('id',$customer[0]['sender_id'])->with('replies')->get();
            //$getCustomerAnswer= BootAdmin::where('pattern',$body)->get();
            return $customer;
           /* if($getBootAnswer[0]['pattern']=='Welcome'){
                $message=$getBootAnswer[0]['replies'][0]['replay'];
                $ch=Chat::where('id',$customer[0]['id'])->update(['body'=>$message,'sender_id'=>4]); 
                
            }
            return $message;  */     
        }

      /*if($customer[0]['sender_id']==1){
             if(date("Y-m-d h:i", strtotime($customer[0]['created_at']))==date("Y-m-d h:i", strtotime(Carbon::now())) || date("Y-m-d h:i", strtotime($customer[0]['updated_at']))==date("Y-m-d h:i", strtotime(Carbon::now()))){
                $cu= Customer::where('id',$customer[0]['customer_id'])->update(['name'=>$body]);
                $message='nice name '.$body.' for customer type c for sales type s';
               $ch=Chat::where('id',$customer[0]['id'])->update(['body'=>$message,'sender_id'=>2]); 
                return $message;
            }else{
                $ch=Chat::where('id',$customer[0]['id'])->update(['body'=>'hello dear whats is your name']);
                return 'hello dear whats is your name';
            }
        }else{
             $ch=Chat::where('id',$customer[0]['id'])->update(['body'=>'hi,for customer type c for sales type s']);
            return "hi,for customer type c for sales type s";
        }*/
    }
    public function getCustomerLang(string $message)
    {
      // $ar=array('ا','ب','ت','ث','ج','ح','خ','د','ذ','ر','ز','س','ص','ض','ش','ط','ظ','ع','غ','ف','ق','ك','ل','م','ن','ه','و','ي','أ','ى');
       $en=array('a','b', 'c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','s','w','x','y','z', );
        $lang=str_split($message,1);
      //  return $lang[0];
       if(count($lang)>1){
        if(in_array($lang[0], $en)||in_array($lang[1], $en)){
            return 'en';
       }else{
            return 'ar';
       }
   }else{
    if(in_array($lang[0], $en)){
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
