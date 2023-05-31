import AppForm from '../app-components/Form/AppForm';

Vue.component('message-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                dir:  false ,
                from:  '' ,
                to:  '' ,
                segments:  '' ,
                status:  '' ,
                body:  '' ,
                media:  '' ,
                sender_type:  '' ,
                sender_id:  '' ,
                customer_type:  '' ,
                customer_id:  '' ,
                chat_id:  '' ,
                
            }
        }
    }

});