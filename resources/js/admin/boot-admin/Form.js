import AppForm from '../app-components/Form/AppForm';

Vue.component('boot-admin-form', {
    mixins: [AppForm],
    props: [
        'patterns',
    ],
    data: function() {
        return {
            form: {
                pattern:  '' ,
                stuff:  '' ,
                previous:  '' ,
                checked:  false ,
                
            }
        }
    }

});