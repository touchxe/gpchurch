// History Page Tab Functionality
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.history-tab');
    const periods = document.querySelectorAll('.timeline-period');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const periodId = this.dataset.period;

            // Remove active class from all tabs and periods
            tabs.forEach(t => t.classList.remove('active'));
            periods.forEach(p => p.classList.remove('active'));

            // Add active class to clicked tab and corresponding period
            this.classList.add('active');
            document.getElementById('period-' + periodId).classList.add('active');
        });
    });
});
