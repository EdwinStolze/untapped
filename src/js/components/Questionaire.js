import AppQuestion from "/src/js/components/Question.js";

export default {

    template: `
        <section class="questionaire">
            <div class="text-align-center body">
                Is life more fun when working {{ repo.companyName }}? Lets find out.
            </div>
            <div v-if="loaded" class="progress">
                <ul>
                    <li v-for="question in repo.questions" :key="question.id" class="button-circle ">
                        {{ question.id }}
                    </li>
                </ul>
            </div>
            <app-question v-if="loaded" :question="currentQuestion"></app-question>
        </section>
    `,

    components: {
        AppQuestion,
    },

    props: {
        repo: Object
    },

    data() {
        return {
            questionIndex: 0,
            loaded: false,
        };
    },

    computed: {
        currentQuestion() {
            return this.repo.questions[this.questionIndex];
        },
    },

    created() {
        // GET request using fetch with error handling
        fetch("http://localhost:8080/employees/api")
            .then(async(response) => {
                const data = await response.json();

                // check for error response
                if (!response.ok) {
                    // get error message from body or default to response statusText
                    const error = (data && data.message) || response.statusText;
                    return Promise.reject(error);
                }
                this.repo.questions = data.questions;
                this.loaded = true;
            })
            .catch((error) => {
                this.errorMessage = error;
                console.error("There was an error!", error);
            });
    },
};