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

Then create a writer based on a layout and fields:

```php
<?php

use WideFocus\Feed\CsvWriter\CsvWriterLayout;
use WideFocus\Feed\Writer\WriterField\WriterField;

$layout = new CsvWriterLayout();
$layout->setDestination('local://my-feed.csv')
    ->setIncludeHeader(true);

$fields = [
    new WriterField('foo', 'Foo'),
    new WriterField('bar', 'Bar', 'strtoupper')
];

$writer = $writerFactory->createWriter($fields, $layout);
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