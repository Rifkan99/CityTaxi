function checkAvailabilityInDatabase(action, value) {
    return fetch('checkAvailability.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=${action}&value=${encodeURIComponent(value)}`,
    })
    .then(response => response.json())
    .then(data => data.available)
    .catch(error => {
        console.error('Error:', error);
        return false;
    });
}
