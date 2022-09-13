export default {
    template: `
        <div class="progress">
            <progress id="file" :value="answeredQuestions.length" :max="questions.length"></progress>
            <ul>
                <li 
                    v-for="question in questions" 
                    :key="question.id" 
                    class="button-circle"
                    :class="{
                        active: isActive(question)
                    }"
                    @click="navigateTo(question)"
                >
                    {{ question.id }}
                </li>
            </ul>
        </div>
    `,

    props: {
        questions: Array,
    },

    computed: {
        answeredQuestions () {
            return this.questions.filter( q => q.userScore > 0);
        }
    },

    methods: {
        navigateTo(question) {
            this.$emit('navigateTo', question);
        },
        isActive(question) {
            if (question.userScore) return true;
            return false;
        }
    }
}