# LiteralNumbers for Laravel
This package changes numeric amounts to literal representative and supports multilingual apps.

Designed for Polish grammar but can work with others.
## Usage

```php
$ln = LiteralNumbers::getInstance(App::getLocale());
echo $ln->toLiteral(4558);
```
Outputs:
``
Four thousand five hundred fifty eight
``
## Currencies
If you want to add literal currency use `setCurrency()` and `currency(true)`:
```php
$ln->setCurrency('usd')->currency(true);
echo $ln->toLiteral(14);
```
Outputs:
``
Fourteen United States dollars
``
