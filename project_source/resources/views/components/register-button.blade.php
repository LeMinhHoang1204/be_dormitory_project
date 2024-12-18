<button class="btn btn-primary change-button" onclick="handleRegisterClick(event, {{ $room->id }})">
    Register
</button>

<script>
    const changeButton = document.querySelector('.change-button');
    changeButton.addEventListener('click', () => {
        alert('Register room successfully!');
    });
</script>
