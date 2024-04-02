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
        <input type="text" class="message-input" placeholder="Type message...">
        <button type="submit" class="message-submit">Send</button>
    </div>
</div>
<div class="bg"></div>


<script>
    $(".helpful-button").on("click", function() {
        insertMessage("役に立つ", true);
        setTimeout(function() {
            insertMessage({
                avatar: avatarUrl,
                content: 'フィードバックをありがとうございます',
            });
        }, 1000);
    });
    $(".unhelpful-button").on("click", function() {
        insertMessage("役に立つ", true);
        setTimeout(function() {
            insertMessage({
                avatar: avatarUrl,
                content: 'フィードバックをありがとうございます',
            });
        }, 1000);
    });
</script>


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
            if (message.feed) {

                var starIcons = '';
                for (var i = 0; i < 5; i++) {
                    starIcons += '<i class="far fa-star" data-index="' + i + '"></i>';
                }

                var starMsg = $('<div class="message new"><figure class="avatar"><img src="' + message.avatar + '" /></figure>' +
                    '<div>' + message.content + '</div>' +
                    '<div class="button-container">' +
                    '<p class="feedback-text">' + "Is it helpful?" + '</p>' + starIcons + '</div>' +
                    '</div>').appendTo($('.mCSB_container')).addClass('new');

                starMsg.find('.fa-star').on('click', function(e) {
                    var index = $(this).data('index');
                    $(this).removeClass('far').addClass('fas');
                    $(this).prevAll('.fa-star').removeClass('far').addClass('fas');
                    $(this).nextAll('.fa-star').removeClass('fas').addClass('far');
                });

            } else {

                $('<div class="message new"><figure class="avatar"><img src="' + message.avatar + '" /></figure>' +
                    '<div>' + message.content + '</div>' +
                    '</div>').appendTo($('.mCSB_container')).addClass('new');
            }
        }

        updateScrollbar();
    }

    function fetchMessages() {
        if (!userAskedQuestion) {
            insertMessage({
                avatar: avatarUrl,
                content: 'How can I help you? <br> どのようにお手伝いできますか？',
            });
        }
    }


    $('.message-submit').click(function() {
        var newUserMessage = $('.message-input').val();
        if ($.trim(newUserMessage) !== '') {
            insertMessage(newUserMessage, true);

            // Clear the input message in the input box
            $('.message-input').val('');

            $.ajax({
                type: 'POST',
                url: '/registers/addAppointment', // Update the URL to your CakePHP endpoint for adding messages
                data: {
                    content: newUserMessage
                },
                success: function(response) {
                    if (response) {
                        var parsedResponse = JSON.parse(response);
                        console.log(parsedResponse.action);
                        if (parsedResponse) {
                            if (parsedResponse.action == 'ask_schedule') {
                                $('.message-input').replaceWith('<input type="text" id="datepicker" class="message-input date" placeholder="Select date...">');
                                initializeDatepicker();
                            } else {
                                $('.message-input').replaceWith('<input type="text" class="message-input" placeholder="Type message...">');
                            }

                            insertMessage({
                                avatar: avatarUrl,
                                content: parsedResponse.message,
                                feed: true
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
    });

    $(window).on('keydown', function(e) {
        if (e.which === 13) {
            // Handle pressing Enter to send messages
            $('.message-submit').click();
            return false;
        }
    });
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    function initializeDatepicker() {
        $("#datepicker").datepicker();
    }
</script>