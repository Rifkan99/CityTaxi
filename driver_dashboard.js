// Mock data for demonstration purposes
const recentTripsData = [
    { date: '2024-01-01', passengerName: 'Assem', tripDetails: 'Colombo 05', rating: 4.5 },
    { date: '2024-01-02', passengerName: 'Sajath', tripDetails: 'City Tour', rating: 5.0 }
];

const accountInfoData = [
    { label: 'Full Name', value: 'Rifkan' },
    { label: 'Contact Number', value: '+94756447296' },
    { label: 'Vehicle', value: 'Toyota Camry' },
    { label: 'License Plate', value: '8378965' }
];

let map;

// Function to initialize Google Maps
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
}

// Function to toggle driver status
function toggleStatus() {
    const statusElement = document.getElementById('status');
    const currentStatus = statusElement.innerText;
    const newStatus = currentStatus === 'AVAILABLE' ? 'BUSY' : 'AVAILABLE';
    statusElement.innerText = newStatus;
}

// Function to update working hours (mock implementation)
function updateWorkingHours() {
    const workingHoursInput = document.getElementById('working_hours');
    const newWorkingHours = workingHoursInput.value;
    // Add logic to send updated working hours to the server (backend)
    // Update the UI with the latest working hours
    alert(`Working hours updated to: ${newWorkingHours}`);
}

// Function to display recent trips
function displayRecentTrips() {
    const recentTripsElement = document.getElementById('recentTrips');
    recentTripsData.forEach(trip => {
        const listItem = document.createElement('li');
        listItem.textContent = `${trip.date}: ${trip.passengerName} - ${trip.tripDetails} (Rating: ${trip.rating})`;
        recentTripsElement.appendChild(listItem);
    });
}

// Function to display account information
function displayAccountInfo() {
    const accountInfoElement = document.getElementById('accountInfo');
    accountInfoData.forEach(info => {
        const listItem = document.createElement('li');
        listItem.textContent = `${info.label}: ${info.value}`;
        accountInfoElement.appendChild(listItem);
    });
}

// Call functions to display recent trips and account information
displayRecentTrips();
// displayAccountInfo();

// Initialize Google Maps after the page loads
window.onload = function () {
    initMap();
};
