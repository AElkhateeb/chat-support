/*
var messagesWrapper = $('.inbox_chat');
var messagesToggle = messagesWrapper.find('.chat_list ');
var messagesCountElem = messagesToggle.data('chat_id');
console.log(messagesToggle);
var messagesCountElem = messagesToggle.find('span[data-count]');
var messagesCount = parseInt(messagesCountElem.data('count'));
var messages = messagesWrapper.find('li.scrollable-container');

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('support-chat-718');
// Bind a function to a Event (the full Laravel class)



 var existingMessages = messages.html();
    var newMessageHtml = `<a href="`+data.user_id+`"><div class="media-body"><h6 class="media-heading text-right">` + data.user_name + `</h6> <p class="Message-text font-small-3 text-muted text-right">` + data.comment + `</p><small style="direction: ltr;"><p class="media-meta text-muted text-right" style="direction: ltr;">` + data.date + data.time + `</p> </small></div></div></a>`;
    messages.html(newMessageHtml + existingMessages);
    messagesCount += 1;
    messagesCountElem.attr('data-count', messagesCount);
    messagesWrapper.find('.notif-count').text(messagesCount);
    messagesWrapper.show();


*/


var channel = pusher.subscribe('support-chat-718');

channel.bind('App\\Events\\NewMessage', function (data) {
   console.log(data);
   //alert(data['chat_id']);
    
    var messagesWrapper = $('#chat-'+data['chat_id']);
        $('#chat-'+data['chat_id']).remove();
    if(messagesWrapper.hasClass('active_chat')) {
        var active ='active_chat';
        if(data['dir']==0){
           var message='<div class="incoming_msg"><div class="incoming_msg_img"><img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"></div>'
            message +='<div class="received_msg"><div class="received_withd_msg"><p>'+data['body']+'</p>'
            message +='<span class="time_date"><p>'+data['date']+' | '+data['time']+'</span></div></div></div>';
        }else{
            var message='<div class="outgoing_msg"><div class="sent_msg"><p>'+data['body']+'</p>';
               message +='<span class="time_date"> '+data['date']+' | '+data['time']+' | '+data['sender_type']+'</span></div>';
               message +='<span><img src="'+data['img']+'" class="avatar-photo">';
               message += '<span class="hidden-md-down" style="color:#4273FA" >'+data['sender_name']+'</span></span></div>';
        }
        $('#msg_history').prepend(message);
       // $('#msg_history').scrollTop($('#msg_history')[0].scrollHeight);
        $('#msg_history').scrollTop(0);
    }else{
        var active ='';
    }
    var chat= '<div id="chat-'+data['chat_id']+'" chat_id="'+data['chat_id']+'" client_id="'+data['client_id']+'" client_type="'+data['client_type']+'" phone="'+data['phone']+'" class="chat_list '+active+'">';
        chat += '<div class="chat_people"><div class="chat_img"><img src="'+data['img']+'" alt="sunil" class="avatar-photo"> </div><div class="chat_ib">';
        chat +='<h5>'+data['client_name']+'<span class="badge rounded-pill bg-danger">'+data['chat_id']+'</span><span class="chat_date">'+data['date']+' | '+data['time']+'</span></h5>';
        chat +='<p>'+data['body']+'</p></div></div</div>';

$( "#inbox_chat" ).prepend(chat);

  // var messagesCountElem = messagesWrapper.attr("chat_id");
   // alert(messagesCountElem);
});
