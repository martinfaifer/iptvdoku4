<?php

namespace App\Services\Invoices\Traits;

trait CurrencyPriceTrait
{
    public function calc_tax($tax, $model)
    {
        if ($model->currency_name->name == "CZK") {
            $tax = (float)$tax + (float)$model->price;
        } else {
            $tax = (float)$tax + ((float)$model->price * (float)$model->currency_name->price);
        }

        return $tax;
    }

    public function calc_tax_with_number_of_customers($tax, $model, $numberOfSubscriptions)
    {
        if ($model->currency_name->name == 'CZK') {
            $tax = $numberOfSubscriptions * $model->price;
        } else {
            $tax = $numberOfSubscriptions * $model->price * $model->currency_name->price;
        }
    }
}
