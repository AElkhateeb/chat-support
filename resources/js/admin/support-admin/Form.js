import AppForm from '../app-components/Form/AppForm';

Vue.component('support-admin-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                first_name:  '' ,
                last_name:  '' ,
                email:  '' ,
                department:  '' ,
                password:  '' ,
                activated:  false ,
                forbidden:  false ,
                language:  '' ,

            }
        }
    }
});
