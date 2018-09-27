# Buto-Plugin-AccountPasswordverify_v1
Ask user for password in critical situations.



This show how it should be used in your application. Do not forget to check server side method validateTime() if user is verified.

## Settings
Seconds how long time successfull verifying is active.
```
plugin_modules:
  passwordverify:
    plugin: 'account/passwordverify_v1'
    settings:
      mysql: "Settings according to PluginWfMysql..."
      seconds: 10
```


## Widget
Should be included in document head section.
```
type: widget
data:
  plugin: account/passwordverify_v1
  method: include
```
## HTML
```
<a onclick="PluginAccountPasswordverify_v1.verify(demo_function, {id: '1234'})" href="#!">Test</a>
```
## Javascript
```
<script>function demo_function(params){console.log(params);}</script>
```
## PHP
Use this to check server side if user is verified.
```
wfPlugin::includeonce('account/passwordverify_v1');
$account = new PluginAccountPasswordverify_v1();
var_dump($account->validateTime());
```
