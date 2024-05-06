## 1. Documentation

- User Guide Standard Edition: https://docs.mageleven.com/social-login-m2/index.html
- User Guide Pro Edition: https://docs.mageleven.com/social-login-pro/index.html
- On Mageleven: https://www.mageleven.com/magento-2-social-login-extension/
- Get Support: https://github.com/mageleven/magento-2-social-login/issues
- Contribute on Github: https://github.com/mageleven/magento-2-social-login/
- Changelog: https://www.mageleven.com/releases/social-login
- Report a security issue to security@mageleven.com

## 2. How to install

### ✓ Install via composer (recommend)

Run the following command in Magento 2 root folder:

```
composer require mageleven/magento-2-social-login
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

Run compile if your store in Product mode:

```
php bin/magento setup:di:compile
```


## 3. FAQs

#### Q: When I click on Login link, the popup does't work
A: You can read https://github.com/mageleven/magento-2-social-login/issues/39

#### Q: I am using custom theme, it is compatible with our design?
A: We have developed Social Login based on Magento coding standard and best practice test on Magento Community and Magento Enterpise site. So it is compatible with themes and custom designs. Ask Magento community on http://magento.stackexchange.com/ or https://github.com/mageleven/magento-2-social-login/issues/

#### Q: Can I install it by myself?
A: Yes, you absolutely can! You can install it like installing any extensions to website, follow our Installation Guide http://docs.mageleven.com/kb/installation.html. User guide: https://docs.mageleven.com/social-login-m2/index.html

#### Q: I got this message `Erro: invalid_scope`
A: Read this https://github.com/mageleven/magento-2-social-login/issues/42

#### Q: I got error: `Mageleven_Core has been already defined`
A: Read solution: https://github.com/mageleven/module-core/issues/3

#### Q: My site is down
A: Please follow this guide: https://www.mageleven.com/blog/magento-site-down.html
