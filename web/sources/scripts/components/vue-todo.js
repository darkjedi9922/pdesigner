;Vue.component('vue-todo', {
    props: {
        listedGroups: {
            required: true,
            default: function() { return {} }
        },
        mode: {
            type: String,
            required: false,
            default: 'all'
        }
    },
    template: `
    <div>
        <div 
            v-for="(group, id) in listedGroups"
            :key="id">

            <todo-group
                :data="group"
            ></todo-group>

            <todo-list
                :mode="mode"
                :list="group.list">
            </todo-list>

        </div>
    </div>`
});