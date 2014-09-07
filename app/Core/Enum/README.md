# Enum

Attempts to provide basic Enum functionality in PHP using class constants.

## Example
Below we define the BugStatus enum:


```
<?php

namespace Acme;

use Portico\Core\Enum\Base;

class BugStatus extends Base
{
    const OPEN = 1;
    const CLOSED = 2;
    const IN_PROGRESS = 3;

    public static function readable()
    {
        return [
                self::OPEN => 'Open',
                self::CLOSED => 'closed',
                self::IN_PROGRESS => 'In Progress',
            ];
    }
}
```

## Laravel Bridge

[Laravel Validator](https://github.com/illuminate/validation/tree/4.2) defines the validation rule `in` as *The field
under validation must be included in the given list of values.* In the case of `'baz' => 'in:foo,bar'`, the value of
baz must either be foo or bar. The bridge provides an easy means to generate this validation rule.

```
$rules = [
    'title' => ['required'],
    'due_date' => ['after:' . date('Y-m-d'), 'date_format:Y-m-d'],
    'status' => ['required', (new LaravelValidatorBridge(BugStatus::readable())->getRule()]
];

```