
function shortcodeCheck() {
    const mediaModal = document.querySelector('#multimedia-shortcode-container #open-modal');
    if (!mediaModal) {
        return;
    } else {
        let player;

        window.onYouTubeIframeAPIReady = function() {
            player = new YT.Player('youtube-player', {
                events: {
                    'onReady': onPlayerReady
                }
            })
        }

        function onPlayerReady(event) {
            // Needed to initialize the yt player object
        }

           
        document.addEventListener( 'DOMContentLoaded' , function() {

            const mediaModal = document.querySelector('#multimedia-shortcode-container #open-modal');
            const iframe = document.querySelector('#multimedia-shortcode-container #youtube-player');
            const modal = document.querySelector('#multimedia-shortcode-container .modal');
            const closeBtn = document.querySelector('#multimedia-shortcode-container .close-btn');

            function setIframeHeight() {
                let windowHeight = window.innerHeight;
                let iframeHeight = Math.round(windowHeight * .8);
                iframe.style.height = iframeHeight + 'px';
            }

            closeBtn.onclick = function() {
                modal.style.display = 'none';

                if (player && typeof player.pauseVideo === 'function') {
                    player.pauseVideo();
                }
            }

            mediaModal.onclick = function() {
                modal.style.display = 'block';
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                    
                    if (player && typeof player.pauseVideo === 'function') {
                        player.pauseVideo();
                    }
                }
            }

            window.onload = setIframeHeight;
            window.onresize = setIframeHeight;
        });


    }
}

shortcodeCheck();