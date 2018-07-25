;new Vue({ 
    el: "#app",
    data: {
        todo: 'undone',
        list: [
            { id: 1, title: 'Демоны', parentId: 0, checked: false },
            { id: 2, title: 'Http', parentId: 0, checked: false },
            { id: 3, title: 'Состояния и ошибки', parentId: 2, checked: false },
            { id: 4, title: 'Коды или тексты?', parentId: 3, checked: false },
            { id: 5, title: 'Исключения', parentId: 2, checked: false }
        ],
        autoincrement: 6 
    },
    methods: {
        add: function() {
            this.list.push({
                id: this.autoincrement++,
                title: 'Новый итем',
                parentId: 0,
                checked: false
            });
        }
    }
});