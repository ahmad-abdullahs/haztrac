<?php

require_once 'modules/RevenueLineItems/RevenueLineItem.php';

class CustomRevenueLineItem extends RevenueLineItem {

    public function __construct() {
        parent::__construct();
    }

    protected function mapFieldsFromProductTemplate() {
        if (!empty($this->product_template_id) && $this->fetched_row['product_template_id'] != $this->product_template_id) {
            /* @var $pt ProductTemplate */
            $pt = BeanFactory::getBean('ProductTemplates', $this->product_template_id);

            // We have revenuelineitems which are linked to the Product Catalogs which are deleted.
            // So it zero out the calculations, this check is added to avoid those deleted product templates...
            if (!empty($pt->id)) {
                $this->category_id = $pt->category_id;
                $this->mft_part_num = $pt->mft_part_num;
                $this->list_price = SugarCurrency::convertAmount($pt->list_price, $pt->currency_id, $this->currency_id);
                $this->cost_price = SugarCurrency::convertAmount($pt->cost_price, $pt->currency_id, $this->currency_id);
                $this->discount_price = SugarCurrency::convertAmount($pt->discount_price, $pt->currency_id, $this->currency_id); // discount_price = unit price on the front end...
                $this->list_usdollar = $pt->list_usdollar;
                $this->cost_usdollar = $pt->cost_usdollar;
                $this->discount_usdollar = $pt->discount_usdollar;
                $this->tax_class = $pt->tax_class;
                $this->weight = $pt->weight;
            }
        }
    }

}
