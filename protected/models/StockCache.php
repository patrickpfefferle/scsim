<?php


class StockItem
{
    public $id;
    public $cd_product_id;
    public $amount;
    public $price;
}

class StockCache
{

    private $_Items;
    private $_Lagerwerte;
    public $items2sale=[];
    public $itemsMaxSale=[];
    public $itemsSold=[];

    public function addItem2Sale($pid,$amount)
    {
        $this->items2sale[$pid]=$amount;
        $this->itemsSold[$pid]=0;
        $this->itemsMaxSale[$pid]=$amount/5;
    }

    public function getMaxItemsSale($pid)
    {
        return $this->itemsMaxSale[$pid];
    }

    public function getOpenSells($pid)
    {
        return $this->items2sale[$pid];
    }

    public function sellItem($pid,$amount)
    {
        $this->items2sale[$pid]=$this->items2sale[$pid]-$amount;
        $this->itemsSold[$pid]=$this->itemsSold[$pid]+$amount;
    }

    public function loadFromDatabase($group_id, $period)
    {
        $stocks = Stock::model()->findAllByAttributes(array('group_id' => $group_id, 'period' => $period));
        foreach ($stocks as $stock) {
            $stockitem = new StockItem();
            $stockitem->id = $stock->id;
            $stockitem->cd_product_id = $stock->cd_product_id;
            $stockitem->amount = $stock->amount;
            $stockitem->price = $stock->price;

            $this->_Items[$stock->cd_product_id] = $stockitem;
        }
    }

    public function saveToDatabase($group_id, $period)
    {
        foreach ($this->_Items as $item) {
            $stock = Stock::model()->findByPk($item->id);
            if (!empty($stock)) {
                $stock->amount = $item->amount;
                $stock->price = $item->price;
                $stock->save();
            }
        }
    }

    public function getAmount($cd_product_id)
    {
        return @$this->_Items[$cd_product_id]->amount;
    }

    public function getPrice($cd_product_id)
    {
        return @$this->_Items[$cd_product_id]->price;
    }

    public function setAmount($cd_product_id, $amount)
    {
        $this->_Items[$cd_product_id]->amount = $amount;

    }

    public function addAmountWithPriceChange($cd_product_id, $amount, $production_costs)
    {
        $alt = ($this->_Items[$cd_product_id]->price * $this->_Items[$cd_product_id]->amount);
        $neu = $amount * $production_costs;
        $neuer_Gesamtpreis = $neu + $alt;
        $price_piece = $neuer_Gesamtpreis / ($this->_Items[$cd_product_id]->amount + $amount);
        $this->_Items[$cd_product_id]->price = $price_piece;
        $this->_Items[$cd_product_id]->amount = $this->_Items[$cd_product_id]->amount + $amount;


    }

    public function removeAmount($cd_product_id, $amount)
    {
        $this->_Items[$cd_product_id]->amount = $this->_Items[$cd_product_id]->amount - $amount;
    }

    public function addLagerwert()
    {
        $l = 0;
        foreach ($this->_Items as $item) {
            $l = $l + ($item->amount * $item->price);
        }
        $this->_Lagerwerte[] = $l;
    }

    public function getLagerwert()
    {
        return array_sum($this->_Lagerwerte) / count($this->_Lagerwerte);
    }

}