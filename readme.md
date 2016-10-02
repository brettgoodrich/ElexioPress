ElexioPress 0.1

Advanced documentation is online at https://www.elexioamp.com/Services/Database/API.asmx.

## Usage
Usage is only available through direct function calls at present moment, but backend is in the plan.

Functions currently return the body of a SimpleXMLElement with relevant data, straight from Elexio's API.
Accessing data from a SimpleXMLElement is detailed here: http://php.net/manual/en/simplexml.examples-basic.php

#### WordPress backend
ElexioPress' settings page is parented to "Settings". You'll need to set your API keys from there. Access is restricted to users with 'unfiltered_html' permission.

#### Supported Functions
```
elexiopress_FindPersonByName('nameToSearch')
elexiopress_FindHouseholdByName('emailToSearch') // Note that Elexio's API searches for an email match, not a name match.
elexiopress_GetPerson('personID')
elexiopress_GetSmallGroups
elexiopress_FindEventsByDate('startDate', 'endDate', 'musthaveTag', 'forbiddenTag1', 'forbiddenTag2')
elexiopress_LookupCodes(numericCode)
```
