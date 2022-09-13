function sayHello() {
    return "Hello";
}


export default {
    template: `
        <div class="answer">
            <div class="options-wrapper">
                <div 
                    class="indicator"
                    >{{ question.userScore }}</div>
                <div 
                    class="option" 
                    v-for="option in question.scoringOptions"
                    @click="setChoosenOption(option.score_value)"
                >
                    <span class="option__text">{{ option.score_label }}</span>
                </div>
            </div>
            <input type="number" v-model="question.userScore">
        </div>
    `,

    props: {
        question: Object
    },

    data() {
        return {
            choosenOption: 0
        }
    },

    computed: {
        indicatorPercentage() {
            if (this.userScore == 0 ) return 0;
            return (this.question.userScore * 20) - 10;
        }
    },

    methods: {
        setChoosenOption(score) {
            // alert(sayHello());
            this.question.userScore = score;
        }
    }
}