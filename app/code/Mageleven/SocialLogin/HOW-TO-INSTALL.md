# How to install Social Login for Magento 2

There are 2 different solutions to install Mageleven extensions:

- Solution #1. Install via Composer (Recommend)
- Solution #2: Ready to paste (Not recommend)

## Important:
- We recommend you to duplicate your live store on a staging/test site and try installation on it in advanced.
- Back up Magento files and the store database.
- This extension requires [Mageleven_Core](https://github.com/mageleven/module-core) to be installed first.

You will get an error, if **Mageleven_Core** is not installed.

## Solution #1. Install via Composer (Recommend)

Run the following command in Magento 2 root folder:

```
composer require mageleven/magento-2-social-login-extension
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## Solution #2: Ready to paste (Not recommend)

Please make sure that you've [installed Mageleven_Core module](https://github.com/mageleven/module-core#how-to-install--upgrade-mageleven_core) already.

If you don't want to install via composer, you can use this way. 

- Download [the latest version here](https://github.com/mageleven/magento-2-social-login/archive/master.zip) 
- Extract `master.zip` file to `app/code/Mageleven/SocialLogin`; You should create a folder path `app/code/Mageleven/SocialLogin` if not exist.
- Go to Magento root folder and run upgrade command line to install `Mageleven_SocialLogin`:

```
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## FAQs

Q: I got this error message: 
```
Fatal error: Uncaught Error: Call to undefined method Mageleven\\SocialLogin\\Helper\\Data::isEnabled()
```
A: Your store installed Mageleven Core old version, please [upgrade it](https://github.com/mageleven/module-core#12-upgrade).

Q: I got an error message:

```
Mageleven_Core has been already defined
```
A: Mageleven Core need to be installed, [learn more](ttps://github.com/mageleven/module-core#how-to-install--upgrade-mageleven_core).


Q: Install Core Module.

A: Our Core module is updated frequently so make sure that you are using [the latest version](https://github.com/mageleven/module-core) of it.


Other messages that indicate missing Core module are: 

```
- Mageleven\Core\Helper\AbstractData does not exist.
- Class Mageleven\<extension_name>\Helper\Data does not exist.
- Specified invalid parent id (Mageleven_Core::menu)
- Call to undefined method Mageleven\\PdfInvoice\\Helper\\Config::jsonEncode
```
