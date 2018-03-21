**DEPRECATED** use https://github.com/BulkGate/sms

Nette SMS
==============================

```php
    /** @var Nette\Sms\ISender @inject */
    public $sms_sender;


    $this->sms_sender->unicode()->send(new Nette\Sms\BulkMessage([
        new Nette\Sms\Message("420777444555", "text"),
        new Nette\Sms\Message("777444556", "text", Nette\Sms\Country::CZECH_REPUBLIC),
        new Nette\Sms\Message("420777444557", "text", Nette\Sms\Country::CZECH_REPUBLIC),
    ]));
    
    $this->sms_sender->send(new Nette\Sms\Message("420888555222", "test"));
```
==============================
