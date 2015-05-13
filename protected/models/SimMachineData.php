<?php

/**
 * This is the model class for table "sim_machine_datas".
 *
 * The followings are the available columns in table 'sim_machine_datas':
 * @property integer $id
 * @property integer $cd_machine_id
 * @property integer $group_id
 * @property double $idle_time
 * @property double $production_time
 * @property double $set_up_time
 * @property double $clearing_time
 * @property integer $period
 * @property string $created
 * @property double $idle_time_shift_1
 * @property double $idle_time_shift_2
 * @property double $idle_time_shift_3
 * @property double $idle_time_overtime
 * @property double $production_time_shift_1
 * @property double $production_time_shift_2
 * @property double $production_time_shift_3
 * @property double $production_time_overtime
 *
 * The followings are the available model relations:
 * @property Groups $group
 */
class SimMachineData extends CActiveRecord
{


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sim_machine_datas';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cd_machine_id, group_id', 'required'),
            array('cd_machine_id, group_id, period', 'numerical', 'integerOnly' => true),
            array('idle_time, production_time, set_up_time, clearing_time, idle_time_shift_1, idle_time_shift_2, idle_time_shift_3, idle_time_overtime, production_time_shift_1, production_time_shift_2, production_time_shift_3, production_time_overtime', 'numerical'),
            array('created', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cd_machine_id, group_id, idle_time, production_time, set_up_time, clearing_time, period, created, idle_time_shift_1, idle_time_shift_2, idle_time_shift_3, idle_time_overtime, production_time_shift_1, production_time_shift_2, production_time_shift_3, production_time_overtime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'group' => array(self::BELONGS_TO, 'Groups', 'group_id'),
            'machine' => array(self::BELONGS_TO, 'CdMachine','cd_machine_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'cd_machine_id' => 'Cd Machine',
            'group_id' => 'Group',
            'idle_time' => 'Idle Time',
            'production_time' => 'Production Time',
            'set_up_time' => 'Set Up Time',
            'clearing_time' => 'Clearing Time',
            'period' => 'Period',
            'created' => 'Created',
            'idle_time_shift_1' => 'Idle Time Shift 1',
            'idle_time_shift_2' => 'Idle Time Shift 2',
            'idle_time_shift_3' => 'Idle Time Shift 3',
            'idle_time_overtime' => 'Idle Time Overtime',
            'production_time_shift_1' => 'Production Time Shift 1',
            'production_time_shift_2' => 'Production Time Shift 2',
            'production_time_shift_3' => 'Production Time Shift 3',
            'production_time_overtime' => 'Production Time Overtime',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('cd_machine_id', $this->cd_machine_id);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('idle_time', $this->idle_time);
        $criteria->compare('production_time', $this->production_time);
        $criteria->compare('set_up_time', $this->set_up_time);
        $criteria->compare('clearing_time', $this->clearing_time);
        $criteria->compare('period', $this->period);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('idle_time_shift_1', $this->idle_time_shift_1);
        $criteria->compare('idle_time_shift_2', $this->idle_time_shift_2);
        $criteria->compare('idle_time_shift_3', $this->idle_time_shift_3);
        $criteria->compare('idle_time_overtime', $this->idle_time_overtime);
        $criteria->compare('production_time_shift_1', $this->production_time_shift_1);
        $criteria->compare('production_time_shift_2', $this->production_time_shift_2);
        $criteria->compare('production_time_shift_3', $this->production_time_shift_3);
        $criteria->compare('production_time_overtime', $this->production_time_overtime);
        $criteria->with = array(
            'machine'=>array(
                'alias'=>'machine'
            )
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,

        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SimMachineData the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Nächsten Auftrag zum abarbeiten erhalten
     */
    public function getOrder2Work($MachineCache, &$StockCache, &$WaitProductCache, $period, $group_id, $simtime)
    {
        //Prüfen ob ein unfertiger aber schon angefangener Auftrag vorhanden ist
        $productionOrdersIncomplete = SimProductionOrder::model()->findAll('group_id=:group_id and cd_machine_id=:machine_id and finished=false and status="incomplete wait" order by id asc', array('group_id' => $this->group_id, 'machine_id' => $this->cd_machine_id));
        if (!empty($productionOrdersIncomplete)) {
            //Wir haben unfertige, angefangene Aufträge!
            //Gib den ersten zurück!
            return $productionOrdersIncomplete[0];
        }

        $shiftScheduling = ShiftScheduling::model()->find('group_id=:group_id and cd_machine_id=:machine_id and period=:period', array('group_id' => $this->group_id, 'machine_id' => $this->cd_machine_id, 'period' => $period));

        if ($shiftScheduling->machine_modus != 'min_set_up') {
            $l = $MachineCache->getLastProductionOrderId($this->id);
            if (empty($l)) {
                $filter = '';
            } else {
                $notready = SimProductionOrder::model()->count('production_order_id=:production_order_id and finished=false', array('production_order_id' => $l));
                if ($notready > 0) {
                    $filter = ' and production_order_id="' . $l . '"';
                } else {
                    $filter = '';
                }
            }

        } else {
            $filter = '';
        }
        //Hier haben wir keine schon angefangenen Aufträge also sehen wir ob wir überhaupt noch welche haben
        $productionOrders = SimProductionOrder::model()->findAll('group_id=:group_id and cd_machine_id=:machine_id and finished=false and status="wait" ' . $filter . ' order by id asc', array('group_id' => $this->group_id, 'machine_id' => $this->cd_machine_id));
        if (!empty($productionOrders)) {
            $lastPo = 'empty';
            foreach ($productionOrders as $productionOrder) {

                if ($productionOrder->sequence <= 1) {
                    $lastPo = 'empty';
                    $Free = 1;
                } else {

                    //Prüfen ob vorhergegangene Arbeitsschritte fertig
                    if ($lastPo != $productionOrder->cd_step_id . '-' . $productionOrder->sequence) {
                        $CurrentCount = SimProductionOrder::model()->count('group_id=:group_id and cd_workflow_id=:cd_workflow_id and sequence=:sequence and finished=true', array('group_id' => $this->group_id, 'cd_workflow_id' => $productionOrder->cd_workflow_id, 'sequence' => $productionOrder->sequence));
                        $BeforeCount = SimProductionOrder::model()->count('group_id=:group_id and cd_workflow_id=:cd_workflow_id and sequence=:sequence and finished=true', array('group_id' => $this->group_id, 'cd_workflow_id' => $productionOrder->cd_workflow_id, 'sequence' => $productionOrder->sequence - 1));
                        $Free = $BeforeCount - $CurrentCount;
                        $lastPo = $productionOrder->cd_step_id . '-' . $productionOrder->sequence;
                    }

                }

                if ($Free >= 1) {
                    //Diesen Produktionsauftrag können wir fertigen, sofern wir noch Material haben
                    $production_possible = true;
                    if ($lastPo != $productionOrder->cd_step_id . '-' . $productionOrder->sequence || empty($cd_inputparts)) {
                        $cd_inputparts = CdInputpart::model()->findAllByAttributes(array('cd_step_id' => $productionOrder->cd_step_id));
                    }
                    foreach ($cd_inputparts as $cd_inputpart) {
                        $stockAmount = $StockCache->getAmount($cd_inputpart->cd_product_id);
                        if ($stockAmount < ($cd_inputpart->amount * $productionOrder->amount)) {
                            $production_possible = false;
                            $WaitProductCache->waitForProduct($cd_inputpart->cd_product_id, 0, $productionOrder->cd_machine_id, $productionOrder->production_order_id, $productionOrder->id, $cd_inputpart->amount * $productionOrder->amount - $stockAmount, $this->period, $this->group_id);
                            break;
                        } else {
                            $WaitProductCache->unwaitForProduct($cd_inputpart->cd_product_id, $productionOrder->id);
                        }

                    }
                    if ($production_possible) {
                        foreach ($cd_inputparts as $cd_inputpart) {
                            $StockCache->removeAmount($cd_inputpart->cd_product_id, $cd_inputpart->amount * $productionOrder->amount);

                            $stockRotation = new StockRotation();
                            $stockRotation->amount = -($cd_inputpart->amount * $productionOrder->amount);
                            $stockRotation->period = $period;
                            $stockRotation->sim_time = $simtime;
                            $stockRotation->group_id = $group_id;
                            $stockRotation->cd_product_id = $cd_inputpart->cd_product_id;
                            $stockRotation->save();
                        }
                        return $productionOrder;
                    }
                }
            }
        }
        // diese Stelle erreicht ist, kann kein Auftrag bearbeitet werden...
        return null;

    }

    public function hasStillWork()
    {
        $order2work = SimProductionOrder::model()->count('group_id=:group_id and cd_machine_id=:cd_machine_id and finished=false', array('group_id' => $this->group_id, 'cd_machine_id' => $this->cd_machine_id));
        return $order2work > 0;
    }


}
