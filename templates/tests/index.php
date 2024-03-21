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
    } else {
      $('<div class="message new"><figure class="avatar"><img src="' + message.avatar + '" /></figure>' +
        '<div>' + message.content + '</div>' +
        '</div>').appendTo($('.mCSB_container')).addClass('new');
    }

    updateScrollbar();
  }

  function fetchMessages() {
    if (!userAskedQuestion) {
      insertMessage({
        avatar: avatarUrl,
        content: 'How can I help you?',
      });
    }
  }


  $('.message-submit').click(function() {
    var newUserMessage = $('.message-input').val();
    if ($.trim(newUserMessage) !== '') {
      insertMessage(newUserMessage, true);

      // Clear the input message in the input box
      $('.message-input').val('');

      //check the word
      if (newUserMessage.toLowerCase() === 'end') {
        userAskedQuestion = false;
        currentCategory = null;
        fetchMessages(); // Restart the conversation
      } else {
        $.ajax({
          type: 'POST',
          url: '/test/addNlpMessages', // Update the URL to your CakePHP endpoint for adding messages
          data: {
            content: newUserMessage
          },
          success: function(response) {

            if (response) {
              var parsedResponse = JSON.parse(response);
              console.log(parsedResponse.chatbotMessage);

              if (parsedResponse.chatbotMessage) {

                var chatbotMessage = parsedResponse.chatbotMessage;

                insertMessage({
                  avatar: avatarUrl,
                  content: chatbotMessage.content
                })
              } else {
                insertMessage({
                  avatar: avatarUrl,
                  content: "Can you provide more details?"
                });
              }
            } else {
              insertMessage({
                avatar: avatarUrl,
                content: "Can you provide more details?"
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