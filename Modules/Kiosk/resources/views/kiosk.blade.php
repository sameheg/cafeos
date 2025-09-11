<div id="kiosk-app" class="full-screen">
    <div id="idle-loop">
        <video autoplay loop muted playsinline>
            <source src="/idle.mp4" type="video/mp4">
        </video>
    </div>
    <div id="menu"></div>
    <div id="payment"></div>
</div>
<script>
    document.addEventListener('touchstart', function(){ console.log('touch'); }, {passive:true});
</script>
