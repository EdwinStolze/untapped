import AppQuestion from "/src/js/components/Question.js";
import CircleButton from "/src/js/components/CircleButton.js";
import QuestionaireProgress from "/src/js/components/Progress.js";

export default {

    template: `
        <section v-if="loaded" class="questionaire">
            <div class="text-align-center body">
                Is life more fun when working {{ questionaire.companyName }}? Lets find out.
            </div>
            <questionaire-progress 
                :questions="questionaire.questions"
                @navigateTo="navigateTo"
            ></questionaire-progress>
            <app-question :question="currentQuestion"></app-question>
            <nav v-if="showNextButton">
                <circle-button @click="next"></circle-button>
            </nav>
            <button @click="processResults">Send results</button>
        </section>
    `,

    components: {
        AppQuestion,
        CircleButton,
        QuestionaireProgress
    },

    props: {
        questionaire: Object
    },

    data() {
        return {
            questionIndex: 0,
            loaded: false,
        };
    },

    computed: {
        currentQuestion() {
            return this.questionaire.questions[this.questionIndex];
        },
        showNextButton() {
            if (this.questionIndex < 0) return false;
            if (this.questionIndex >= this.questionaire.questions.length -1) return false;
            return true;
        },
    },

    methods: {

        // Move to the next question
        next () {
            this.questionIndex++;
        },

        // Helper function to get the index of a question
        getIndexOf(question) {
            return this.questionaire.questions.findIndex( q => {
                return q.id == question.id;
            });
        },

        // Navigate to question
        navigateTo(question) {
            this.questionIndex = this.getIndexOf(question);
        },

        processResults() {
            console.log('Process results');

            // POST request using fetch with error handling
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                // body: JSON.stringify({ title: 'Vue POST Request Example' })
                body: JSON.stringify(this.questionaire)
            };
            fetch('http://localhost:8080/backend/', requestOptions)
            .then(async response => {
                const data = await response.json();

                console.log(data);

                // check for error response
                if (!response.ok) {
                    // get error message from body or default to response status
                    const error = (data && data.message) || response.status;
                    return Promise.reject(error);
                }
                this.postId = data.id;
            })
            .catch(error => {
                this.errorMessage = error;
                console.error('There was an error!', error);
            });
        }
    },

    created() {
        // GET request using fetch with error handling
        fetch("http://localhost:8080/intro/choice/employer/api")
            .then(async(response) => {
                const data = await response.json();

                // check for error response
                if (!response.ok) {
                    // get error message from body or default to response statusText
                    const error = (data && data.message) || response.statusText;
                    return Promise.reject(error);
                }
                this.questionaire.questions = data.questions;
                this.loaded = true;
            })
            .catch((error) => {
                this.errorMessage = error;
                console.error("There was an error!", error);
            });
    },
};