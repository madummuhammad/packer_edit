@extends('layouts.backend.default')

@section('title', 'Chat')

@section('style')

<link href="{{ asset('assets/backend/assets/css/apps/mailing-chat.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="chat-system">
            <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
            <div class="user-list-box">
                <div class="search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" class="form-control" placeholder="Search" />
                </div>
                <div class="people">
                    <!-- Placeholder: Person -->
                </div>
            </div>
            <div class="chat-box">
                <div class="chat-not-selected">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg> Click User To Chat</p>
                </div>
                <div class="chat-box-inner">
                    <div class="chat-meta-user">
                        <div class="current-chat-user-name"><span><img src="{{ asset('assets/apps/img/default_image.png') }}" alt="dynamic-image"><span class="name"></span></span></div>
                    </div>
                    <div class="chat-conversation-box">
                        <div id="chat-conversation-box-scroll" class="chat-conversation-box-scroll">
                            
                        </div>
                    </div>
                    <div class="chat-footer">
                        <div class="chat-input">
                            <form class="chat-form" action="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                <input type="text" class="mail-write-box form-control" placeholder="Message"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script src="{{ asset('assets/backend/assets/js/apps/mailbox-chat.js') }}"></script>

<script>

    $(function () {

        getOutbound();

    });

    async function getOutbound() {

        await axios.get(`/api/outbound`, {
            headers: {
                "Authorization": "Bearer {{ Session::get('api_token') }}",
            },
        })
        .then(function (res) {
            console.log('response', res.data);
            if (res.status == 200) {
                var data = res.data.data;
                var html = ``;
                var htmlChat = ``;
                data.map((e) => {
                    html += `
                        <div class="person" data-chat="person${e.id}">
                            <div class="user-info">
                                <div class="f-head">
                                    <img src="{{ asset('assets/apps/img/default_image.png') }}" alt="avatar">
                                </div>
                                <div class="f-body">
                                    <div class="meta-info">
                                        <span class="user-name" data-name="${e.invoice_number}">${e.invoice_number}</span>
                                        <span class="user-meta-time">${moment(e.created_at).format('DD MMM YYYY')}</span>
                                    </div>
                                    <span class="preview">${e.status_name}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    htmlChat += `
                        <div class="chat" data-chat="person${e.id}">
                            <div class="conversation-start">
                                <span>${e.created_at}</span>
                            </div>
                            ${
                                e.chat_items.map((i) => {
                                    return `
                                        <div class="bubble ${i.user_id == userId ? 'me' : 'you'}">
                                            ${i.text}
                                        </div>       
                                    `;
                                })
                            }
                        </div>
                    `;
                });
                $('.people').html(html);
                $('.chat-conversation-box-scroll').html(htmlChat);
            } else {
                var html = `
                    <div class="items text-center p-3">
                        <div class="item-content">
                            <p>No data</p>
                        </div>
                    </div>
                `;
                $('.people').html(html);
            }
        })
        .catch(function (err) {
            console.log('error', err);
            if (err.response) {
                var html = `
                    <div class="items text-center p-3">
                        <div class="item-content">
                            <p>No data</p>
                        </div>
                    </div>
                `;
                $('.people').html(html);
            }
        });

    }

</script>

@endsection
