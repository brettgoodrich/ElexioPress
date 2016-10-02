ElexioPress 0.1

## Usage
Heh. Documentation to be updated. Usage is only available through direct function calls at present moment, but backend is in the plan.

#### WordPress backend
ElexioPress' settings page is parented to "Settings". You'll need to set your API keys from there.

#### Supported Functions
```
elexiopress_FindPersonByName('name')
elexiopress_GetPerson('personID')
elexiopress_FindEventsByDate('startDate', 'endDate', 'musthaveTag', 'forbiddenTag1', 'forbiddenTag2')
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
