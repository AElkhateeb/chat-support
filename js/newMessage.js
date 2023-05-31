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
   var chatSelector='#chat-'+data['chat_id'] ;
   var senderSelector="#inbox_chat_"+data['sender_id'] ;
  // alert(senderSelector);
   // alert(document.getElementById(senderSelector));
   var ceoSelector="#inbox_chat_ceo";
     if( $(chatSelector).length ) {
        var messagesWrapper = $(chatSelector);
        $('#chat-'+data['chat_id']).remove();
        if(messagesWrapper.hasClass('active_chat')) {
            var active ='active_chat';
            if(data['dir']==0){
                
                var message='<li class="t-mb-30"><div class="msg-receiver d-flex align-items-end"><div class="avatars avatars--circle avatars--sm-plus t-mr-5">';
                message +='<img src="https://ptetutorials.com/images/user-profile.png" alt="max" class="img-fulid w-100"><div class="avatars__status"></div></div>';
                message +='<ul class="t-list msg-receiver__list"><li class="msg-receiver__list-item">'+data['body']+'</li></ul></div></li>';

            }else{
                
                var message='<li class="t-mb-30"><ul class="t-list msg-sender__list"><li class="msg-sender__list-item text-end">';
                message +='<div class="msg-sender__message">'+data['body']+'</div></li></ul></li>';
            }
            $('#msg_history').append(message);
            $('#msg_history').scrollTop($('#msg_history')[0].scrollHeight);
           // $('#msg_history').scrollTop(0);
        }else{
            var active ='';
        }

     }
       var chat='<li id="chat-'+data['chat_id']+'"  chat_id="'+data['chat_id']+'" customer_id="'+data['customer_id']+'" customer_type="'+data['customer_type']+'" phone="'+data['phone']+'" name="'+data['phone']+'" body="'+data['body']+'"  class="chat__list-item '+active+'">';
         chat +='<a href="#" class="t-link w-100"><div class="messages__msg"><div class="messages__avatar messages__avatar-empty t-bg-alpha"><img src="'+data['img']+'" alt="Adminage" class="img-fluid w-100"><div class="messages__avatar-notification messages__avatar-notification--active"></div></div>';
         chat +='<div class="messages__content messages__content--unseen"><div class="messages__title"><span class="messages__author text-capitalize">'+data['customer_name']+'</span><span class="messages__time text-capitalize">'+data['date']+' | '+data['time']+'</span></div>';
         chat +='<div class="messages__content-body"><span class="messages__preview">'+data['body']+'</span><span class="messages__status messages__status--unseen"></span></div></div></div></a></li>';
    if( $(senderSelector).length ) {
       
        $(senderSelector).prepend(chat);
    }else if( $(ceoSelector).length ) {
        $(ceoSelector).prepend(chat);
    }else{
        //$(senderSelector).prepend(chat);
        alert('not for you');
    }


  // var messagesCountElem = messagesWrapper.attr("chat_id");
   // alert(messagesCountElem);
});
