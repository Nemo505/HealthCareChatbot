<div class="chat">
  <div class="chat-title">
    <h1>Fabio Ottaviani</h1>
    <h2>Supah</h2>
    <figure class="avatar">
      <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" />
    </figure>
  </div>
  <div class="messages">
    <div class="messages-content"></div>
  </div>
  <div class="message-box">
    <textarea type="text" class="message-input" placeholder="Type message..."></textarea>
    <button type="submit" class="message-submit">Send</button>
  </div>
</div>
<div class="bg"></div>

<script>
  var $messages = $('.messages-content');
  var userAskedQuestion = false; // Flag to track whether the user has asked a question

  $(window).load(function() {
    $messages.mCustomScrollbar();
    // Initially, fetch only the initial message
    fetchMessages();
  });

  function updateScrollbar() {
    $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
      scrollInertia: 10,
      timeout: 0
    });
  }

  function insertMessage(message, isUser = false) {
    // Determine the class based on whether the message is from the user or chatbot
    if (isUser) {
     $('<div class="message message-personal">' + message + '</div>').appendTo($('.mCSB_container')).addClass('new')
    }else{

      if (message.button) {
        $('<div class="message new"><figure class="avatar"><img src="' + message.avatar + '" /></figure>' +
        '<div class="message-content">' + message.content + '</div>' +
        '<span class="custom-badge cursor-pointer" onclick="handleBadgeClick(\'General Information\')">General Information</span>' +
        '<span class="custom-badge cursor-pointer" onclick="handleBadgeClick(\'Symptom\')">Symptom</span>' +
        '<span class="custom-badge cursor-pointer" onclick="handleBadgeClick(\'Treatment\')">Treatment</span>' +
        '</div>').appendTo($('.mCSB_container')).addClass('new');
      }else {
        $('<div class="message new"><figure class="avatar"><img src="' + message.avatar + '" /></figure><div class="message-content">' + message.content + '</div></div>').appendTo($('.mCSB_container')).addClass('new')
      }
    }

    updateScrollbar();
  }

  function handleBadgeClick(category) {

      insertMessage(category, true);
        if (category === 'General Information') {
          insertMessage({
          avatar: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg',
          content: 'What specific information are you looking for?'
          });

        } else if (category === 'Symptom') {
          insertMessage({
            avatar: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg',
            content: 'Tell me more about the symptoms you are experiencing.'
          });
        } else if (category === 'Treatment') {
          insertMessage({
            avatar: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg',
            content: 'Are you interested in treatment options? If so, for what condition?'
          });
        } else {
          insertMessage({
            avatar: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg',
            content: "I'm sorry, I didn't understand that category."
          });
        }
      console.log(category);
    sendMessageToServer(category);
  }


  function fetchMessages() {
    if (!userAskedQuestion) {
      insertMessage({
        avatar: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg',
        content: 'How can I help you?',
        button: true,
      });
    }
  }

  
  function sendMessageToServer(category) {
    $('.message-submit').click(function() {
      var newUserMessage = $('.message-input').val();

      if ($.trim(newUserMessage) !== '') {
        insertMessage(newUserMessage, true); 
        $.ajax({
          type: 'POST',
          url: '/chatbot/addMessages', // Update the URL to your CakePHP endpoint for adding messages
          data: { content: newUserMessage, category: category },
          success: function(response) {
            if (response) {
              var parsedResponse = JSON.parse(response);
              var chatbotMessage = parsedResponse.chatbotMessage;

              if (category === 'General Information') {
                insertMessage({
                   avatar: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg',
                   content: chatbotMessage.content
                 });
                
              } else if (category === 'Symptom') {
                insertMessage({
                   avatar: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg',
                   content: chatbotMessage.description
                 });
              } else if (category === 'Treatment'){
                insertMessage({
                   avatar: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg',
                   content: chatbotMessage.description
                 });
              }
            }
          },
          error: function(error) {
            console.error('Error adding message:', error);
          }
        });
      }
    });
  }

  $(window).on('keydown', function(e) {
    if (e.which === 13) {
      // Handle pressing Enter to send messages
      $('.message-submit').click();
      return false;
    }
  });
</script>
