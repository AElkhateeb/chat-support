@extends('support.layout.chat')

@section('body')                 
<main class="main-content t-mt-15 t-mb-15">
   <div class="container-fluid px-3">
      <div class="row g-3">
         <div class="col-12">
            <div class="chat">
               <div
                  class="chat__left-wrapper d-inline-block t-bg-white t-shadow">
                  <div class="chat__head t-bg-light-2">
                     <div
                        class="d-flex align-items-center justify-content-between">
                        <h5 class="text-capitalize mt-0 mb-0">chat</h5>
                       
                     </div>
                     
                  </div>
                  <div class="chat__left" data-simplebar>
                     <div class="chat__nav">
                        <div class="chat__nav-body">
                           <div class="chat__box">
                              <ul id="inbox_chat_{{Auth::user()->id}}" class="t-list chat__list">
                                 @foreach($data as $chat)
                                        @if(count($chat['messages'])>0)
                                            <?php
                                            $messages_array=$chat['messages'];
                                            $messages=$chat['messages'];
                                            $chat_id=$chat['id'];
                                            $customer_id=$chat['customer_id'];
                                            $customer_type=$chat['customer_type'];
                                            $phone=($chat['customer_type']=='App\Models\Customer')? $chat['customer']['phone'] : $chat['customer']['full_name'];
                                            $name=($chat['customer_type']=='App\Models\Customer')? $chat['customer']['name'] : $chat['customer']['full_name'];
                                            $body=$chat['body'];
                                            $img=($chat['customer_type']=='App\Models\Customer')?'https://ptetutorials.com/images/user-profile.png' : is_null($chat['customer']['avatar_thumb_url'])? 'https://ptetutorials.com/images/user-profile.png' : 'public/'.$chat['customer']['avatar_thumb_url'];
                                           // $messages= array_reverse(array($messages_array));
                                            //$messages=is_array($chat['messages'])? array_reverse($chat['messages']):[];
                                             ?>
                                          @endif   
                                 <li id="chat-{{$chat['id']}}"  chat_id="{{$chat['id']}}" customer_id="{{$chat['customer_id']}}" customer_type="{{$chat['customer_type']}}" phone="{{ ($chat['customer_type']=='App\Models\Customer')? $chat['customer']['phone'] : $chat['customer']['full_name'] }}" name="{{ ($chat['customer_type']=='App\Models\Customer')? $chat['customer']['name'] : $chat['customer']['full_name'] }}" body="{!! $chat['body'] !!}"  class="chat__list-item {{(count($chat['messages'])>0)?'active_chat':''}}">
                                    <a href="#" class="t-link w-100">
                                       <div class="messages__msg">
                                          <div
                                             class="messages__avatar messages__avatar-empty t-bg-alpha">
                                             <img src="{{($chat['customer_type']=='App\Models\Customer')?'https://ptetutorials.com/images/user-profile.png' : is_null($chat['customer']['avatar_thumb_url'])? 'https://ptetutorials.com/images/user-profile.png' : 'public/'.$chat['customer']['avatar_thumb_url']  }}"
                                                alt="Adminage"
                                                class="img-fluid w-100">
                                             <div
                                                class="messages__avatar-notification messages__avatar-notification--active">
                                             </div>
                                          </div>
                                          <div
                                             class="messages__content messages__content--unseen">
                                             <div
                                                class="messages__title">
                                                <span
                                                   class="messages__author text-capitalize">
                                                {{ ($chat['customer_type']=='App\Models\Customer')? $chat['customer']['name'] :$chat['customer']['full_name'] }}
                                                </span>
                                                <span
                                                   class="messages__time text-capitalize">
                                                {{$chat['created_at']}}
                                                </span>
                                             </div>
                                             <div
                                                class="messages__content-body">
                                                <span 
                                                   class="messages__preview">
                                                {!! $chat['body'] !!}
                                                </span>
                                                <span
                                                   class="messages__status messages__status--unseen"></span>
                                             </div>
                                          </div>
                                       </div>
                                    </a>
                                 </li>
                                 @endforeach
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="chat__right t-shadow">
                  <div class="chat__right-head t-bg-light-2">
                     <div
                        class="d-flex align-items-center justify-content-between">
                        <a href="#" class="t-link">
                           <div class="messages__msg">
                              <div
                                 class="messages__avatar messages__avatar-empty t-bg-alpha">
                                 <img src="{{ $img ?? '' }}"
                                                alt="Adminage"
                                                class="img-fluid w-100">
                                 <div
                                    class="messages__avatar-notification messages__avatar-notification--active">
                                 </div>
                              </div>
                              <div
                                 class="messages__content messages__content--unseen">
                                 <div class="messages__title">
                                    <span id="messages__author"
                                       class="messages__author text-capitalize">
                                    {{ $name  ?? '' }}
                                    </span>
                                 </div>
                                 <div class="messages__content-body">
                                    <span id="messages__preview" class="messages__preview">
                                    {!! $body  ?? '' !!}
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </a>
                        <ul class="t-list d-flex align-items-center">
                           <li class="t-list__item">
                              <a href="#"
                                 class="t-link t-link--primary xlg-text">
                              <span class="fa fa-close" id="chat-close"  chat="{{$chat_id ?? '' }}"></span>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="chat__right-main t-bg-white" data-simplebar>
                     <div class="t-pt-30 t-pl-15 t-pr-15 t-pb-30">
                        <ul  id="msg_history" class="t-list">
                            @if(isset($messages))
                                @include('messages',compact('messages'))
                            @endif
                        </ul>
                     </div>
                  </div>
                  <div
                     class="chat__right-footer d-flex align-items-center t-bg-white t-pt-15 t-pb-15 t-pl-15 t-pr-15 mx-auto">
                     
                    <form id="messageForm" onkeydown="if(event.keyCode == 13) {send_message(); return event.key != 'Enter';}">
                            <div class="chat__search">
                                 @csrf
                            <input type="hidden" id="chat_id" name="chat_id" value="{{(isset($chat_id))?$chat_id : '' }}" />
                            <input type="hidden" id="customer_id" name="customer_id" value="{{(isset($customer_id))?$customer_id : '' }}" />
                            <input type="hidden" id="customer_type" name="customer_type" value="{{(isset($customer_type))?$customer_type : '' }}" />
                            <input type="hidden" id="to" name="to" value="{{(isset($phone))?$phone : ''}}" />
                            <input type="text" class="chat__search-input w-100" id="write_msg" name="body" placeholder="Type a message" />    
                            </div>
                            
                            
                    </form>                     
                    
                     <ul id="msg_send_btn" class="t-list d-flex">
                        <li class="t-ml-8">
                           <a href="#"
                              class="t-link t-link--primary xlg-text">
                           <span class="fa fa-paper-plane-o"></span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>
                              
@endsection
@section('bottom-scripts')
<script src="{{URL::asset('js/moment.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-material-datetimepicker.js')}}"></script>

    <!-- Bootstrap -->
    <script src="{{URL::asset('js/bootstrap.bundle.min.js')}}"></script>
   
    <!-- simplebar -->
    <script src="{{URL::asset('js/simplebar.js')}}"></script>
   
    <!-- Main script -->
<script src="{{URL::asset('js/main.js')}}"></script>
            <script>
                $(document).ready(function(){
                 $('#msg_history').scrollTop($('#msg_history')[0].scrollHeight);
                });
                
                $(document).on('click', '.chat__list-item', function (e) {
                    e.preventDefault();
                    $('.chat__list li.active_chat').removeClass('active_chat');
                   $(this).addClass('active_chat');
                    var chat_id =  $(this).attr('chat_id');
                    var customer_id= $(this).attr('customer_id');
                    var customer_type = $(this).attr('customer_type');
                    var phone = $(this).attr('phone');
                    var name = $(this).attr('name');
                    var body = $(this).attr('body');
                    $.ajax({
                        type: 'get',
                        url: "{{url('support/messages')}}?chat="+chat_id,
                        success: function (data) {
                            $('#count-'+chat_id).hide();
                            $('#msg_history').html(data);
                            $('#chat_id').val(chat_id);
                            $('#customer_id').val(customer_id);
                            $('#customer_type').val(customer_type);
                            $('#to').val(phone);
                            $('#messages__author').text(name);
                            $('#messages__preview').text(body);
                            $('#chat-close').attr('chat',chat_id);
                            $('#msg_history').scrollTop($('#msg_history')[0].scrollHeight);
                            //$('.offerRow'+data.id).remove();
                        }, error: function (reject) {
                        }
                    });
                    
                    
                });

            $(document).on('click', '#chat-close', function (e) {
                        var chat_id =  $(this).attr('chat');
                        
                        $.ajax({
                            type: 'get',
                            url: "{{url('support/chats/')}}/"+chat_id+'/edit',
                            success: function (data) {
                                console.log(data);
                                $('#chat-'+data['chat']['id']).remove();
                                $('#msg_history').html('');
                            }, error: function (reject) {
                            }
                        });
                    });
                function send_message() {
                   // $('#photo_error').text('');
                    var formData = new FormData($('#messageForm')[0]);
                    var chat_id = $('#chat_id').val();
                    $.ajax({
                        type: 'post',
                        enctype: 'multipart/form-data',
                        url: "{{url('support/messages')}}?chat="+chat_id,
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                          //  $('#msg_history').html(data);
                          $('#write_msg').val('');
                        }, error: function (reject) {
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "_error").text(val[0]);
                            });
                        }
                    });
                }

                $(document).on('click', '#msg_send_btn', function (e) {
                    e.preventDefault();
                   send_message();
                });
                $('#write_msg').bind("enterKey",function(e){
                    //do stuff here
                    e.preventDefault();
                    send_message();
                });

            </script>
@endsection
