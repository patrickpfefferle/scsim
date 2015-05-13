<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 09.08.14
 * Time: 01:02
 */

if ($ready) {
    if ($layout) {
        Yii::app()->controller->redirect(array('site/index'));
    } else {
        echo "1";
        die();
    }
}

?>



<section class='container-fluid'>
    <div class='row-fluid'>


        <div class='span3'><br/></div>
        <div class='span3'>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td style="text-align: center"> <?php echo Yii::t('app', 'Status'); ?> </td>
                    <td> <?php echo Yii::t('app', 'Description'); ?> </td>
                </tr>
                </thead>

                <?php
                if (empty($logs)) {
                    ?>
                    <tr>
                        <td style="text-align: center">
                            <img src="<?php echo Yii::app()->request->baseUrl . '/img/loading.gif'; ?>" alt=""
                                 width="32" height="32">
                        </td>
                        <td style="vertical-align: middle;">
                            <b> <?php echo Yii::t('app', 'Simulation processing'); ?> </b>
                        </td>
                    </tr>
                <?php
                }
                foreach ($logs as $log) {
                    ?>

                    <tr>
                        <td style="text-align: center">
                            <?php
                            if ($log->status == 0) {
                                ?>
                                <img src="<?php echo Yii::app()->request->baseUrl . '/img/loading.gif'; ?>" alt=""
                                     width="32" height="32">
                            <?php
                            }
                            if ($log->status == 1) {
                                echo CHtml::image(Yii::app()->request->baseUrl . '/img/ok.png', 'IMAGE');
                            }
                            ?>

                        </td>
                        <td style="vertical-align: middle;"><b> <?php echo Yii::t('app', $log->description); ?> </b>
                        </td>
                    </tr>


                <?php
                }

                ?>
            </table>

        </div>
        <div class='span3'>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td style="text-align: center"> <?php echo Yii::t('app', 'Operating numbers'); ?> </td>
                    <td> <?php echo Yii::t('app', 'Value'); ?> </td>
                </tr>
                </thead>
                <tr>
                    <td>
                        <?php echo Yii::t('app', 'simulation time') ?>
                    </td>
                    <td>
                        <?php
                        $currentSimTime = Yii::app()->db->createCommand()->select('max(simtime)')->from('sim_debug_logs')->where('group_id=:group_id and period=:period', array(':group_id' => $group_id, ':period' => $period))->queryScalar();
                        echo $currentSimTime;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo Yii::t('app', 'unfinished batches') ?>
                    </td>
                    <td>
                        <?php
                        $countSim = SimProductionOrder::model()->count('group_id=:group_id and finished=false', array('group_id' => $group_id));
                        echo $countSim;
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</section>

