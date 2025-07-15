document.addEventListener('DOMContentLoaded', function() {        
    // Responsive iframe resizing
    function resizeVideo() {
        const videoPlayer = document.querySelector('.video-player');
        if (videoPlayer) {
            const width = videoPlayer.offsetWidth;
            videoPlayer.style.height = (width * 9 / 16) + 'px';
        }
    }
    
    window.addEventListener('resize', resizeVideo);
    resizeVideo(); 
});