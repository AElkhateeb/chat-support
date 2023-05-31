import AppForm from '../app-components/Form/AppForm';

Vue.component('chat-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                customer_type:  '' ,
                customer_id:  '' ,
                sender_type:  '' ,
                sender_id:  '' ,
                body:  '' ,
                
            }
        }
    }

});