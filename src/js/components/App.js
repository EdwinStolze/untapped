import Questionaire from "/src/js/components/Questionaire.js";

export default {

    template: `
    	<questionaire :questionaire="questionaire"></questionaire>
    `,

    components: {
        Questionaire,
    },

    data() {
        return {
			questionaire: {
				companyName: 'My Company',
				email: '',
				questions: []
			}
        };
    },
};