import { mapState} from 'vuex';

export default {
    data: function(){

    },
    computed: {
        ...mapState([
            'eventSelected',
        ]),
        ...mapGetters([
            'getYear',
            'getMonth',
            'getMonthName'
        ]),
    }
}