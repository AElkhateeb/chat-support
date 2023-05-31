import AppForm from '../app-components/Form/AppForm';

Vue.component('reply-form', {
    mixins: [AppForm],
    props: [
        'patterns',
    ],
    data: function() {
        return {
            form: {
                replay:  this.getLocalizedFormDefaults() ,
                pattern:  '' ,
                
            }
        }
    }

});