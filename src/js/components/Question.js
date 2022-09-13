

export default {
    template: `
        <div class="question text-align-center h1">
            {{ question.question }}
        </div>
        <div class="answer">
            <input type="number" v-model="question.userScore">
        </div>
    `,
    
    props: {
        question: Object,
    },

    data() {
        return {
            answer: 0
        }
    }
}

