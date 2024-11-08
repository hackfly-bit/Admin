@extends('layouts.master-without-nav')
@section('title')
    Chat
@endsection
@section('page-title')
    Chat
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="d-lg-flex justify-content-center">
            <!-- end chat-leftsidebar -->

            <div class="w-75 user-chat mt-4 mt-sm-0 ms-lg-3">
                <div class="card">
                    <div class="chat-conversation p-3" id="chat-container" style=" overflow-y: auto;">
                        <ul class="list-unstyled mb-0" id="message-list">
                            {{-- messages will be displayed here --}}
                        </ul>
                    </div>

                    <div class="p-3 border-top">
                        <div class="row">
                            <div class="col">
                                <div class="position-relative">
                                    <input type="text" class="form-control border bg-soft-light"
                                        placeholder="Enter Message..." id="message-input">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="button" id="send-message"
                                    class="btn btn-primary chat-send w-md waves-effect waves-light">
                                    <span class="d-none d-sm-inline-block me-2">Send</span>
                                    <i class="mdi mdi-send float-end"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end user chat -->
        </div>
        <!-- End d-lg-flex  -->

        <div class="modal fade" id="joinChatModal" tabindex="-1" aria-labelledby="joinChatModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="joinChatModalLabel">Join Chat</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="guest-name">Your Name</label>
                            <input type="text" class="form-control" placeholder="Enter Your Name" id="guest-name"
                                required>
                            <div class="invalid-feedback">
                                Please enter your name to join the chat.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btn-join-chat">
                            <i class="bx bx-check me-1 align-middle"></i> Join Chat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script>
            const roomId = {{ $roomId }}
            const url = '{{ $url }}'
            console.log(roomId)
            document.addEventListener('DOMContentLoaded', function() {
                // Check if guest session exists
                const hasGuestSession = {{ session('guest_joined') ? 'true' : 'false' }};

                if (!hasGuestSession) {
                    // Configure modal options
                    const joinChatModal = new bootstrap.Modal(document.getElementById('joinChatModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    joinChatModal.show();

                    // Extract the last part of the URL to get room identifier
                    // const urlParts = window.location.pathname.split('/');
                    console.log(url)
                    const roomIdentifier = url
                    console.log(roomIdentifier)

                    // Listen for join button click
                    document.getElementById('btn-join-chat').addEventListener('click', function() {
                        const guestNameInput = document.getElementById('guest-name');
                        const guestName = guestNameInput.value.trim();

                        if (guestName === '') {
                            guestNameInput.classList.add('is-invalid');
                        } else {
                            guestNameInput.classList.remove('is-invalid');

                            // Send guest name and room identifier to backend
                            fetch('{{ route('room.guest.session') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        name: guestName,
                                        url: roomIdentifier
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'Success') {
                                        // Set session to prevent modal from reappearing
                                        joinChatModal.hide();
                                    } else {
                                        alert(data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        }
                    });
                }
                // loadChatHistory();
            });

            function loadChatHistory() {
                fetch(`/room/${roomId}/messages`)
                    .then(response => response.json())
                    .then(messages => {
                        const messageList = document.getElementById('message-list');
                        messageList.innerHTML = ''; // Clear existing messages

                        messages.forEach(message => {
                            displayMessage(message.content, message.userName, message.timestamp);
                        });

                        scrollToBottom();
                    })
                    .catch(error => {
                        console.error('Error loading chat history:', error);
                    });
            }


            document.addEventListener('DOMContentLoaded', function() {
                const sendButton = document.getElementById('send-message');
                const messageInput = document.getElementById('message-input');

                sendButton.addEventListener('click', function() {
                    const message = messageInput.value.trim();

                    if (message) {
                        // AJAX request to send the message to the server
                        fetch('/send-message', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    content: message,
                                    message_type: 'text'
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! Status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.status === 'success') {
                                    // Clear the input field after sending
                                    messageInput.value = '';
                                }
                            })
                            .catch(error => {
                                console.error('Error sending message:', error);
                            });
                    }
                });
            });
            console.log(`chat.${roomId}`)
            Echo.channel(`chat.${roomId}`)
                .listen('.message.sent', (e) => {
                    console.log('user', e.userName);
                    console.log('msg', e.message);
                    let msg = e.message
                    let nme = e.userName
                    displayMessage(msg, nme);
                });

            function displayMessage(message, name) {
                const messageList = document.getElementById('message-list');
                const messageElement = document.createElement('li');
                messageElement.classList.add('right');

                // Create message HTML
                messageElement.innerHTML = `
                    <div class="conversation-list">
                        <div class="d-flex">
                            <div class="flex-1">
                                <div class="ctext-wrap">
                                    <div class="custom-wrap-content ">
                                        <div class="d-flex justify-content-start">
                                            <h6 class="mb-1 .text-dark text-start">${name}</h5>
                                        </div>
                                        <p class="mb-0 text-start">${message}</p>
                                        ${message.message_type === 'image' ? getImageMarkup(message.content) : ''}
                                         <span style="font-size:9px;">  ${new Date().toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}  </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Add new message to bottom of list
                // shouldScroll = messages.scrollTop + messages.clientHeight === messages.scrollHeight;
                messageList.appendChild(messageElement);

                // if (!shouldScroll) {
                forceScrollToBottom();
                // }
            }

            function scrollToBottom() {
                const chatContainer = document.querySelector('.chat-conversation');

                if (!chatContainer) {
                    console.warn('Chat container not found');
                    return;
                }

                // Calculate if we're already near the bottom (within 100px tolerance)
                const isNearBottom = chatContainer.scrollHeight - chatContainer.scrollTop - chatContainer.clientHeight < 100;

                // Only auto-scroll if user is already near the bottom
                if (isNearBottom) {
                    // Use requestAnimationFrame for smooth scrolling
                    requestAnimationFrame(() => {
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    });
                }
            }

            // Optional: Function to force scroll to bottom regardless of current position
            function forceScrollToBottom() {
                const chatContainer = document.querySelector('.chat-conversation');

                if (!chatContainer) {
                    console.warn('Chat container not found');
                    return;
                }

                requestAnimationFrame(() => {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                });
            }

            function getImageMarkup(imageUrl) {
                return `
                    <ul class="list-inline message-img mt-2 mb-0">
                        <li class="list-inline-item message-img-list">
                            <a class="d-inline-block" href="${imageUrl}" target="_blank">
                                <img src="${imageUrl}" alt="image" class="rounded img-thumbnail">
                            </a>
                        </li>
                    </ul>
                `;
            }
        </script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
