# WideFocus Feed Csv Writer

This package contains models to write a CSV feed.

## Installation

Use composer to install the package.

```shell
$ composer require widefocus/feed-csv-writer
```

## Usage

First create a writer factory:

```php
<?php

use WideFocus\Feed\CsvWriter\CsvWriterFactory;
use WideFocus\Feed\CsvWriter\LeagueCsv\LeagueCsvWriterFactory;
use League\Flysystem\MountManager;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

$mountManager = new MountManager(
    ['local' => new Filesystem(new Local('/tmp'))]
);

$writerFactory = new CsvWriterFactory(
    new LeagueCsvWriterFactory(),
    $mountManager
);
```

Then create a writer based on parameters and fields:

```php
<?php

use WideFocus\Feed\CsvWriter\CsvWriterParameters;
use WideFocus\Feed\Writer\Field\WriterField;

$parameters = new CsvWriterParameters([
    'destination' => 'local://my-feed.csv',
    'include_header' => true
]);

$writer = $writerFactory->createWriter($parameters);
$writer->setFields([
    new WriterField('foo', 'Foo'),
    new WriterField('bar', 'Bar', 'strtoupper')
]);
```

Then write the feed:

```php
<?php

use ArrayIterator;
use ArrayObject;

$items = new ArrayIterator(
    [
        new ArrayObject(['foo' => 'FooValue', 'bar' => 'BarValue']),
        new ArrayObject(['foo' => 'AnotherFooValue', 'bar' => 'AnotherBarValue'])
    ]
);

$writer->write($items);
```

This would result in a file /tmp/my-feed.csv with the following contents:

```text
Foo,Bar
FooValue,BARVALUE
AnotherFooValue,ANOTHERBARVALUE
```