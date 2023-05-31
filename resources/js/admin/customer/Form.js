import AppForm from '../app-components/Form/AppForm';

Vue.component('customer-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                phone:  '' ,
                name:  '' ,
                opened:  false ,
                
            }
        }
    }

});