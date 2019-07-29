<script type="text/javascript">
    _dashboardAppData = {
        username: "<?= Yii::$app->user->identity->username ?>",
        projects: [{
            id: 1,
            name: 'Lightness',
            description: '# The description\n\nNew **line**',
            tasks: [{
                id: 1,
                number: 41,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                status: 2
            }, {
                id: 2,
                number: 42,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                status: 2
            }, {
                id: 3,
                number: 43,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                status: 2
            }]
        }, {
            id: 2,
            name: 'Project Designer',
            description: '# The description\n\nNew **line**',
            tasks: [{
                id: 4,
                number: 41,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                status: 2
            }, {
                id: 5,
                number: 42,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                status: 2
            }, {
                id: 6,
                number: 43,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                status: 2
            }]
        }]
    }
</script>

<div id="dashboard-app"></div>