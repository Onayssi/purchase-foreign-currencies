# purchase-foreign-currencies
A web application that allow a user to purchase foreign currencies, using Yii Framework.
# Synopsis:
The app display the available currencies for selection by the user and has inputs where that user can enter the amount of foreign currency they wish to purchase or the amount of ZAR currency they wish to pay.
Once the user has entered either amount and selected the foreign currency the necessary calculation needs to be done that will display the amount they need to pay in ZAR.
The user can select to "purchase" the foreign currency, an "order" for the currency must be saved to the database and the user must be shown a confirmation.
# Pre-requisites
- Apache Server, online host or local (XAMPP / WAMP / MAMP / LAMP)
- PHP Version 5.4.X or greater
- MySQL Database Driver
- Composer (Dependency Manager for PHP) to manage dependencies in case of need (https://getcomposer.org/doc/00-intro.md)
- The Yii debug mode is enable (development environment), that can be modified from the parameters configuration tools. 

# Details of Process
The currency used for payment with be South African Rands (ZAR).

**The currencies that can be purchased are:** 
- US Dollars (USD)
- British Pound (GBP)
- Euro (EUR)
- Kenyan Shilling (KES)

**The Default exchange rates are:**
- ZAR to USD: 0.0808279
- ZAR to GBP: 0.0527032
- ZAR to EUR: 0.0718710
- ZAR to KES: 7.81498

**A surcharge must be added to orders and differs for the foreign currencies as below:**
- USD: 7.5%
- GBP: 5%
- EUR: 5%
- KES: 2.5%

**Each operation concerning the order is saved with information below:**
- Foreign currency purchased
- Exchange rate for foreign currency
- Surcharge percentage
- Amount of foreign currency purchased
- Amount to be paid in ZAR
- Amount of surcharge
- Date created

**When an order is saved the following extra actions are set for the different foreign currencies:**
- USD: No action
- GBP: Send an email with order details. This can be a basic text or html email to any configurable email address
- EUR: Apply a 2% discount on the total order amount, the configuration is set for the currency and be saved separately on an order. This is not be included in the initial currency calculation
- KES: No action.

# Code Example
Using a foreign exchange API to get exchange rates, the default values of the exchange rates would be updating in the database for each currency.The updating of exchange rates only needs to happen periodically in the real world, thus the update should be triggered via a URL when an internet connection is availabale for each calculation.

# API Reference

You can use jsonrates API (http://jsonrates.com/docs/) to retrieve the rates. Register for a free API key. Any Other API would be fine (e.g: Yahoo Finance API). Suggestion: use an API from Google Finance.<br>
**Important**: The jsonrates documentation has been deprecated and is no longer valid. For detailed reference about API integration, usage guides and language examples please visit: https://currencylayer.com/documentation

#Installation
Download the source package as a zip format, extract the web files and put all into the server root, change the configuration of the database (host credentials and database name) from the configuration script (application/config/db), use the sql file included (pfcurrencies.sql) to create the database using MySQL command tools or phpmyadmin interface  and set the server root to be pointed to the app main page (application/web).
The SMTP authentication configuration must be configured in order ro send an email notification concerning an order set, providing an admin email, host, username, password and port, that can be configured from the params configuration script (application/config/params). It's included also, the API Key used for the currencies conversion from 'jsonrates' API.

```
  'adminEmail' => 'info@pfc.co.za', // admin email address (signature of sending mail from)
  'jsonratesAPIKey' => 'jr-2238edff7800ed83551aef03952fe791', // api key (deprecated)
  'smtp_hostname' => 'mail.domain.ext', // smtp host name
  'smtp_username' => 'user@domain.ext', // smtp username
  'smtp_password' => 'XXXXXX', // smtp password
  'smtp_port' => '26', // smtp port [25 or 26]
```

#Copyright
Copyright (c) 2010 - 2016 Mouhamad Ounayssi.<br>
Blog: https://www.mouhamadounayssi.wordpress.com.
