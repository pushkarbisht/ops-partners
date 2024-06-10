</main>
</div>
<script src="https://kit.fontawesome.com/c7181909f1.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#logout-button').click(function() {
            $.ajax({
                url: 'https://partners.opsol.in/api/logout',
                type: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.location.href = 'https://partners.opsol.in/login';
                },
                error: function(xhr, status, error) {
                    console.error('Failed to log out:', error);
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuToggle = document.getElementById('menu-toggle');
        const navMenu = document.querySelector('nav');

        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('hidden');
        });
    });
</script>
</body>

</html>
