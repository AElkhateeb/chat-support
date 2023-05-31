@foreach($messages as $message)
    @if($message['dir']==0)
    <li class="t-mb-30">
     <div class="msg-receiver d-flex align-items-end">
        <div class="avatars avatars--circle avatars--sm-plus t-mr-5">
            <img src="https://ptetutorials.com/images/user-profile.png" alt="max" class="img-fulid w-100"><div class="avatars__status"></div>
        </div>
        <ul class="t-list msg-receiver__list">
            <li class="msg-receiver__list-item">{!! $message['body'] !!}</li>
        </ul>
     </div>
    </li>   
    @else
    <li class="t-mb-30">
        <ul class="t-list msg-sender__list">
            <li class="msg-sender__list-item text-end">
                <div class="msg-sender__message">
                 {!! $message['body'] !!}
                </div>
            </li>                         
        </ul>
    </li>        
    @endif
@endforeach