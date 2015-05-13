<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Production Orders');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Production Orders')
));

?>

<script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.min.js"></script>
<script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css'/>


<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id' => 'productionorder-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));

    $searchnames = array();

    foreach ($partsAndProducts as $partandproduct) {
        $searchnames[] = $partandproduct->number;
    }

    // preselected orderProducts:
    /* @var $productionOrders array */

    $displayedRows = 10;
    if (count($productionOrders) > $displayedRows) {$displayedRows = count($productionOrders);}

    ?>

    <div class="form sharp">


        <fieldset id="productionorderinput">


        </fieldset>


        <input type="button" value="Add a field" class="add" id="add"/>


        <script type="text/javascript">

            function deleteRow(btn) {
                $(this).closest('tr').remove();

            }

            function setRowValues(idx, productID, amount) {
                // console.log('fillRow '+idx);
                $('#ProductionOrder_'+idx+'_cd_product_id').val(productID);
                $('#ProductionOrder_'+idx+'_amount').val(amount);
            }

            $(document).ready(function () {

                var i = 0;

                var body = document.getElementsByTagName('body')[0];
                var tbl = document.createElement('table');
                //tbl.style.width = '30%';
                tbl.setAttribute('border', '0');

                var tr = document.createElement('tr');

                var th = document.createElement('th');
                th.appendChild(document.createTextNode('Part'));
                th.setAttribute('style', 'text-align: left');
                tr.appendChild(th);

                var th = document.createElement('th');
                th.appendChild(document.createTextNode('Menge'));
                th.setAttribute('style', 'text-align: left');
                tr.appendChild(th);


                var th = document.createElement('th');
                th.appendChild(document.createTextNode('Entfernen'));
                th.setAttribute('style', 'text-align: center');
                tr.appendChild(th);

                tbl.appendChild(tr);


                $("#add").click(function () {


                    var amount_field_name = "ProductionOrder[" + i + "][amount]";
                    var amount_field_id = "ProductionOrder_" + i + "_amount";

                    var cd_product_id_field_name = "ProductionOrder[" +
                        i + "][cd_product_id]";
                    var cd_product_id_field_id = "ProductionOrder_" + i + "_cd_product_id";


                    var tr = document.createElement('tr');

                    var fPart = document.createElement('input');
                    fPart.setAttribute('type', 'text');
                    fPart.setAttribute('class', 'sharp');
                    fPart.setAttribute('placeholder', 'Produkt');
                    fPart.setAttribute('name', cd_product_id_field_name);
                    fPart.setAttribute('id', cd_product_id_field_id);

                    var td = document.createElement('td');
                    td.appendChild(fPart);
                    td.setAttribute('style', 'text-align: left');
                    tr.appendChild(td);

                    var fMenge = document.createElement('input');
                    fMenge.setAttribute('type', 'text');
                    fMenge.setAttribute('class', 'sharp');
                    fMenge.setAttribute('placeholder', 'Menge');
                    fMenge.setAttribute('name', amount_field_name);
                    fMenge.setAttribute('id', amount_field_id);

                    var td = document.createElement('td');
                    td.appendChild(fMenge);
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

                    $("#productionorderinput").append(tbl);
                    <?php
                    $autocompleteParams = array();
                    $autocompleteParams["minLength"] = 0;
                    $autocompleteParams["source"] = $searchnames;
                    ?>
                    $("#" + cd_product_id_field_id).autocomplete(<?php echo json_encode($autocompleteParams);?>);

                    i = i + 1;

                });


                for (var f=0;f<<?php echo $displayedRows; ?>;f++)
                {
                    $("#add").click();
                }

                <?php

                    foreach($productionOrders as $idx => $order) {
                        $id = $order['cd_product_id'];
                        $amount = $order['amount'];
                        // TODO: use js escape fn from yii
                        echo "setRowValues(".$idx.", '".$id."', '".$amount."');\n";
                    }
                 ?>
            });
        </script>


    </div>
    <div class="span12 noFM" align="center">
        <a class="btn sharp btn-secondary" href="<?php echo $this->createUrl('order/new');?>"><?php echo Yii::t('app', 'Back to orders') ?></a>
        <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Save and proceed') ?></button>
        <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset') ?></button>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->