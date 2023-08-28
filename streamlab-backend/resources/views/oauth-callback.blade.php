<script>
    // Send a message to the main window
    window.opener.postMessage({ success: {{ $success ? 'true': 'false'}} , name: '{!!$name!!}'}, 'http://localhost:3000');
</script>
