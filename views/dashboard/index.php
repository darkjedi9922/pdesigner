<script type="text/javascript">
    _dashboardAppData = {
        username: "<?= Yii::$app->user->identity->username ?>",
        tasks: {
            1: {
                id: 1,
                number: 41,
                projectId: 1,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                groupId: 1
            },
            2: {
                id: 2,
                number: 42,
                projectId: 1,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                groupId: 1
            },
            4: {
                id: 4,
                number: 41,
                projectId: 2,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                groupId: 3
            },
            5: {
                id: 5,
                number: 42,
                projectId: 2,
                title: 'Сделать Dashboard в Project DesignerСделать Dashboard в Project Designer',
                groupId: 3
            }
        },
        projects: {
            1: {
                id: 1,
                name: 'Lightness',
                description: '# The description\n\nNew **line**'
            },
            2: {
                id: 2,
                name: 'Project Designer',
                description: '# The description\n\nNew **line**'
            }
        },
        groups: {
            1: {
                id: 1,
                projectId: 1,
                name: 'Новые фичи',
                colorId: 4
            },
            2: {
                id: 2,
                projectId: 1,
                name: 'Баги',
                colorId: 1
            },
            3: {
                id: 3,
                projectId: 2,
                name: 'Общее',
                colorId: 2
            },
            4: {
                id: 4,
                projectId: 3,
                name: 'Баги',
                colorId: 1
            }
        }
    }
</script>

<div id="dashboard-app"></div>