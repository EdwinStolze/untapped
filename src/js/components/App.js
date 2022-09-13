import Questionaire from "/src/js/components/Questionaire.js";

export default {

    template: `
    	<questionaire :repo="repo"></questionaire>
    `,

    components: {
        Questionaire,
    },

    data() {
        return {
			repo: {
				companyName: 'My Company',
				email: '',
				questions: []
			}
        };
    },
};