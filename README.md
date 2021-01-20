## Task #1 - Only BE
Installation process (BE Only – 1 Task)

Configured Apache, MySQL and PHP

Installed with composer using MKT keys.

```
php bin/magento setup:install --admin-email cassio-almeida@live.com --admin-firstname Cassio --admin-lastname Almeida --admin-password Teste@123 --admin-user cassio --backend-frontname admin --base-url http://scandiweb.test --db-host 127.0.0.1 --db-name scandiweb --db-password secret --db-user homestead --session-save files --use-rewrites 1 --use-secure 0
```

Enabled my admin access : ``bin/magento admin:user:unlock cassio`` 

Disabled Two Factor Authentication:

``bin/magento module:disable Magento_TwoFactorAuth``

``bin/magento cache:flush``

Developed the code under ``code/Cassio`` provider folder.

Enabled that with: ``bin/magento module:enable Cassio_MetaLang``

Configured two websites: US, with one locale. And PT, with two locales, PT and ES.  

![Alt text](docs/stores.png?raw=true "Stores")


Created the CMS page about us, and attached to those stores view.

![Alt text](docs/pages.png?raw=true "Pages")

The result:

![Alt text](docs/meta-results.png?raw=true "Pages")

---

## Task #2 - BE + FE

Created and registered the module ``Cassio/ChangeColor``

Created the command class and register the ``di.xml``

Enabled the module

Created the command class ``ColorChangeCommand`` to save store config

Ran it, for example: ``bin/magento cassio:change-color FF0000 1``

Created the block that will load the store config.

Created the template that will use the block method in order to print the ``style`` tag

Ran the command: ``bin/magento cassio:change-color FF0000 1`` 

Clear the case: ``bin/magento cache:clean``

![Alt text](docs/change-color.png?raw=true "Change Color")

Then, ran the command: ``bin/magento cassio:change-color 000000 1``

Clear the case: ``bin/magento cache:clean``

![Alt text](docs/change-color-2.png?raw=true "Change Color")

---

## Task #3 - Only FE
Edited the ``vendor/magento/module-checkout/Block/Checkout/LayoutProcessor.php`` file line 101

Then added the code to remove ``company`` and ``city`` from checkout shipping layout.

```
foreach ($attributes as $attribute) {
    $code = $attribute->getAttributeCode();
    if ($attribute->getIsUserDefined() || $code == 'company' || $code == 'city') { <--- Here is where we remove company adn city from the checkout
        continue;
    }
    $elements[$code] = $this->attributeMapper->map($attribute);
    if (isset($elements[$code]['label'])) {
        $label = $elements[$code]['label'];
        $elements[$code]['label'] = __(strrev($label)); <--- Here is where we write vice versa labels
    }
}
```

The result:

![Alt text](docs/checkout-shipping.png?raw=true "Change Color")

Edited the: ``vendor/magento/module-checkout/view/frontend/web/template/shipping.html`` and added a simple ``onlick`` on the "Next" button at line 74 so the user will be redirected to ``/checkout/cart`` 


```
<div class="actions-toolbar" id="shipping-method-buttons-container">
    <div class="primary">
        <button onclick="return window.location = '/checkout/cart/';" data-role="opc-continue" type="submit" class="button action continue primary">
            <span translate="'Next'" />
        </button>
    </div>
</div>
```
