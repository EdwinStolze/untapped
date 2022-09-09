export default {
    template: `
        <button
            :class="{
                'red': type === 'error',
                'orange': type === 'warning',
            }"
            @click="plus"
        >
            <slot>clicker</slot>
            <span v-show="clickcount > 0">({{ clickcount }})</span>
        </button>
    `,
    props: {
        type: {
            default: 'warning',
            type: String
        }
    },
    methods: {
        plus() {
            this.clickcount++
        }
    },
    data() {
        return {
            processing: false,
            clickcount: 0
        }
    }
}