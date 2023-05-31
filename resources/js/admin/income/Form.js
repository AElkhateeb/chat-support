import AppForm from '../app-components/Form/AppForm';

Vue.component('income-form', {
    mixins: [AppForm],
    props: [
        'patterns',
        'replies',
    ],
    data: function() {
        return {
            form: {
                income:  this.getLocalizedFormDefaults() ,
                pattern:  '' ,
                replay:  '' ,
                
            }
        }
    }

});