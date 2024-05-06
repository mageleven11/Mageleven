## Documentation

- Installation guide: https://www.mageleven.com/install-magento-2-extension/#solution-1-ready-to-paste
- User Guide: https://docs.mageleven.com/better-popup/
- Product page: https://www.mageleven.com/magento-2-better-popup/
- FAQs: https://www.mageleven.com/faqs/
- Get Support: https://www.mageleven.com/contact.html or support@mageleven.com
- Changelog: https://www.mageleven.com/releases/better-popup/
- License agreement: https://www.mageleven.com/LICENSE.txt


## How to install

Install ready-to-paste package (Recommended)

- Installation guide: https://www.mageleven.com/install-magento-2-extension/#solution-1-ready-to-paste


## How to upgrade

1. Backup
Backup your Magento code, database before upgrading.
2. Remove BetterPopup folder 
In case of customization, you should backup the customized files and modify in newer version. 
Now you remove `app/code/Mageleven/BetterPopup` folder. In this step, you can copy override BetterPopup folder but this may cause of compilation issue. That why you should remove it.
3. Upload new version
Upload this package to Magento root directory
4. Run command line:

```
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```



## FAQs


#### Q: I got error: `Mageleven_Core has been already defined`
A: Read solution: https://github.com/mageleven/module-core/issues/3

#### Q: My site is down
A: Please follow this guide: https://www.mageleven.com/blog/magento-site-down.html



## Support

- FAQs: https://www.mageleven.com/faqs/
- https://mageleven.freshdesk.com/
- support@mageleven.com