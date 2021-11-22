<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\LIB\Validation;
use MYMVC\MODELS\AbstractModel;
use MYMVC\MODELS\privilegecontrolmodel;
use MYMVC\MODELS\Productmodel;

class IndexController extends AbstractController
{
    use Validation;

    public function defaultAction()
    {

        $this->_language->load('Index', 'default');

        $this->_data['index'] = AbstractModel::getbySQL('select 
                                                                    (select count(*) from products)as count_product, 
                                                                    (select count(*) from suppliers)as count_suppliers,
                                                                    (select count(*) from users)as count_users,
                                                                    (select count(*) from clients)as count_clients
                                                                    ');

        $this->_data['purchases'] = AbstractModel::getbySQL(
            'SELECT (SELECT COUNT(*) FROM purchases_bills )as count_purchases_bills ,
                sum(purchases_orders.order_price) as price_purchases_bills
                FROM purchases_bills
  	            JOIN purchases_orders ON purchases_orders.purchases_bill_id = purchases_bills.bill_id');

        $this->_data['purchases_receipt'] = AbstractModel::getbySQL(
            'SELECT COUNT(*) as count_purchases_receipt ,
                sum(purchases_receipt.receipt_price) as price_purchases_receipt
                FROM purchases_receipt');

        $this->_data['sales'] = AbstractModel::getbySQL(
            'SELECT (SELECT COUNT(*) FROM sales_bills ) as count_sales_bills ,
                sum(sales_orders.order_price) as price_sales_bills
                FROM sales_bills
  	            JOIN sales_orders ON sales_orders.sales_bill_id = sales_bills.bill_id');

        $this->_data['sales_receipt'] = AbstractModel::getbySQL(
            'SELECT COUNT(*) as count_sales_receipt ,
                sum(sales_receipt.receipt_price) as price_sales_receipt
                FROM sales_receipt');

        $this->view();
    }

}