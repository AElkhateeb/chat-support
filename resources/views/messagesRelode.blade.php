@foreach($messages as $message)

    @if($message[0]['dir']==0)
        <div class="incoming_msg">
            <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
            <div class="received_msg">
                <div class="received_withd_msg">
                    <p>{!! $message[0]['body'] !!}</p>
                    <span class="time_date">  {!! $message[0]['created_at'] !!} </span></div>
            </div>
        </div>
    @else
        <div class="outgoing_msg">
            <div class="sent_msg">
                <p>{!! $message[0]['body'] !!}</p>
                <?php
                $sender=str_replace('App\Models\Users\\','',$message[0]['sender_type']);
                $role=str_replace('Brackets\AdminAuth\Models\\','',$sender);

                ?>
                <span class="time_date"> {!! $message[0]['created_at'] !!}  |  {!! $role!!}</span>
            </div>
            <span>
 <img src="{{ is_null($message[0]['sender']['avatar_thumb_url'])? 'https://ptetutorials.com/images/user-profile.png' : $message[0]['sender']['avatar_thumb_url'] }}" class="avatar-photo">
<span class="hidden-md-down" style="color:#4273FA" >{{ $message[0]['sender']['full_name'] }}</span>
                    </span>

        </div>
    @endif
@endforeach
