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
  var currentLanguage = 'en';
  var translations = {
    'How can I help you?': 'どのようにお手伝いできますか？',
    'General Information': '一般的な情報',
    'Symptom': '病状',
    'Treatment': '治療',
    'You can type "End" to end the process.': 'プロセスを終了するには、「End」と入力できます。',
  };
  var currentLanguage = 'en'; // Default language is English

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
          $('<div class="message new "><figure class="avatar"><img src="' + message.avatar + '" /></figure>' +
          '<div class="generalInfo">How can I help you?</div>' +
          '<span class="custom-badge cursor-pointer generalInfo" onclick="handleBadgeClick(\'General Information\')">General Information</span>' +
          '<span class="custom-badge cursor-pointer generalInfo" onclick="handleBadgeClick(\'Symptom\')">Symptom</span>' +
          '<span class="custom-badge cursor-pointer generalInfo" onclick="handleBadgeClick(\'Treatment\')">Treatment</span>' +
          '<div class="generalInfo" style=" padding-bottom:15px;">You can type "End" to end the process.</div>' +
          '<div class="translate-text" onclick="translateMessage()">🔄Translate</div>'+
          '</div>').appendTo($('.mCSB_container')).addClass('new');
        }else if(message.star){
           var starIcons = '';
            for (var i = 0; i < 5; i++) {
                starIcons += '<i class="far fa-star"></i>';
            }

            var $message = $('<div class="message new"><figure class="avatar"><img src="' + message.avatar + '" /></figure>' +
            '<div style=" padding-bottom:15px; class="toTranslate">' + message.content + '</div>' +
            '<div class="flex justify-content-center">' +
              starIcons +
            '</div>'+
            '<div class="translate-text" onclick="translateUserMessage(this.previousElementSibling)">🔄Translate</div>'+
            '</div>').appendTo($('.mCSB_container')).addClass('new');

            $message.find('.fa-star').hover(function () {
                $(this).removeClass('far').addClass('fas');
                $(this).prevAll('.fa-star').removeClass('far').addClass('fas');
                $(this).nextAll('.fa-star').removeClass('fas').addClass('far');
            }, function () {
                $(this).removeClass('fas').addClass('far');
                $(this).prevAll('.fa-star').removeClass('fas').addClass('far');
            });
          
        }else{
          $('<div class="message new"><figure class="avatar"><img src="' + message.avatar + '" /></figure>' +
            '<div style=" padding-bottom:15px; class="toTranslate">' + message.content + '</div>' +
            '<div class="translate-text" onclick="translateUserMessage(this.previousElementSibling)">🔄Translate</div>'+
            '</div>').appendTo($('.mCSB_container')).addClass('new');
          }
    }

    updateScrollbar();
  }

  function handleBadgeClick(category) {
      currentCategory = category;
      if (currentLanguage === 'ja') {
          insertMessage(translations[category], true);
          if (category === 'General Information') {
            insertMessage({
            avatar: avatarUrl,
            content: '具体的な情報は何をお探しですか？'
            });
    
          } else if (category === 'Symptom') {
            insertMessage({
              avatar: avatarUrl,
              content: '経験している症状について詳しく教えてください。'
            });
          } else if (category === 'Treatment') {
            insertMessage({
              avatar: avatarUrl,
              content: '治療の選択肢に興味がありますか？もしそうなら、どの症状に対してですか？'
            });
          } else {
            insertMessage({
              avatar: avatarUrl,
              content: "申し訳ありませんが、そのカテゴリーが理解できませんでした。"
            });
          }
      } else if (currentLanguage === 'en') {
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
          insertMessage({
            avatar: avatarUrl,
            content: "Thank you for using our service. Please rate your experience.",
            star: true
          });

          // fetchMessages(); // Restart the conversation
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
                console.log(chatbotMessage);
                
               if (currentCategory === 'General Information' || currentCategory === '一般的な情報') {
                  insertMessage({
                      avatar: avatarUrl,
                      content: chatbotMessage
                    });
                  
                } else if (currentCategory === 'Symptom' || currentCategory === '病状') {
                  insertMessage({
                      avatar: avatarUrl,
                      content: chatbotMessage
                    });
                } else if (currentCategory === 'Treatment' || currentCategory == '治療'){
                  insertMessage({
                      avatar: avatarUrl,
                      content: chatbotMessage
                    })
                }
              }else{
                if (currentLanguage === 'ja') {
                    insertMessage({
                      avatar: avatarUrl,
                      content: "もっと詳細な情報や文脈を教えていただけますか？それによって、もっと効果的にお手伝いできるかと思います。"
                    });
                } else {
                  
                    insertMessage({
                        avatar: avatarUrl,
                        content: "Could you provide more details or context about what you're looking for? It will help me assist you more effectively."
                    });
                }
              }
            }else{
              if (currentLanguage === 'ja') {
                    insertMessage({
                      avatar: avatarUrl,
                      content: "もっと詳細な情報や文脈を教えていただけますか？それによって、もっと効果的にお手伝いできるかと思います。"
                    });
              } else {
                
                insertMessage({
                      avatar: avatarUrl,
                      content: "Could you provide more details or context about what you're looking for? It will help me assist you more effectively."
                    });
              }
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

  //translation
  function translateMessage() {
    var translateElements = document.querySelectorAll('.generalInfo');

    // Iterate through each element and update its text content
    translateElements.forEach(function (element) {
      var originalContent = element.innerHTML;

      // Check if the current language is English or Japanese and update accordingly
      element.textContent = translateContent(originalContent);
    });

    // Toggle the language
    currentLanguage = currentLanguage === 'en' ? 'ja' : 'en';
  }

  function translateContent(content) {
    if (currentLanguage === 'ja') {
      Object.keys(translations).forEach(function (key) {
        content = content.replace(new RegExp(escapeRegExp(translations[key]), 'g'), key);
      });
      
    } else if (currentLanguage === 'en') {
      // Reverse the translations to switch from Japanese back to English
      Object.keys(translations).forEach(function (key) {
        content = content.replace(new RegExp(escapeRegExp(key), 'g'), translations[key]);
      });
    }

    return content;
  }

  function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
  }

  function translateUserMessage(clickedElement){
    var contentToTranslate = clickedElement.innerHTML;

    $.ajax({
          type: 'POST',
          url: '/chatbot/googleTranslate', // Update the URL to your CakePHP endpoint for adding messages
          data: { content:  contentToTranslate},
          success: function(response) {
              var parsedResponse = JSON.parse(response);
              var translatedContent = parsedResponse.translatedMessage;
              clickedElement.innerHTML = translatedContent;
          }
    })

  }
</script>
