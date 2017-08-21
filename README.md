# Notifications
Mini Project about Notifications: MySQL, PHP, JS

```html
<script type='text/javascript'>
    $(document).ready(function(e){
      var notification=new Notification();
      notification.execute();
    });
</script>
```


# Table user
| Type | Name |
| ------ | ----------- |
|integer|iduser|


# Table notification
| Type | Name |
| ------ | ----------- |
|integer|idnotification|
|datetime|date|
|varchar|title|
|longtext|message|
|varchar|url|
|enum('Y','N')|readed|
|integer|user_id|

*Note: This Project is still under development.*
