import Answer from '/src/js/components/QuestionAnswer.js';

export default {
    template: `
        <div class="question text-align-center h1">
            {{ question.question }}
        </div>
        <answer :question="question"></answer>
    `,

    components: {
        Answer
    },

    props: {
        question: Object,
    },

    data() {
        return {
            answer: 0
        }
    },
}

