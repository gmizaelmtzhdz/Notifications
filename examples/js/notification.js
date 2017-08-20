function Notification()
{
  var block=1;
  var segment=3;
  /**
  * Function to execute Notifications
  * @method execute
  * @return {void}
  */
  this.execute=function()
  {
    event();
    getNotification();
  }
  /**
  * set Segment
  * @method setSegment
  * @param {int} segment_
  * @return {void}
  */
  this.setSegment=function(segment_)
  {
    segment=segment_;
  }
  /**
  * Listener evenets
  * @method event
  * @return {void}
  */
  var event=function()
  {
    $("#view_more").off();

    $("#view_more").click(function(e){
      block++;
      getNotification();
    });
  }
  /**
  * Get Notifications
  * @method getNotification
  * @return {void}
  */
  var getNotification=function()
  {
    $.ajax({
      method:"POST",
      url: "../src/Notification.php",
      data:{action:"read",block:block,segment:segment}
    }).done(function(data)
    {
      data=JSON.parse(data);
      console.log(data);
      process_notification(data);
    });
  }
  /**
  * Get Notifications
  * @method process_notification
  * @param {array} data
  * @return {void}
  */
  var process_notification=function(data)
  {
    if(data==null)
    {
      $("#container_notification_items").html("Without message :(");
    }
    else
    {
      fill_notification_container(data);
    }
  }
  /**
  * Get Notifications
  * @method fill_notification_container
  * @param {array} data
  * @return {void}
  */
  var fill_notification_container=function(data)
  {
    var string='';
    for(var i=0;i<data.length;i++)
    {
      string=string+'<div class="notification">';
        string=string+'<div class="notification_content_icon">';
          string=string+'<div class="notification_icon"></div>';
        string=string+'</div>';
        string=string+'<a href="'+data[i]["url"]+'" class="notification_url">';
          string=string+'<div class="notification_title">'+data[i]["title"]+'</div>';
          string=string+'<div class="notification_message">'+data[i]["message"]+'</div>';
        string=string+'<a>';
      string=string+'</div>';
    }
    $("#container_notification_items").append(string);
    event();
  }
}
