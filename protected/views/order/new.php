<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Orders');

/** @var $orders array */

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Orders')
));

?>

<script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.min.js"></script>
<script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css'/>


<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id' => 'orders-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));

    $searchnames = array();

    foreach ($parts as $part) {
        $searchnames[] = $part->number;
    }

    $displayedRows = 10;
    if (count($orders) > $displayedRows) {$displayedRows = count($orders);}

    ?>

    <div class="form sharp">


        <fieldset id="orderinput">


        </fieldset>


        <input type="button" value="Add a field" class="add" id="add"/>


        <script type="text/javascript">

            function deleteRow(btn) {
                $(this).closest('tr').remove();

            }

            function setRowValues(idx, productID, amount, orderType) {
                // console.log('setRowValues '+idx);
                $('#Order_'+idx+'_cd_product_id').val(productID);
                $('#Order_'+idx+'_amount').val(amount);
                $('#Order_'+idx+'_order_type').val(orderType);
            }

            $(document).ready(function () {

                var i = 0;

                var body = document.getElementsByTagName('body')[0];
                var tbl = document.createElement('table');
                //tbl.style.width = '30%';
                tbl.setAttribute('border', '0');

                var tr = document.createElement('tr');

                var th = document.createElement('th');
                th.appendChild(document.createTextNode('Kaufteil'));
                th.setAttribute('style', 'text-align: left');
                tr.appendChild(th);

                var th = document.createElement('th');
                th.appendChild(document.createTextNode('Menge'));
                th.setAttribute('style', 'text-align: left');
                tr.appendChild(th);

                var th = document.createElement('th');
                th.appendChild(document.createTextNode('Bestelltyp'));
                th.setAttribute('style', 'text-align: left');
                tr.appendChild(th);

                var th = document.createElement('th');
                th.appendChild(document.createTextNode('Entfernen'));
                th.setAttribute('style', 'text-align: center');
                tr.appendChild(th);

                tbl.appendChild(tr);


                $("#add").click(function () {


                    var product_field_name = "Order[" + i +
                        "][cd_product_id]";
                    var product_field_id = "Order_" + i +
                        "_cd_product_id";
                    var amount_name = "Order[" + i +
                        "][amount]";
                    var amount_id = "Order_" + i +
                        "_amount";
                    var order_type_name = "Order[" + i +
                        "][order_type]";
                    var order_type_id = "Order_" + i +
                        "_order_type";

                    var tr = document.createElement('tr');

                    var fPart = document.createElement('input');
                    fPart.setAttribute('type', 'text');
                    fPart.setAttribute('class', 'sharp');
                    fPart.setAttribute('placeholder', 'Kaufteil');
                    fPart.setAttribute('name', product_field_name);
                    fPart.setAttribute('id', product_field_id);

                    var td = document.createElement('td');
                    td.appendChild(fPart);
                    td.setAttribute('style', 'text-align: left');
                    tr.appendChild(td);

                    var fMenge = document.createElement('input');
                    fMenge.setAttribute('type', 'text');
                    fMenge.setAttribute('class', 'sharp');
                    fMenge.setAttribute('placeholder', 'Menge');
                    fMenge.setAttribute('name', amount_name);
                    fMenge.setAttribute('id', amount_id);

                    var td = document.createElement('td');
                    td.appendChild(fMenge);
                    td.setAttribute('style', 'text-align: left');
                    tr.appendChild(td);

                    var fOrderType = document.createElement("select");
                    fOrderType.setAttribute('class', 'fieldtype');
                    fOrderType.setAttribute('name', order_type_name);
                    fOrderType.setAttribute('id', order_type_id);


                    var op = new Option();
                    op.value = "Normal";
                    op.text = "Normal";
                    fOrderType.options.add(op);

                    var op = new Option();
                    op.value = "Eil";
                    op.text = "Eil";
                    fOrderType.options.add(op);

                    var td = document.createElement('td');
                    td.appendChild(fOrderType);
                    td.setAttribute('style', 'text-align: left');
                    tr.appendChild(td);

                    var removeButton = document.createElement('input');
                    removeButton.setAttribute('type', 'button');
                    removeButton.setAttribute('class', 'btn btn-small btn-primary sharp');
                    removeButton.setAttribute('value', '-');
                    removeButton.addEventListener("click", deleteRow, false);

                    var td = document.createElement('td');
                    td.appendChild(removeButton);
                    td.setAttribute('style', 'text-align: center');
                    tr.appendChild(td);

                    tbl.appendChild(tr);

                    $("#orderinput").append(tbl);
                    <?php
                    $autocompleteParams = array();
                    $autocompleteParams["minLength"] = 0;
                    $autocompleteParams["source"] = $searchnames;
                    ?>
                    $("#" + product_field_id).autocomplete(<?php echo json_encode($autocompleteParams);?>);

                    i = i + 1;

                });


                for (var f=0;f<<?php echo $displayedRows; ?>;f++)
                {
                    $("#add").click();
                }

                <?php

                    foreach($orders as $idx => $order) {
                        $id = $order['cd_product_id'];
                        $amount = $order['amount'];
                        $orderType = $order['order_type'];
                        // TODO: use js escape fn from yii
                        echo "setRowValues(".$idx.", '".$id."', '".$amount."', '".$orderType."');\n";
                    }
                 ?>
            });
        </script>


    </div>
    <div class="span12 noFM" align="center">
        <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Save and proceed') ?></button>
        <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset') ?></button>
        <?php if (SimPeriodStatus::isReadytoSimulate()) { ?>
            <a class="btn sharp btn-secondary" href="<?php echo $this->createUrl('simulation/simulate');?>"><?php echo Yii::t('app', 'Simulate now') ?></a>
        <?php } ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->