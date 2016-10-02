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
Advanced documentation is online at https://www.elexioamp.com/Services/Database/API.asmx.
