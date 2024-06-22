document.addEventListener("DOMContentLoaded", function() {
    const progressCircle = document.querySelector('.progress-ring__circle2');

    // Example: Set progress to 70%
    function setProgress(percent) {
        const offset = 503 - percent / 100 * 503;
        progressCircle.style.strokeDashoffset = offset;
        document.querySelector('.progress-percent').textContent = `${percent}%`;
        progressCircle.classList.add('progress');
    }

    // Call setProgress with desired percentage (0-100)
    setProgress(85); // Example: 70% progress

    var myCarousel = document.getElementById('progressCarousel');
    var carousel = new bootstrap.Carousel(myCarousel, {
      interval: false,  // Disables automatic cycling
      wrap: false       // Prevents looping
    });
  
});
