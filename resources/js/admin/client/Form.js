import AppForm from '../app-components/Form/AppForm';

Vue.component('client-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                phone:  '' ,
                name:  '' ,
                
            }
        }
    }

});