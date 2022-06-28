document.querySelector('.chat[data-chat=person2]').classList.add('active-chat');
document.querySelector('.person[data-chat=person2]').classList.add('active-active');

var friends = {
    list: document.querySelector('ul.people'),
    all: document.querySelectorAll('.left .person'),
    name: ''
};

var chat = {
    container: document.querySelector('.container-chat .right'),
    current: null,
    person: null,
    name: document.querySelector('.container-chat .right .top .name')
};


friends.all.forEach(f => {
    f.addEventListener('mousedown', () => {
        f.classList.contains('active-active') || setActiveChat(f);
    });
});

function setActiveChat(f) {
    friends.list.querySelector('.active-active').classList.remove('active-active');
    f.classList.add('active-active');
    chat.current = chat.container.querySelector('.active-chat');
    chat.person = f.getAttribute('data-chat');
    chat.current.classList.remove('active-chat');
    chat.container.querySelector('[data-chat="' + chat.person + '"]').classList.add('active-chat');
    friends.name = f.querySelector('.name').innerText;
    chat.name.innerHTML = friends.name;
}