<div class="chat">
  <div class="chat-title">
    <h1>Fabio Ottaviani</h1>
    <h2>Chyu</h2>
    <figure class="avatar" data-avatar="<?= $this->Url->image('../uploads/avatars/' . $user->avatar, ['fullBase' => true]) ?>">
        <img src="<?= $this->Url->image('../uploads/avatars/' . $user->avatar, ['fullBase' => true]) ?>" alt="Avatar" class="w-16 h-16 rounded-full">
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
  var userAskedQuestion = false; 
  var currentCategory = null;
  var avatarUrl = document.querySelector('.avatar').getAttribute('data-avatar');

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
        '<div class="message-content">You can type "End" to end the process.</div>' +
        '</div>').appendTo($('.mCSB_container')).addClass('new');
      }else {
        $('<div class="message new"><figure class="avatar"><img src="' + message.avatar + '" /></figure><div class="message-content">' + message.content + '</div></div>').appendTo($('.mCSB_container')).addClass('new')
      }
    }

    updateScrollbar();
  }

  function handleBadgeClick(category) {
      currentCategory = category;
      insertMessage(category, true);
        if (category === 'General Information') {
          insertMessage({
          avatar: avatarUrl,
          content: 'What specific information are you looking for?'
          });

        } else if (category === 'Symptom') {
          insertMessage({
            avatar: avatarUrl,
            content: 'Tell me more about the symptoms you are experiencing.'
          });
        } else if (category === 'Treatment') {
          insertMessage({
            avatar: avatarUrl,
            content: 'Are you interested in treatment options? If so, for what condition?'
          });
        } else {
          insertMessage({
            avatar: avatarUrl,
            content: "I'm sorry, I didn't understand that category."
          });
        }
      
  }

  function fetchMessages() {
    if (!userAskedQuestion) {
      insertMessage({
        avatar: avatarUrl,
        content: 'How can I help you?',
        button: true,
      });
    }
  }

  
  $('.message-submit').click(function() {
    var newUserMessage = $('.message-input').val();
    if ($.trim(newUserMessage) !== '' && currentCategory) {
      insertMessage(newUserMessage, true); 

      // Clear the input message in the input box
      $('.message-input').val('');

      //check the word
      if (newUserMessage.toLowerCase() === 'end') {
          userAskedQuestion = false;
          currentCategory = null;
          fetchMessages(); // Restart the conversation
      }else {

        $.ajax({
          type: 'POST',
          url: '/chatbot/addMessages', // Update the URL to your CakePHP endpoint for adding messages
          data: { content: newUserMessage, category: currentCategory },
          success: function(response) {
            
            if (response) {
              var parsedResponse = JSON.parse(response);
              if (parsedResponse.chatbotMessage) {
                
                var chatbotMessage = parsedResponse.chatbotMessage;
                
                if (currentCategory === 'General Information') {
                  insertMessage({
                      avatar: avatarUrl,
                      content: chatbotMessage.content
                    });
                  
                } else if (currentCategory === 'Symptom') {
                  insertMessage({
                      avatar: avatarUrl,
                      content: chatbotMessage.description
                    });
                } else if (currentCategory === 'Treatment'){
                  insertMessage({
                      avatar: avatarUrl,
                      content: chatbotMessage.description
                    });
                }
              }else{
                insertMessage({
                      avatar: avatarUrl,
                      content: "Could you provide more details or context about what you're looking for? It will help me assist you more effectively."
                    });
              }
            }else{
              insertMessage({
                    avatar: avatarUrl,
                    content: "Could you provide more details or context about what you're looking for? It will help me assist you more effectively."
                  });
            }
          },
          error: function(error) {
            console.error('Error adding message:', error);
          }
        });
      }

    }
  });

  $(window).on('keydown', function(e) {
    if (e.which === 13) {
      // Handle pressing Enter to send messages
      $('.message-submit').click();
      return false;
    }
  });
</script>
