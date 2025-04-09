document.getElementById('ajaxPostForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('ajax_post.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('postResult').innerHTML = data;
    });
});

document.getElementById('ajaxGetForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const message = this.message.value;
    fetch('ajax_get.php?message=' + encodeURIComponent(message))
    .then(response => response.text())
    .then(data => {
        document.getElementById('getResult').innerHTML = data;
    });
});
