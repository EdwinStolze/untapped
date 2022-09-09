import AppButton from '/src/js/components/AppButton.js';

export default {
    components: {
        AppButton
    },
    data() {
        return {
            answer: 0,
            questions: [
                { question: "Question 1", complete: false, id:1},
                { question: "Question 2", complete: false, id:2 },
                { question: "Question 3", complete: false, id:3 },
                { question: "Question 4", complete: false, id:4 },
            ]
        }
    }
}