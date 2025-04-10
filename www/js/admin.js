function updateTime() {
    const now = new Date();
    document.getElementById('time-now').innerText = now.toLocaleString('cs-CZ');
}
setInterval(updateTime, 1000);
updateTime();

const loadDiv = document.getElementById('data-loads');
const outputDiv = document.getElementById('server-load');
const loads = JSON.parse(loadDiv.dataset.loads);  // Loads is now an array of numbers

const progressTemplate = `
    <div class="progress my-1 w-100" role="progressbar" aria-label="Server load" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" style="width: 0%"></div>
    </div>`;

for (const load of loads) {

    const progressWrapper = document.createElement('div');
    progressWrapper.innerHTML = progressTemplate.trim();

    const progress = progressWrapper.firstElementChild;
    const progressBar = progress.querySelector('.progress-bar');

    if (progressBar) {
        progressBar.style.width = load + '%';
        progressBar.setAttribute('aria-valuenow', load);
        progressBar.classList.add(
            load > 80 ? 'bg-danger' : load > 50 ? 'bg-warning' : 'bg-success'
        );
    } else {
        console.error("Progress bar not found!");
    }

    outputDiv.appendChild(progress);
}

const storageDiv = document.getElementById('data-storage');
const outputStorageDiv = document.getElementById('storage-load');
const [freeBytes, totalBytes] = JSON.parse(storageDiv.dataset.loads);

// Calculate used space
const usedBytes = totalBytes - freeBytes;
const usedGB = (usedBytes / 1024 ** 3).toFixed(1);
const totalGB = (totalBytes / 1024 ** 3).toFixed(1);

// Calculate percentage used
const percentUsed = ((usedBytes / totalBytes) * 100).toFixed(1);

// Build progress bar
const storageProgressWrapper = document.createElement('div');
storageProgressWrapper.innerHTML = `
    <div class="progress my-1 w-100" role="progressbar" aria-label="Storage load" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" style="width: ${percentUsed}%"></div>
    </div>
    <div class="small text-center mt-1">${usedGB} GB / ${totalGB} GB used</div>
`.trim();

// Get progress bar and style it
const progress = storageProgressWrapper.querySelector('.progress');
const progressBar = storageProgressWrapper.querySelector('.progress-bar');

if (progressBar) {
    progressBar.setAttribute('aria-valuenow', percentUsed);
    progressBar.classList.add(
        percentUsed > 80 ? 'bg-danger' : percentUsed > 50 ? 'bg-warning' : 'bg-success'
    );
} else {
    console.error("Storage progress bar not found!");
}

// Append to the page
outputStorageDiv.appendChild(storageProgressWrapper);

$(document).ready(function () {
    const inner = `
        <div class="alert alert-info" role="alert">Změna hostingu webu z vývojového prostředí na platformu Hukot.cz</div>
        <div class="alert alert-info" role="alert">Responzivita a SSL certifikát (HTTPS)</div>`;
    $('#last-update').after(inner);
    $('#hukot-status').closest('button').attr({
        'data-bs-toggle': 'modal',
        'data-bs-target': '#statusModal'
    });



});

$(document).ready(function() {
    // Make the API call to /api/hukotStatus.php
    $.ajax({
        url: '/api/hukotStatus.php',
        method: 'GET',
        success: function(data) {
            // Assuming `data` is a JSON array like the one you provided
            let tableHtml = '<table class="table table-bordered table-striped">';
            tableHtml += '<thead><tr><th>Server</th><th>SLA</th><th>Stav</th></tr></thead>';
            tableHtml += '<tbody>';

            // List of titles to be made bold
            const boldTitles = [
                'Virtual Private Servers (VPS) - Node Infrastructure',
                'Storage services',
                'Web Administration',
                'Datacenter - Czech Republic',
                'Datacenter - Germany'
            ];

            data.forEach(function(item) {
                // Check if the current title should be bold
                const isBold = boldTitles.includes(item.title);
                const isGreen = (item.status === 'Operational');

                // Apply bold style if it's in the boldTitles array
                const titleStyle = isBold ? 'font-weight: bold;' : '';
                const statusStyle = isGreen ? 'color: green;' : '';

                tableHtml += `<tr>
                                <td style="${titleStyle}">${item.title}</td>
                                <td style="">${item.sla}</td>
                                <td style="${statusStyle}">${item.status}</td>
                             </tr>`;
            });

            tableHtml += '</tbody></table>';

            // Insert the table HTML into the div with id "hukot-status-table"
            $('#hukot-status-table').html(tableHtml);
        },
        error: function() {
            $('#hukot-status-table').html('<p class="text-danger">Failed to load data.</p>');
        }
    });
});
