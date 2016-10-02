ElexioPress 0.1

## Usage
There's a good number of functions. I'll update this readme at some point.

#### WordPress backend
ElexioPress' settings are given their own page parented to "Settings". You can easily edit key information.

#### Supported Functions
```
elexiopress_FindPersonByName('name')
elexiopress_GetPerson('personID')
elexiopress_FindEventsByDate('startDate', 'endDate', 'reqTag', 'forbiddenTag1', 'forbiddenTag2')
elexiopress_LookupCodes(numericCode)
```

You can access the plugin's settings with `elexiopress()`, which will `return` an array like so:
```
Array
(
    [elexiopress_keys_activationkey] => the activation key
    [elexiopress_keys_apipass] => the apipass
)
```
