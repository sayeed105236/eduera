<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<div class="container-fluid h-100" style="margin-top: 20px; margin-bottom: 20px;">

            <div class="row justify-content-center h-100">
                <div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
                    <div class="card-header">
                         <div class="wrap">
                             
                             <?php 
                             if(isset($user_info)){
                                if($user_info[0]->profile_photo_name != '' || $user_info[0]->profile_photo_name != NULL){        
                             ?>
                                    <img id="profile-img" src="<?php echo base_url() . 'uploads/user_image/' . $user_info[0]->profile_photo_name; ?>" class="rounded-circle user_img" alt="" />
                            <?php }else{?>
                                    <img id="profile-img" src="<?php echo base_url().'uploads/user_image/placeholder.png';?>" class="rounded-circle user_img" alt="" />
                            <?php } }else{ ?>
                                 <img id="profile-img" src="<?php echo base_url().'uploads/user_image/placeholder.png';?>" class="rounded-circle user_img" alt="" />
                            <?php 
                             }
                                $name = $this->session->userdata('name');
                            if(isset($name)){?>
                            <p><?= $this->session->userdata('name')?></p>
                          <?php }else{?>
                            <p>Unknown</p>
                          <?php }?>
                      </div>
                      <br>
                        <!--<div class="input-group">-->
                        <!--    <input type="text" placeholder="Search..." name="" class="form-control search">-->
                        <!--    <div class="input-group-prepend">-->
                        <!--        <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                       <div class="unseen_messages">
                         <?php 
                            if(isset($total_unseen_message)){?>
                            <?php if($total_unseen_message > 0){?>
                             <br>
                        
                           
                           
                        <span class="messsages"><?= ($total_unseen_message < 1) ? $total_unseen_message .' unread message' : $total_unseen_message .' unread messages'  ?></span>
                        
                       
                        <?php } }?>
                         </div>
                    </div>
                  
                    <div class="card-body contacts_body">
                        <ui class="contacts" id="contacts">
                        <?php foreach($admin_list as $admin){?>    
                        <li class="active"><a href="<?= base_url('home/user_message/'.$admin->id)?>">
                            <div class="d-flex bd-highlight">
                                <div class="img_cont">
                                    
                                    <?php if ($admin->profile_photo_name === null || $admin->profile_photo_name === "") {?>
                                        <img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="rounded-circle user_img">
                                    <?php } else {?>
                                        <img src="<?php echo base_url() . 'uploads/user_image/' . $admin->profile_photo_name; ?>" alt="" class="rounded-circle user_img">
                                    <?php }?>
                               <?php if($admin->last_activity == 1){?>

                                    <span class="online_icon"></span>
                                <?php }else{?>
                                     <span class="offline"></span>
                                <?php }?>
                                </div>
                                <div class="user_info">
                                    <span><?= $admin->first_name?> <?= $admin->last_name?></span>
                                    <?php 
                                    if(isset($admin->message_count)){
                                        if($admin->message_count > 0){ ?>
                                   
                                    
                                    <span class="badge"><?=$admin->message_count ?></span>
                                    <?php }
                                    }
                                    ?>
                                    <?php

                                    if($admin->last_activity == 1){
                                    ?>
                                    <p><?= $admin->first_name?> is online</p>
                                <?php }else {?>
                                    <p><?= $admin->first_name?> is offline</p>
                                <?php }?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <?php }?>
                      
                      
                        </ui>
                    </div>
                    
                    <div class="card-footer"></div>
                </div></div>
                <div class="col-md-8 col-xl-6 " >
                    <?php if(!isset($selected_admin)){?>
                    <spna style="margin-top: 0; ">Select a user to continue your chat .</spna>
                <?php }else{?>
                    <div class="card chat">
                        <div class="card-header msg_head">
                            <div class="d-flex bd-highlight">
                                <div class="img_cont">
                                     <?php if ($selected_admin->profile_photo_name === null || $selected_admin->profile_photo_name === "") {?>
                                        <img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="rounded-circle user_img">
                                    <?php } else {?>
                                        <img src="<?php echo base_url() . 'uploads/user_image/' . $selected_admin->profile_photo_name; ?>" alt="" class="rounded-circle user_img">
                                    <?php }?>
                                    <span class="online_icon"></span>
                                </div>
                                <div class="user_info">
                                    <span>Chat with <?= $selected_admin->first_name?></span>
                                    <!--<p>1767 Messages</p>-->
                                </div>
                               <!--  <div class="video_cam">
                                    <span><i class="fas fa-video"></i></span>
                                    <span><i class="fas fa-phone"></i></span>
                                </div> -->
                            </div>
                            <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
                            <div class="action_menu">
                                <ul>
                                    <li><i class="fas fa-user-circle"></i> View profile</li>
                                    <li><i class="fas fa-users"></i> Add to close friends</li>
                                    <li><i class="fas fa-plus"></i> Add to group</li>
                                    <li><i class="fas fa-ban"></i> Block</li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body msg_card_body" id="msg_card_body">
                            <?php 
                            if(isset($user_messages)){
                            foreach($user_messages as $user_message){
                                    if($user_message->chat_messages_status == 0){
                                ?>
                                
                            <div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                      <?php 
                                     if(isset($user_info)){
                                         if($user_info[0]->profile_photo_name != '' || $user_info[0]->profile_photo_name != NULL){
                                     ?>
                                            <img src="<?php echo base_url() . 'uploads/user_image/' . $user_info[0]->profile_photo_name; ?>" alt="" class="rounded-circle user_img_msg">
                                       <?php 
                                         }else{
                                       ?>
                                             <img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="rounded-circle user_img_msg">
                                    <?php
                                         }
                                     }else{?>
                                         <img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="rounded-circle user_img_msg">
                                    <?php
                                     }
                                   ?>
                                </div>
                                <div class="msg_cotainer">
                                    <?= $user_message->chat_messages_text?>
                                    <span class="msg_time"><?= date('D M Y H:i', strtotime($user_message->chat_messages_datetime))?></span>
                                </div>
                            </div>

                            <?php } else{ ?>
                            <div class="d-flex justify-content-end mb-4">
                                 
                                <div class="msg_cotainer_send">
                                    <?= $user_message->chat_messages_text?>
                                    <span class="msg_time_send"><?= date('D M Y H:i', strtotime($user_message->chat_messages_datetime))?></span>
                                </div>
                                <div class="img_cont_msg">
                                    
                        
                                    <?php if ($selected_admin->profile_photo_name === null || $selected_admin->profile_photo_name === "") {?>
                                        <img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="rounded-circle user_img_msg">
                                    <?php } else {?>
                                        <img src="<?php echo base_url() . 'uploads/user_image/' . $selected_admin->profile_photo_name; ?>" alt="" class="rounded-circle user_img_msg">
                                    <?php }?>
                                        
                                <!--<img src="" class="rounded-circle user_img_msg" alt="">-->
                                </div>
                            </div>
                          <?php  
                         }
                     }
                      } ?>
                        </div>
                        <div class="card-footer">
                                <form>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                                    </div>
                                    <textarea name="user_message" class="form-control type_msg" placeholder="Type your message..." required="" id="chat_message_area"></textarea>

                                    <div class="input-group-append">
                                        <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                                        <!-- <input type="submit" name="submit" value="Send"> -->
                                    </div>
                                </div>
                            </form>    
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>

<script type="text/javascript">
$(document).ready(function(){
    $('#action_menu_btn').click(function(){
        $('.action_menu').toggle();
    });
});
var messageBody = document.querySelector('#msg_card_body');
messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;

$('.send_btn').click(function(){
    message = $(".type_msg").val();
    time = '<?=date('D M Y H:i', strtotime(date('Y-m-d H:i:s'))) ?>';
    if(message == ''){
        alert('Please type message first.')
    }else{
         admin_id = '<?= isset($selected_admin) ? $selected_admin->id : ''?>';
         $("#chat_message_area").val('');
        $.ajax({
            url: '<?=base_url('/rest/api/insertUserMessage')?>',
            type: 'POST',
            data: {message:message, admin_id: admin_id},
            success:function(response){
                console.log(response);
               user_info = JSON.parse("[" + response + "]");
               
             
                var html = '<div class="d-flex justify-content-start mb-4">';
                html += '<div class="img_cont_msg">';
                if(user_info[0] != null){
                      if (user_info[0].data === undefined || user_info[0].data.length == 0) {
                    
                    // array empty or does not exist
                     html += '<img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="rounded-circle user_img_msg">';
                   
                }else{
                     if(user_info[0].data[0].profile_photo_name != ''){
                        html += '<img src="<?php echo base_url() . 'uploads/user_image/' ?>'+user_info[0].data[0].profile_photo_name+'" class="rounded-circle user_img_msg">';
                  
                    }else{
                         html += '<img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="rounded-circle user_img_msg">';
                    }
                }

              
                }else{
                    html += '<img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="rounded-circle user_img_msg">';
                }
              
               
                
                html += '</div> <div class="msg_cotainer">';
                html += message;
                html +='<span class="msg_time">'+time+'</span>';
                html += '</div> </div>';

                $("#msg_card_body").append(html);

                var messageBody = document.querySelector('#msg_card_body');
                messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
            }
        })
    }
})
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://js.pusher.com/6.0/pusher.min.js"></script>

<script type="text/javascript">
    // Enable pusher logging - don't include this in production
   Pusher.logToConsole = true;

    var pusher = new Pusher('46cd25c3a10b34a7f996', {
      cluster: 'mt1'
    });


    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      // alert(JSON.stringify(data));
    //   console.log(data.receiver_id);
    
    //  var aSound = document.createElement('audio');
    // aSound.setAttribute('src', 'https://www.file.server.eduera.com.bd/user_message.mp3');
    // aSound.play();

     
      /*user unseen message count*/
        $.ajax({
          url: '<?=base_url('/rest/api/get_user_unseen_message/')?>'+data.sender_id,
          type: 'GET',
        //   datatype: 'json',
          success:function(response){
              data = JSON.parse(response);
            //   console.log(data);
                var html = '<ul class="contacts" id="contacts">';
                $("#contacts").remove();
                
                for(var i=0; i < data[0].length; i++){
                    // console.log(data[0][i].message_count);
                    html += '<li class="active"><a href="<?= base_url('home/user_message/')?>'+data[0][i].id+'">';
                    html += '<div class="d-flex bd-highlight">';
                    html += '<div class="img_cont">';
                    
                       if (data[0][i].profile_photo_name ==  "") {
                          html += '<img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt=""  class="rounded-circle user_img">';
                       }else{
                          html += '<img src="<?php echo base_url() . 'uploads/user_image/' ?>'+data[0][i].profile_photo_name+'" alt=""  class="rounded-circle user_img">'

                       }
                        
                    // html += '<img src="https://www.khaama.com/wp-content/uploads/2019/02/Afghan-Singer-Ghawgha-Taban-880x672-880x672.jpg" class="rounded-circle user_img">';
                    html += ' <span class="online_icon"></span>';
                    html += '</div>';
                    html += '<div class="user_info"><span>';
                    html += data[0][i].first_name + ' ' + data[0][i].last_name;
                   
                    if(data[0][i].message_count > 0){
                        html += '<span class="badge">';
                        html += data[0][i].message_count;
                        html += '</span>';
                    }else{
                          html += '<span class="badge"></span>';
                    }
                    
                    html += '<p>'+data[0][i].first_name+' is online</p>';
                    html += '</div></div></a></li>';
                }
                $(".contacts_body").append(html);
                
                /* total unseen message count*/
                $(".messsages").remove();
                var html1 = '<span class="messsages" style="text-align:center;  color:white; padding:10px">';
                 html1 += data[1];
                if(data[1].length <1){
                    html1 += 'unread message';
                }else{
                      html1 += ' unread messages';
                }
               html1 += '</span>';
              
                $('.unseen_messages').append(html1);
               



          }
      });
      
      
       $.ajax({
          url: '<?=base_url('/rest/api/get_user_chat_messages/')?>'+data.receiver_id+'/'+data.sender_id,
          type: 'GET',
          datatype: 'json',
          success:function(response){
              responseData = JSON.parse(response);
                // console.log(responseData);
                
                var selected_admin = '<?= isset($selected_admin) ? json_encode($selected_admin) : "" ?>';
                if(selected_admin != ''){
                     admin_info  = JSON.parse("[" + selected_admin + "]");
                     
                     if(admin_info[0].id == responseData.admin[0].id){
                         
                     var html = '<div class="d-flex justify-content-end mb-4"> <div class="msg_cotainer_send">';
                     html += responseData.messages[0].chat_messages_text;
                    
                     html += '<span class="msg_time_send">'+responseData.messages[0].chat_messages_datetime+'</span></div>';
                     html += ' <div class="img_cont_msg">';
                        
                      if(responseData.admin[0].profile_photo_name != '' ){
                          html += '<img src="<?= base_url() . 'uploads/user_image/' ?>'+responseData.admin[0].profile_photo_name+'" class="rounded-circle user_img_msg">';
                      }else{
                            html += '<img src="<?= base_url() . 'uploads/user_image/placeholder.png' ?>" class="rounded-circle user_img_msg">';
                      }
                        html += '</div></div>';
                      $("#msg_card_body").append(html);
        
                        var messageBody = document.querySelector('#msg_card_body');
                        messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
                             }
                        }
                   

          }
      });
     
   
      
    });
</script>