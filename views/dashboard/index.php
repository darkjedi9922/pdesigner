<?php
$tasks = Yii::$app->db->createCommand(
    "SELECT [[id]], [[project_id]], [[number]], [[group_id]], [[title]]
    FROM {{issues}} WHERE [[status]] = 2"
)->queryAll();
$projects = [];
$groups = [];
?>

<script type="text/javascript">
    _dashboardAppData = {
        username: "<?= Yii::$app->user->identity->username ?>",
        tasks: {},
        projects: {},
        groups: {}
    }
    <?php for ($i = 0, $c = count($tasks); $i < $c; ++$i) : $task = $tasks[$i] ?>
        // Рендерим задачу
        _dashboardAppData.tasks[<?= $task['id'] ?>] = {
            id: <?= $task['id'] ?>,
            projectId: <?= $task['project_id'] ?>,
            number: <?= $task['number'] ?>,
            groupId: <?= $task['group_id'] ?>,
            title: '<?= $task['title'] ?>'
        }

        // Рендерим группу, если еще не грузили ее
        <?php if (!isset($groups[$task['group_id']])) : ?>
            <?php
            $groups[$task['group_id']] = true;
            $group = Yii::$app->db->createCommand(
                'SELECT name, color_id FROM issue_groups
                WHERE id = ' . $task['group_id']
            )->queryOne();
            ?>
            _dashboardAppData.groups[<?= $task['group_id'] ?>] = {
                id: <?= $task['group_id'] ?>,
                name: '<?= $group['name'] ?>',
                colorId: <?= $group['color_id'] ?>
            }
        <?php endif ?>

        // Рендерим проект, если еще не грузили его
        <?php if (!isset($projects[$task['project_id']])) : ?>
            <?php
            $projects[$task['project_id']] = true;
            $project = Yii::$app->db->createCommand(
                'SELECT name FROM projects WHERE id = ' . $task['project_id']
            )->queryOne();
            ?>
            _dashboardAppData.projects[<?= $task['project_id'] ?>] = {
                id: <?= $task['project_id'] ?>,
                name: '<?= $project['name'] ?>',
            }
        <?php endif ?>
    <?php endfor ?>
</script>

<div id="dashboard-app"></div>