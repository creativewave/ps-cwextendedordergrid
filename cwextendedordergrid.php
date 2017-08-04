<?php

class CWExtendedOrderGrid extends Module
{
    /**
     * Registered hooks.
     *
     * @var array
     */
    const HOOKS = [
        'actionAdminOrdersListingFieldsModifier',
        'actionAdminOrdersListingResultsModifier',
    ];

    /**
     * @see ModuleCore
     */
    public $name    = 'cwextendedordergrid';
    public $tab     = 'administration';
    public $version = '1.0.0';
    public $author  = 'Creative Wave';
    public $need_instance = 0;
    public $ps_versions_compliancy = [
        'min' => '1.6',
        'max' => '1.6.99.99',
    ];

    /**
     * Initialize module.
     */
    public function __construct()
    {
        parent::__construct();

        $this->displayName      = $this->l('Extended Order Grid');
        $this->description      = $this->l('Display extended order data in orders grid.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    /**
     * Install module.
     */
    public function install(): bool
    {
        return parent::install() and $this->registerHooks(static::HOOKS);
    }

    /**
     * Append custom fields.
     *
     * @todo Append additional fields based from user configuration.
     */
    public function hookActionAdminOrdersListingFieldsModifier(array $params)
    {
        $params['fields'] += [
            'invoice_number' => [
                'title'  => $this->l('Invoice number'),
                'search' => false,
            ],
        ];
    }

    /**
     * Set additional order data.
     *
     * @todo Handle order with multiple invoices.
     * @todo Set additional data based from user configuration.
     */
    public function hookActionAdminOrdersListingResultsModifier(array $params)
    {
        foreach ($params['list'] as &$order) {
            $id_order_invoice = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue(
                (new DbQuery())
                    ->select('id_order_invoice')
                    ->from('order_invoice')
                    ->where('id_order = '.$order['id_order'])
            );
            if (!$id_order_invoice) {
                $order['invoice_number'] = '--';
                continue;
            }
            $order_invoice = new OrderInvoice($id_order_invoice);
            $order['invoice_number'] = $order_invoice->getInvoiceNumberFormatted(
                $this->context->language->id,
                $this->context->shop->id
            );
        }
    }

    /**
     * Add hooks.
     */
    protected function registerHooks(array $hooks): bool
    {
        return array_product(array_map([$this, 'registerHook'], $hooks));
    }
}
