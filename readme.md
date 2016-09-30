ElexioPress 0.1

## Usage

#### WordPress backend
The alert's settings are given their own page parented to "Posts". You can easily edit the title, description, and enable/disable the alert.

#### Code
You can access the plugin's settings with `hcs_alert()`, which will `return` an array like so:
```
Array
(
    [alert_title] => Snow Day
    [alert_desc] => There will be an epic snow day on April 24, 2016, due to El Nino.
    [alert_enbl] => 1
)
```
- **alert_title** and **alert_desc** are simple strings.
- **alert_enbl** will be 1 if the alert is enabled and will not be in the array at all if it is disabled.
