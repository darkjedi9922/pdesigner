;Vue.component('todo-group', {
    props: {
        data: Object
    },
    data: function() {
        return {
            store: mainStore,
            colorId: undefined,
            mainClass: 'todo-group'
        }
    },
    computed: {
        colorClass: function() {
            return 'todo-group--color-' + this.colorId;
        }
    },
    mounted: function() {
        this.colorId = this.data.colorId;
    },
    methods: {
        colorClicked: function(event) {
            for (var i = 1; i <= 4; ++i) {
                if ($(event.target).hasClass('todo-group--bckg-' + i)) {
                    this.colorId = i;
                    this.setDbColorId(i);
                }
            }
        },
        setDbColorId: function(id) {
            $.ajax({ url: mainStore.groups.links.setColorId(this.data.id, id) });
        }
    },
    template: `
        <div :class="[mainClass, colorClass]">
            <span class="todo-group__title">{{ data.name }}</span>
            <contextmenu class="todo-contextmenu">
                <span class="todo-contextmenu__item" id="change-color"><i class="icon paint brush"></i>Изменить цвет</span>
                <span class="todo-contextmenu__item"><i class="icon pencil alternate"></i>Изменить название</span>
                <a :href="store.groups.links.getAddTask(data.id)" class="todo-contextmenu__item"><i class="icon add"></i>Добавить задачу</a>
                <span class="todo-contextmenu__item"><i class="icon trash"></i>Удалить группу</span>
            </contextmenu>
            <contextmenu class="todo-contextmenu" for="change-color" on="click">
                <table class="todo-group__color-table" @click="colorClicked">
                    <tr>
                        <td class="todo-group__color-cell todo-group--bckg-1"></td>
                        <td class="todo-group__color-cell todo-group--bckg-2"></td>
                    </tr>
                    <tr>
                        <td class="todo-group__color-cell todo-group--bckg-3"></td>
                        <td class="todo-group__color-cell todo-group--bckg-4"></td>
                    </tr>
                </table>
            </contextmenu>
        </div>
    `
});