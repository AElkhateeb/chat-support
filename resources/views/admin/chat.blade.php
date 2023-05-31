@extends('layouts.chat')

@section('body')
    <div class="row">
        <div class="col">
            <div class="card">

            <div class="card-header">
                     <h3 class="text-center">Messaging</h3>
            </div>
                <div class="card-body">
                    <div class="messaging">
                        <div class="inbox_msg">
                            <div class="inbox_people">
                                <div class="headind_srch">
                                    <div class="recent_heading">
                                        <h4>Recent</h4>
                                    </div>
                                    <div class="srch_bar">
                                        <div class="stylish-input-group">

                                            <span class="input-group-addon">
                                                <input type="text" class="search-bar"  placeholder="Search" >
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
                                    </div>
                                </div>
                                <div id="inbox_chat_ceo" class="inbox_chat">
                                    @foreach($data as $chat)
                                        @if(count($chat['messages'])>0)
                                            <?php
                                           // $messages_array=$chat['messages'];
                                            $messages=$chat['messages'];
                                            $chat_id=$chat['id'];
                                            $customer_id=$chat['customer_id'];
                                            $customer_type=$chat['customer_type'];
                                            $phone=($chat['customer_type']=='App\Models\Customer')? $chat['customer']['phone'] : $chat['customer']['full_name'];
                                           // $messages= array_reverse(array($messages_array));
                                            //$messages=is_array($chat['messages'])? array_reverse($chat['messages']):[];
                                            
                                             ?>
                                             
                                    <div id="chat-{{$chat['id']}}" chat_id="{{$chat['id']}}" customer_id="{{$chat['customer_id']}}" customer_type="{{$chat['customer_type']}}" phone="{{ ($chat['customer_type']=='App\Models\Customer')? $chat['customer']['phone'] : $chat['customer']['full_name'] }}" class="chat_list active_chat">
                                        @else
                                    <div  id="chat-{{$chat['id']}}" chat_id="{{$chat['id']}}" customer_id="{{$chat['customer_id']}}" customer_type="{{$chat['customer_type']}}" phone="{{ ($chat['customer_type']=='App\Models\customer')? $chat['customer']['phone'] : $chat['customer']['full_name'] }}" class="chat_list">
                                        @endif
                                        <div class="chat_people">
                                            <div class="chat_img"> <img src="{{($chat['customer_type']=='App\Models\Customer')?'https://ptetutorials.com/images/user-profile.png' : is_null($chat['customer']['avatar_thumb_url'])? 'https://ptetutorials.com/images/user-profile.png' : $chat['customer']['avatar_thumb_url']  }}" alt="sunil" class="avatar-photo"> </div>
                                            <div class="chat_ib">
                                                <h5>{{ ($chat['customer_type']=='App\Models\Customer')? $chat['customer']['name'] :$chat['customer']['full_name'] }}
                                                    <span class="badge rounded-pill bg-danger">35</span>
                                                    <span class="chat_date">{{$chat['created_at']}}</span></h5>
                                                <p>{!! $chat['body'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mesgs">
                                <div id="msg_history" class="msg_history">
                                    @if(isset($messages))
                                    @include('messages',compact('messages'))
                                    @endif
                                </div>
                                <div class="type_msg">
                                    <div class="input_msg_write">
                                        <form id="messageForm">
                                            @csrf
                                            <input type="hidden" id="chat_id" name="chat_id" value="{{(isset($chat_id))?$chat_id : '' }}" />
                                            <input type="hidden" id="customer_id" name="customer_id" value="{{(isset($customer_id))?$customer_id : '' }}" />
                                            <input type="hidden" id="customer_type" name="customer_type" value="{{(isset($customer_type))?$customer_type : '' }}" />
                                            <input type="hidden" id="to" name="to" value="{{(isset($phone))?$phone : ''}}" />
                                            <input type="text" class="write_msg" id="write_msg" name="body" placeholder="Type a message" />
                                            <button id="msg_send_btn" class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('bottom-scripts')
            <script>
               // $('#msg_history').scrollTop($('#msg_history')[0].scrollHeight);
               $('#msg_history').scrollTop(0);
                $(document).on('click', '.chat_list', function (e) {
                    e.preventDefault();
                    $('.inbox_chat div.active_chat').removeClass('active_chat');
                    $(this).addClass('active_chat');
                    var chat_id =  $(this).attr('chat_id');
                    var customer_id= $(this).attr('customer_id');
                    var customer_type = $(this).attr('customer_type');
                    var phone = $(this).attr('phone');
                    $.ajax({
                        type: 'get',
                        url: "{{url('admin/messages')}}?chat="+chat_id,
                        success: function (data) {
                            $('#msg_history').html(data);
                            $('#chat_id').val(chat_id);
                            $('#customer_id').val(customer_id);
                            $('#customer_type').val(customer_type);
                            $('#phone').val(phone);
                            $('#msg_history').scrollTop(0);
                           // $('#msg_history').scrollTop($('#msg_history')[0].scrollHeight);
                            //$('.offerRow'+data.id).remove();
                        }, error: function (reject) {
                        }
                    });
                   /* var offer_id =  $(this).attr('offer_id');
                    $.ajax({
                        type: 'post',
                        url: "route('ajax.offers.delete')",
                        data: {
                            '_token': "csrf_token()",
                            'id' :offer_id
                        },
                        success: function (data) {
                            if(data.status == true){
                                $('#success_msg').show();
                            }
                            $('.offerRow'+data.id).remove();
                        }, error: function (reject) {
                        }
                    });
                    */
                });

                function send_message() {
                   // $('#photo_error').text('');
                    var formData = new FormData($('#messageForm')[0]);
                    var chat_id = $('#chat_id').val();
                    $.ajax({
                        type: 'post',
                        enctype: 'multipart/form-data',
                        url: "{{url('admin/messages')}}?chat="+chat_id,
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
