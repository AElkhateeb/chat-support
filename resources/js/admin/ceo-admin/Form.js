import AppForm from '../app-components/Form/AppForm';

Vue.component('ceo-admin-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                first_name:  '' ,
                last_name:  '' ,
                email:  '' ,
                password:  '' ,
                activated:  false ,
                forbidden:  false ,
                language:  '' ,

            }
        }
    }
});
